<section class="relative lg:pb-14 md:pb-10 pt-14 pb-10">

    <div class="container">

        <div class="relative bg-center p-8"
            style="background-image: url('{{ asset("assets/images/bg_home_1.png") }}');">
            <p class="can-exp-p text-center text-gray-700 mb-4">
                {!! $homePageSettingDetail->section1_description !!}
            </p>

        </div>


        <h2 class="text-3xl text-center md:text-4xl font-bold text-gray-900 mb-6">Business Categories</h2>

        @php
        $businessCategories = getAllBusinessCategories();
        @endphp
        <div class="relative grid md:grid-cols-2 grid-cols-1 gap-[15px]">
            @foreach ($businessCategories as $businessCategory)
            <div class="flex items-center p-4 text-base md:text-base lg:text-lg border border-grey-300 rounded-lg bg-gray-100"
                role="alert">
                <img
                    src="{{ asset('assets/icons/' . $businessCategory->category_icon) }}"
                    class="flex-shrink-0 inline w-8 h-8 mr-3"
                    alt="Business Category Icon" />

                <div>
                    @php
                    $url = isset($businessCategory->slug) ? route('user.business-category.index', ['abbreviation' => $lang->abbreviation, 'slug' => $businessCategory->slug]) : '#';
                    @endphp
                    <a aria-label="Candian Exporters" href="{{ $url }}"
                        class="md:ml-2 text-yellow-800 font-Futura text-base md:text-base lg:text-lg tracking-normal hover:text-primary  duration-500 ease-in-out">
                        @php
                        $category_name = strtolower($businessCategory->category_name);
                        $category_name = ucwords($category_name);
                        @endphp
                        {{ $category_name }}</a>
                </div>
            </div>
            @endforeach
            <div class="flex items-center font-Futura p-2 text-base md:text-base lg:text-lg text-primary border border-primary rounded-lg bg-primary/10"
                role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="flex-shrink-0 inline w-6 h-6 mr-3 text-primary">
                    <path fill-rule="evenodd"
                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    @php
                    $url = langBasedURL($lang, $homePageSettingDetail->section1_business_category_url);
                    @endphp
                    <a aria-label="Candian Exporters" href="{{ $url }}"
                        class="md:ml-2 can-exp-a text-base md:text-base lg:text-lg tracking-normal hover:text-secondary hover:underline hover:decoration-solid duration-500 ease-in-out text-secondary">
                        {!! $homePageSettingDetail->section1_business_category !!}
                    </a>
                </div>
            </div>
        </div>


    </div>
</section>