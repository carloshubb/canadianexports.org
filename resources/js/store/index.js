import { createStore } from "vuex";
import menus from "./admin/menus.js";
import languages from "./admin/languages.js";
import business_categories from "./admin/business_categories.js";
import registration_packages from "./admin/registration_packages.js";
import coffee_wall_packages from "./admin/coffee_wall_packages.js";
import packages from "./admin/packages.js";
import errors from "./admin/errors.js";
import reg_page_setting from "./admin/reg_page_setting.js";
import auth from "./admin/auth.js";
import pages from "./admin/pages.js";
import i2b from "./admin/i2b.js";
import banners from "./admin/banners.js";
import one_more_thing from "./admin/one_more_thing.js";
import exporting_fairs from "./admin/exporting_fairs.js";
import events from "./admin/events.js";
import sponsers from "./admin/sponsers.js";
import admin_accounts from "./admin/admin_accounts.js";
import users from "./admin/users.js";
import business_profiles from "./admin/business_profiles.js";
import testimonials from "./admin/testimonials.js";
import successStories from "./admin/successStories.js";
import financingPrograms from "./admin/financingPrograms.js";
import issues from "./admin/issues.js";
import widgets from "./admin/widgets.js";
import footer_setting from "./admin/footer_setting.js";
import general_setting from "./admin/general_setting.js";
import holiday_emails from "./admin/holiday_emails.js";
import static_translation from "./admin/static_translation.js";
import faqs from "./admin/faqs.js";
import email_setting from "./admin/email_setting.js";
import advertiser_forms from "./admin/advertiser_forms.js";
import info_letter_forms from "./admin/info_letter_forms.js";
import contact_forms from "./admin/contact_forms.js";
import coffee_wallets from "./admin/coffee_wallets.js";
import stats from "./admin/business_profile_stats.js";
import business_directories from "./admin/business_directories.js";
import coffee_wall_beneficiaries from "./admin/coffee_wall_beneficiaries.js";
import coffee_wall_faqs from "./admin/coffee_wall_faqs.js";

export default new createStore({
    strict: true,
    modules: {
        menus,
        sponsers,
        languages,
        business_categories,
        registration_packages,
        coffee_wall_packages,
        packages,
        business_directories,
        auth,
        errors,
        reg_page_setting,
        pages,
        i2b,
        banners,
        events,
        admin_accounts,
        users,
        business_profiles,
        testimonials,
        financingPrograms,
        successStories,
        issues,
        widgets,
        footer_setting,
        general_setting,
        faqs,
        email_setting,
        advertiser_forms,
        info_letter_forms,
        contact_forms,
        coffee_wallets,
        stats,
        static_translation,
        holiday_emails,
        one_more_thing,
        exporting_fairs,
        coffee_wall_beneficiaries,
        coffee_wall_faqs,
    },
});
