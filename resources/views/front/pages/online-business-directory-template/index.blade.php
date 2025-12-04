@isset($onlineBusinessDirectorySettingDetail)
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
                    <!--Tabs-->
                    <form action="{{route('business_directory_search')}}">
                    <div class="grid grid-cols-1 gap-12 container">
                        <div class="w-full mx-auto mt-10 flex flex-col xl:flex-row xl:items-end space-x-4 space-y-4 xl:space-y-0">
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4">
                                <div class="ml-2">
                                    <label for="" class="block text-base lg:text-lg">{{$onlineBusinessDirectorySettingDetail->keyword_label}}</label>
                                    <input type="text" name="keyword" class="can-exp-input" placeholder="{{$onlineBusinessDirectorySettingDetail->keyword_placeholder}}">
                                </div>
                                <div class="ml-2">
                                    <label for="" class="block text-base lg:text-lg">{{$onlineBusinessDirectorySettingDetail->city_label}}</label>
                                    <input type="text" name="city" class="can-exp-input" placeholder="{{$onlineBusinessDirectorySettingDetail->city_placeholder}}">
                                </div>
                                <div class="ml-2">
                                    <label for="" class="block text-base lg:text-lg">{{$onlineBusinessDirectorySettingDetail->province_label}}</label>
                                    <input type="text" name="province" class="can-exp-input" placeholder="{{$onlineBusinessDirectorySettingDetail->province_placeholder}}">
                                </div>
                                <div class="ml-2">
                                    <label for="" class="block text-base lg:text-lg">{{$onlineBusinessDirectorySettingDetail->industry_label}}</label>
                                    <select type="text" name="industry" class="can-exp-input" placeholder="{{$onlineBusinessDirectorySettingDetail->industry_placeholder}}">
                                        @foreach($onlineBusinessDirectory as $industry)
                                        <option value="{{$industry}}">{{$industry}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-0.5"><button type="submit" class="button-exp-fill">{{$onlineBusinessDirectorySettingDetail->button_text}}</button></div>
                        </div>

                    </div>
                    </form>



                </section>
            </div>
        </div>
    </div>
@endisset
