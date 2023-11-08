<?php

namespace App\Livewire;

use App\Models\answer;
use App\Models\question;
use Livewire\Component;
use WireUi\Traits\Actions;

class Survey extends Component
{
    use Actions;
    public $question;
    public $udid;
    public $qid,$loc;
    protected $queryString = [
        'qid',
        'loc'
    ];
    public function mount(){
        
        $this->question=question::find($this->qid??1);
        // dd($this->question,$this->qid,$this->loc);
    }

    public function render()
    {
        return view('livewire.survey')->extends('layouts.app');
    }
    public function checkRecord(){
        $record = answer::where('user',$this->udid)
        ->where('location',$this->loc??request()->ip())
        ->where('questions_id',$this->question->id)
        ->whereBetween('created_at',[today(),now()])
        ->count();
        return $record;
    }
    public function notifyDuplicate(){
        $this->udid=null;

        $this->notification()->error(
            $title = 'Error',
            $description = "this wrist band already regis"
        );

        // $this->emit('change-focus');
        // $this->addError('uuid', 'this wrist band already regis');
        return redirect(route('home'));
    }

    public function updated(){
        // run every update
        /* $validatedData = $this->validate([
                            'qid' => 'required|unique:answers,user'
                        ]); */
        if($this->checkRecord() > 0){
            $this->notifyDuplicate();
        }
    }
    public function save($rate){
        // validate and save
        
        if($this->checkRecord() > 0){
            $this->notifyDuplicate();
        }
        $ans = answer::create([
            'questions_id' => $this->question->id,
            'socre' => $rate,
            'Location' => $this->loc??request()->ip(),
            'deviceAgent' => request()->userAgent(),
            'user' => $this->udid,
        ]);
        // dd($ans);
        $this->notification()->success(
            $title = 'Success',
            $description = 'Thank for your time'
        );
        $this->udid=null;
        redirect(route('home'));
    }
}
