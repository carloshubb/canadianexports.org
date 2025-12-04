@extends('front.layouts.app')

@section('title', 'Articles')
@section('meta_description', 'Latest articles and insights')

@section('content')
<section class="relative pt-28 md:pt-32 pb-10 md:pb-14">
  <div class="container">
    <!-- Featured Article Hero -->
    @if($featuredArticle)
    <div class="relative h-96 md:h-[500px] mb-12 rounded-3xl overflow-hidden shadow-2xl group">
      <!-- Background Image -->
      <img src="{{ getImageUrl($featuredArticle->cover_image) }}" 
           alt="{{ $featuredArticle->title }}" 
           class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
      
      <!-- Gradient Overlay -->
      <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent"></div>
      
      <!-- Content -->
      <div class="absolute inset-0 flex flex-col justify-end p-6 md:p-12">
        <!-- Featured Badge -->
        <div class="mb-4">
          <span class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-full text-sm font-bold shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            Featured Article
          </span>
        </div>
        
        <!-- Category & Date -->
        <div class="flex items-center gap-3 text-white/90 text-sm mb-3">
          @if($featuredArticle->section)
            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full border border-white/30">
              {{ $featuredArticle->section->name }}
            </span>
          @endif
          <span class="flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            {{ $featuredArticle->published_at->format('M d, Y') }}
          </span>
          @if($featuredArticle->author)
            <span class="flex items-center gap-2">
              <div class="w-6 h-6 bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center text-white text-xs font-bold border border-white/40">
                {{ strtoupper(substr($featuredArticle->author->name, 0, 1)) }}
              </div>
              {{ $featuredArticle->author->name }}
            </span>
          @endif
        </div>
        
        <!-- Title -->
        <h2 class="text-3xl md:text-5xl font-bold text-white mb-4 leading-tight max-w-4xl">
          {{ $featuredArticle->title }}
        </h2>
        
        <!-- Summary -->
        @if($featuredArticle->summary)
          <p class="text-lg md:text-xl text-white/90 mb-6 max-w-3xl line-clamp-2">
            {{ $featuredArticle->summary }}
          </p>
        @endif
        
        <!-- CTA Button -->
        <div>
          <a href="{{ route('web.articles.show', ['abbreviation' => request()->route('abbreviation'),'slug' => $featuredArticle->slug]) }}" 
             class="inline-flex items-center gap-2 px-8 py-4 bg-white text-primary rounded-xl font-bold shadow-xl hover:shadow-2xl hover:bg-gray-50 transform hover:scale-105 transition-all duration-300">
            Read Full Article
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </a>
        </div>
      </div>
    </div>
    @endif

    <!-- Page Header with Enhanced Search -->
    <div class="mb-8">
      <div class="text-center mb-8">
        <h1 class="text-4xl md:text-5xl font-bold text-primary mb-3">Articles & Insights</h1>
        <p class="text-lg text-gray-600">Discover the latest trends, tips, and industry knowledge</p>
      </div>
      
      <!-- Enhanced Search Bar -->
      <form id="articles-filter-form" method="GET" class="max-w-2xl mx-auto mb-8">
        <div class="relative">
          <input type="text" 
                 name="q" 
                 value="{{ request('q') }}" 
                 placeholder="Search articles, topics, insights..." 
                 class="w-full px-6 py-4 pl-14 rounded-2xl border-2 border-gray-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition shadow-sm hover:shadow-md" />
          <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-5 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          @if(request('q'))
            <button type="button" onclick="document.querySelector('input[name=q]').value=''; document.getElementById('articles-filter-form').submit();" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          @endif
        </div>
      </form>
      
      <!-- Visual Section Navigation -->
      @if($sections->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
          <a href="?{{ http_build_query(array_filter(array_merge(request()->except('section'), ['section' => null]))) }}" 
             class="group relative h-28 rounded-xl overflow-hidden transition-all duration-300 hover:scale-105 {{ !request('section') ? 'ring-4 ring-primary/50' : '' }}">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-400 to-gray-600"></div>
            <div class="absolute inset-0 flex flex-col items-center justify-center text-white p-3">
              <span class="text-3xl mb-1">📚</span>
              <span class="font-semibold text-sm text-center">All Articles</span>
              <span class="text-xs opacity-90 mt-1">{{ $articles->total() }}</span>
            </div>
            @if(!request('section'))
              <div class="absolute inset-0 border-2 border-white"></div>
            @endif
          </a>
          
          @foreach($sections as $s)
            @php $active = request('section') === $s->slug; @endphp
            <a href="?{{ http_build_query(array_merge(request()->except('page'), ['section' => $s->slug])) }}" 
               class="group relative h-28 rounded-xl overflow-hidden transition-all duration-300 hover:scale-105 {{ $active ? 'ring-4 ring-primary/50' : '' }}">
              @if($s->cover_image)
                <img src="{{ getImageUrl($s->cover_image) }}" alt="{{ $s->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-black/20 group-hover:from-black/80 transition-all"></div>
              @else
                <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-600 group-hover:from-blue-500 group-hover:to-indigo-700 transition-all"></div>
              @endif
              <div class="absolute inset-0 flex flex-col items-center justify-center text-white p-3 text-center">
                <span class="font-bold text-sm line-clamp-2">{{ $s->name }}</span>
                <span class="text-xs opacity-90 mt-1">{{ $s->articles_count ?? 0 }} articles</span>
              </div>
              @if($active)
                <div class="absolute inset-0 border-2 border-white"></div>
              @endif
            </a>
          @endforeach
        </div>
      @endif
    </div>

    <!-- Enhanced Article Cards -->
    @if($articles->count())
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($articles as $a)
        <article class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-primary/30">
          <!-- Cover Image -->
          <a href="{{ route('web.articles.show', ['abbreviation' => request()->route('abbreviation'),'slug' => $a->slug]) }}" class="block relative overflow-hidden">
            @if($a->cover_image)
              <div class="aspect-[16/9] bg-gray-100">
                <img src="{{ getImageUrl($a->cover_image) }}" 
                     alt="{{ $a->title }}" 
                     loading="lazy"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
              </div>
            @else
              <div class="aspect-[16/9] bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
              </div>
            @endif
            <!-- Gradient overlay on hover -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          </a>
          
          <!-- Content -->
          <div class="p-6">
            <!-- Meta Info -->
            <div class="flex items-center gap-3 text-xs mb-3">
              <time class="text-gray-500 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ optional($a->published_at)->format('M d, Y') }}
              </time>
              @if($a->section)
                <span class="px-2.5 py-1 bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 rounded-full text-xs font-medium border border-blue-200/50">
                  {{ $a->section->name }}
                </span>
              @endif
            </div>
            
            <!-- Title -->
            <a href="{{ route('web.articles.show', ['abbreviation' => request()->route('abbreviation'),'slug' => $a->slug]) }}" class="block mb-3">
              <h2 class="text-xl font-bold text-gray-900 group-hover:text-primary transition-colors leading-tight line-clamp-2">
                {{ $a->title }}
              </h2>
            </a>
            
            <!-- Summary -->
            @if($a->summary)
              <p class="text-gray-600 line-clamp-3 mb-4 leading-relaxed">{{ $a->summary }}</p>
            @endif
            
            <!-- Footer with Author & Read More -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
              @if($a->author)
                <div class="flex items-center gap-2">
                  <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-semibold shadow-sm">
                    {{ strtoupper(substr($a->author->name, 0, 1)) }}
                  </div>
                  <span class="text-sm text-gray-600 font-medium">{{ $a->author->name }}</span>
                </div>
              @else
                <div></div>
              @endif
              <a href="{{ route('web.articles.show', ['abbreviation' => request()->route('abbreviation'),'slug' => $a->slug]) }}" 
                 class="text-primary font-semibold text-sm hover:text-secondary transition inline-flex items-center gap-1 group/link">
                Read more
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
              </a>
            </div>
          </div>
        </article>
        @endforeach
      </div>
    @else
      <!-- Empty State -->
      <div class="text-center py-20">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">No articles found</h3>
        <p class="text-gray-500">{{ request('q') ? 'Try adjusting your search terms' : 'Check back soon for new content!' }}</p>
      </div>
    @endif
    
    <!-- Enhanced Pagination -->
    @if($articles->hasPages())
      <div class="mt-12">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-4 py-6 bg-white rounded-2xl shadow-sm border border-gray-200">
          <!-- Results Info -->
          <div class="text-sm text-gray-600">
            Showing <span class="font-semibold text-gray-900">{{ $articles->firstItem() }}</span> 
            to <span class="font-semibold text-gray-900">{{ $articles->lastItem() }}</span> 
            of <span class="font-semibold text-gray-900">{{ $articles->total() }}</span> articles
          </div>
          
          <!-- Pagination Links -->
          <div>
            {{ $articles->links() }}
          </div>
        </div>
      </div>
    @endif
  </div>

  @push('scripts')
  <script>
    (function(){
      const form = document.getElementById('articles-filter-form');
      if(!form) return;
      const q = form.querySelector('input[name="q"]');
      let t;
      function submitDebounced(){
        clearTimeout(t);
        t = setTimeout(()=>form.submit(), 400);
      }
      if(q){
        q.addEventListener('input', submitDebounced);
      }
    })();

    // Scroll to Top Button for Index Page
    (function() {
      // Create scroll to top button
      const scrollBtn = document.createElement('button');
      scrollBtn.id = 'scroll-to-top-index';
      scrollBtn.className = 'fixed bottom-6 right-6 w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-primary to-secondary text-white rounded-full shadow-xl hover:shadow-2xl transform hover:scale-110 transition-all duration-300 opacity-0 pointer-events-none z-40';
      scrollBtn.setAttribute('aria-label', 'Scroll to top');
      scrollBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>';
      document.body.appendChild(scrollBtn);
      
      // Show/hide on scroll
      window.addEventListener('scroll', function() {
        if (window.scrollY > 400) {
          scrollBtn.classList.remove('opacity-0', 'pointer-events-none');
          scrollBtn.classList.add('opacity-100');
        } else {
          scrollBtn.classList.add('opacity-0', 'pointer-events-none');
          scrollBtn.classList.remove('opacity-100');
        }
      });
      
      // Scroll to top on click
      scrollBtn.addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
    })();
  </script>
  @endpush
</section>
@endsection


