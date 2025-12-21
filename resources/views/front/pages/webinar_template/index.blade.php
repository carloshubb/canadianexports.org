@php
    use App\Models\Webinar;

    // Helper function to parse image path from database
    function parseWebinarImage($imagePath) {
        if (!$imagePath) return null;
        
        // If it's a JSON string (array), parse it
        if (is_string($imagePath) && str_starts_with($imagePath, '[')) {
            $parsed = json_decode($imagePath, true);
            if (is_array($parsed) && count($parsed) > 0) {
                return '/' . str_replace('\\', '/', $parsed[0]);
            }
        }
        // If it's already an array
        if (is_array($imagePath) && count($imagePath) > 0) {
            return '/' . str_replace('\\', '/', $imagePath[0]);
        }
        // If it's a plain string path
        if (is_string($imagePath) && strlen($imagePath) > 0) {
            return str_starts_with($imagePath, '/') ? $imagePath : '/' . $imagePath;
        }
        return null;
    }

    // Upcoming webinars (future dates)
    $upcomingWebinars = Webinar::where('status', 'published')
        ->where('scheduled_at', '>', now())
        ->orderBy('scheduled_at')
        ->get();

    // Past webinars (for recordings/replay)
    $pastWebinars = Webinar::where('status', 'published')
        ->where('scheduled_at', '<=', now())
        ->orderBy('scheduled_at', 'desc')
        ->get();

    // Recorded/On-demand webinars
    $recordedWebinars = Webinar::where('status', 'published')
        ->where('webinar_type', 'recorded')
        ->orderBy('created_at', 'desc')
        ->get();
@endphp

<div class="h-full bg-gray-50">
    <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <section>
                @isset($page->pageDetail[0])
                    <div>
                        @php
                            $page_detail = $page->pageDetail[0]->page_detail;
                        @endphp
                        @include('front.pages.widgets.render-widget-with-detail', [
                            'page_detail' => $page_detail,
                        ])
                    </div>
                @endisset

                <div class="container mt-8">
                    {{-- Upcoming Webinars --}}
                    <webinars-index
                        :webinars='@json($upcomingWebinars)'
                        register-url="{{ url('api/webinars') }}"
                    ></webinars-index>

                    {{-- Recorded/On-Demand Webinars Section --}}
                    @if($recordedWebinars->count() > 0)
                        <div class="mt-12">
                            <h2 class="can-exp-h2 text-primary mb-6">On-Demand Webinars</h2>
                            <p class="text-gray-600 mb-6">Watch these webinars anytime at your convenience.</p>
                            <div class="grid gap-6 md:grid-cols-2">
                                @foreach($recordedWebinars as $webinar)
                                    @php $coverImg = parseWebinarImage($webinar->cover_image); @endphp
                                    <div class="border border-gray-200 rounded-lg overflow-hidden bg-white shadow-sm">
                                        {{-- Cover Image or Video Embed --}}
                                        @if($webinar->embed_code)
                                            <div class="aspect-video bg-black">
                                                {!! $webinar->embed_code !!}
                                            </div>
                                        @elseif($coverImg)
                                            <div class="aspect-video bg-gray-200">
                                                <img src="{{ $coverImg }}" alt="{{ $webinar->title }}" class="w-full h-full object-cover">
                                            </div>
                                        @elseif($webinar->recording_url)
                                            @php
                                                // Auto-generate embed for YouTube/Vimeo URLs
                                                $embedHtml = '';
                                                if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $webinar->recording_url, $matches)) {
                                                    $embedHtml = '<iframe class="w-full h-full" src="https://www.youtube.com/embed/' . $matches[1] . '" frameborder="0" allowfullscreen></iframe>';
                                                } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $webinar->recording_url, $matches)) {
                                                    $embedHtml = '<iframe class="w-full h-full" src="https://www.youtube.com/embed/' . $matches[1] . '" frameborder="0" allowfullscreen></iframe>';
                                                } elseif (preg_match('/vimeo\.com\/(\d+)/', $webinar->recording_url, $matches)) {
                                                    $embedHtml = '<iframe class="w-full h-full" src="https://player.vimeo.com/video/' . $matches[1] . '" frameborder="0" allowfullscreen></iframe>';
                                                }
                                            @endphp
                                            @if($embedHtml)
                                                <div class="aspect-video bg-black">
                                                    {!! $embedHtml !!}
                                                </div>
                                            @else
                                                <div class="aspect-video bg-gray-800 flex items-center justify-center">
                                                    <a href="{{ $webinar->recording_url }}" target="_blank" class="text-white hover:text-blue-300 flex flex-col items-center">
                                                        <svg class="w-16 h-16 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                                        </svg>
                                                        <span>Watch Recording</span>
                                                    </a>
                                                </div>
                                            @endif
                                        @else
                                            <div class="aspect-video bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-500">No recording available</span>
                                            </div>
                                        @endif
                                        
                                        <div class="p-5">
                                            <div class="flex items-start justify-between mb-2">
                                                <h3 class="text-xl font-semibold text-primary">{{ $webinar->title }}</h3>
                                                <span class="text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded">On-Demand</span>
                                            </div>
                                            @if($webinar->presenter_name)
                                                <p class="text-sm text-gray-600 mb-2">With {{ $webinar->presenter_name }}</p>
                                            @endif
                                            @if($webinar->duration_minutes)
                                                <p class="text-sm text-gray-700 mb-2">
                                                    <span class="font-semibold">Duration:</span> {{ $webinar->duration_minutes }} minutes
                                                </p>
                                            @endif
                                            @if($webinar->description)
                                                <p class="text-sm text-gray-700 line-clamp-3">{{ $webinar->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Past Webinars Section (with recordings) --}}
                    @php
                        $pastWithRecordings = $pastWebinars->filter(fn($w) => $w->recording_url || $w->embed_code);
                    @endphp
                    @if($pastWithRecordings->count() > 0)
                        <div class="mt-12">
                            <h2 class="can-exp-h2 text-primary mb-6">Past Webinar Recordings</h2>
                            <div class="grid gap-6 md:grid-cols-2">
                                @foreach($pastWithRecordings as $webinar)
                                    @php $coverImg = parseWebinarImage($webinar->cover_image); @endphp
                                    <div class="border border-gray-200 rounded-lg overflow-hidden bg-white shadow-sm">
                                        {{-- Cover Image or Video Embed --}}
                                        @if($webinar->embed_code)
                                            <div class="aspect-video bg-black">
                                                {!! $webinar->embed_code !!}
                                            </div>
                                        @elseif($coverImg)
                                            <div class="aspect-video bg-gray-200">
                                                <img src="{{ $coverImg }}" alt="{{ $webinar->title }}" class="w-full h-full object-cover">
                                            </div>
                                        @elseif($webinar->recording_url)
                                            @php
                                                $embedHtml = '';
                                                if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $webinar->recording_url, $matches)) {
                                                    $embedHtml = '<iframe class="w-full h-full" src="https://www.youtube.com/embed/' . $matches[1] . '" frameborder="0" allowfullscreen></iframe>';
                                                } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $webinar->recording_url, $matches)) {
                                                    $embedHtml = '<iframe class="w-full h-full" src="https://www.youtube.com/embed/' . $matches[1] . '" frameborder="0" allowfullscreen></iframe>';
                                                } elseif (preg_match('/vimeo\.com\/(\d+)/', $webinar->recording_url, $matches)) {
                                                    $embedHtml = '<iframe class="w-full h-full" src="https://player.vimeo.com/video/' . $matches[1] . '" frameborder="0" allowfullscreen></iframe>';
                                                }
                                            @endphp
                                            @if($embedHtml)
                                                <div class="aspect-video bg-black">
                                                    {!! $embedHtml !!}
                                                </div>
                                            @else
                                                <div class="aspect-video bg-gray-800 flex items-center justify-center">
                                                    <a href="{{ $webinar->recording_url }}" target="_blank" class="text-white hover:text-blue-300 flex flex-col items-center">
                                                        <svg class="w-16 h-16 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                                        </svg>
                                                        <span>Watch Recording</span>
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                        
                                        <div class="p-5">
                                            <div class="flex items-start justify-between mb-2">
                                                <h3 class="text-xl font-semibold text-primary">{{ $webinar->title }}</h3>
                                                <span class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded">Recording</span>
                                            </div>
                                            @if($webinar->presenter_name)
                                                <p class="text-sm text-gray-600 mb-2">With {{ $webinar->presenter_name }}</p>
                                            @endif
                                            <p class="text-sm text-gray-700 mb-2">
                                                <span class="font-semibold">Originally aired:</span> 
                                                {{ \Carbon\Carbon::parse($webinar->scheduled_at)->format('M d, Y') }}
                                            </p>
                                            @if($webinar->description)
                                                <p class="text-sm text-gray-700 line-clamp-3">{{ $webinar->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</div>

