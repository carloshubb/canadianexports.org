@extends('front.layouts.app')
@section('content')
<div>
    <h1 class="text-center can-exp-h1">Choose your plan</h1>
</div>

<div class="sm:grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-12">
    <!--cards 1-->
    <div class="relative hover:shadow-lg transition-all z-0">
        <div
            class="w-full h-full flex flex-col bg-white shadow rounded relative z-20">
            <div class="py-4 flex-initial">
                <h2 class="can-exp-h2 text-primary text-center">Standard</h2>
            </div>
            <div class="bg-primary text-center bg-opacity-5 py-2 border-y">
                <h2 class="mb-0 card-heading text-primary">$139</h2>
                <p class="text-center">per month</p>
            </div>
            <div class="p-4 space-y-1 flex-auto">
                <div class="flex items-center gap-x-4">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-red-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="">
                        <p>Upto 5 users</p>
                    </div>
                </div>

                <div class="flex items-center gap-x-4">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-green-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.5 12.75l6 6 9-13.5" />
                        </svg>

                    </div>
                    <div class="">
                        <p>Max 400 items/month</p>
                    </div>
                </div>

                <div class="flex items-center gap-x-4">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-red-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="">
                        <p>Unlimited queries</p>
                    </div>
                </div>

                <div class="flex items-center gap-x-4">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-green-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.5 12.75l6 6 9-13.5" />
                        </svg>

                    </div>
                    <div class="">
                        <p>Unlimited statics</p>
                    </div>
                </div>

                <div class="flex items-center gap-x-4">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-red-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="">
                        <p>Free consultation</p>
                    </div>
                </div>


            </div>

            <div class="flex justify-center items-center py-4 flex-end">
                <button aria-label="Candian Exporters" class="button-exp-fill">
                    Get started
                </button>
            </div>

        </div>
        <div
            class="bg-primary w-6 rounded h-[90%] my-auto absolute z-10 top-0 bottom-0 -left-2">

        </div>
    </div>

    <!--cards 2-->
    <div class="relative hover:shadow-lg transition-all z-0">
        <div
            class="w-full h-full flex flex-col bg-white shadow rounded relative z-20">
            <div class="py-4 flex-initial">
                <h2 class="can-exp-h2 text-primary text-center">Business</h2>
            </div>
            <div class="bg-primary text-center bg-opacity-5 py-2 border-y">
                <h2 class="mb-0 card-heading text-primary">$139</h2>
                <p class="text-center">per month</p>
            </div>
            <div class="p-4 space-y-1 flex-auto">
                <div class="flex items-center gap-x-4">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-red-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="">
                        <p>Upto 5 users</p>
                    </div>
                </div>

                <div class="flex items-center gap-x-4">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-green-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4.5 12.75l6 6 9-13.5" />
                        </svg>

                    </div>
                    <div class="">
                        <p>Upto 5 users</p>
                    </div>
                </div>

                <div class="flex items-center gap-x-4">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-red-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="">
                        <p>Upto 5 users</p>
                    </div>
                </div>

                <div class="flex items-center gap-x-4">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-green-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4.5 12.75l6 6 9-13.5" />
                        </svg>

                    </div>
                    <div class="">
                        <p>Upto 5 users</p>
                    </div>
                </div>

                <div class="flex items-center gap-x-4">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-red-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="">
                        <p>Upto 5 users</p>
                    </div>
                </div>

                <div class="flex items-center gap-x-4">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-green-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4.5 12.75l6 6 9-13.5" />
                        </svg>

                    </div>
                    <div class="">
                        <p>Upto 5 users</p>
                    </div>
                </div>

                <div class="flex items-center gap-x-4">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-red-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="">
                        <p>Upto 5 users</p>
                    </div>
                </div>


            </div>

            <div class="flex justify-center items-center py-4 flex-end">
                <button aria-label="Candian Exporters" class="button-exp-fill">
                    Get started
                </button>
            </div>

        </div>
        <div
            class="bg-primary w-6 rounded h-[90%] my-auto absolute z-10 top-0 bottom-0 -left-2">

        </div>
    </div>

    <!--cards 3-->
    <div class="relative hover:shadow-lg transition-all z-0">
        <div
            class="w-full h-full flex flex-col bg-white shadow rounded relative z-20">
            <div class="py-4 flex-initial">
                <h2 class="can-exp-h2 text-primary text-center">Premium</h2>
            </div>
            <div class="bg-primary text-center bg-opacity-5 py-2 border-y">
                <h2 class="mb-0 card-heading text-primary">$139</h2>
                <p class="text-center">per month</p>
            </div>
            <div class="p-4 space-y-1 flex-auto">
                <div class="flex items-center gap-x-4">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-red-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="">
                        <p>Upto 5 users</p>
                    </div>
                </div>

                <div class="flex items-center gap-x-4">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-green-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4.5 12.75l6 6 9-13.5" />
                        </svg>

                    </div>
                    <div class="">
                        <p>Upto 5 users</p>
                    </div>
                </div>

                <div class="flex items-center gap-x-4">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-red-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="">
                        <p>Upto 5 users</p>
                    </div>
                </div>


            </div>

            <div class="flex justify-center items-center py-4 flex-end">
                <button aria-label="Candian Exporters" class="button-exp-fill">
                    Get started
                </button>
            </div>

        </div>
        <div
            class="bg-primary w-6 rounded h-[90%] my-auto absolute z-10 top-0 bottom-0 -left-2">

        </div>
    </div>

</div>
@endsection
<!--end cards-->
