<template>
  <div>
    <TransitionRoot as="template" :show="sidebarOpen">
      <Dialog as="div" class="relative z-50 lg:hidden" @close="sidebarOpen = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0"
          enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
          leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-900/80" />
        </TransitionChild>

        <div class="fixed inset-0 flex">
          <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
            enter-from="-translate-x-full" enter-to="translate-x-0"
            leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
            leave-to="-translate-x-full">
            <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
              <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                  <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                    <span class="sr-only">Close sidebar</span>
                    <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                  </button>
                </div>
              </TransitionChild>
              <!-- Sidebar component, swap this element with another sidebar if you like -->
              <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gradient-to-l from-blue-500 to-blue-600 pb-4">
                <div class="flex h-16 shrink-0 items-center bg-white text-center px-4 py-2">
                  <img src="/assets/images/logo.png" class="w-48 h-auto" alt="Candian Exporters" />
                </div>
                <nav class="flex flex-1 flex-col px-6">
                  <ul role="list" class="flex flex-1 flex-col gap-y-7 font-FuturaMdCnBT">
                    <li>
                      <ul role="list" class="-mx-2 space-y-1 font-FuturaMdCnBT">
                        <li v-for="item in resolvedNavigation" :key="item.name">
                          <router-link v-if="!item.children" :to="item.href" :class="[
                            isCurrent(item.href)
                              ? 'bg-secondary text-white'
                              : 'text-blue-100 hover:text-white hover:bg-secondary',
                            'group flex gap-x-3 rounded-md p-2 text-base leading-6 font-FuturaMdCnBT',
                          ]">
                            <component :is="item.icon" :class="[
                              isCurrent(item.href)
                                ? 'text-gray-700'
                                : 'hover:text-gray-800',
                              'h-6 w-6 shrink-0',
                            ]" aria-hidden="true" />
                            {{ item.name }}
                          </router-link>
                          <Disclosure as="div" v-else v-slot="{ open }">
                            <DisclosureButton :class="[
                              isParentCurrent(item)
                                ? 'bg-secondary text-white'
                                : 'hover:bg-secondary hover:text-white text-blue-100',
                              'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-base leading-6',
                            ]">
                              <component :is="item.icon" :class="[
                                isParentCurrent(item) ? 'text-gray-800' : '',
                                'h-6 w-6 shrink-0',
                              ]" aria-hidden="true" />
                              {{ item.name }}
                              <ChevronRightIcon :class="[
                                open
                                  ? 'rotate-90 text-gray-800'
                                  : 'hover:text-gray-800',
                                'ml-auto h-5 w-5 shrink-0',
                              ]" aria-hidden="true" />
                            </DisclosureButton>
                            <DisclosurePanel as="ul" class="mt-1 px-2 rounded-2xl border-2 border-solid bg-blue-50">
                        <li v-for="subItem in item.children" :key="subItem.name">
                          <DisclosureButton as="a" :href="subItem.href" :class="[
                            isCurrent(subItem.href)
                              ? 'text-gray-900'
                              : 'hover:text-gray-900',
                            'block rounded-md py-2 pr-2 pl-9 text-base leading-6 text-gray-600',
                          ]">
                            {{ subItem.name }}
                          </DisclosureButton>
                        </li>
                        </DisclosurePanel>
                        </Disclosure>
                    </li>
                  </ul>
                  </li>
                  <li>
                    <div class="text-base leading-6 text-blue-100">
                      Management
                    </div>
                    <ul role="list" class="-mx-2 mt-2 space-y-1 font-FuturaMdCnBT">
                      <li v-for="team in resolvedTeam" :key="team.name">
                        <a :href="team.href" :class="[
                          team.current
                            ? 'bg-secondary text-white'
                            : 'text-blue-100 hover:text-white hover:bg-secondary',
                          'group flex gap-x-3 rounded-md p-2 text-base leading-6',
                        ]">
                          <span
                            class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-blue-400 bg-blue-500 text-[0.625rem] font-medium text-white">{{
                              team.initial }}</span>
                          <span class="truncate">{{ team.name }}</span>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="mt-auto">
                    <router-link :to="{ name: 'admin.general-setting.create' }"
                      class="group -mx-2 flex gap-x-3 rounded-md p-2 text-base leading-6 text-blue-100 hover:bg-secondary hover:text-white">
                      <Cog6ToothIcon class="h-6 w-6 shrink-0 text-blue-100 group-hover:text-white" aria-hidden="true" />
                      Settings
                    </router-link>
                  </li>
                  </ul>
                </nav>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-0 lg:flex lg:w-72 lg:flex-col font-FuturMdCnBT">
      <!-- Sidebar component, swap this element with another sidebar if you lik7e -->
      <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gradient-to-l from-blue-500 to-blue-600 pb-4">
        <div class="block h-16 shrink-0 items-center bg-white text-center px-4 py-2">
          <img src="/assets/images/logo.png" class="w-48 h-auto" alt="Candian Exporters" />
        </div>
        <nav class="flex flex-1 flex-col px-6">
          <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
              <ul role="list" class="-mx-2 space-y-1 font-FuturaMdCnBT">
                <li v-for="item in resolvedNavigation" :key="item.name">
                  <router-link v-if="!item.children" :to="item.href" :class="[
                    isCurrent(item.href)
                      ? 'bg-secondary text-white'
                      : 'text-blue-100 hover:text-white hover:bg-secondary',
                    'group flex gap-x-3 rounded-md p-2 text-base md:text-base lg:text-lg leading-6',
                  ]">
                    <component :is="item.icon" :class="[
                      isCurrent(item.href)
                        ? 'text-gray-700'
                        : 'hover:text-gray-800',
                      'h-6 w-6 shrink-0',
                    ]" aria-hidden="true" />
                    {{ item.name }}
                  </router-link>
                  <Disclosure as="div" v-else v-slot="{ open }">
                    <DisclosureButton :class="[
                      isParentCurrent(item)
                        ? 'bg-secondary text-white'
                        : 'hover:bg-secondary hover:text-white text-blue-100',
                      'flex items-center w-full text-left rounded-md p-2 gap-x-3 leading-6 text-base md:text-base lg:text-lg',
                    ]">
                      <component :is="item.icon" :class="[
                        isParentCurrent(item) ? 'text-gray-800' : '',
                        'h-6 w-6 shrink-0',
                      ]" aria-hidden="true" />
                      {{ item.name }}
                      <ChevronRightIcon :class="[
                        open
                          ? 'rotate-90 text-gray-800'
                          : 'hover:text-gray-800',
                        'ml-auto h-5 w-5 shrink-0',
                      ]" aria-hidden="true" />
                    </DisclosureButton>
                    <DisclosurePanel as="ul" class="mt-1 px-2 rounded-2xl border-2 border-solid bg-blue-50">
                <li v-for="subItem in item.children" :key="subItem.name">
                  <DisclosureButton as="a" :href="subItem.href" :class="[
                    isCurrent(subItem.href)
                      ? 'text-gray-900 font-semibold'
                      : 'hover:text-gray-900',
                    'block rounded-md py-2 pr-2 pl-9 text-base leading-6 text-gray-600',
                  ]">
                    {{ subItem.name }}
                  </DisclosureButton>
                </li>
                </DisclosurePanel>
                </Disclosure>
            </li>
          </ul>
          </li>
          <li>
            <div class="text-base leading-6 text-blue-100 font-FuturaMdCnBT">
              Management
            </div>
            <ul role="list" class="-mx-2 mt-2 space-y-1 font-FuturaMdCnBT">
              <li v-for="team in resolvedTeam" :key="team.name">
                <a :href="team.href" :class="[
                  team.current
                    ? 'bg-secondary text-white'
                    : 'text-blue-100 hover:text-white hover:bg-secondary',
                  'group flex gap-x-3 rounded-md p-2 text-base md:text-base lg:text-lg leading-6',
                ]">
                  <span
                    class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-blue-400 bg-secondary text-[0.625rem] font-medium text-white">{{
                      team.initial }}</span>
                  <span class="truncate">{{ team.name }}</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="mt-auto">
            <router-link :to="{ name: 'admin.general-setting.create' }"
              class="group -mx-2 flex gap-x-3 rounded-md p-2 text-base md:text-base lg:text-lg leading-6 text-blue-100 hover:bg-secondary hover:text-white font-FuturaMdCnBT">
              <Cog6ToothIcon class="h-6 w-6 shrink-0 text-blue-100 group-hover:text-white" aria-hidden="true" />
              Settings
            </router-link>
          </li>
          </ul>
        </nav>
      </div>
    </div>

    <div class="lg:pl-72">
      <div
        class="sticky top-0 z-10 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
        <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="sidebarOpen = true">
          <span class="sr-only">Open sidebar</span>
          <Bars3Icon class="h-6 w-6" aria-hidden="true" />
        </button>

        <!-- Separator -->
        <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true" />

        <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
          <div class="relative flex flex-1" action="#" method="GET">
            <nav class="flex" aria-label="Breadcrumb">
              <ol class="items-center space-x-1 md:space-x-3 hidden md:inline-flex">
                <template v-for="(breadcrumb, index) in breadcrumbs">
                  <li class="inline-flex items-center" v-if="index == 0">
                    <router-link :to="{ name: breadcrumb.routeName }" :disabled="breadcrumb.isCurrentRoute"
                      class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                      <svg aria-hidden="true" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                        </path>
                      </svg>
                      {{ breadcrumb.name }}
                    </router-link>
                  </li>
                  <li v-else :aria-current="breadcrumb.isCurrentRoute ? 'page' : ''">
                    <div class="flex items-center">
                      <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                          clip-rule="evenodd"></path>
                      </svg>
                      <router-link :to="{ name: breadcrumb.routeName }" :disabled="breadcrumb.isCurrentRoute" href="#"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                        {{ breadcrumb.name }}</router-link>
                    </div>
                  </li>
                </template>
              </ol>
            </nav>
          </div>
          <div class="flex items-center gap-x-4 lg:gap-x-6">
            <!-- Profile dropdown -->
            <Menu as="div" class="relative">
              <MenuButton class="-m-1.5 flex items-center p-1.5">
                <span class="sr-only">Open user menu</span>
                <img class="h-8 w-8 rounded-full bg-gray-50" :src="loggedInUser ? loggedInUser.profile_photo_path : ''"
                  alt="profile image" />
                <span class="hidden lg:flex lg:items-center">
                  <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true">{{ loggedInUser ?
                    loggedInUser.name : "" }}</span>
                  <ChevronDownIcon class="ml-2 h-5 w-5 text-gray-400" aria-hidden="true" />
                </span>
              </MenuButton>
              <transition enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95">
                <MenuItems
                  class="absolute right-0 z-10 mt-2.5 w-48 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                  <div class="px-4 py-3">
                    <p class="text-sm leading-5">Signed in as</p>
                    <p class="text-sm font-medium leading-5 text-gray-900 truncate">
                      {{ loggedInUser ? loggedInUser.email : "" }}
                    </p>
                  </div>
                  <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                  <router-link :to="item.href" :class="[
                    active ? 'bg-blue-50' : '',
                    'block px-3 py-1 text-sm leading-6 text-gray-900',
                  ]">{{ item.name }}</router-link>
                  </MenuItem>
                  <div class="py-1">
                    <a href="javascript:void(0)" tabindex="3"
                      class="text-red flex justify-between w-full px-4 py-2 text-sm leading-5 text-left" role="menuitem"
                      onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
                  </div>
                </MenuItems>
              </transition>
            </Menu>
          </div>
        </div>
      </div>

      <main class="py-4 relative">
        <div class="px-2 sm:px-4 lg:px-6">
          <slot />
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import { useRoute, useRouter } from "vue-router";
import { ref, watchEffect } from "vue";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { ChevronRightIcon } from "@heroicons/vue/20/solid";
import {
  Dialog,
  DialogPanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import {
  Bars3Icon,
  HomeIcon,
  Cog6ToothIcon,
  DocumentIcon,
  XMarkIcon,
  CubeIcon,
  InboxStackIcon,
  UserGroupIcon,
  WindowIcon,
  LanguageIcon,
  LifebuoyIcon,
  UserCircleIcon,
} from "@heroicons/vue/24/outline";
import { ChevronDownIcon, MagnifyingGlassIcon } from "@heroicons/vue/20/solid";

export default {
  computed: {
    ...mapState({
      loggedInUser: (state) => state.auth.loggedInUser,
    }),
    resolvedNavigation() {
      return [
        {
          name: "Profile",
          href: this.route("admin.profile.edit"),
          icon: HomeIcon,
        },
        {
          name: "Site Pages",
          href: this.route("admin.pages.index"),
          icon: DocumentIcon,
        },
        {
          name: "Business Profiles",
          href: this.route("admin.business-profiles.index"),
          icon: UserGroupIcon,
        },
        {
          name: "Banners",
          href: this.route("admin.widgets.index"),
          icon: WindowIcon,
        },
        {
          name: "Supporting Forms",
          icon: LifebuoyIcon,
          children: [
            { name: "Articles", href: this.route("admin.articles.index") },
            { name: "Article sections", href: this.route("admin.article-sections.index") },
            {
              name: "Billing Discounts",
              href: this.route("admin.billing_period_discounts.index"),
            },
            {
              name: "Business categories",
              href: this.route("admin.business_categories.index"),
            },
            {
              name: "Business directories",
              href: this.route("admin.business_directories.index"),
            },
            {
              name: "Coffee on wall packages",
              href: this.route("admin.coffee_on_wall_packages.index"),
            },
            {
              name: "Coffee Wall Beneficiaries",
              href: this.route("admin.coffee_wall_beneficiaries.index"),
            },
            { name: "Events", href: this.route("admin.events.index") },
            {
              name: "Export Fairs",
              href: this.route("admin.exporting-fairs.index"),
            },
            { name: "Coffee Wall FAQs", href: this.route("admin.coffee_wall_faqs.index") },
            {
              name: "Financing Program",
              href: this.route("admin.financingPrograms.index"),
            },

            {
              name: "Holiday Emails",
              href: this.route("admin.holiday-emails.index"),
            },
            { name: "Inquiries to buy", href: this.route("admin.i2b.index") },
            { name: "Languages", href: this.route("admin.languages.index") },
            { name: "Magazines", href: this.route("admin.issues.index") },
            {
              name: "One more thing",
              href: this.route("admin.one-more-thing.index"),
            },
            {
              name: "Profile packages",
              href: this.route("admin.registration_packages.index"),
            },
            { name: "Sponsors", href: this.route("admin.sponsors.index") },
            {
              name: "Sponsor Amounts",
              href: this.route("admin.sponsor_amounts.index"),
            },
            {
              name: "Success Stories",
              href: this.route("admin.successStories.index"),
            },
            {
              name: "Testimonials",
              href: this.route("admin.testimonials.index"),
            },

          ],
        },
        {
          name: "Form Submissions",
          icon: InboxStackIcon,
          children: [
            {
              name: "Advertiser forms",
              href: this.route("admin.advertiser-forms.index"),
            },
            {
              name: "Contact forms",
              href: this.route("admin.contact-forms.index"),
            },
            {
              name: "Info letter forms",
              href: this.route("admin.info-letter-forms.index"),
            },
          ],
        },
        {
          name: "General Settings",
          icon: CubeIcon,
          children: [
            { name: "Error Handling", href: this.route("admin.errors.edit") },
            { name: "Footer", href: this.route("admin.footer-setting.index") },
            { name: "Media", href: this.route("admin.media-setting.create") },
            { name: "Menu", href: this.route("admin.menus.index") },
            {
              name: "Meta tags",
              href: this.route("admin.meta-tags-setting.create"),
            },
            {
              name: "Submissions",
              href: this.route("admin.email-setting.create"),
            },
            {
              name: "Email Templates",
              href: this.route("admin.email-templates.index"),
            },
          ],
        },
        {
          name: "Language Settings",
          icon: LanguageIcon,
          children: [
            {
              name: "Advance Search",
              href: this.route("admin.static-translation.create", {
                type: "advance-search",
              }),
            },
            {
              name: "Alert Settings",
              href: this.route("admin.static-translation.create", {
                type: "general-messages",
              }),
            },
            {
              name: "Business profile",
              href: this.route("admin.static-translation.create", {
                type: "business-profile-setting",
              }),
            },
            {
              name: "Coffee on the Wall",
              href: this.route("admin.static-translation.create", {
                type: "coffee-wall-setting",
              }),
            },
            {
              name: "Cookies",
              href: this.route("admin.static-translation.create", {
                type: "cookies-modal",
              }),
            },
            {
              name: "Event Details",
              href: this.route("admin.static-translation.create", {
                type: "event-detail-setting",
              }),
            },
            {
              name: "Export fair",
              href: this.route("admin.static-translation.create", {
                type: "exporting-fair-detail-setting",
              }),
            },
            {
              name: "Forget Password",
              href: this.route("admin.static-translation.create", {
                type: "forget-password-setting",
              }),
            },
            {
              name: "General Translation",
              href: this.route("admin.static-translation.create", {
                type: "general",
              }),
            },
            {
              name: "Inquiries to Buy",
              href: this.route("admin.static-translation.create", {
                type: "i2b-modal",
              }),
            },
            {
              name: "Online Business Directory Search",
              href: this.route("admin.static-translation.create", {
                type: "online-business-directory-search",
              }),
            },
            {
              name: "Payment & review",
              href: this.route("admin.static-translation.create", {
                type: "payment-setting",
              }),
            },
            {
              name: "Resend Email",
              href: this.route("admin.static-translation.create", {
                type: "resend-email-verification-setting",
              }),
            },
            {
              name: "Reset Password",
              href: this.route("admin.static-translation.create", {
                type: "reset-password-setting",
              }),
            },
            // {
            //   name: "Unsubcribe Email ",
            //   href: this.route("admin.static-translation.create", {
            //     type: "unsubscribe_email_setting",
            //   }),
            // },
          ],
        },
      ];
    },
    resolvedTeam() {
      return [
        {
          name: "Admin accounts",
          href: this.route("admin.admin-accounts.index"),
          icon: UserCircleIcon,
          initial: "A",
        },
        {
          name: "Coffee wallets",
          href: this.route("admin.coffee-wallets.index"),
          icon: CubeIcon,
          initial: "C",
        },
        {
          name: "Customers",
          href: this.route("admin.users.index"),
          icon: CubeIcon,
          initial: "C",
        },
        {
          name: "Stats",
          href: this.route("admin.business-profile-stats.index"),
          icon: CubeIcon,
          initial: "S",
        },
        //  { name: "Backups", href: "#", icon: CubeIcon, initial: 'B', },
      ];
    },
  },
  components: {
    Dialog,
    DialogPanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
    Bars3Icon,
    Cog6ToothIcon,
    HomeIcon,
    DocumentIcon,
    WindowIcon,
    LifebuoyIcon,
    InboxStackIcon,
    XMarkIcon,
    ChevronDownIcon,
    MagnifyingGlassIcon,
    CubeIcon,
    UserGroupIcon,
    ChevronRightIcon,
    DisclosureButton,
    DisclosurePanel,
    Disclosure,
  },
  setup() {
    const router = useRouter();

    function route(name, params = {}, query = {}) {
      const route = router.resolve({ name, params, query });
      return route.href;
    }
    return { route };
  },
  data() {
    return {
      breadcrumbs: [],
      userNavigation: [
        { name: "Change password", href: { name: "admin.profile.edit" } },
        { name: "Users", href: { name: "admin.users.index" } },
      ],
      sidebarOpen: false,
    };
  },
  created() {
    this.breadcrumbs = this.$route.meta.breadcrumbs;
    this.$store.dispatch("auth/fetchCurrentUser");
  },
  methods: {
    route(name) {
      return route(name);
    },
    burgerMenu() {
      this.$store.commit("menus/setIsBurgerMenu");
    },
    goToBack() {
      this.$router.go(-1);
    },
    isCurrent(path) {
      return path === window.location.href;
    },
    isParentCurrent(parentItem) {
      if (this.isCurrent(parentItem.href)) return true;
      return (
        parentItem.children?.some((child) => this.isCurrent(child.href)) ||
        false
      );
    },
  },
};
</script>
<style>
.dropdown:focus-within .dropdown-menu {
  opacity: 1;
  transform: translate(0) scale(1);
  visibility: visible;
}
</style>
