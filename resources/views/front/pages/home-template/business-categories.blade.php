<section class="relative lg:pb-14 md:pb-10 pt-14 pb-10">

    <div class="container">

        <div class="relative bg-center p-8"
            style="background-image: url('{{ asset("assets/images/bg_home_1.png") }}');">
            <p class="can-exp-p text-center text-gray-700 mb-4">
                {!! $homePageSettingDetail->section1_description !!}
            </p>

        </div>


        <h2 class="text-3xl text-center md:text-4xl mt-6 font-semibold text-[#006EB7] mb-6">Business Categories</h2>

        @php
        $businessCategories = getAllBusinessCategories();
        $totalCategories = count($businessCategories);
        @endphp
        
        <div class="business-categories-container">
            <div id="categoriesGrid" class="relative grid md:grid-cols-2 grid-cols-1 gap-[15px] transition-all duration-500 ease-in-out overflow-hidden">
                @foreach ($businessCategories as $index => $businessCategory)
                <div class="category-item flex items-center p-4 text-base md:text-base lg:text-lg border border-grey-300 rounded-lg bg-gray-100 {{ $index >= 6 ? 'hidden' : '' }}"
                    role="alert" data-index="{{ $index }}">
                    <img
                        src="{{ asset('assets/icons/' . $businessCategory->category_icon) }}"
                        class="flex-shrink-0 inline w-8 h-8 mr-3"
                        alt="Business Category Icon" />

                    <div>
                        @php
                        $url = isset($businessCategory->slug) ? route('user.business-category.index', ['abbreviation' => $lang->abbreviation, 'slug' => $businessCategory->slug]) : '#';
                        @endphp
                        <a aria-label="Candian Exporters" href="{{ $url }}"
                            class="md:ml-2 text-black font-Futura text-base md:text-base lg:text-lg tracking-normal hover:text-primary  duration-500 ease-in-out">
                            @php
                            $category_name = strtolower($businessCategory->category_name);
                            $category_name = ucwords($category_name);
                            @endphp
                            {{ $category_name }}</a>
                    </div>
                </div>
                @endforeach
                <div id="howCategoriesBar" class="how-categories-bar hidden flex items-center font-Futura p-2 text-base md:text-base lg:text-lg text-primary border border-primary rounded-lg bg-primary/10"
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

            <!-- Initial view: Button only below collapsed view (blue bar appears only when expanded) -->
            <div id="initialViewControls" class="mt-6 space-y-4">
                <button id="toggleCategoriesBtn" 
                    class="w-full md:w-auto mx-auto flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white font-Futura text-base md:text-lg rounded-none hover:bg-primary/90 transition-all duration-300 ease-in-out shadow-md hover:shadow-lg">
                    <span>View all {{ $totalCategories }} categories</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </div>

            <!-- Expanded view: "View less" button below all categories -->
            <div id="expandedViewControls" class="mt-6 space-y-4 hidden">
                <button id="toggleCategoriesBtnExpanded" 
                    class="w-full md:w-auto mx-auto flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white font-Futura text-base md:text-lg rounded-none hover:bg-primary/90 transition-all duration-300 ease-in-out shadow-md hover:shadow-lg">
                    <span>View less</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 transform rotate-180">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </div>
        </div>

        <style>
            .business-categories-container {
                position: relative;
            }
            
            .category-item {
                transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
            }
            
            .category-item.hidden {
                display: none;
            }
            
            .category-item.showing {
                animation: fadeInUp 0.4s ease-in-out;
            }
            
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toggleBtn = document.getElementById('toggleCategoriesBtn');
                const toggleBtnExpanded = document.getElementById('toggleCategoriesBtnExpanded');
                const categoriesGrid = document.getElementById('categoriesGrid');
                const initialControls = document.getElementById('initialViewControls');
                const expandedControls = document.getElementById('expandedViewControls');
                const categoryItems = document.querySelectorAll('.category-item');
                const howCategoriesBar = document.getElementById('howCategoriesBar');
                let isExpanded = false;

                function expandCategories() {
                    isExpanded = true;
                    
                    // Show all category items with animation
                    categoryItems.forEach((item, index) => {
                        if (item.classList.contains('hidden')) {
                            setTimeout(() => {
                                item.classList.remove('hidden');
                                item.classList.add('showing');
                                setTimeout(() => {
                                    item.classList.remove('showing');
                                }, 400);
                            }, (index - 6) * 30); // Stagger animation
                        }
                    });

                    // Show blue bar (original position: last grid item)
                    if (howCategoriesBar) {
                        howCategoriesBar.classList.remove('hidden');
                    }

                    // Hide initial controls and show expanded controls
                    setTimeout(() => {
                        initialControls.classList.add('hidden');
                        expandedControls.classList.remove('hidden');
                        
                        // Smooth scroll to maintain position
                        const scrollPosition = window.scrollY;
                        window.scrollTo({
                            top: scrollPosition,
                            behavior: 'smooth'
                        });
                    }, 200);
                }

                function collapseCategories() {
                    isExpanded = false;
                    
                    // Hide expanded controls and show initial controls
                    expandedControls.classList.add('hidden');
                    initialControls.classList.remove('hidden');

                    // Hide category items beyond the first 6
                    categoryItems.forEach((item, index) => {
                        if (index >= 6) {
                            item.classList.add('hidden');
                            item.classList.remove('showing');
                        }
                    });

                    // Hide blue bar when collapsed
                    if (howCategoriesBar) {
                        howCategoriesBar.classList.add('hidden');
                    }

                    // Smooth scroll to top of categories section
                    const categoriesSection = document.querySelector('.business-categories-container');
                    if (categoriesSection) {
                        categoriesSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }

                toggleBtn.addEventListener('click', expandCategories);
                toggleBtnExpanded.addEventListener('click', collapseCategories);
            });
        </script>


    </div>
</section>