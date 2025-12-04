<x-web-layout>
    <x-slot:title>
        Profile | Canadian Export
        </x-slot>
        <section class="bg-white px-4 py-6 md:p-12 desktop:px-80">
            <h2 class="text-center can-exp-h1">Business Profile</h2>
            <!--Form-->
            <form>
                <div class="my-4">
                    <div class="relative w-full mb-3">
                        <label class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg" for="company-name">
                            Company Name <span class="sups text-primaryRed">*</span>
                        </label>
                        <input type="text"
                            class="border border-gray-100 transition-all delay-150 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow
                    focus:outline-none focus:ring w-full"
                            placeholder="" />
                    </div>
                    <div class="relative w-full mb-3">
                        <label class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg" for="company-email">
                            Company email <span class="sups text-primaryRed">*</span>
                        </label>
                        <input type="email"
                            class="border border-gray-100 transition-all delay-150 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow
                    focus:outline-none focus:ring w-full"
                            placeholder="Enter your business email, even if it is the same as the one you entered above" />
                    </div>
                    <div class="relative w-full mb-3">
                        <label class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg" for="mailing-address">
                            Mailing address With Postal Code And Address<span class="sups text-primaryRed">*</span>
                        </label>
                        <textarea rows="4"
                            class="border border-gray-100 transition-all delay-150 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow
                    focus:outline-none focus:ring w-full"
                            placeholder="Complete address, with Postal Code (ZIP Code) and country name"></textarea>
                    </div>
                    <div class="relative w-full mb-3">
                        <label class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg" for="phone">
                            Phone <span class="sups text-primaryRed">*</span>
                        </label>
                        <input type="number"
                            class="border border-gray-100 transition-all delay-150 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow
                    focus:outline-none focus:ring w-full"
                            placeholder="With area code" />
                    </div>
                    <div class="relative w-full mb-3">
                        <label class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg" for="fax">
                            Fax <span class="sups text-primaryRed">*</span>
                        </label>
                        <input type="text"
                            class="border border-gray-100 transition-all delay-150 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow
                    focus:outline-none focus:ring w-full"
                            placeholder="" />
                    </div>
                    <div class="relative w-full mb-3">
                        <label class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg" for="website">
                            Website <span class="sups text-primaryRed">*</span>
                        </label>
                        <input type="text"
                            class="border border-gray-100 transition-all delay-150 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow
                    focus:outline-none focus:ring w-full"
                            placeholder="http://www.nedo.org.uk" />
                    </div>
                    <div class="relative w-full mb-3">
                        <label class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg" for="cta_link">
                            CTA Link <span class="sups text-primaryRed">*</span>
                        </label>
                        <input type="text"
                            class="border border-gray-100 transition-all delay-150 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow
                    focus:outline-none focus:ring w-full"
                            placeholder="http://www.nedo.org.uk" />
                    </div>
                    <div class="relative w-full mb-3">
                        <label class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg" for="cta_btn">
                            CTA Button <span class="sups text-primaryRed">*</span>
                        </label>
                        <input type="text"
                            class="border border-gray-100 transition-all delay-150 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow
                    focus:outline-none focus:ring w-full"
                            placeholder="http://www.nedo.org.uk" />
                    </div>
                    <div class="relative w-full mb-3">
                        <label class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg" for="tagline">
                            TagLine <span class="sups text-primaryRed">*</span>
                        </label>
                        <input type="text"
                            class="border border-gray-100 transition-all delay-150 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow
                    focus:outline-none focus:ring w-full"
                            placeholder="" />
                    </div>
                    <div class="relative w-full mb-3">
                        <label class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg" for="short-description">
                            Short business description <span class="sups text-primaryRed">*</span>
                        </label>
                        <textarea rows="3"
                            class="border border-gray-100 resize-none transition-all delay-150 px-3 py-4 placeholder-gray-400 text-gray-700 bg-white rounded shadow
                    focus:outline-none focus:ring w-full"
                            placeholder="Describe the nature of your business..."></textarea>
                    </div>
                    <div class="relative w-full mb-3">
                        <label class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg" for="detailed-description">
                            Detailed business description <span class="sups text-primaryRed">*</span>
                        </label>
                        <textarea rows="3"
                            class="border border-gray-100 resize-none transition-all delay-150 px-3 py-4 placeholder-gray-400 text-gray-700 bg-white rounded shadow
                    focus:outline-none focus:ring w-full"
                            placeholder="This is the text that will appear on your actual business profile page..."></textarea>
                    </div>
                    <div class="relative w-full mb-3">
                        <label class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg" for="keywords">
                            Keywords : separated With Commas <span class="sups text-primaryRed">*</span>
                        </label>
                        <textarea rows="3"
                            class="border border-gray-100 resize-none transition-all delay-150 px-3 py-4 placeholder-gray-400 text-gray-700 bg-white rounded shadow
                    focus:outline-none focus:ring w-full"
                            placeholder="Enter up to 5 separate keywords or keyphrases, separated by commas..."></textarea>
                    </div>
                </div>
                <div class="mt-10 flex justify-center">
                    <button aria-label="Candian Exporters"
                        class="font-FuturaBdCnBT text-primaryRed border border-primaryRed hover:bg-primaryRed hover:text-white active:bg-blue-600 font-medium px-8 py-1.5 rounded outline-none focus:outline-none ease-linear transition-all duration-150"
                        type="button">
                        Proceed
                    </button>
                </div>
            </form>
        </section>
</x-web-layout>
