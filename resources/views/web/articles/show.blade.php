@extends('front.layouts.app')

@section('title', $article->meta_title ?: $article->title)
@section('meta_description', $article->meta_description ?: Str::limit(strip_tags($article->summary ?: $article->body), 150))

@section('content')
<!-- Reading Progress Bar -->
<div id="reading-progress" class="fixed top-0 left-0 h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 z-50 transition-all duration-150" style="width: 0%"></div>

<!-- Scroll to Top Button -->
<button id="scroll-to-top" 
        class="fixed bottom-6 right-6 w-12 h-12 bg-gradient-to-br from-primary to-secondary text-white rounded-full shadow-xl hover:shadow-2xl transform hover:scale-110 transition-all duration-300 opacity-0 pointer-events-none z-40"
        aria-label="Scroll to top">
  <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
  </svg>
</button>

<!-- Mobile Back Button -->
<button onclick="window.history.back()" 
        class="md:hidden fixed bottom-6 left-6 w-12 h-12 bg-white text-primary rounded-full shadow-xl border-2 border-primary hover:bg-primary hover:text-white transition-all duration-300 z-40"
        aria-label="Go back">
  <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
  </svg>
</button>

<section class="relative pt-28 md:pt-32 pb-10 md:pb-14">
  <div class="container">
    <!-- Breadcrumbs -->
    <nav class="mb-6 text-sm" aria-label="Breadcrumb">
      <ul class="flex items-center gap-2 flex-wrap list-none">
        <li>
          <a href="{{ url('/') }}" class="text-gray-500 hover:text-primary transition flex items-center gap-1.5 hover:underline">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Home
          </a>
        </li>
        <li class="text-gray-400">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </li>
        <li>
          <a href="{{ route('web.articles.index', ['abbreviation' => request()->route('abbreviation')]) }}" class="text-gray-500 hover:text-primary transition hover:underline">
            Articles
          </a>
        </li>
        @if($article->section)
          <li class="text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </li>
          <li>
            <span class="text-primary font-medium">{{ $article->section->name }}</span>
          </li>
        @endif
      </ul>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
      <div class="lg:col-span-8">
        <!-- Article Header -->
        <div class="mb-6 md:mb-8">
          <h1 class="text-2xl md:text-4xl font-bold text-gray-900 mb-4 md:mb-6 leading-tight">{{ $article->title }}</h1>
          
          <!-- Meta Information -->
          <div class="flex flex-wrap items-center gap-3 md:gap-4 text-sm text-gray-600 pb-4 md:pb-6 border-b border-gray-200">
            <!-- Author -->
            @if($article->author)
              <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-full flex items-center justify-center text-white font-semibold shadow-sm">
                  {{ strtoupper(substr($article->author->name, 0, 1)) }}
                </div>
                <div class="flex flex-col">
                  <span class="text-gray-900 font-semibold">{{ $article->author->name }}</span>
                  <span class="text-xs text-gray-500">Author</span>
                </div>
              </div>
            @endif
            
            <!-- Published Date -->
            <div class="flex items-center gap-1.5 text-gray-600">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <span>{{ optional($article->published_at)->format('M d, Y') }}</span>
            </div>
            
            <!-- Section Badge -->
            @if($article->section)
              <span class="px-3 py-1.5 bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 rounded-full text-sm font-medium border border-blue-200/50">
                {{ $article->section->name }}
              </span>
            @endif
          </div>
        </div>

        <!-- Article Content -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 p-4 md:p-8">
          @php $tpl = $article->template; @endphp
          @if(in_array($tpl, ['image_left','image_right']))
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 items-start mb-6">
              @if($tpl === 'image_left')
                <div class="md:col-span-2">
                  @include('web.articles.partials.media')
                </div>
                <div class="md:col-span-3 prose prose-lg max-w-none">{!! $article->body !!}</div>
              @else
                <div class="md:col-span-3 prose prose-lg max-w-none">{!! $article->body !!}</div>
                <div class="md:col-span-2">@include('web.articles.partials.media')</div>
              @endif
            </div>
          @elseif($tpl === 'media_bottom')
            <div class="prose prose-lg max-w-none mb-8">{!! $article->body !!}</div>
            @include('web.articles.partials.media')
          @else
            <!-- Standard Template - Show cover image first if no video -->
            @if(!$article->video_url && $article->cover_image)
              <div class="mb-8">
                @include('web.articles.partials.media')
              </div>
            @endif
            <div class="prose prose-lg max-w-none">{!! $article->body !!}</div>
          @endif
          
          <!-- Keywords/Tags -->
          @if($article->keywords && is_array($article->keywords) && count($article->keywords) > 0)
            <div class="mt-8 pt-6 border-t border-gray-200">
              <div class="flex items-center gap-2 flex-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                @foreach($article->keywords as $keyword)
                  <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-primary hover:text-white transition cursor-default">
                    {{ $keyword }}
                  </span>
                @endforeach
              </div>
            </div>
          @endif
        </div>
        
        <!-- Share Buttons -->
        <div class="mt-6 flex flex-col sm:flex-row items-start sm:items-center gap-3">
          <span class="text-gray-600 font-medium text-sm md:text-base">Share this article:</span>
          <div class="flex items-center gap-3">
          <button onclick="shareTwitter()" class="w-10 h-10 rounded-full bg-blue-400 hover:bg-blue-500 text-white transition flex items-center justify-center shadow-sm" title="Share on Twitter">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
            </svg>
          </button>
          <button onclick="shareLinkedIn()" class="w-10 h-10 rounded-full bg-blue-700 hover:bg-blue-800 text-white transition flex items-center justify-center shadow-sm" title="Share on LinkedIn">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
            </svg>
          </button>
          <button onclick="shareFacebook()" class="w-10 h-10 rounded-full bg-blue-600 hover:bg-blue-700 text-white transition flex items-center justify-center shadow-sm" title="Share on Facebook">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
          </button>
          </div>
        </div>
      </div>
      <aside class="lg:col-span-4 mt-8 lg:mt-0">
        @if(($relatedByAuthor && $relatedByAuthor->count()) || ($relatedByKeywords && $relatedByKeywords->count()))
          <div class="bg-white rounded-xl md:rounded-2xl border border-gray-200 shadow-sm p-4 md:p-6 lg:sticky lg:top-28">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
              </svg>
              Related Articles
            </h3>
            
            @if($relatedByAuthor && $relatedByAuthor->count())
              <div class="mb-6">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3 flex items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  By the same author
                </h4>
                <ul class="space-y-3">
                  @foreach($relatedByAuthor as $ra)
                    <li class="group">
                      <a href="{{ route('web.articles.show', ['abbreviation' => request()->route('abbreviation'),'slug' => $ra->slug]) }}" class="block p-3 rounded-lg hover:bg-gray-50 transition">
                        <div class="font-semibold text-gray-900 group-hover:text-primary transition line-clamp-2 mb-1">{{ $ra->title }}</div>
                        <div class="text-xs text-gray-500 flex items-center gap-1">
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                          {{ optional($ra->published_at)->format('M d, Y') }}
                        </div>
                      </a>
                    </li>
                  @endforeach
                </ul>
              </div>
            @endif
            
            @if($relatedByKeywords && $relatedByKeywords->count())
              <div>
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3 flex items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                  </svg>
                  Similar Topics
                </h4>
                <ul class="space-y-3">
                  @foreach($relatedByKeywords as $rk)
                    <li class="group">
                      <a href="{{ route('web.articles.show', ['abbreviation' => request()->route('abbreviation'),'slug' => $rk->slug]) }}" class="block p-3 rounded-lg hover:bg-gray-50 transition">
                        <div class="font-semibold text-gray-900 group-hover:text-primary transition line-clamp-2 mb-1">{{ $rk->title }}</div>
                        <div class="text-xs text-gray-500 flex items-center gap-1">
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                          {{ optional($rk->published_at)->format('M d, Y') }}
                        </div>
                      </a>
                    </li>
                  @endforeach
                </ul>
              </div>
            @endif
          </div>
        @endif
      </aside>
    </div>
  </div>
</section>

@push('scripts')
<script>
  // Social Share Functions
  function shareTwitter() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent('{{ addslashes($article->title) }}');
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, 'twitter-share', 'width=550,height=420');
  }
  
  function shareLinkedIn() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, 'linkedin-share', 'width=550,height=420');
  }
  
  function shareFacebook() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, 'facebook-share', 'width=550,height=420');
  }

  // Reading Progress Bar
  (function() {
    const progressBar = document.getElementById('reading-progress');
    const scrollToTopBtn = document.getElementById('scroll-to-top');
    
    if (progressBar) {
      window.addEventListener('scroll', function() {
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight - windowHeight;
        const scrolled = window.scrollY;
        const progress = (scrolled / documentHeight) * 100;
        
        progressBar.style.width = Math.min(progress, 100) + '%';
        
        // Show/hide scroll to top button
        if (scrolled > 300) {
          scrollToTopBtn.classList.remove('opacity-0', 'pointer-events-none');
          scrollToTopBtn.classList.add('opacity-100');
        } else {
          scrollToTopBtn.classList.add('opacity-0', 'pointer-events-none');
          scrollToTopBtn.classList.remove('opacity-100');
        }
      });
    }
    
    // Scroll to top functionality
    if (scrollToTopBtn) {
      scrollToTopBtn.addEventListener('click', function() {
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      });
    }
  })();
</script>
@endpush

@endsection


