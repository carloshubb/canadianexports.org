<template>
    <div class="w-full">
        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row justify-between items-center gap-2">
            <div>
                <p class="text-center md:text-justify" v-if="subscription_status == 'ok'">
                    {{ general_setting && general_setting['next_invoice_text'] ? general_setting['next_invoice_text'] : ''}} {{ user.package_expiry_date }}
                </p>
                <p class="text-center md:text-justify" v-else>{{ general_setting && general_setting['package_validity_text'] ? general_setting['package_validity_text'] : ''}} {{ user.package_expiry_date }}</p>
            </div>
            <div class="flex items-center gap-2">
                <template v-if="user && user.is_auto_renew == '1'">
                    <button aria-label="Candian Exporters"
                        type="button"
                        class="button-exp-fill hover:text-white"
                        @click="cancelSubscription()"
                        v-if="subscription_status == 'ok'"
                    >
                    {{ general_setting && general_setting['cancel_subscription_text'] ? general_setting['cancel_subscription_text'] : ''}}
                    </button>
                    <button aria-label="Candian Exporters"
                        type="button"
                        class="button-exp-fill hover:text-white"
                        @click="resumeSubscription()"
                        v-else-if="subscription_status == 'cancel'"
                    >
                    {{ general_setting && general_setting['resume_subscription_text'] ? general_setting['resume_subscription_text'] : ''}}
                    </button>
                </template>
                <Upgrade :user="user"></Upgrade>
            </div>
        </div>
        <div v-if="loading">
            <div id="form_preloader">
                <div id="form_status">
                    <div class="form_spinner">
                        <div class="form-double-bounce1"></div>
                        <div class="form-double-bounce2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import Upgrade from "./Upgrade.vue";
export default {
    computed: {
        ...mapState({
            subscription_status: (state) => state.signup.subscription_status,
        }),
    },
    components: {
        Upgrade,
    },
    props: ["user"],
    data() {
        return {
            loading: false,
            general_setting: null,
        };
    },
    created() {
        this.$store.commit(
            "signup/setSubscriptionStatus",
            this.user.subscription_status
        );
        this.$store.dispatch("signup/fetchStaticSetting", {
            url: `${process.env.MIX_WEB_API_URL}get-static-setting?getGeneralSetting=1`
        }).then(res => {
            if(res.data.status == 'Success'){
                this.general_setting = res.data.data;
            }
        });
    },
    methods: {
        cancelSubscription() {
            this.loading = true;
            this.$store.dispatch("signup/cancelSubscription").then((res) => {
                if (res.data.status == "Success") {
                    this.$store.commit(
                        "signup/setSubscriptionStatus",
                        "cancel"
                    );
                }
                this.loading = false;
            });
        },
        resumeSubscription() {
            this.loading = true;
            this.$store.dispatch("signup/resumeSubscription").then((res) => {
                if (res.data.status == "Success") {
                    this.$store.commit("signup/setSubscriptionStatus", "ok");
                }
                this.loading = false;
            });
        },
    },
};
</script>
