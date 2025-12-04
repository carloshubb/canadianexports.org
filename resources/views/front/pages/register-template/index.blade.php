<section class="relative lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
    @php
        $payment_setting = getI2bModalSetting($lang, ['payment_setting']);
    @endphp

    <div class="container lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-10 pb-8">
        <signup page_id="{{ $page->id }}" lang="{{$lang}}" payment_setting="{{$payment_setting}}"></signup>
    </div>
</section>
