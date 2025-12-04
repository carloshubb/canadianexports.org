@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'can-exp-input rounded border border-gray-300']) !!}>
