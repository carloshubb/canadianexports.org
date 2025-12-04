@extends('front.layouts.app')
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8 mt-5">
        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">
                    {{ isset($businessDirectorySearchTranslations['page_title']) ? $businessDirectorySearchTranslations['page_title'] : '' }}</h1>
            </div>
        </div>

        <div class="mt-10 space-y-4">
            @if ($businessDirectories->count() > 0)
            @foreach ($businessDirectories as $businessDirectory)
                <div class="border rounded p-4 w-full grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <div class="grid grid-cols-1">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4 md:col-span-2 font-extrabold">
                                    <p>{{ isset($businessDirectorySearchTranslations['name_label_text']) ? $businessDirectorySearchTranslations['name_label_text'] : '' }}</p>
                                </div>
                                
                                <div class="col-span-7 md:col-span-9 font-semibold text-gray-700">
                                    <p>{{ isset($businessDirectory->businessDirectoryDetail[0]->name) ? $businessDirectory->businessDirectoryDetail[0]->name : '---' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 mt-2">
                                <div class="col-span-4 md:col-span-2 font-extrabold">
                                    <p>{{ isset($businessDirectorySearchTranslations['province_label_text']) ? $businessDirectorySearchTranslations['province_label_text'] : '' }}</p>
                                </div>
                                
                                <div class="col-span-7 md:col-span-9 text-gray-700">
                                    <p>{{ isset($businessDirectory->province) ? $businessDirectory->province : '---' }}</p>

                                </div>
                            </div>

                            <div class="grid grid-cols-12 mt-2">
                                <div class="col-span-4 md:col-span-2 font-extrabold">
                                    <p>{{ isset($businessDirectorySearchTranslations['city_label_text']) ? $businessDirectorySearchTranslations['city_label_text'] : '' }}</p>
                                </div>
                                
                                <div class="col-span-7 md:col-span-9 text-gray-700">
                                    <p>{{ isset($businessDirectory->city) ? $businessDirectory->city : '---' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 mt-2">
                                <div class="col-span-4 md:col-span-2 font-extrabold">
                                    <p>{{ isset($businessDirectorySearchTranslations['industry_label_text']) ? $businessDirectorySearchTranslations['industry_label_text'] : '' }}</p>
                                </div>
                                
                                <div class="col-span-7 md:col-span-9 text-gray-700">
                                    <p>{{ isset($businessDirectory->industry) ? $businessDirectory->industry : '---' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 mt-2">
                                <div class="col-span-4 md:col-span-2 font-extrabold">
                                    <p>{{ isset($businessDirectorySearchTranslations['postal_code_label_text']) ? $businessDirectorySearchTranslations['postal_code_label_text'] : '' }}</p>
                                </div>
                                
                                <div class="col-span-7 md:col-span-9 text-gray-700">
                                    <p>{{ isset($businessDirectory->postal_code) ? $businessDirectory->postal_code : '---' }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-2">
                                <div class="col-span-4 md:col-span-2 font-extrabold">
                                    <p>{{ isset($businessDirectorySearchTranslations['phone_label_text']) ? $businessDirectorySearchTranslations['phone_label_text'] : '' }}</p>
                                </div>
                                
                                <div class="col-span-7 md:col-span-9 text-gray-700">
                                    <p>{{ isset($businessDirectory->phone) ? $businessDirectory->phone : '---' }}</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-12 mt-2">
                                <div class="col-span-4 md:col-span-2 font-extrabold">
                                    <p>{{ isset($businessDirectorySearchTranslations['address_label_text']) ? $businessDirectorySearchTranslations['address_label_text'] : '' }}</p>
                                </div>
                                
                                <div class="col-span-7 md:col-span-9 text-gray-700">
                                    <p>{{ isset($businessDirectory->address) ? $businessDirectory->address : '---' }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-2">
                                <div class="col-span-4 md:col-span-2 font-extrabold">
                                    <p>{{ isset($businessDirectorySearchTranslations['fax_label_text']) ? $businessDirectorySearchTranslations['fax_label_text'] : '' }}</p>
                                </div>
                                
                                <div class="col-span-7 md:col-span-9 text-gray-700">
                                    <p>{{ isset($businessDirectory->fax) ? $businessDirectory->fax : '---' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @else
            <div class="text-center text-gray-500 text-lg mt-10">
                <p>Sorry, your search yielded no results.</p>
                {{-- <p>Please double-check your spelling and try different variations of your keywords or key phrases.</p> --}}
            </div>
        @endif
        </div>

    </div>
@endsection
