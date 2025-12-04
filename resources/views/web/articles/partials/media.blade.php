@if($article->video_url)
  @php
    $videoUrl = trim($article->video_url);
    $embedUrl = $videoUrl;
    if (Str::contains($videoUrl, ['youtube.com', 'youtu.be'])) {
        $videoId = null;
        if (preg_match('/youtu\.be\/([^\?&]+)/', $videoUrl, $m)) {
            $videoId = $m[1];
        } elseif (preg_match('/v=([^\?&]+)/', $videoUrl, $m)) {
            $videoId = $m[1];
        } elseif (preg_match('/embed\/([^\?&]+)/', $videoUrl, $m)) {
            $videoId = $m[1];
        }
        if ($videoId) {
            $embedUrl = 'https://www.youtube.com/embed/' . $videoId . '?rel=0&modestbranding=1';
        }
    }
  @endphp
  <div class="relative w-full overflow-hidden rounded-xl shadow-lg" style="padding-top: 56.25%;">
    <iframe
      src="{{ $embedUrl }}"
      class="absolute top-0 left-0 w-full h-full"
      frameborder="0"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
      allowfullscreen
    ></iframe>
  </div>
@elseif($article->cover_image)
  <div class="relative rounded-xl overflow-hidden shadow-lg">
    <img src="{{ getImageUrl($article->cover_image) }}" 
         alt="{{ $article->title }}" 
         loading="lazy"
         class="w-full h-auto object-cover">
  </div>
@endif


