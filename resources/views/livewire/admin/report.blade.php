<div class="container mx-auto relative">
    <x-nav />
    <section class="h-28">
        
    </section>
    <section class="bg-slate-50 shadow grid grid-cols-2 lg:grid-cols-4 gap-2 p-5 rounded-xl">
        <div class="col-span-2 lg:col-span-4">
            <h1>Report</h1>
        
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
                    <x-toggle label="Month" wire:model="date.monthMode" />
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
                            wire:model="date.month"
                        />
                    @endif

                </div>
                <x-toggle label="Show Chart" wire:model="date.chartMode" />

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


        @else
        <div class="col-span-2 lg:col-span-4">no data</div>
        @endisset

    </section>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
</div>
