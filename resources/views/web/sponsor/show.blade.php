@extends('front.layouts.app')
@section('title', 'Canadian Exports | Register your account')
@section('meta_description',
    'Canadian Exports is a Canadian export portal and a directory of Canadian exporters,
    showcasing lists of Canadian products and services, and promoting Canadian manufacturers and exporters. Canadian Exports
    is a Canadian business directory and a Canadian business database highlighting the Canadian industry')
@section('Canadian Export, Export from Canada, Canada export, Export Canada, Exporting from Canada, Canada export
    catalogue, Canada export directory, Directory of, Canadian exporters, Canada business directory, Directory of Canadian
    companies, Directory of Canadian companies, Canada trade, Canadian trade, Canada export portal, Canada trade mission')
@section('content')
    @php
        $lang = getDefaultLanguage(true);
    @endphp
    <div class="h-full bg-gray-50 lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10 container">
            <div class="">

                <section class="mb-4">
                    <div class=" bg-white rounded shadow pt-6">
                        <div class="px-4 md:px-12 desktop:px-80">
                            <h2 class="text-primary text-center">
                                @isset($sponsor)
                                    {!! $sponsor->business_name ?? $sponsor->name !!}
                                @endisset
                            </h2>
                        </div>
                        
                        {{-- Brief Description --}}
                        @if(isset($sponsor->summary))
                        <div class="px-4 md:px-12 desktop:px-80 mt-4">
                            <p class="text-lg text-gray-700">
                                {!! $sponsor->summary !!}
                            </p>
                        </div>
                        @endif

                        <div class="p-4 md:px-12 desktop:px-80 grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                            <div class="order-2 md:order-2 lg:order-1 mt-[5px]">
                                @php
                                    // Support both new Sponsor model and old Banner model
                                    $description = $sponsor->detail_description ?? $sponsor['detail_description'] ?? '';
                                @endphp
                                <p>{!! $description !!}</p>
                            </div>

                            <div class="order-1 md:order-1 lg:order-2">
                                <div class="">
                                    @php
                                        // Support both new Sponsor model and old Banner model
                                        $imageMedia = null;
                                        if (isset($sponsor->featuredMedia) && $sponsor->featuredMedia) {
                                            $imageMedia = $sponsor->featuredMedia;
                                        } elseif (isset($sponsor->mediaImage) && $sponsor->mediaImage) {
                                            $imageMedia = $sponsor->mediaImage;
                                        } elseif (isset($banner->mediaImage) && $banner->mediaImage) {
                                            $imageMedia = $banner->mediaImage;
                                        }
                                    @endphp

                                    @if($imageMedia)
                                        <div>
                                            @php
                                                $imagePath = $imageMedia->large_image ?? $imageMedia->medium_image ?? $imageMedia->path;
                                            @endphp
                                            @if($imagePath && file_exists($imagePath))
                                                <img class="h-60 md:h-80 w-full object-cover rounded"
                                                    src="{{ asset($imagePath) }}" alt="{{ $sponsor->business_name ?? 'Sponsor' }}">
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="p-4 md:px-12 desktop:px-80 flex justify-center">
                            <button class="button-exp-fill whitespace-nowrap mt-10 mb-10">
                                <a class="text-white fix-url" onclick="fixUrls()" aria-label="Candian Exporters"
                                    href="{{ $sponsor->url }}" target="_blank">
                                    Go to {{ $sponsor->business_name ?? $sponsor->name }}
                                </a>
                            </button>
                        </div>

                    </div>

                </section>


            </div>
        </div>
    </div>
@endsection
@section('scripts')


@endsection
