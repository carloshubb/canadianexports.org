@extends('front.layouts.app')

@section('title', 'Articles')
@section('meta_description', 'Latest articles and insights')

@section('content')
    <div class="container mx-auto py-24  px-4">
        <div class="text-center"> 
            <h1 class="text-4xl md:text-5xl font-extrabold mb-3 bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 bg-clip-text text-transparent tracking-tight">
                @if($subsection)
                    {{ $subsection->name }}
                @else
                    Search Results
                @endif
            </h1>    
        </div>

        <article class="bg-white rounded-xl shadow-sm overflow-hidden border-[3px] border-[#bdafb7] hover:shadow-lg transition-all duration-300 p-4 flex items-center gap-6 ">
            <div class="grid grid-cols-1 gap-6 w-full">
                @foreach($articles as $article)
                <article class="bg-white w-full rounded-xl shadow-sm overflow-hidden border border-[#4babe3] hover:shadow-lg transition-all duration-300 p-4 flex items-center gap-6 border-t-[5px] ">

                    {{-- LEFT: Circular Image --}}
                    <article class="group bg-white rounded-xl overflow-hidden flex items-center gap-6">
                        <div class="w-48 h-48 flex-shrink-0 overflow-hidden rounded-full">
                            @if($article->cover_image)
                                <img src="{{ getImageUrl($article->cover_image) }}"
                                    alt="{{ $article->title }}"
                                    loading="lazy"
                                    class="w-full h-full object-cover rounded-full transition-all duration-500 ease-out group-hover:scale-150 group-hover:shadow-2xl">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400 rounded-full">No image</div>
                            @endif
                        </div>
                    </article>

                    {{-- RIGHT SIDE CONTENT --}}
                    <div class="flex-1">
                        <h1 class="text-4xl font-bold text-[#b18142]">
                            {{ $article->title }}
                        </h1>
                        
                        <p class="text-gray-900 mt-2">
                            {{ \Illuminate\Support\Str::limit($article->summary, 50) }}
                        </p>                    

                        {{-- BUTTON --}}
                        <div class="flex mt-4 justify-end">
                            <a href="{{ route('web.articles.show', ['abbreviation' => $abbreviation, 'slug' => $article->slug]) }}"
                            class="inline-block bg-[#349765] text-white px-5 py-2 rounded-md font-medium hover:bg-[#27754e]">
                            Continue reading
                            </a>
                        </div>
                    </div>

                </article>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $articles->links('web.articles.custom-tailwind') }}
            </div>
        </article>  
    </div>
@endsection


