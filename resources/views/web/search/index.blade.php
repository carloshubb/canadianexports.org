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
        $general_setting = getI2bModalSetting($lang, ['general']);
    @endphp
    <div class="h-full bg-gray-50 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
            <div class="container">
                <section class="bg-gray-50">

                    <!--Tabs-->
                    <div class="flex flex-wrap" id="tabs-id">
                        <div class="w-full">
                            @isset($_GET['q'])
                                <h1 class="can-exp-h1 text-center text-primary">
                                    {{isset($general_setting['search_result_for_text']) ? $general_setting['search_result_for_text'] : ''}} ({{ $_GET['q'] }})
                                </h1>
                            @endisset
                            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 mt-8 gap-5">
                                @forelse  ($testimonials as $testimonial)
                                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                                        <section
                                            class="h-full relative isolate overflow-hidden bg-white px-6 py-6 sm:py-12 lg:px-8 border-4 border-primary rounded-xl">
                                            <div
                                                class="absolute inset-0 -z-10 bg-[radial-gradient(45rem_50rem_at_top,theme(colors.indigo.100),white)] opacity-20">
                                            </div>
                                            <div
                                                class="absolute inset-y-0 right-1/2 -z-10 mr-16 w-[200%] origin-bottom-left skew-x-[-30deg] bg-white shadow-xl shadow-indigo-600/10 ring-1 ring-indigo-50 sm:mr-28 lg:mr-0 xl:mr-16 xl:origin-center">
                                            </div>
                                            <div class="mx-auto max-w-2xl lg:max-w-4xl flex flex-col h-full">
                                                <div class="mx-auto max-w-4xl text-center flex-initial">
                                                    <p class="mt-2 card-heading text-primary">
                                                        @php
                                                            $category_name = strtolower(isset($testimonial->businessCategory->businessCategoryDetail[0]) ? $testimonial->businessCategory->businessCategoryDetail[0]->name : '');
                                                            $category_name = ucwords($category_name);
                                                        @endphp
                                                        {{ $category_name }}
                                                    </p>
                                                </div>
                                                <figure class="mt-10 flex-auto">
                                                    <blockquote
                                                        class="text-center font-semibold leading-8 text-gray-900 sm:text-2xl sm:leading-9">
                                                        <p class="can-exp-p">
                                                            {{ isset($testimonial->testimonialDetail[0]) ? $testimonial->testimonialDetail[0]->comment : '' }}
                                                        </p>
                                                    </blockquote>

                                                </figure>
                                                <div class="mt-10 flex-end">
                                                    <div
                                                        class="mt-4 flex items-center justify-center space-x-3 text-base md:text-base lg:text-lg">
                                                        <div class="font-semibold text-gray-900 w-[45%] text-right">
                                                            <div>
                                                                {{ isset($testimonial->testimonialDetail[0]) ? $testimonial->testimonialDetail[0]->name : '' }}
                                                            </div>
                                                        </div>
                                                        <svg viewBox="0 0 2 2" width="3" height="3"
                                                            aria-hidden="true" class="fill-gray-900">
                                                            <circle cx="1" cy="1" r="1" />
                                                        </svg>
                                                        <div class="text-gray-600 w-[45%]">
                                                            {{ isset($testimonial->testimonialDetail[0]) ? $testimonial->testimonialDetail[0]->place : '' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                @empty
                                <div class="col-span-2">
                                    <h3 class="can-exp-h3 text-center text-primary">{{isset($general_setting['no_result_found_text']) ? $general_setting['no_result_found_text'] : ''}}</h3>
                                </div>
                                @endforelse

                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        {{ $testimonials->appends($_GET)->links() }}
                    </div>



                </section>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection
