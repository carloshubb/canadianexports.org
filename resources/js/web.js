
require("./bootstrap");
import { createApp } from "vue";
import store from "./store/web/index.js";
import signup from "./web/signup/Signup.vue";
import SocialMedia from "./web/signup/SocialMedia";
import UserProfile from "./web/signup/UserProfile";
import CustomerProfile from "./web/signup/CustomerProfile";
import CustomerMedia from "./web/signup/Media";
import BusinessCategories from "./web/signup/BusinessCategories";
import RegistrationPackage from "./web/signup/RegistrationPackage";
import Rates from "./web/Rates/Index";
import AllEvents from "./web/Event/Index";
import AllSponsers from "./web/Sponser/Index.vue";
import ResetPasswordInput from "./web/components/ResetPasswordInput.vue";
import LoginPasswordInput from "./web/components/LoginPasswordInput.vue";
import CreateEventSignup from "./web/event-signup/Create";
import CreateCoffeeWall from "./web/coffee-wall/Create";
import ProfileEventSignup from "./web/event-signup/Profile";
import SuccessMessage from "./web/components/SuccessMessage";
import EventListing from "./web/Event-Listing/Index";
import EventListingGrid from "./web/Event-Listing/Event-Listing-Grid";
import AdvertisersContactForm from "./web/advertisers-contact-form/AdvertisersContactForm";
import DeactiveProfile from "./web/Customer/DeactiveProfile.vue";
import i2bListing from "./web/I2B/Index";
import i2bHome from "./web/I2B/I2B-home";
import CreateEvent from "./web/Event/Create";
import EventBookingStand from "./web/Event/BookingStand";
import EventContact from "./web/Event/Contact";
import CreateInfoLetter from "./web/info-letter/InfoLetter.vue";
import CreateContactUs from "./web/contact-us/ContactUs.vue";
import ScamAlert from "./web/scam-alert/ScamAlert.vue";
import Testimonial from "./web/testimonial/Testimonial.vue";
import SuccessStories from "./web/success_stories/SuccessStories.vue";
import FaqExporter from "./web/faq-exporter/FaqExporter.vue";
import FaqImporter from "./web/faq-importer/FaqImporter.vue";
import CloseAccount from "./web/close-account/CloseAccount.vue";
import CreateComments from "./web/comments/Comments.vue";
import CreateBecomeSponsor from "./web/become-sponsor/BecomeSponsor.vue";
import SponsorProfile from "./web/become-sponsor/SponsorProfile.vue";
import SponsorProfileEdit from "./web/become-sponsor/SponsorProfileEdit.vue";
import SponsorshipsList from "./web/become-sponsor/SponsorshipsList.vue";
import SponsorManagement from "./web/become-sponsor/SponsorManagement.vue";
import AddSponsorshipForm from "./web/become-sponsor/AddSponsorshipForm.vue";
import CreateFinancingProgram from "./web/financing-program/FinancingProgram.vue";
import ContactForRateForm from "./web/contact-for-rate/ContactForRateForm.vue";
import CreateProfilePayment from "./web/profile-payment/ProfilePayment";

import LanguageModal from "./web/modals/LanguageModal.vue";
import Message from "./web/components/Message.vue";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

createApp({})
    .use(VueSweetalert2)
    .component("signup", signup)

    .component("LanguageModal", LanguageModal)
    .component("SocialMedia", SocialMedia)
    .component("UserProfile", UserProfile)
    .component("CustomerProfile", CustomerProfile)
    .component("CustomerMedia", CustomerMedia)
    .component("Message", Message)
    .component("CreateEvent", CreateEvent)
    .component("EventBookingStand", EventBookingStand)
    .component("EventContact", EventContact)
    .component("CreateInfoLetter", CreateInfoLetter)
    .component("CreateContactUs", CreateContactUs)
    .component("ScamAlert", ScamAlert)
    .component("Testimonial", Testimonial)
    .component("SuccessStories", SuccessStories)
    .component("FaqExporter", FaqExporter)
    .component("FaqImporter", FaqImporter)
    .component("CloseAccount", CloseAccount)
    .component("CreateComments", CreateComments)
    .component("CreateBecomeSponsor", CreateBecomeSponsor)
    .component("SponsorProfile", SponsorProfile)
    .component("SponsorProfileEdit", SponsorProfileEdit)
    .component("SponsorshipsList", SponsorshipsList)
    .component("SponsorManagement", SponsorManagement)
    .component("AddSponsorshipForm", AddSponsorshipForm)
    .component("CreateFinancingProgram", CreateFinancingProgram)
    .component("ContactForRateForm", ContactForRateForm)
    .component("CreateProfilePayment", CreateProfilePayment)
    .component("AllEvents", AllEvents)
    .component("AllSponsers", AllSponsers)
    .component("CreateEventSignup", CreateEventSignup)
    .component("CreateCoffeeWall", CreateCoffeeWall)
    .component("ProfileEventSignup", ProfileEventSignup)
    .component("SuccessMessage", SuccessMessage)
    .component("i2bListing", i2bListing)
    .component("i2bHome", i2bHome)
    .component("DeactiveProfile", DeactiveProfile)
    .component("AdvertisersContactForm", AdvertisersContactForm)
    .component("EventListing", EventListing)
    .component("EventListingGrid", EventListingGrid)
    .component("LoginPasswordInput", LoginPasswordInput)
    .component("ResetPasswordInput", ResetPasswordInput)
    .component("BusinessCategories", BusinessCategories)
    .component("RegistrationPackage", RegistrationPackage)
    .component("Rates", Rates)
    .use(store)
    .mount("#canexp-app");
