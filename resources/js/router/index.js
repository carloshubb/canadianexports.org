import { createRouter, createWebHistory } from "vue-router";

import Dashboard from '../admin/Dashboard/Dashboard.vue'
import Languages from '../admin/Languages/Languages.vue'
import CreateLanguages from '../admin/Languages/Create.vue'
import BusinessCategories from '../admin/BusinessCategories/BusinessCategories.vue'
import CreateBusinessCategories from '../admin/BusinessCategories/Create.vue'
import BillingPeriodDiscounts from '../admin/BillingPeriodDiscounts/Index.vue'
import RegistrationPackages from '../admin/RegistrationPackages/RegistrationPackages.vue'
import CoffeeWallPackages from '../admin/CoffeeOnWallPackages/Index.vue'
import CreateRegistrationPackages from '../admin/RegistrationPackages/Create.vue'
import CreateCoffeeWallPackages from '../admin/CoffeeOnWallPackages/Create.vue'
import Packages from '../admin/Packages/Packages.vue'
import CreatePackages from '../admin/Packages/Create.vue'
import Errors from '../admin/Errors/Create.vue'
import RegPageSetting from '../admin/Pages/RegPageSetting.vue'
import Profile from '../admin/Profile/Profile.vue'
import Pages from '../admin/Pages/Pages.vue'
import CreatePages from '../admin/Pages/Create.vue'
import BusinessDirectories from "../admin/BusinessDirectories/BusinessDirectories.vue";
import CreateBusinessDirectories from "../admin/BusinessDirectories/Create.vue";
import BulkImportBusinessDirectory from "../admin/BusinessDirectories/BulkImportBusinessDirectory.vue";
import Banners from '../admin/Banners/Banners.vue'
import CreateBanners from '../admin/Banners/Create.vue'
import Sponsors from '../admin/Sponsors/Index.vue'
import ViewSponsor from '../admin/Sponsors/View.vue'
import InquiriesToBuy from '../admin/I2b/I2b.vue'
import CreateInquiriesToBuy from '../admin/I2b/Create.vue'
import ImportInquiriesToBuy from '../admin/I2b/Import.vue'
import Events from '../admin/Events/Events.vue'
import CreateEvents from '../admin/Events/Create.vue'
import ExportingFairs from '../admin/ExportingFairs/ExportingFairs.vue'
import CreateExportingFairs from '../admin/ExportingFairs/Create.vue'
import OneMoreThing from '../admin/OneMoreThing/OneMoreThing.vue'
import CreateOneMoreThing from '../admin/OneMoreThing/Create.vue'
import EmailTemplates from '../admin/EmailTemplates/Index.vue'
import CreateEmailTemplate from '../admin/EmailTemplates/Create.vue'
import AdminAccounts from '../admin/AdminAccounts/AdminAccounts.vue'
import CreateAdminAccounts from '../admin/AdminAccounts/Create.vue'
import Users from '../admin/Users/Users.vue'
import CreateUsers from '../admin/Users/Create.vue'
import ShowUser from '../admin/Users/Show.vue'
import BusinessProfiles from '../admin/BusinessProfiles/BusinessProfiles.vue'
import CreateBusinessProfiles from '../admin/BusinessProfiles/Create.vue'
import ImportBusinessProfiles from '../admin/BusinessProfiles/Import.vue'
import Testimonials from '../admin/Testimonials/Testimonials.vue'
import SuccessStories from '../admin/SuccessStories/SuccessStories.vue'
import CreateTestimonials from '../admin/Testimonials/Create.vue'
import CreateSuccessStories from '../admin/SuccessStories/Create.vue'
import CreateFinancingPrograms from '../admin/FinancingProgram/Create.vue'
import FinancingPrograms from '../admin/FinancingProgram/FinancingProgram.vue'
import Issues from '../admin/Issues/Issues.vue'
import CreateIssues from '../admin/Issues/Create.vue'
import Menus from '../admin/Menus/Menus.vue'
import CreateMenus from '../admin/Menus/Create.vue'
import CreateMenuBuilder from '../admin/Menus/MenuBuilder.vue'
import Widgets from '../admin/Widgets/Widgets.vue'
import CreateWidgets from '../admin/Widgets/Create.vue'
import FooterSetting from '../admin/FooterSetting/FooterSetting.vue'
import CreateFooterSetting from '../admin/FooterSetting/Create.vue'
import CreateGeneralSetting from '../admin/GeneralSetting/Create.vue'
import CreatePackageSetting from '../admin/PackageSetting/Create.vue'
import CreateMetaTagsSetting from '../admin/MetaTags/Create.vue'
import CreateStaticTranslation from '../admin/StaticTranslation/Create.vue'
import CreateMediaSetting from '../admin/MediaSetting/Create.vue'
import Faqs from '../admin/Faqs/Faqs.vue'
import CreateFaqs from '../admin/Faqs/Create.vue'
import HolidayEmails from '../admin/HolidayEmails/HolidayEmails.vue'
import CreateHolidayEmails from '../admin/HolidayEmails/Create.vue'
import CreateEmailSetting from '../admin/EmailSetting/Create.vue'
import AdvertiserForms from '../admin/GeneralForms/AdvertiserForms.vue'
import InfoLetterForms from '../admin/GeneralForms/InfoLetterForms.vue'
import ContactForms from '../admin/GeneralForms/ContactForms.vue'
import CoffeeWallets from '../admin/CoffeeWallets/Index.vue'
import BusinessProfileStats from '../admin/BusinessProfileStats/BusinessProfileStats.vue'
import BusinessProfileStatsSummary from '../admin/BusinessProfileStats/BusinessProfileStatsSummary.vue'
import CoffeeWallBeneficiaries from '../admin/CoffeeWallBeneficiaries/Index.vue'
import CoffeeWallFaqs from '../admin/CoffeeWallFaqs/Index.vue'
import SponsorAmounts from '../admin/SponsorAmounts/Index.vue'
import Articles from '../admin/Articles/Articles.vue'
import CreateArticle from '../admin/Articles/Create.vue'
import ArticleSections from '../admin/ArticleSections/Sections.vue'
import CreateArticleSection from '../admin/ArticleSections/Create.vue'
const routes = [
    {
        path: '/admin/dashboard',
        name: 'admin.dashboard',
        component: Dashboard,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/articles',
        name: 'admin.articles.index',
        component: Articles,
        meta: {
            breadcrumbs: [{ 'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0 }, { 'name': 'Articles', 'routeName': 'admin.articles.index', 'isCurrentRoute': 1 }],
        },
    },
    {
        path: '/admin/articles/create',
        name: 'admin.articles.create',
        component: CreateArticle,
        meta: {
            breadcrumbs: [{ 'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0 }, { 'name': 'Articles', 'routeName': 'admin.articles.index', 'isCurrentRoute': 0 }, { 'name': 'Create', 'routeName': 'admin.articles.create', 'isCurrentRoute': 1 }],
        },
    },
    {
        path: '/admin/articles/:id/edit',
        name: 'admin.articles.edit',
        component: CreateArticle,
        meta: {
            breadcrumbs: [{ 'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0 }, { 'name': 'Articles', 'routeName': 'admin.articles.index', 'isCurrentRoute': 0 }, { 'name': 'Edit', 'routeName': 'admin.articles.edit', 'isCurrentRoute': 1 }],
        },
    },
    {
        path: '/admin/article-sections',
        name: 'admin.article-sections.index',
        component: ArticleSections,
        meta: {
            breadcrumbs: [{ 'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0 }, { 'name': 'Article sections', 'routeName': 'admin.article-sections.index', 'isCurrentRoute': 1 }],
        },
    },
    {
        path: '/admin/article-sections/create',
        name: 'admin.article-sections.create',
        component: CreateArticleSection,
        meta: {
            breadcrumbs: [{ 'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0 }, { 'name': 'Article sections', 'routeName': 'admin.article-sections.index', 'isCurrentRoute': 0 }, { 'name': 'Create', 'routeName': 'admin.article-sections.create', 'isCurrentRoute': 1 }],
        },
    },
    {
        path: '/admin/article-sections/:id/edit',
        name: 'admin.article-sections.edit',
        component: CreateArticleSection,
        meta: {
            breadcrumbs: [{ 'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0 }, { 'name': 'Article sections', 'routeName': 'admin.article-sections.index', 'isCurrentRoute': 0 }, { 'name': 'Edit', 'routeName': 'admin.article-sections.edit', 'isCurrentRoute': 1 }],
        },
    },
    {
        path: '/admin/languages',
        name: 'admin.languages.index',
        component: Languages,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Languages', 'routeName': 'admin.languages.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/languages/create',
        name: 'admin.languages.create',
        component: CreateLanguages,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Languages', 'routeName': 'admin.languages.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.languages.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/languages/:id/edit',
        name: 'admin.languages.edit',
        component: CreateLanguages,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Languages', 'routeName': 'admin.languages.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.languages.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/business-categories',
        name: 'admin.business_categories.index',
        component: BusinessCategories,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Business categories', 'routeName': 'admin.business_categories.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/business-categories/create',
        name: 'admin.business_categories.create',
        component: CreateBusinessCategories,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Business categories', 'routeName': 'admin.business_categories.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.business_categories.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/business-categories/:id/edit',
        name: 'admin.business_categories.edit',
        component: CreateBusinessCategories,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Business categories', 'routeName': 'admin.business_categories.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.business_categories.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/coffee-on-wall-packages',
        name: 'admin.coffee_on_wall_packages.index',
        component: CoffeeWallPackages,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Coffee on wall packages', 'routeName': 'admin.coffee_on_wall_packages.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/coffee-on-wall-packages/create',
        name: 'admin.coffee_on_wall_packages.create',
        component: CreateCoffeeWallPackages,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Coffee on wall packages', 'routeName': 'admin.coffee_on_wall_packages.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.coffee_on_wall_packages.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/coffee-on-wall-packages/:id/edit',
        name: 'admin.coffee_on_wall_packages.edit',
        component: CreateCoffeeWallPackages,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Coffee on wall packages', 'routeName': 'admin.coffee_on_wall_packages.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.coffee_on_wall_packages.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/sponsor-amounts',
        name: 'admin.sponsor_amounts.index',
        component: SponsorAmounts,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Sponsor Amounts', 'routeName': 'admin.sponsor_amounts.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/billing-period-discounts',
        name: 'admin.billing_period_discounts.index',
        component: BillingPeriodDiscounts,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Billing Period Discounts', 'routeName': 'admin.billing_period_discounts.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/registration-packages',
        name: 'admin.registration_packages.index',
        component: RegistrationPackages,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Registration packages', 'routeName': 'admin.registration_packages.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/registration-packages/create',
        name: 'admin.registration_packages.create',
        component: CreateRegistrationPackages,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Registration packages', 'routeName': 'admin.registration_packages.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.registration_packages.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/registration-packages/:id/edit',
        name: 'admin.registration_packages.edit',
        component: CreateRegistrationPackages,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Registration packages', 'routeName': 'admin.registration_packages.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.registration_packages.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/packages',
        name: 'admin.packages.index',
        component: Packages,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Registration packages', 'routeName': 'admin.packages.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/packages/create',
        name: 'admin.packages.create',
        component: CreatePackages,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Registration packages', 'routeName': 'admin.packages.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.packages.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/packages/:id/edit',
        name: 'admin.packages.edit',
        component: CreatePackages,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Registration packages', 'routeName': 'admin.packages.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.packages.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/profile',
        name: 'admin.profile.edit',
        component: Profile,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Profile', 'routeName': 'admin.profile.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/errors',
        name: 'admin.errors.edit',
        component: Errors,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Errors', 'routeName': 'admin.errors.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/pages/registration',
        name: 'admin.registration.edit',
        component: RegPageSetting,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Registration page', 'routeName': 'admin.registration.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/pages',
        name: 'admin.pages.index',
        component: Pages,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Page', 'routeName': 'admin.pages.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/pages/create',
        name: 'admin.pages.create',
        component: CreatePages,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Pages', 'routeName': 'admin.pages.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.pages.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/pages/:id/edit',
        name: 'admin.pages.edit',
        component: CreatePages,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Inquiries to buy', 'routeName': 'admin.pages.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.pages.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/inquiries-to-buy',
        name: 'admin.i2b.index',
        component: InquiriesToBuy,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Page', 'routeName': 'admin.i2b.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/inquiries-to-buy/create',
        name: 'admin.i2b.create',
        component: CreateInquiriesToBuy,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Inquiries to buy', 'routeName': 'admin.i2b.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.i2b.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/inquiries-to-buy/:id/edit',
        name: 'admin.i2b.edit',
        component: CreateInquiriesToBuy,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Inquiries to buy', 'routeName': 'admin.i2b.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.i2b.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/inquiries-to-buy/import',
        name: 'admin.i2b.import',
        component: ImportInquiriesToBuy,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Inquiries to buy', 'routeName': 'admin.i2b.index', 'isCurrentRoute': 0}, {'name': 'Import inquiries', 'routeName': 'admin.i2b.import', 'isCurrentRoute': 1}],
        },
    },
    {
        path: "/admin/business_directories",
        name: "admin.business_directories.index",
        component: BusinessDirectories,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Business directories",
                    routeName: "admin.business_directories.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/business_directories/create",
        name: "admin.business_directories.create",
        component: CreateBusinessDirectories,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Business directories",
                    routeName: "admin.business_directories.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.business_directories.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/business-directories/bulk-import",
        name: "admin.business-directories.bulk.import",
        component: BulkImportBusinessDirectory,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Business directories",
                    routeName: "admin.business_directories.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Business directories Import",
                    routeName: "admin.business-directories.bulk.import",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/business_directories/:id/edit",
        name: "admin.business_directories.edit",
        component: CreateBusinessDirectories,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Business directories",
                    routeName: "admin.business_directories.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.business_directories.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: '/admin/banners',
        name: 'admin.banners.index',
        component: Banners,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Banners', 'routeName': 'admin.banners.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/banners/create',
        name: 'admin.banners.create',
        component: CreateBanners,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Banners', 'routeName': 'admin.banners.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.banners.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/banners/:id/edit',
        name: 'admin.banners.edit',
        component: CreateBanners,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Banners', 'routeName': 'admin.banners.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.banners.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/sponsors',
        name: 'admin.sponsors.index',
        component: Sponsors,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Sponsors', 'routeName': 'admin.sponsors.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/sponsors/:id',
        name: 'admin.sponsors.view',
        component: ViewSponsor,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Sponsors', 'routeName': 'admin.sponsors.index', 'isCurrentRoute': 0}, {'name': 'View', 'routeName': 'admin.sponsors.view', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/events',
        name: 'admin.events.index',
        component: Events,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Events', 'routeName': 'admin.events.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/events/create',
        name: 'admin.events.create',
        component: CreateEvents,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Events', 'routeName': 'admin.events.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.events.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/events/:id/edit',
        name: 'admin.events.edit',
        component: CreateEvents,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Events', 'routeName': 'admin.events.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.events.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/admin-accounts',
        name: 'admin.admin-accounts.index',
        component: AdminAccounts,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Admin accounts', 'routeName': 'admin.admin-accounts.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/admin-accounts/create',
        name: 'admin.admin-accounts.create',
        component: CreateAdminAccounts,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Admin accounts', 'routeName': 'admin.admin-accounts.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.admin-accounts.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/admin-accounts/:id/edit',
        name: 'admin.admin-accounts.edit',
        component: CreateAdminAccounts,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Admin accounts', 'routeName': 'admin.admin-accounts.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.admin-accounts.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/email-templates',
        name: 'admin.email-templates.index',
        component: EmailTemplates,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Email templates', 'routeName': 'admin.email-templates.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/email-templates/create',
        name: 'admin.email-templates.create',
        component: CreateEmailTemplate,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Email templates', 'routeName': 'admin.email-templates.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.email-templates.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/email-templates/:id/edit',
        name: 'admin.email-templates.edit',
        component: CreateEmailTemplate,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Email templates', 'routeName': 'admin.email-templates.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.email-templates.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/users',
        name: 'admin.users.index',
        component: Users,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Users', 'routeName': 'admin.users.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/users/create',
        name: 'admin.users.create',
        component: CreateUsers,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Users', 'routeName': 'admin.users.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.users.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/users/:id/edit',
        name: 'admin.users.edit',
        component: CreateUsers,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Users', 'routeName': 'admin.users.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.users.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/user/:id',
        name: 'admin.users.show',
        component: ShowUser,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Users', 'routeName': 'admin.users.index', 'isCurrentRoute': 0}, {'name': 'Show user', 'routeName': 'admin.users.show', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/business-profiles',
        name: 'admin.business-profiles.index',
        component: BusinessProfiles,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Business profiles', 'routeName': 'admin.business-profiles.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/business-profiles/create',
        name: 'admin.business-profiles.create',
        component: CreateBusinessProfiles,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Business profiles', 'routeName': 'admin.business-profiles.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.business-profiles.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/business-profiles/:id/edit',
        name: 'admin.business-profiles.edit',
        component: CreateBusinessProfiles,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Business profiles', 'routeName': 'admin.business-profiles.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.business-profiles.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/business-profiles/import',
        name: 'admin.business-profiles.import',
        component: ImportBusinessProfiles,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Business profiles', 'routeName': 'admin.business-profiles.index', 'isCurrentRoute': 0}, {'name': 'Import inquiries', 'routeName': 'admin.business-profiles.import', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/testimonials',
        name: 'admin.testimonials.index',
        component: Testimonials,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Testimonials', 'routeName': 'admin.testimonials.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/testimonials/create',
        name: 'admin.testimonials.create',
        component: CreateTestimonials,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Testimonials', 'routeName': 'admin.testimonials.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.testimonials.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/testimonials/:id/edit',
        name: 'admin.testimonials.edit',
        component: CreateTestimonials,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Testimonials', 'routeName': 'admin.testimonials.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.testimonials.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/financingPrograms',
        name: 'admin.financingPrograms.index',
        component: FinancingPrograms,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'FinancingPrograms', 'routeName': 'admin.financingPrograms.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/financingPrograms/create',
        name: 'admin.financingPrograms.create',
        component: CreateFinancingPrograms,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'FinancingPrograms', 'routeName': 'admin.financingPrograms.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.financingPrograms.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/financingPrograms/:id/edit',
        name: 'admin.financingPrograms.edit',
        component: CreateFinancingPrograms,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'FinancingPrograms', 'routeName': 'admin.financingPrograms.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.financingPrograms.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/successStories',
        name: 'admin.successStories.index',
        component: SuccessStories,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'SuccessStories', 'routeName': 'admin.successStories.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/successStories/create',
        name: 'admin.successStories.create',
        component: CreateSuccessStories,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'SuccessStories', 'routeName': 'admin.successStories.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.successStories.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/successStories/:id/edit',
        name: 'admin.successStories.edit',
        component: CreateSuccessStories,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'SuccessStories', 'routeName': 'admin.successStories.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.successStories.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/issues',
        name: 'admin.issues.index',
        component: Issues,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Issues', 'routeName': 'admin.issues.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/issues/create',
        name: 'admin.issues.create',
        component: CreateIssues,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Issues', 'routeName': 'admin.issues.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.issues.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/issues/:id/edit',
        name: 'admin.issues.edit',
        component: CreateIssues,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Issues', 'routeName': 'admin.issues.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.issues.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/menus',
        name: 'admin.menus.index',
        component: Menus,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Menus', 'routeName': 'admin.menus.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/menus/create',
        name: 'admin.menus.create',
        component: CreateMenus,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Menus', 'routeName': 'admin.menus.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.menus.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/menus/:id/edit',
        name: 'admin.menus.edit',
        component: CreateMenus,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Menus', 'routeName': 'admin.menus.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.menus.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/menus/:id/builder',
        name: 'admin.menu-builder.edit',
        component: CreateMenuBuilder,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Menus', 'routeName': 'admin.menus.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.menu-builder.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/widgets',
        name: 'admin.widgets.index',
        component: Widgets,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Widgets', 'routeName': 'admin.widgets.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/widgets/create',
        name: 'admin.widgets.create',
        component: CreateWidgets,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Widgets', 'routeName': 'admin.widgets.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.widgets.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/widgets/:id/edit',
        name: 'admin.widgets.edit',
        component: CreateWidgets,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Widgets', 'routeName': 'admin.widgets.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.widgets.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/footer-setting',
        name: 'admin.footer-setting.index',
        component: FooterSetting,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Footer setting', 'routeName': 'admin.footer-setting.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/footer-setting/create',
        name: 'admin.footer-setting.create',
        component: CreateFooterSetting,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Footer setting', 'routeName': 'admin.footer-setting.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.footer-setting.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/footer-setting/:id/edit',
        name: 'admin.footer-setting.edit',
        component: CreateFooterSetting,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Footer setting', 'routeName': 'admin.footer-setting.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.footer-setting.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/general-setting',
        name: 'admin.general-setting.create',
        component: CreateGeneralSetting,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Edit general setting', 'routeName': 'admin.general-setting.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/meta-tags-setting',
        name: 'admin.meta-tags-setting.create',
        component: CreateMetaTagsSetting,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Edit meta tags setting', 'routeName': 'admin.meta-tags-setting.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/static-translation/:type',
        name: 'admin.static-translation.create',
        component: CreateStaticTranslation,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Edit static translation', 'routeName': 'admin.static-translation.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/media-setting',
        name: 'admin.media-setting.create',
        component: CreateMediaSetting,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Edit media setting', 'routeName': 'admin.media-setting.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/faqs',
        name: 'admin.faqs.index',
        component: Faqs,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Faqs', 'routeName': 'admin.faqs.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/faqs/create',
        name: 'admin.faqs.create',
        component: CreateFaqs,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Faqs', 'routeName': 'admin.faqs.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.faqs.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/faqs/:id/edit',
        name: 'admin.faqs.edit',
        component: CreateFaqs,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Faqs', 'routeName': 'admin.faqs.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.faqs.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/holiday-emails',
        name: 'admin.holiday-emails.index',
        component: HolidayEmails,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Holiday emails', 'routeName': 'admin.holiday-emails.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/holiday-emails/create',
        name: 'admin.holiday-emails.create',
        component: CreateHolidayEmails,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Holiday emails', 'routeName': 'admin.holiday-emails.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.holiday-emails.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/holiday-emails/:id/edit',
        name: 'admin.holiday-emails.edit',
        component: CreateHolidayEmails,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Holiday emails', 'routeName': 'admin.holiday-emails.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.holiday-emails.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/email-setting',
        name: 'admin.email-setting.create',
        component: CreateEmailSetting,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Edit email setting', 'routeName': 'admin.email-setting.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/advertiser-forms',
        name: 'admin.advertiser-forms.index',
        component: AdvertiserForms,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Advertiser forms', 'routeName': 'admin.advertiser-forms.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/info-letter-forms',
        name: 'admin.info-letter-forms.index',
        component: InfoLetterForms,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Info letter forms', 'routeName': 'admin.info-letter-forms.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/contact-forms',
        name: 'admin.contact-forms.index',
        component: ContactForms,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Contact forms', 'routeName': 'admin.contact-forms.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/coffee-wallets',
        name: 'admin.coffee-wallets.index',
        component: CoffeeWallets,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Coffee wallets', 'routeName': 'admin.coffee-wallets.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/business-profile-stats',
        name: 'admin.business-profile-stats.index',
        component: BusinessProfileStats,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Stats', 'routeName': 'admin.business-profile-stats.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/business-profile-stats/:id',
        name: 'admin.business-profile-stats.show',
        component: BusinessProfileStatsSummary,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Stats', 'routeName': 'admin.business-profile-stats.index', 'isCurrentRoute': 0}, {'name': 'Stats summary', 'routeName': 'admin.business-profile-stats.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/one-more-thing',
        name: 'admin.one-more-thing.index',
        component: OneMoreThing,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'One more thing', 'routeName': 'admin.one-more-thing.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/one-more-thing/create',
        name: 'admin.one-more-thing.create',
        component: CreateOneMoreThing,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'One more thing', 'routeName': 'admin.one-more-thing.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.one-more-thing.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/one-more-thing/:id/edit',
        name: 'admin.one-more-thing.edit',
        component: CreateOneMoreThing,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'One more thing', 'routeName': 'admin.one-more-thing.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.one-more-thing.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/exporting-fairs',
        name: 'admin.exporting-fairs.index',
        component: ExportingFairs,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Exporting fairs', 'routeName': 'admin.exporting-fairs.index', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/exporting-fairs/create',
        name: 'admin.exporting-fairs.create',
        component: CreateExportingFairs,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Exporting fairs', 'routeName': 'admin.exporting-fairs.index', 'isCurrentRoute': 0}, {'name': 'Create', 'routeName': 'admin.exporting-fairs.create', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/exporting-fairs/:id/edit',
        name: 'admin.exporting-fairs.edit',
        component: CreateExportingFairs,
        meta: {
            breadcrumbs: [{'name': 'Dashboard', 'routeName': 'admin.dashboard', 'isCurrentRoute': 0}, {'name': 'Exporting fairs', 'routeName': 'admin.exporting-fairs.index', 'isCurrentRoute': 0}, {'name': 'Edit', 'routeName': 'admin.exporting-fairs.edit', 'isCurrentRoute': 1}],
        },
    },
    {
        path: '/admin/coffee-wall-beneficiaries',
        name: 'admin.coffee_wall_beneficiaries.index',
        component: CoffeeWallBeneficiaries,
        meta: {
            breadcrumbs: [
                { name: 'Dashboard', routeName: 'admin.dashboard', isCurrentRoute: 0 },
                { name: 'Coffee Wall Beneficiaries', routeName: 'admin.coffee_wall_beneficiaries.index', isCurrentRoute: 1 }
            ],
        },
    },
    {
        path: '/admin/coffee-wall-faqs',
        name: 'admin.coffee_wall_faqs.index',
        component: CoffeeWallFaqs,
        meta: {
            breadcrumbs: [
                { name: 'Dashboard', routeName: 'admin.dashboard', isCurrentRoute: 0 },
                { name: 'Coffee Wall FAQs', routeName: 'admin.coffee_wall_faqs.index', isCurrentRoute: 1 }
            ],
        },
    },
]

export default createRouter({
    history: createWebHistory(),
    routes
})
