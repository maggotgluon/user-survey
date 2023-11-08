<div class="container mx-auto relative font-Taviraj">
    <x-nav />
    <section class="h-28">
        
    </section>
    <section class="bg-slate-50 shadow grid grid-cols-2 lg:grid-cols-4 gap-2 p-5 rounded-xl">
        <div class="col-span-2 lg:col-span-4">
            <h1 class="text-4xl font-bold">Report</h1>
        
            <div class="flex gap-2 ">
                <div>
                    <x-native-select
                        label="Year"
                        placeholder="Select Year"
                        :options="$list['year']"
                        wire:model="date.year"
                    />
                </div>
                <div class="flex flex-col justify-between">
                    {{-- {{$date['month']}} --}}
                    <x-toggle label="Month" wire:model.live="date.monthMode" />
                    @if ($date['monthMode'])
                        <x-native-select
                            
                            placeholder="Select Month"
                            :options="[
                                ['name'=>'January', 'value'=>1],
                                ['name'=>'February', 'value'=>2],
                                ['name'=>'March', 'value'=>3],
                                ['name'=>'April', 'value'=>4],
                                ['name'=>'May', 'value'=>5],
                                ['name'=>'June', 'value'=>6],
                                ['name'=>'July', 'value'=>7],
                                ['name'=>'August', 'value'=>8],
                                ['name'=>'September', 'value'=>9],
                                ['name'=>'October', 'value'=>10],
                                ['name'=>'November', 'value'=>11],
                                ['name'=>'December', 'value'=>12],
                            ]"
                            option-label="name"
                            option-value="value"
                            wire:model.live="date.month"
                        />
                    @endif

                </div>
                <x-toggle label="Show Chart" wire:model.live="date.chartMode" />

                <div class="ml-auto">
                    <x-button label="Download Summery" wire:click="exportDataSum" />
                </div>
            </div>
        </div>
        <div class="col-span-2 lg:col-span-4">
        <x-badge outline >
            Data from {{$dateStart->format('l jS \\ F Y')}}{{$dateStart!==$dateEnd?' - '.$dateEnd->format('l jS \\ F Y'):''}}
        </x-badge>
        </div>
        @isset ($data)
        <div>
            <x-card title="Average Score">
                <div class="text-9xl text-right">
                    {{$data['total']['avg']}}
                </div>
            </x-card>
        </div>
        <div>
            <x-card title="Count User">
                <div class="text-9xl text-right">
                    {{$data['total']['total']}}
                </div>
            </x-card>
        </div>
        <div class="col-span-2">
            <x-card title="chart overall">
                <livewire:livewire-line-chart 
                        key="{{ $lineModel->reactiveKey() }}"
                        :line-chart-model="$lineModel"
                    /> 
            </x-card>
        </div>

        <hr class="col-span-2 lg:col-span-4">
        
        <div class="col-span-2 lg:col-span-4">
            <x-card title="Summery Data">
                <div class="overflow-x-scroll min-w-full">
            <table class="w-full rounded-xl overflow-hidden">
                <thead>
                    <tr class="bg-primary-100">
                        <th class="border border-primary-100 p-4 w-3/12">Location</th>
                        <th class="border border-primary-100 p-4 w-2/12">Average<br> Score</th>
                        <th class="border  lg:table-cell border-primary-100 p-4 w-1/12">
                            <span class="lg:hidden">Summery </span>
                            <span class="hidden lg:block">Excellent <span class="block text-xs">(5)</span></span>
                        </th>
                        <th class="border hidden lg:table-cell border-primary-100 p-4 w-1/12">Good <span class="block text-xs">(4)</span></th>
                        <th class="border hidden lg:table-cell border-primary-100 p-4 w-1/12">Acceptable <span class="block text-xs">(3)</span></th>
                        <th class="border hidden lg:table-cell border-primary-100 p-4 w-1/12">Poor <span class="block text-xs">(2)</span></th>
                        <th class="border hidden lg:table-cell border-primary-100 p-4 w-1/12">Unacceptable <span class="block text-xs">(1)</span></th>
                        <th class="border border-primary-100 p-4 w-1/12">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key=>$rec)
                    @if ($key!=='total')
                        <tr class="hover:bg-secondary-100">
                            <th class="border border-primary-100 capitalize">{{$key}}</th>
                            <td class="text-center border border-primary-100 p-2">{{$rec['avg']}}</td>
                            <td class="text-center block lg:table-cell border border-primary-100 p-2">{{$rec['score_5']}} <span class="text-xs">({{$rec['percentile_5']}}%)</span></td>
                            <td class="text-center block lg:table-cell border border-primary-100 p-2">{{$rec['score_4']}} <span class="text-xs">({{$rec['percentile_4']}}%)</span></td>
                            <td class="text-center block lg:table-cell border border-primary-100 p-2">{{$rec['score_3']}} <span class="text-xs">({{$rec['percentile_3']}}%)</span></td>
                            <td class="text-center block lg:table-cell border border-primary-100 p-2">{{$rec['score_2']}} <span class="text-xs">({{$rec['percentile_2']}}%)</span></td>
                            <td class="text-center block lg:table-cell border border-primary-100 p-2">{{$rec['score_1']}} <span class="text-xs">({{$rec['percentile_1']}}%)</span></td>
                            <td class="text-center border border-primary-100 p-2">{{$rec['total']}}</td>
                        </tr>
                    @endif
                    @endforeach
                    <tr class="bg-primary-200">
                        <th class="border border-primary-100 p-4">TOTAL</th>
                        <th class="border border-primary-100 p-4">{{$data['total']['avg']}}</th>
                        <th class="border block lg:table-cell border-primary-100 p-4">{{$data['total']['score_5']}}</th>
                        <th class="border block lg:table-cell border-primary-100 p-4">{{$data['total']['score_4']}}</th>
                        <th class="border block lg:table-cell border-primary-100 p-4">{{$data['total']['score_3']}}</th>
                        <th class="border block lg:table-cell border-primary-100 p-4">{{$data['total']['score_2']}}</th>
                        <th class="border block lg:table-cell border-primary-100 p-4">{{$data['total']['score_1']}}</th>
                        <th class="border border-primary-100 p-4">{{$data['total']['total']}}</th>
                    </tr>
                </tbody>
            </table>
                </div>
            </x-card>
        </div>

        <hr class="col-span-2 lg:col-span-4">
        @if($date['chartMode'])
        @foreach ($data as $location=>$data)
            <div class="{{$location=='total'?'col-span-2 lg:col-span-1':''}} capitalize">
                <x-card title="{{$location}}">
                    <livewire:livewire-pie-chart 
                        key="{{ $chartModel[$location]->reactiveKey() }}"
                        :pie-chart-model="$chartModel[$location]"/>
                        
                        <table class="text-xs w-full">
                            <thead>
                                <tr>
                                    <th class="text-center"> {{$location}} </th>
                                    <th class="border border-primary-200 bg-primary-100 p-2 w-1/12">TOTAL</th>
                                    <th class="border border-primary-200 bg-primary-100 p-2 w-1/12">Percentile</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-1 border border-primary-200">Excellent (5)</td><td class="p-1 border border-primary-200 text-right">{{$data['score_5']}}</td><td class="p-1 border border-primary-200 text-right">{{$data['percentile_5']}}%</td>
                                </tr><tr>
                                    <td class="p-1 border border-primary-200">Good (4)</td><td class="p-1 border border-primary-200 text-right">{{$data['score_4']}}</td><td class="p-1 border border-primary-200 text-right">{{$data['percentile_4']}}%</td>
                                </tr><tr>
                                    <td class="p-1 border border-primary-200">Acceptable (3)</td><td class="p-1 border border-primary-200 text-right">{{$data['score_3']}}</td><td class="p-1 border border-primary-200 text-right">{{$data['percentile_3']}}%</td>
                                </tr><tr>
                                    <td class="p-1 border border-primary-200">Poor (2)</td><td class="p-1 border border-primary-200 text-right">{{$data['score_2']}}</td><td class="p-1 border border-primary-200 text-right">{{$data['percentile_2']}}%</td>
                                </tr><tr>
                                    <td class="p-1 border border-primary-200">Unacceptable (1)</td><td class="p-1 border border-primary-200 text-right">{{$data['score_1']}}</td><td class="p-1 border border-primary-200 text-right">{{$data['percentile_1']}}%</td>
                                </tr>
                            </tbody>
                        </table>
                </x-card>
            </div>
        @endforeach

        <div class="col-span-2 lg:col-span-4">
            
            
            <ul class="lg:flex gap-4 justify-center ">
                <li class=""><x-icon name="chart-pie" class="w-5 h-5 text-red-500 inline" solid /> <span class="text-base">Unacceptable (1)</span></li>
                <li class=""><x-icon name="chart-pie" class="w-5 h-5 text-orange-500 inline" solid /> <span class="text-base">Poor (2)</span></li>
                <li class=""><x-icon name="chart-pie" class="w-5 h-5 text-yellow-500 inline" solid /> <span class="text-base">Acceptable (3)</span></li>
                <li class=""><x-icon name="chart-pie" class="w-5 h-5 text-lime-500 inline" solid /> <span class="text-base">Good (4)</span></li>
                <li class=""><x-icon name="chart-pie" class="w-5 h-5 text-green-500 inline" solid /> <span class="text-base">Excellent (5)</span></li>
            </ul>
        </div>

        <hr class="col-span-2 lg:col-span-4">
        @endif
        <div class="col-span-2 lg:col-span-4 flex justify-start gap-2">
            <div>
            <x-native-select
                label="Show"
                placeholder="Selected"
                :options="['5','15','25','50','100','show all']"
                wire:model.live="pagination.show"
            />
            </div><div>
            <x-native-select
                label="Location"
                placeholder="Selected"
                :options="$list['location']"
                wire:model.live="pagination.location"
            />
            </div>

            <div class="ml-auto">
                <x-button label="Download Raw Data"  wire:click="exportDataAll" />
            </div>
        </div>

        <div class="col-span-2 lg:col-span-4">
            <x-card title="Raw Data">
                <table  class="border w-full">
                    <thead>
                        <tr class="bg-primary-100">
                            {{-- <th>ID</th> --}}
                            <th class="p-4 w-3/12">Location</th>
                            <th class="p-4 ">Wristband</th>
                            <th class="p-4 w-1/12">Score</th>
                            <th class="p-4 w-2/12">Date Create</th>
                        </tr>
                    </thead>
    
                    <tbody>
                        @foreach($raw->sortByDesc('created_at') as $ans)
                    <tr class="hover:bg-secondary-100">
                        {{-- <td class="text-center">{{$ans->id}}</td> --}}
                        
                        <td class="p-2 text-center border border-primary-100 capitalize">
                            {{-- {{dd($ans->Location)}} --}}
                            @switch ($ans->Location)
                            @case ('172.16.110.196')
                            Ticketing
                            @break
                            @case ('172.16.110.224')
                            LostAndFound
                            @break
                            @case ('172.16.110.246')
                            Locker
                            @break
                            @case ('172.16.110.248')
                            Retail
                            @break
                            @case ('172.16.110.249')
                            TheVillage
                            @break
                            @case ('172.16.110.244')
                            Tropical
                            @break
                            @case ('172.16.110.161')
                            EmeraldSandbar
                            @break
                            @case ('172.16.110.205')
                            Wavebar
                            @break
                            @default
                            Other
                            @endswitch
                            <!-- {{$ans->Location}} -->
                        </td>
                        <td class="p-2 border border-primary-100 capitalize">{{$ans->user}}</td>
                        <td class="p-2 text-center border border-primary-100 capitalize">{{$ans->socre}}</td>
                        <td class="p-2 border border-primary-100 capitalize text-center">{{$ans->created_at->diffForHumans(Carbon\Carbon::now())}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            @if(get_class($raw)=='Illuminate\Pagination\LengthAwarePaginator')
            <div class="my-4">
            {{ $raw->links() }}
            </div>
            @endif
            </x-card>
        </div>


        @else
        <div class="col-span-2 lg:col-span-4">no data</div>
        @endisset

    </section>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
</div>
