@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Your Banners</h2>

    @if($banners->isEmpty())
        <p>No banners found.</p>
    @else
        <div class="grid grid-cols-3 gap-4">
            @foreach($banners as $banner)
                <div class="p-4 border rounded shadow">
                    {{-- <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="w-full h-48 object-cover"> --}}
                    <h3 class="text-lg font-semibold mt-2">{{ $banner->business_name }}</h3>
                    <h3 class="text-lg font-semibold mt-2">{{ $banner->small_business_description }}</h3>
                </div>
            @endforeach
        </div>
    @endif
</div>
@section('content')

@endsection
