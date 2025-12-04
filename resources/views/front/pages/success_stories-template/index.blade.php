@isset($successStoriesSettingDetail)
    <div class="h-full bg-gray-50">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
                <section class="">
                    @isset($page->pageDetail[0])
                        <div class="">
                            @php
                                $page_detail = $page->pageDetail[0]->page_detail;
                            @endphp
                            @include('front.pages.widgets.render-widget-with-detail', [
                                'page_detail' => $page_detail,
                            ])
                        </div>

                    @endisset
                    <div class="container">
                        <div class="grid grid-cols-1 mt-8 gap-5">
                            @php
                                $successStories = getAllSuccessStories(30, $lang);
                            @endphp
                            @forelse ($successStories as $successStorie)
                                <div class="flex flex-col mb-4">
                                    <h2 class="text-lg font-bold">
                                        {{ isset($successStorie->successStoriesDetail[0]) ? $successStorie->successStoriesDetail[0]->company_name : '' }}:
                                    </h2>
                                    <p class="">
                                        {{ isset($successStorie->successStoriesDetail[0]) ? $successStorie->successStoriesDetail[0]->message : '' }}
                                    </p>
                                </div>
                            @empty
                                <!-- <p>No result found</p> -->
                            @endforelse
                        </div>
                        <div class="mt-10">
                            {{ $successStories->links() }}
                        </div>
                    </div>
                    <h1 class="text-center">{{ $successStoriesSettingDetail->page_heading }}</h1>
                    <div class="container">
                        <p class="text-red-500"><span class="text-red-500">*</span>
                            {{ $successStoriesSettingDetail->required_fields_text }}</p>
                    </div>
                    <!--Tabs-->
                    <div class="grid grid-cols-1 gap-12 container">
                        <div class="order-2 md:order-1">
                            <success-stories success_stories_setting="{{ $successStoriesSettingDetail }}"
                                submit_url="{{ route('user.success-stories.send-message') }}" page_id="{{ $page->id }}">
                            </success-stories>
                        </div>

                    </div>



                </section>
            </div>
        </div>
    </div>
@endisset
