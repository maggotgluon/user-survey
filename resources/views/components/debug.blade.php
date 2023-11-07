<div>
    @if(config('app.env')=='local')
    <div class="flex flex-wrap gap-2 p-2 mx-auto max-w-xs">
        <x-badge outline info  :icon="$icon??'adjustments'" >
            {{$slot??'env : '.config('app.env')}}
        </x-badge>
    </div>
    @endif
</div>