<?php

namespace App\Livewire\Admin;

use App\Models\answer;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;

class Report extends Component
{
    use WithPagination;
    public $location,$dateStart,$dateEnd;
    public $data,$all;
    public $date,$pagination,$list;

    public function mount(){

        $this->all=answer::orderBy("created_at","desc")->get();
        
        $this->date=array();
        $this->dateStart=now()->startOfMonth()->startOfDay();
        $this->dateEnd=now()->endOfMonth()->endOfDay();

        $this->date['month']=$this->dateStart->month;
        $this->date['year']=$this->dateStart->year;
        $this->date['monthMode']=true;

        $this->date['chartMode']=false;
        
        $this->pagination['show']='5';
        //dd($arr,$this->data);
        $this->list['year']=array();
        for ($i=$this->all->min('created_at')->year; $i <= $this->all->max('created_at')->year; $i++) { 
            array_push($this->list['year'],$i);
        }
        $this->pagination['location']=null;
    }
    public function render()
    {   
        $answer = Answer::whereIn('questions_id',[1])
            ->whereBetween('created_at',[$this->dateStart->toDateString(),$this->dateEnd->toDateString()])
            ->orderBy('socre', 'desc');
        
        if($answer->count()){
            $this->list['location']=$answer->get()->unique('Location')->pluck('Location');
            $this->getData($answer);
            $locationLineModel=new LineChartModel();
            $locationLineModel->setYAxisVisible(false)->withLegend()->withDataLabels();
            
            foreach ($this->data as $key => $value) {
                $locationPieModel[$key]=(new PieChartModel())
                                ->setTitle($key)
                                ->addSlice('Unacceptable (1)',$value['score_1'],'#d8402b')
                                ->addSlice('Poor (2)',$value['score_2'],'#fd740d')
                                ->addSlice('Acceptable (3)',$value['score_3'],'#ffd302')
                                ->addSlice('Good (4)',$value['score_4'],'#a1d22a')
                                ->addSlice('Excellent (5)',$value['score_5'],'#25b83f');
                if($key!='total'){
                    $locationLineModel->addPoint($key,$value['avg']);
                }
            }
        }else{
            $this->data=null;
        }
        
        if($this->pagination['location']){
            $answer->where('location','like','%'.$this->pagination['location'].'%');
        }
        
        if(is_numeric($this->pagination['show'])){
            $answer=$answer->paginate($this->pagination['show']);
        }else{
            $answer=$answer->get();
        }

        return view('livewire.admin.report',[
            'raw'=>$answer,
            'chartModel'=>$locationPieModel??null,
            'lineModel'=>$locationLineModel??null
        ])->extends('layouts.app');
    }
    public function updatedDate(){
        dd('date updated');
        $this->date['month']==null?$this->date['month']=now()->month:$this->date['month'];
        $this->date['year']==null?$this->date['year']=now()->year:$this->date['year'];

        $this->dateStart=Carbon::create($this->date['year'],$this->date['month'],1)->startOfMonth()->startOfDay();
        $this->dateEnd=carbon::create($this->date['year'],$this->date['month'],1)->endOfMonth()->endOfDay();
        
        if(!$this->date['monthMode']){
            $this->dateStart=$this->dateStart->startOfYear();
            $this->dateEnd=$this->dateEnd->endOfYear();
        }

        $this->pagination['location']=null;
    }


    public function download(){
        $this->exportDataSum();
        $this->exportDataAll();
    }
    public function exportDataSum(){
        
        $all=$this->data->sortBy('no');
        /* dd($all);
        foreach ($all as $loc=>$d) {
            dd( $d['no'],$loc,$d['avg'],$d['score_5'],$d['percentile_5'].'%',$d['score_4'],$d['percentile_4'].'%',$d['score_3'],$d['percentile_3'].'%',$d['score_2'],$d['percentile_2'].'%',$d['score_1'],$d['percentile_1'].'%',$d['total']); // Add more fields as needed
        } */
        $csvFileName = 'Summery_'.$this->dateStart->toDateString().'-'.$this->dateEnd->toDateString().'.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = array('Location', 'Average Score', 'Excellent[5]','Percentile Excellent[5]', 'Good[4]','Percentile Good[4]','Acceptable[3]','Percentile Acceptable[3]','Poor[2]','Percentile Poor[2]','Unacceptable[1]','Percentile Unacceptable[1]','Total');

        $callback = function() use($all, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            foreach ($all as $loc=>$d) {
                fputcsv($file, [$loc,$d['avg'],$d['score_5'],$d['percentile_5'].'%',$d['score_4'],$d['percentile_4'].'%',$d['score_3'],$d['percentile_3'].'%',$d['score_2'],$d['percentile_2'].'%',$d['score_1'],$d['percentile_1'].'%',$d['total']]); // Add more fields as needed
            }

            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    public function exportDataAll(){
        $all=$this->all->whereBetween('created_at',[$this->dateStart->toDateString(),$this->dateEnd->toDateString()]);
        $csvFileName = 'Data_'.$this->dateStart->toDateString().'-'.$this->dateEnd->toDateString().'.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = array('id', 'Location', 'socre', 'created_at');

        $callback = function() use($all, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            foreach ($all as $d) {
                fputcsv($file, [$d->id, $d->Location, $d->socre, $d->created_at]); // Add more fields as needed
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function getData($answer){
        
        $monthYear = carbon::create($answer->max('created_at'))->endOfMonth();
        $monthTotal = $answer->count();
        $arr=array();
        $arr['total']['score_1']=0;
        $arr['total']['score_2']=0;
        $arr['total']['score_3']=0;
        $arr['total']['score_4']=0;
        $arr['total']['score_5']=0;

        $arr['total']['weight_1']=0;
        $arr['total']['weight_2']=0;
        $arr['total']['weight_3']=0;
        $arr['total']['weight_4']=0;
        $arr['total']['weight_5']=0;
        $arr['total']['total']=0;
        $arr['total']['totalWeight']=0;
        $arr['total']['no']=999;
        foreach ($answer->get() as $rec) {
            // dd($rec);
            switch ($rec->Location){
                case ('172.16.110.196'):
                    $rec->Location='Ticketing';
                    $no=1;
                break;
                case ('172.16.110.224'):
                    $rec->Location='LostAndFound';
                    $no=2;
                break;
                case ('172.16.110.246'):
                    $rec->Location='Locker';
                    $no=3;
                break;
                case ('172.16.110.248'):
                    $rec->Location='Retail';
                    $no=4;
                break;
                case ('172.16.110.249'):
                    $rec->Location='TheVillage';
                    $no=5;
                break;
                case ('172.16.110.244'):
                    $rec->Location='Tropical';
                    $no=6;
                break;
                case ('172.16.110.161'):
                    $rec->Location='EmeraldSandbar';
                    $no=7;
                break;
                case ('172.16.110.205'):
                    $rec->Location='Wavebar';
                    $no=7;
                break;
                default:
                    // $rec->Location='Other';
                    $no=99;
            }

            if(!isset($arr[$rec->Location])){
                $arr[$rec->Location]['score_1']=0;
                $arr[$rec->Location]['score_2']=0;
                $arr[$rec->Location]['score_3']=0;
                $arr[$rec->Location]['score_4']=0;
                $arr[$rec->Location]['score_5']=0;
                $arr[$rec->Location]['weight_1']=0;
                $arr[$rec->Location]['weight_2']=0;
                $arr[$rec->Location]['weight_3']=0;
                $arr[$rec->Location]['weight_4']=0;
                $arr[$rec->Location]['weight_5']=0;
                $arr[$rec->Location]['no']=$no;
            }
            
            
            $arr[$rec->Location]['score_'.$rec->socre]+=1;
            $arr['total']['score_'.$rec->socre]+=1;
        }

        foreach ($arr as $location => $data) {
            
            $arr[$location]['weight_1']=$data['score_1']*1;
            $arr[$location]['weight_2']=$data['score_2']*2;
            $arr[$location]['weight_3']=$data['score_3']*3;
            $arr[$location]['weight_4']=$data['score_4']*4;
            $arr[$location]['weight_5']=$data['score_5']*5;
            
            $arr[$location]['total']=$data['score_1']+$data['score_2']+$data['score_3']+$data['score_4']+$data['score_5'];

            $arr[$location]['percentile_1']=round($data['score_1']/$arr[$location]['total']*100,2);
            $arr[$location]['percentile_2']=round($data['score_2']/$arr[$location]['total']*100,2);
            $arr[$location]['percentile_3']=round($data['score_3']/$arr[$location]['total']*100,2);
            $arr[$location]['percentile_4']=round($data['score_4']/$arr[$location]['total']*100,2);
            $arr[$location]['percentile_5']=round($data['score_5']/$arr[$location]['total']*100,2);

            $arr[$location]['totalWeight']=$arr[$location]['weight_1']+$arr[$location]['weight_2']+$arr[$location]['weight_3']+$arr[$location]['weight_4']+$arr[$location]['weight_5'];
            $arr[$location]['avg']=round($arr[$location]['totalWeight']/$arr[$location]['total'],2);
        }
        $this->data=collect($arr);
    }
}
