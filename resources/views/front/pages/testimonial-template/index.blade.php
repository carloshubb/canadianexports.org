    {{-- <div class="h-full bg-gray-50 relative">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10 ">
                <section class="rounded-md">
                    @isset($page->pageDetail[0])
                        <div class="text-center">
                            @php
                                $page_detail = $page->pageDetail[0]->page_detail;
                            @endphp
                            @include('front.pages.widgets.render-widget-with-detail', [
                                'page_detail' => $page_detail,
                            ])
                        </div>
                    @endisset

                    <div class="container">
                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 mt-8 gap-5">
                            @php
                                $testimonials = getAllTestimonials(30, $lang);
                            @endphp
                            @forelse  ($testimonials as $testimonial)
                                <div class="">
                                    <section
                                        class="h-full relative isolate overflow-hidden bg-white px-6 py-6 sm:py-6 lg:px-6 border-4 border-primary rounded-xl mb-4">
                                        <div
                                            class="absolute inset-0 -z-10 bg-[radial-gradient(45rem_50rem_at_top,theme(colors.indigo.100),white)] opacity-20">
                                        </div>
                                        <div
                                            class="absolute inset-y-0 right-1/2 -z-10 mr-16 w-[200%] origin-bottom-left skew-x-[-30deg] bg-white shadow-xl shadow-indigo-600/10 ring-1 ring-indigo-50 sm:mr-28 lg:mr-0 xl:mr-16 xl:origin-center">
                                        </div>
                                        <div class="mx-auto max-w-2xl lg:max-w-4xl flex flex-col h-full">
                                            <div class="mx-auto max-w-4xl text-center flex flex-start">
                                                <p class="mt-2 card-heading text-primary">
                                                    @php
                                                        $category_name = strtolower(isset($testimonial->businessCategory->businessCategoryDetail[0]) ? $testimonial->businessCategory->businessCategoryDetail[0]->name : '');
                                                        $category_name = ucwords($category_name);
                                                    @endphp
                                                    {{ $category_name }}
                                                </p>
                                            </div>
                                            <figure class="mt-4 flex flex-auto">
                                                <blockquote
                                                    class="text-center text-base md:text-base lg:text-lg leading-8 text-gray-900 sm:text-2xl sm:leading-9">
                                                    <p class="can-exp-p">
                                                        {{ isset($testimonial->testimonialDetail[0]) ? $testimonial->testimonialDetail[0]->comment : '' }}
                                                    </p>
                                                </blockquote>
                                            </figure>
                                            <div class="flex items-center gap-2 mt-2">
                                                <div class="">
                                                    {{ isset($testimonial->testimonialDetail[0]) ? $testimonial->testimonialDetail[0]->name : '' }}
                                                </div>


                                            </div>
                                            <div class="flex items-center gap-2 mt-2">
                                                <div class="">
                                                    {{ isset($testimonial->testimonialDetail[0]) ? $testimonial->testimonialDetail[0]->place : '' }}
                                                </div>
                                            </div>

                                        </div>
                                    </section>
                                </div>
                            @empty
                                <!-- <p>No result found</p> -->
                            @endforelse

                        </div>
                        <div class="mt-10">
                            {{ $testimonials->links() }}
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div> --}}



    @isset($testimonialSettingDetail)
    <div class="h-full bg-gray-50">
        <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
            <div class="lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-10">
                <section class="rounded-md">
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
                    {{-- <div class="container">
                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 mt-8 gap-5">
                            @php
                                $testimonials = getAllTestimonials(30, $lang);
                            @endphp
                            @forelse ($testimonials as $testimonial)
                                <div class="">
                                    <section class="h-full relative isolate overflow-hidden bg-white px-6 py-6 sm:py-6 lg:px-6 border-4 border-primary rounded-xl mb-4">
                                        <div class="absolute inset-0 -z-10 bg-[radial-gradient(45rem_50rem_at_top,theme(colors.indigo.100),white)] opacity-20"></div>
                                        <div class="absolute inset-y-0 right-1/2 -z-10 mr-16 w-[200%] origin-bottom-left skew-x-[-30deg] bg-white shadow-xl shadow-indigo-600/10 ring-1 ring-indigo-50 sm:mr-28 lg:mr-0 xl:mr-16 xl:origin-center"></div>

                                        <div class="mx-auto max-w-2xl lg:max-w-4xl flex flex-col h-full">
                                            <div class="mx-auto max-w-4xl text-center flex flex-start">
                                                <p class="mt-2 card-heading text-primary">
                                                    @php
                                                        $category_names = [];
                                                        if (isset($testimonial->testimonialDetail[0]->primary_industry)) {
                                                            $industries = json_decode($testimonial->testimonialDetail[0]->primary_industry, true);
                                                            foreach ($industries as $industry) {
                                                                $category_names[] = ucwords(strtolower($industry['category_name']));
                                                            }
                                                        }
                                                    @endphp
                                                    {{ implode(', ', $category_names) }}
                                                </p>
                                            </div>

                                            <figure class="mt-4 flex flex-auto">
                                                <blockquote class="text-center text-base md:text-base lg:text-lg leading-8 text-gray-900 sm:text-2xl sm:leading-9">
                                                    <p class="can-exp-p">
                                                        {{ isset($testimonial->testimonialDetail[0]) ? $testimonial->testimonialDetail[0]->comment : '' }}
                                                    </p>
                                                </blockquote>
                                            </figure>

                                            <div class="flex items-center gap-2 mt-2">
                                                <div class="">
                                                    {{ isset($testimonial->testimonialDetail[0]) ? $testimonial->testimonialDetail[0]->name : '' }}
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2 mt-2">
                                                <div class="">
                                                    {{ isset($testimonial->testimonialDetail[0]) ? $testimonial->testimonialDetail[0]->place : '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            @empty
                                <p>No result found</p>
                            @endforelse
                        </div>

                        <div class="mt-10">
                            {{ $testimonials->links() }}
                        </div>
                    </div> --}}
                    <div class="container">
                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 mt-8 gap-5">
                            @php
                                $testimonials = getAllTestimonials(30, $lang);
                            @endphp
                            @forelse ($testimonials as $testimonial)
                                <div class="">
                                    <section class="h-full relative isolate overflow-hidden bg-white px-6 py-6 sm:py-6 lg:px-6 border-4 border-primary rounded-xl mb-4">
                                        <div class="absolute inset-0 -z-10 bg-[radial-gradient(45rem_50rem_at_top,theme(colors.indigo.100),white)] opacity-20"></div>
                                        <div class="absolute inset-y-0 right-1/2 -z-10 mr-16 w-[200%] origin-bottom-left skew-x-[-30deg] bg-white shadow-xl shadow-indigo-600/10 ring-1 ring-indigo-50 sm:mr-28 lg:mr-0 xl:mr-16 xl:origin-center"></div>

                                        <div class="mx-auto max-w-2xl lg:max-w-4xl flex flex-col h-full">
                                            <div class="mx-auto max-w-4xl text-center flex flex-start">
                                                <p class="mt-2 card-heading text-primary">
                                                    @php
                                                        $category_names = [];
                                                        if (isset($testimonial->testimonialDetail[0]->primary_industry)) {
                                                            $industries = json_decode($testimonial->testimonialDetail[0]->primary_industry, true);
                                                            foreach ($industries as $industry) {
                                                                $category_names[] = ucwords(strtolower($industry['category_name']));
                                                            }
                                                        }
                                                    @endphp
                                                    {{ implode(', ', $category_names) }}
                                                </p>
                                            </div>

                                            <figure class="mt-4 flex flex-auto">
                                                <blockquote class="text-center text-base md:text-base lg:text-lg leading-8 text-gray-900 sm:text-2xl sm:leading-9">
                                                    <p class="can-exp-p">
                                                        {{ isset($testimonial->testimonialDetail[0]) ? $testimonial->testimonialDetail[0]->comment : '' }}
                                                    </p>
                                                </blockquote>
                                            </figure>

                                            <div class="flex items-center gap-2 mt-2">
                                                <div class="">
                                                    {{ isset($testimonial->testimonialDetail[0]) ? $testimonial->testimonialDetail[0]->name : '' }}
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2 mt-2">
                                                <div class="">
                                                    {{ isset($testimonial->testimonialDetail[0]) ? $testimonial->testimonialDetail[0]->place : '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            @empty
                                <!-- <p>No result found</p> -->
                            @endforelse
                        </div>

                        <div class="mt-10">
                            {{ $testimonials->links() }}
                        </div>
                    </div>


                    <h1 class="text-center">{{ $testimonialSettingDetail->page_heading }}</h1>
                    <div class="container">
                        <p class="text-red-500"><span class="text-red-500">*</span>
                            {{ $testimonialSettingDetail->required_fields_text }}</p>
                    </div>
                    <!--Tabs-->
                    <div class="grid grid-cols-1 gap-12 container">
                        <div class="order-2 md:order-1">
                            <testimonial testimonial_setting="{{ $testimonialSettingDetail }}"
                                submit_url="{{ route('user.testimonial.send-message') }}" page_id="{{ $page->id }}">
                            </testimonial>
                        </div>

                    </div>



                </section>
            </div>
        </div>
    </div>
@endisset
