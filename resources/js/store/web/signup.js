import ErrorHandling from "../../ErrorHandling";

const signup = {
    namespaced: true,
    state: {
        form: new FormData(),
        validationErros: new ErrorHandling(),
        error: null,
        selectedPackageId: null,
        loading: false,
        registrationPackages: null,
        businessCategories: null,
        customerPaymentMethods: null,
        payment_setting: null,
        regPageSetting: null,
        max_files: 0,
        subscription_status: 0,
        package_type: null,
        isRequiredFieldsFilled: true,
        selectedRegistrationPackage: null,
        payment_frequency: null,
        // registration_package_price: 0,
    },
    mutations: {
        removeValidationError(state, field) {
            if (state.validationErros[field]) {
                delete state.validationErros[field];
            }
        },
        setPaymentFrequency(state, payload) {
            state.payment_frequency = payload;
        },
        setSelectedRegistrationPackage(state, payload) {
            state.selectedRegistrationPackage = payload;
        },
        setPackageType(state, payload) {
            state.package_type = payload;
        },
        setSubscriptionStatus(state, payload) {
            state.subscription_status = payload;
        },
        setMaxFiles(state, payload) {
            state.max_files = payload;
        },
        setSelectedPackageId(state, payload) {
            state.selectedPackageId = payload;
        },
        setRegistrationPackages(state, payload) {
            state.registrationPackages = payload;
        },
        setRegPageSetting(state, payload) {
            state.regPageSetting = payload;
        },
        setBusinessCategories(state, payload) {
            state.businessCategories = payload;
        },
        setCustomerPaymentMethods(state, payload) {
            state.customerPaymentMethods = payload;
        },
        setPaymentSetting(state, payload) {
            state.payment_setting = payload;
        },
        // setRegistrationPackagePrice(state, payload) {
        //     state.registration_package_price = payload;
        // },
        setForm(state, payload) {
            state.form.set(payload.field, payload.value);
            this.commit('signup/checkRequiredFields');
        },
        resetGalleryImages(state, payload) {
            state.form.set("gallery_images", []);
        },
        recordValidationError(state, payload) {
            let fieldName = { [payload.field]: [payload.error] };
            state.validationErros.record(fieldName);
        },
        clearValidationError(state, payload) {
            state.validationErros.clear(payload.field);
        },
        setGalleryImages(state, payload) {
            if (payload.type == "add") {
                if (!state.form.get("gallery_images")) {
                    state.form.set(
                        "gallery_images",
                        JSON.stringify([payload.value])
                    );
                } else {
                    let gallery_images = JSON.parse(
                        state.form.get("gallery_images")
                    );
                    gallery_images.push(payload.value);
                    state.form.set(
                        "gallery_images",
                        JSON.stringify(gallery_images)
                    );
                }
            } else {
                let gallery_images = JSON.parse(
                    state.form.get("gallery_images")
                );
                const index = gallery_images.indexOf(payload.value);
                if (index > -1) {
                    gallery_images.splice(index, 1);
                    state.form.set(
                        "gallery_images",
                        JSON.stringify(gallery_images)
                    );
                }
            }
        },
        setBusinessCategoriesForm(state, payload) {
            if (payload.type == "add") {
                if (!state.form.get("business_categories_id")) {
                    state.form.set(
                        "business_categories_id",
                        JSON.stringify([payload.value])
                    );
                } else {
                    let business_categories_id = JSON.parse(
                        state.form.get("business_categories_id")
                    );
                    business_categories_id.push(payload.value);
                    state.form.set(
                        "business_categories_id",
                        JSON.stringify(business_categories_id)
                    );
                }
            } else {
                let business_categories_id = JSON.parse(
                    state.form.get("business_categories_id")
                );
                const index = business_categories_id.indexOf(payload.value);
                if (index > -1) {
                    business_categories_id.splice(index, 1);
                    state.form.set(
                        "business_categories_id",
                        JSON.stringify(business_categories_id)
                    );
                }
            }
            this.commit('signup/checkRequiredFields');
        },
        checkRequiredFields(state) {
            let fields = [
                "payment_frequency",
                "registration_package_id",
                "name",
                "email",
                "password",
                "password_confirmation",
                "customer_profile_company_name",
                "customer_profile_company_email",
                "customer_profile_address",
                "customer_profile_phone",
                "customer_profile_website",
                "customer_profile_short_description",
                "customer_profile_description",
                "customer_profile_keywords",
                "customer_profile_cta_link",
                "customer_profile_cta_btn",
                "is_agree",
                "business_categories_id",
            ];

            for (let i = 0; i < fields.length; i++) {
                let field = fields[i];
                if (
                    field == "is_agree" && (!state.form.has(field) ||
                        state.form.get(field) != 'true')
                ) {
                    state.isRequiredFieldsFilled = false;
                    break;
                } else if (
                    field == "business_categories_id" &&
                    (!state.form.has(field) ||
                        JSON.parse(state.form.get(field)).length == 0)
                ) {
                    state.isRequiredFieldsFilled = false;
                    break;
                } else if (
                    field != "is_agree" &&
                    field != "business_categories_id" &&
                    (!state.form.has(field) || state.form.get(field) === "")
                ) {
                    state.isRequiredFieldsFilled = false;
                    break;
                } else {
                    state.isRequiredFieldsFilled = true;
                }
            }
        },
        setValidationErros(state, payload) {
            state.validationErros.record(payload);
        },
        updateValidationErros(state, payload) {
            state.validationErros.set(payload.field, payload.message);
        },
        removeValidationErros(state, payload) {
            state.validationErros.clear(payload.field);
        },
        setEmptyError(state) {
            state.validationErros = new ErrorHandling();
        },
        setEmailErrorEmpty(state) {
            if (state.validationErros.has("email")) {
                state.validationErros.clear("email");
            }
        },
        setEmailError(state, payload) {
            console.log(payload);
            state.validationErros.set("email", payload?.email?.[0]);
        },
        setCustomerProfileEmailError(state, payload) {
            state.validationErros.set(
                "customer_profile_company_email",
                payload?.customer_profile_company_email?.[0]
            );
        },
        setCustomerProfileEmailErrorEmpty(state) {
            if (state.validationErros.has("customer_profile_company_email")) {
                state.validationErros.clear("customer_profile_company_email");
            }
        },
        setError(state, payload) {
            state.error = payload;
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
    },
    actions: {
        addForm({ commit, state }) {
            let url = `${process.env.MIX_WEB_API_URL}signup`;
            let config = {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            };
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .post(url, state.form, config)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            // helper.swalSuccessMessageForWeb(res.data.message);
                            resolve(res);
                        } else {
                            helper.swalErrorMessageForWeb(res.data.message);
                            reject(res);
                        }
                    })
                    .catch((error) => {
                        commit("setEmptyError");
                        if (error.response && error.response.status == 422) {
                            commit(
                                "setValidationErros",
                                error.response.data.errors
                            );
                        } else if (
                            error.response &&
                            error.response.data &&
                            error.response.data.status == "Error"
                        ) {
                            helper.swalErrorMessageForWeb(
                                error.response.data.message
                            );
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        checkCustomerEmail({ commit }, payload) {
            let url = `${process.env.MIX_WEB_API_URL}check-customer-email`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .post(url, payload)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setEmailErrorEmpty");
                        }
                    })
                    .catch((error) => {
                        commit("setEmailErrorEmpty");
                        if (error.response && error.response.status == 422) {
                            commit(
                                "setEmailError",
                                error?.response?.data?.errors
                            );
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        checkCustomerProfileEmail({ commit }, payload) {
            let url = `${process.env.MIX_WEB_API_URL}check-customer-profile-email`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .post(url, payload)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setCustomerProfileEmailErrorEmpty");
                        }
                    })
                    .catch((error) => {
                        commit("setCustomerProfileEmailErrorEmpty");
                        if (error.response && error.response.status == 422) {
                            commit(
                                "setCustomerProfileEmailError",
                                error.response.data.errors
                            );
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchRegistrationPackages({ commit }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}get-registration-packages`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setRegistrationPackages", res.data.data);
                            resolve(res);
                        }
                        reject(error);
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchRegPageSetting({ commit }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}get-reg-page-setting?findByPageId=${payload.id}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setRegPageSetting", res.data.data);
                            resolve(res);
                        }
                        reject(error);
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchBusinessCategories({ commit }) {
            let url = `${process.env.MIX_WEB_API_URL}get-business-categories`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setBusinessCategories", res.data.data);
                            resolve(res);
                        }
                        reject(error);
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchCustomerPaymentMethods({ commit }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}customer-payment-methods`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit(
                                "setCustomerPaymentMethods",
                                res.data.data.methods
                            );
                            commit(
                                "setPaymentSetting",
                                res.data.data.payment_setting
                            );
                            resolve(res);
                        }
                        reject(error);
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        updateSocialMedia({ commit, state }) {
            let url = `${process.env.MIX_WEB_API_URL}social-media`;
            let config = {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            };
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .post(url, state.form, config)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessageForWeb(res.data.message);
                            resolve(res);
                        } else {
                            helper.swalErrorMessageForWeb(res.data.message);
                            reject(res);
                        }
                    })
                    .catch((error) => {
                        commit("setEmptyError");
                        if (error.response && error.response.status == 422) {
                            commit(
                                "setValidationErros",
                                error.response.data.errors
                            );
                        } else if (
                            error.response &&
                            error.response.data &&
                            error.response.data.status == "Error"
                        ) {
                            helper.swalErrorMessageForWeb(
                                error.response.data.message
                            );
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        getSocialMedia({ commit, state }, payload) {
            let url = `${process.env.MIX_WEB_API_URL}show-social-media`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        updateUserProfile({ commit, state }) {
            let url = `${process.env.MIX_WEB_API_URL}user-profile`;
            let config = {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            };
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .post(url, state.form, config)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessageForWeb(res.data.message);
                            resolve(res);
                        } else {
                            helper.swalErrorMessageForWeb(res.data.message);
                            reject(res);
                        }
                    })
                    .catch((error) => {
                        commit("setEmptyError");
                        if (error.response && error.response.status == 422) {
                            commit(
                                "setValidationErros",
                                error.response.data.errors
                            );
                        } else if (
                            error.response &&
                            error.response.data &&
                            error.response.data.status == "Error"
                        ) {
                            helper.swalErrorMessageForWeb(
                                error.response.data.message
                            );
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        updateProfileSetting({ commit, state }) {
            let url = `${process.env.MIX_WEB_API_URL}update-profile-setting`;
            let config = {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            };
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .post(url, state.form, config)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessageForWeb(res.data.message).then(() => {
                                window.location.href = "/";
                                resolve(res);
                            });
                            resolve(res);
                        } else {
                            helper.swalErrorMessageForWeb(res.data.message);
                            reject(res);
                        }
                    })
                    .catch((error) => {
                        commit("setEmptyError");
                        if (error.response && error.response.status == 422) {
                            commit(
                                "setValidationErros",
                                error.response.data.errors
                            );
                        } else if (
                            error.response &&
                            error.response.data &&
                            error.response.data.status == "Error"
                        ) {
                            helper.swalErrorMessageForWeb(
                                error.response.data.message
                            );
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        cancelSubscription({ commit, state }) {
            let url = `${process.env.MIX_WEB_API_URL}cancel-subscription`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .post(url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessageForWeb(res.data.message);
                            resolve(res);
                        } else {
                            helper.swalErrorMessageForWeb(res.data.message);
                            reject(res);
                        }
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        resumeSubscription({ commit, state }) {
            let url = `${process.env.MIX_WEB_API_URL}resume-subscription`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .post(url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessageForWeb(res.data.message);
                            resolve(res);
                        } else {
                            helper.swalErrorMessageForWeb(res.data.message);
                            reject(res);
                        }
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        upgradePackage({ commit, state }, payload) {
            let url = `${process.env.MIX_WEB_API_URL}upgrade-package`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .post(url, payload)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessageForWeb(res.data.message);
                            resolve(res);
                        } else {
                            helper.swalErrorMessageForWeb(res.data.message);
                            reject(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        getUserProfile({ commit }) {
            let url = `${process.env.MIX_WEB_API_URL}show-user-profile`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        updateBussinessProfile({ commit, state }) {
            let url = `${process.env.MIX_WEB_API_URL}bussiness-profile`;
            let config = {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            };
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .post(url, state.form, config)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessageForWeb(res.data.message);
                            resolve(res);
                        } else {
                            helper.swalErrorMessageForWeb(res.data.message);
                            reject(res);
                        }
                    })
                    .catch((error) => {
                        commit("setEmptyError");
                        if (error.response && error.response.status == 422) {
                            commit(
                                "setValidationErros",
                                error.response.data.errors
                            );
                        } else if (
                            error.response &&
                            error.response.data &&
                            error.response.data.status == "Error"
                        ) {
                            helper.swalErrorMessageForWeb(
                                error.response.data.message
                            );
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        updateMediaSetting({ commit, state }) {
            let url = `${process.env.MIX_WEB_API_URL}media-setting`;
            let config = {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            };
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .post(url, state.form, config)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessageForWeb(res.data.message);
                            resolve(res);
                        } else {
                            helper.swalErrorMessageForWeb(res.data.message);
                            reject(res);
                        }
                    })
                    .catch((error) => {
                        commit("setEmptyError");
                        if (error.response && error.response.status == 422) {
                            commit(
                                "setValidationErros",
                                error.response.data.errors
                            );
                        } else if (
                            error.response &&
                            error.response.data &&
                            error.response.data.status == "Error"
                        ) {
                            helper.swalErrorMessageForWeb(
                                error.response.data.message
                            );
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        getBussinessProfile({ commit, state }, payload) {
            let url = `${process.env.MIX_WEB_API_URL}show-bussiness-profile`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchStaticSetting({ commit }, payload) {
            let url = payload.url;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            resolve(res);
                        }
                        reject(error);
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
    },
};

export default signup;
