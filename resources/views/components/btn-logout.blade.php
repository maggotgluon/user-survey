@php

    $defaultAttributes = [
        'wire:loading.attr'  => 'disabled',
        'wire:loading.class' => '!cursor-wait',
    ];

@endphp
<x-button :href="route('logout')" 
    {{ $attributes->merge($defaultAttributes) }}
    onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
    />

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>