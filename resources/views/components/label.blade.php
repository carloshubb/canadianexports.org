@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-base md:text-base lg:text-lg font-Nunito leading-6 text-gray-900']) }}>
    {{ $value ?? $slot }}
</label>
