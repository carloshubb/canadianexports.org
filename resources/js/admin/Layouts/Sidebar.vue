<template>
  <div class="sidebar" :class="isBurgerMenu ? 'open' : ''">
    <div class="text-white mt-2 mr-2 block lg:hidden">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="w-7 h-7 float-right cursor-pointer" @click.prevent="burgerMenu()">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </div>
    <div class="logo-details">
      <!-- <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" viewBox="0 0 82.704 81.496">
                    <path id="ok" d="M-2708.364,648.938l33.57,33.438-20.821,20.788.263-14.093,6.314-6.556-19.326-19.637Zm60.943-7.434-19.749,19.212-6.52-6.352-14.09-.344,20.666,20.941,33.632-33.376Zm21.761,60.122-19.326-19.638,6.314
                -6.556.263-14.092-20.821,20.787,33.57,33.439ZM-2686.6,723l19.75-19.212,6.519,6.352,14.091.344-20.667-20.941-33.632,33.376Z" transform="translate(2708.364 -641.504)" fill="currentColor" />
                </svg>
            </div> -->
      <div class="logo_name pointer-events-none py-2">
        <img src="/assets/images/logo.png" class="w-48" alt="Candian Exporters" />
        <!-- <div><img src="assets/XelentLogo.png" alt="Candian Exporters"></div> -->
      </div>
    </div>
    <ul class="nav-list accordion text-base md:text-base lg:text-lg font-FuturaMdCnBT" id="accordion-collapse"
      data-accordion="collapse">
      <li @click="hideBurgerMenu()">
        <router-link @click.prevent="updateSubMenuName(null)" :to="{ name: 'admin.dashboard' }"
          class="py-2 hover:border-l-4 border-white flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
          :class="$route.name == 'admin.dashboard'
            ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
            : ''
            ">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 01-1.125-1.125v-3.75zM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-8.25zM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-2.25z" />
            </svg>
          </div>
          <span class="links_name pointer-events-auto opacity-0 text-white">Dashboard</span>
        </router-link>
      </li>
      <li class="cursor-pointer flex items-center justify-between pr-2" @click.prevent="
        subMenuName == 'supporting-forms'
          ? updateSubMenuName(null)
          : updateSubMenuName('supporting-forms')
        ">
        <a href="#"
          class="py-2 hover:border-l-4 border-white flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
            </svg>
          </div>
          <span class="links_name pointer-events-auto opacity-0 text-white">Supporting forms</span>
        </a>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6 text-white" v-if="subMenuName == null || subMenuName != 'supporting-forms'">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6 text-white" v-else-if="subMenuName == 'supporting-forms'">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
        </svg>
      </li>
      <ul id="supporting-forms-body" class="ml-6" :class="subMenuName == 'supporting-forms' ? 'block' : 'hidden'">
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.banners.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.banners.index' ||
              $route.name == 'admin.banners.create' ||
              $route.name == 'admin.banners.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25m-18 0V6a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 6v2.25m-18 0h18M5.25 6h.008v.008H5.25V6zM7.5 6h.008v.008H7.5V6zm2.25 0h.008v.008H9.75V6z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Banners</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.articles.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.articles.index' ||
              $route.name == 'admin.articles.create' ||
              $route.name == 'admin.articles.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-7.5A3.375 3.375 0 005.25 11.625V14.25m14.25 0H4.5m15 0v2.625A3.375 3.375 0 0116.125 20.25h-7.5A3.375 3.375 0 015.25 16.875V14.25m0 0V8.25A3.375 3.375 0 018.625 4.875h6.75A3.375 3.375 0 0118.75 8.25V14.25" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Articles</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.article-sections.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.article-sections.index' ||
              $route.name == 'admin.article-sections.create' ||
              $route.name == 'admin.article-sections.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Article sections</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.sponsors.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.sponsors.index' ||
              $route.name == 'admin.sponsors.view'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Sponsors</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.business_categories.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.business_categories.index' ||
              $route.name == 'admin.business_categories.create' ||
              $route.name == 'admin.business_categories.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Business categories</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.coffee_wall_beneficiaries.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.coffee_wall_beneficiaries.index' ||
              $route.name == 'admin.coffee_wall_beneficiaries.create' ||
              $route.name == 'admin.coffee_wall_beneficiaries.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Coffee Wall Beneficiaries</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.coffee_wall_faqs.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.coffee_wall_faqs.index'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Coffee Wall FAQs</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.events.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.events.index' ||
              $route.name == 'admin.events.create' ||
              $route.name == 'admin.events.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Events</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.exporting-fairs.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.exporting-fairs.index' ||
              $route.name == 'admin.exporting-fairs.create' ||
              $route.name == 'admin.exporting-fairs.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Exporting fairs</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.coffee_wall_faqs.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.coffee_wall_faqs.index'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Coffee Wall FAQs</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.holiday-emails.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.holiday-emails.index' ||
              $route.name == 'admin.holiday-emails.create' ||
              $route.name == 'admin.holiday-emails.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Holiday emails</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.i2b.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.i2b.index' ||
              $route.name == 'admin.i2b.create' ||
              $route.name == 'admin.i2b.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Inquiries to buy</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.issues.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.issues.index' ||
              $route.name == 'admin.issues.create' ||
              $route.name == 'admin.issues.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Issues</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.languages.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.languages.index' ||
              $route.name == 'admin.languages.create' ||
              $route.name == 'admin.languages.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="w-6 h-6 text-white">
                <path fill-rule="evenodd"
                  d="M9 2.25a.75.75 0 01.75.75v1.506a49.38 49.38 0 015.343.371.75.75 0 11-.186 1.489c-.66-.083-1.323-.151-1.99-.206a18.67 18.67 0 01-2.969 6.323c.317.384.65.753.998 1.107a.75.75 0 11-1.07 1.052A18.902 18.902 0 019 13.687a18.823 18.823 0 01-5.656 4.482.75.75 0 11-.688-1.333 17.323 17.323 0 005.396-4.353A18.72 18.72 0 015.89 8.598a.75.75 0 011.388-.568A17.21 17.21 0 009 11.224a17.17 17.17 0 002.391-5.165 48.038 48.038 0 00-8.298.307.75.75 0 01-.186-1.489 49.159 49.159 0 015.343-.371V3A.75.75 0 019 2.25zM15.75 9a.75.75 0 01.68.433l5.25 11.25a.75.75 0 01-1.36.634l-1.198-2.567h-6.744l-1.198 2.567a.75.75 0 01-1.36-.634l5.25-11.25A.75.75 0 0115.75 9zm-2.672 8.25h5.344l-2.672-5.726-2.672 5.726z"
                  clip-rule="evenodd" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Languages</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.one-more-thing.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.one-more-thing.index' ||
              $route.name == 'admin.one-more-thing.create' ||
              $route.name == 'admin.one-more-thing.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">One more thing</span>
          </router-link>
        </li>

        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.packages.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.packages.index' ||
              $route.name == 'admin.packages.create' ||
              $route.name == 'admin.packages.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Profile packages</span>
          </router-link>
        </li>

        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.billing_period_discounts.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.billing_period_discounts.index'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Billing Discounts</span>
          </router-link>
        </li>

        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.testimonials.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.testimonials.index' ||
              $route.name == 'admin.testimonials.create' ||
              $route.name == 'admin.testimonials.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Testimonials</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.successStories.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.successStories.index' ||
              $route.name == 'admin.successStories.create' ||
              $route.name == 'admin.successStories.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Success Stories</span>
          </router-link>
        </li>
      </ul>
      <li class="cursor-pointer flex items-center justify-between pr-2" @click.prevent="
        subMenuName == 'user-accounts'
          ? updateSubMenuName(null)
          : updateSubMenuName('user-accounts')
        ">
        <a href="#"
          class="py-2 hover:border-l-4 border-white flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
            </svg>
          </div>
          <span class="links_name pointer-events-auto opacity-0 text-white">User accounts</span>
        </a>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6 text-white" v-if="subMenuName == null || subMenuName != 'user-accounts'">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6 text-white" v-else-if="subMenuName == 'user-accounts'">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
        </svg>
      </li>
      <ul id="user-accounts-body" class="ml-6" :class="subMenuName == 'user-accounts' ? 'block' : 'hidden'">
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.admin-accounts.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.admin-accounts.index' ||
              $route.name == 'admin.admin-accounts.create' ||
              $route.name == 'admin.admin-accounts.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Admin A/C</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.users.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.users.index' ||
              $route.name == 'admin.users.create' ||
              $route.name == 'admin.users.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">User A/C</span>
          </router-link>
        </li>
      </ul>
      <li @click="hideBurgerMenu()">
        <router-link @click.prevent="updateSubMenuName(null)" :to="{ name: 'admin.errors.edit' }"
          class="py-2 hover:border-l-4 border-white flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
          :class="$route.name == 'admin.errors.edit'
            ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
            : ''
            ">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
            </svg>
          </div>
          <span class="links_name pointer-events-auto opacity-0 text-white">Error handling</span>
        </router-link>
      </li>
      <li @click="hideBurgerMenu()">
        <router-link @click.prevent="updateSubMenuName(null)" :to="{ name: 'admin.pages.index' }"
          class="py-2 hover:border-l-4 border-white flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
          :class="$route.name == 'admin.pages.index' ||
            $route.name == 'admin.pages.create' ||
            $route.name == 'admin.pages.edit'
            ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
            : ''
            ">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 004.5 9v.878m13.5-3A2.25 2.25 0 0119.5 9v.878m0 0a2.246 2.246 0 00-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0121 12v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6c0-.98.626-1.813 1.5-2.122" />
            </svg>
          </div>
          <span class="links_name pointer-events-auto opacity-0 text-white">Pages</span>
        </router-link>
      </li>
      <li @click="hideBurgerMenu()">
        <router-link @click.prevent="updateSubMenuName(null)" :to="{ name: 'admin.widgets.index' }"
          class="py-2 hover:border-l-4 border-white flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
          :class="$route.name == 'admin.widgets.index' ||
            $route.name == 'admin.widgets.create' ||
            $route.name == 'admin.widgets.edit'
            ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
            : ''
            ">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
            </svg>
          </div>
          <span class="links_name pointer-events-auto opacity-0 text-white">Widgets</span>
        </router-link>
      </li>
      <li @click="hideBurgerMenu()">
        <router-link @click.prevent="updateSubMenuName(null)" :to="{ name: 'admin.business-profiles.index' }"
          class="py-2 hover:border-l-4 border-white flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
          :class="$route.name == 'admin.business-profiles.index' ||
            $route.name == 'admin.business-profiles.create' ||
            $route.name == 'admin.business-profiles.edit'
            ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
            : ''
            ">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
            </svg>
          </div>
          <span class="links_name pointer-events-auto opacity-0 text-white">Business profiles</span>
        </router-link>
      </li>
      <li @click="hideBurgerMenu()">
        <router-link @click.prevent="updateSubMenuName(null)" :to="{ name: 'admin.business-profile-stats.index' }"
          class="py-2 hover:border-l-4 border-white flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
          :class="$route.name == 'admin.business-profile-stats.index'
            ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
            : ''
            ">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
            </svg>
          </div>
          <span class="links_name pointer-events-auto opacity-0 text-white">Business profile Stats</span>
        </router-link>
      </li>
      <li class="cursor-pointer flex items-center justify-between pr-2" @click.prevent="
        subMenuName == 'general-forms'
          ? updateSubMenuName(null)
          : updateSubMenuName('general-forms')
        ">
        <a href="#"
          class="py-2 hover:border-l-4 border-white flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
            </svg>
          </div>
          <span class="links_name pointer-events-auto opacity-0 text-white">General form submission</span>
        </a>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6 text-white" v-if="subMenuName == null || subMenuName != 'general-forms'">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6 text-white" v-else-if="subMenuName == 'general-forms'">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
        </svg>
      </li>
      <ul id="general-forms-body" class="ml-6" :class="subMenuName == 'general-forms' ? 'block' : 'hidden'">
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.advertiser-forms.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.advertiser-forms.index'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Advertiser forms</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.contact-forms.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.contact-forms.index'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Contact forms</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.info-letter-forms.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.info-letter-forms.index'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Info letter forms</span>
          </router-link>
        </li>
      </ul>
      <li class="cursor-pointer flex items-center justify-between pr-2" @click.prevent="
        subMenuName == 'general-setting'
          ? updateSubMenuName(null)
          : updateSubMenuName('general-setting')
        ">
        <a href="#"
          class="py-2 hover:border-l-4 border-white flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
          </div>
          <span class="links_name pointer-events-auto opacity-0 text-white">Settings</span>
        </a>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6 text-white" v-if="subMenuName == null || subMenuName != 'general-setting'">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-6 h-6 text-white" v-else-if="subMenuName == 'general-setting'">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
        </svg>
      </li>
      <ul id="general-setting-body" class="ml-6" :class="subMenuName == 'general-setting' ? 'block' : 'hidden'">
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.general-setting.create' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.general-setting.create'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">General setting</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.meta-tags-setting.create' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.meta-tags-setting.create'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Meta tags setting</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.footer-setting.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.footer-setting.index' ||
              $route.name == 'admin.footer-setting.create' ||
              $route.name == 'admin.footer-setting.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25m-18 0V6a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 6v2.25m-18 0h18M5.25 6h.008v.008H5.25V6zM7.5 6h.008v.008H7.5V6zm2.25 0h.008v.008H9.75V6z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Footer setting</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.media-setting.create' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.media-setting.create'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Media setting</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.menus.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.menus.index' ||
              $route.name == 'admin.menus.create' ||
              $route.name == 'admin.menus.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Menu setting</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.email-setting.create' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.email-setting.create'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Email setting</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{ name: 'admin.email-templates.index' }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.name == 'admin.email-templates.index' ||
              $route.name == 'admin.email-templates.create' ||
              $route.name == 'admin.email-templates.edit'
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.087 1.928l-7.5 4.286a2.25 2.25 0 01-2.226 0L2.837 8.921A2.25 2.25 0 011.75 6.993V6.75" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Email templates</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{
            name: 'admin.static-translation.create',
            params: { type: 'i2b-modal' },
          }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.path.indexOf('i2b-modal') > -1
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">I2b popup setting</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{
            name: 'admin.static-translation.create',
            params: { type: 'general' },
          }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.path.indexOf('general') > -1
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">General translation setting</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{
            name: 'admin.static-translation.create',
            params: { type: 'advance-search' },
          }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.path.indexOf('advance-search') > -1
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Advance search setting</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{
            name: 'admin.static-translation.create',
            params: { type: 'cookies-modal' },
          }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.path.indexOf('cookies-modal') > -1
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Cookies modal setting</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{
            name: 'admin.static-translation.create',
            params: { type: 'reset-password-setting' },
          }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.path.indexOf('reset-password-setting') > -1
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Reset password setting</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{
            name: 'admin.static-translation.create',
            params: { type: 'forget-password-setting' },
          }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.path.indexOf('forget-password-setting') > -1
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Forget password setting</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{
            name: 'admin.static-translation.create',
            params: { type: 'event-detail-setting' },
          }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.path.indexOf('event-detail-setting') > -1
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Event detail setting</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{
            name: 'admin.static-translation.create',
            params: { type: 'exporting-fair-detail-setting' },
          }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.path.indexOf('exporting-fair-detail-setting') > -1
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Exporting fair detail setting</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{
            name: 'admin.static-translation.create',
            params: { type: 'business-profile-setting' },
          }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.path.indexOf('business-profile-setting') > -1
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Business profile setting</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{
            name: 'admin.static-translation.create',
            params: { type: 'payment-setting' },
          }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.path.indexOf('payment-setting') > -1
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Payment & review setting</span>
          </router-link>
        </li>
        <li @click="hideBurgerMenu()">
          <router-link :to="{
            name: 'admin.static-translation.create',
            params: { type: 'general-messages' },
          }"
            class="py-2 flex items-start h-full w-full hover:bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group"
            :class="$route.path.indexOf('general-messages') > -1
              ? 'border-l-4 border-white bg-gradient-to-r from-secondarywhite to-transparent bg-opacity-50 group'
              : ''
              ">
            <div class="sidebar-links-icon flex justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
              </svg>
            </div>
            <span class="links_name pointer-events-auto opacity-0 text-white">Alerts setting</span>
          </router-link>
        </li>
      </ul>
    </ul>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: mapState({
    isBurgerMenu: (state) => state.menus.isBurgerMenu,
    subMenuName: (state) => state.menus.subMenuName,
  }),
  methods: {
    updateSubMenuName(menuName) {
      this.$store.commit("menus/setSubMenuName", menuName);
    },
    burgerMenu() {
      this.$store.commit("menus/setIsBurgerMenu");
    },
    hideBurgerMenu() {
      if (
        navigator.userAgent.match(/Android/i) ||
        navigator.userAgent.match(/webOS/i) ||
        navigator.userAgent.match(/iPhone/i) ||
        navigator.userAgent.match(/iPad/i) ||
        navigator.userAgent.match(/iPod/i) ||
        navigator.userAgent.match(/BlackBerry/i) ||
        navigator.userAgent.match(/Windows Phone/i)
      ) {
        this.burgerMenu();
      }
    },
  },
  created() {
    let routeName = this.$route.name;
    if (
      routeName == "admin.languages.index" ||
      routeName == "admin.languages.create" ||
      routeName == "admin.languages.edit" ||
      routeName == "admin.business-profile-stats.index" ||
      routeName == "admin.business_categories.index" ||
      routeName == "admin.business_categories.create" ||
      routeName == "admin.business_categories.edit" ||
      routeName == "admin.registration_packages.index" ||
      routeName == "admin.registration_packages.create" ||
      routeName == "admin.registration_packages.edit" ||
      routeName == "admin.billing_period_discounts.index" ||
      routeName == "admin.i2b.index" ||
      routeName == "admin.i2b.create" ||
      routeName == "admin.i2b.edit" ||
      routeName == "admin.banners.index" ||
      routeName == "admin.banners.create" ||
      routeName == "admin.banners.edit" ||
      routeName == "admin.sponsors.index" ||
      routeName == "admin.sponsors.view" ||
      routeName == "admin.events.index" ||
      routeName == "admin.events.create" ||
      routeName == "admin.events.edit" ||
      routeName == "admin.testimonials.index" ||
      routeName == "admin.testimonials.create" ||
      routeName == "admin.testimonials.edit" ||
      routeName == "admin.successStories.index" ||
      routeName == "admin.successStories.create" ||
      routeName == "admin.successStories.edit" ||
      routeName == "admin.issues.index" ||
      routeName == "admin.issues.create" ||
      routeName == "admin.issues.edit" ||
      routeName == "admin.coffee_wall_faqs.index" ||
      routeName == "admin.holiday-emails.index" ||
      routeName == "admin.holiday-emails.create" ||
      routeName == "admin.holiday-emails.edit" ||
      routeName == "admin.one-more-thing.index" ||
      routeName == "admin.one-more-thing.create" ||
      routeName == "admin.one-more-thing.edit" ||
      routeName == "admin.exporting-fairs.index" ||
      routeName == "admin.exporting-fairs.create" ||
      routeName == "admin.exporting-fairs.edit"
    ) {
      this.updateSubMenuName("supporting-forms");
    } else if (
      routeName == "admin.articles.index" ||
      routeName == "admin.articles.create" ||
      routeName == "admin.articles.edit" ||
      routeName == "admin.article-sections.index" ||
      routeName == "admin.article-sections.create" ||
      routeName == "admin.article-sections.edit"
    ) {
      this.updateSubMenuName("supporting-forms");
    } else if (
      routeName == "admin.coffee_wall_beneficiaries.index" ||
      routeName == "admin.coffee_wall_beneficiaries.create" ||
      routeName == "admin.coffee_wall_beneficiaries.edit" ||
      routeName == "admin.admin-accounts.index" ||
      routeName == "admin.admin-accounts.create" ||
      routeName == "admin.admin-accounts.edit" ||
      routeName == "admin.users.index" ||
      routeName == "admin.users.create" ||
      routeName == "admin.users.edit"
    ) {
      this.updateSubMenuName("user-accounts");
    } else if (
      routeName == "admin.advertiser-forms.index" ||
      routeName == "admin.info-letter-forms.index" ||
      routeName == "admin.contact-forms.index"
    ) {
      this.updateSubMenuName("general-forms");
    } else if (
      routeName == "admin.general-setting.create" ||
      routeName == "admin.meta-tags-setting.create" ||
      routeName == "admin.footer-setting.index" ||
      routeName == "admin.footer-setting.create" ||
      routeName == "admin.footer-setting.edit" ||
      routeName == "admin.media-setting.create" ||
      routeName == "admin.menus.index" ||
      routeName == "admin.menus.create" ||
      routeName == "admin.menus.edit" ||
      routeName == "admin.menu-builder.edit" ||
      routeName == "admin.email-templates.index" ||
      routeName == "admin.email-templates.create" ||
      routeName == "admin.email-templates.edit"
    ) {
      this.updateSubMenuName("general-setting");
    }
  },
};
</script>
