import ErrorHandling from "../../ErrorHandling";

const events = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            page_id: null,
            zipcode: null,
            featured: false,
            media_id: [],
            gallery_images: [],
            start_date: null,
            end_date: null,
            event_website: null,
            exibitors_url: null,
            visitors_url: null,
            press_url: null,
            video_url: null,
            facebook_url: null,
            twitter_url: null,
            linkedin_url: null,
            youtube_url: null,
            pintrest_url: null,
            instagram_url: null,
            snapchat_url: null,
            registration_package_id: null,
            order_amount: 0,
            payment_method: "stripe",
            customer_payment_method_id: null,
            card_holder_name: null,
            card_no: null,
            expiry_month: ("0" + (new Date().getMonth() + 1)).slice(-2),
            expiry_year: new Date().getFullYear(),
            cvc: null,
            is_agree: false,
            title: {},
            country: {},
            city: {},
            street_name: {},
            venue: {},
            product_search: {},
            short_description: {},
            description: {},
        },
        events: null,
        loading: false,
        sortBy: "id",
        sortType: "desc",
        searchParam: null,
        pagination: {},
        limit: 10,
        param: "withMedia=1",
        isFormEdit: false,
    },
    mutations: {
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setEvents(state, payload) {
            state.events = payload;
        },
        setEvent(state, payload) {
            state.form[payload.key] = payload.value;
        },
        updateEvent(state, payload) {
            state.form[payload.key][`${payload.key}_${payload.id}`] =
                payload.value;
        },
        setPagination(state, pagination) {
            if (pagination.meta) {
                state.pagination = {
                    current_page: pagination.meta.current_page,
                    last_page: pagination.meta.last_page,
                    next_page_url: pagination.links
                        ? pagination.links.next
                        : null,
                    prev_page_url: pagination.links
                        ? pagination.links.prev
                        : null,
                };
            }
        },
        setSearchParam(state, payload) {
            state.searchParam = payload;
            state.param = helper.updateUrlParameter(
                state.param,
                "searchParam",
                payload
            );
        },
        setLimit(state, payload) {
            state.limit = payload;
            state.param = helper.updateUrlParameter(
                state.param,
                "limit",
                payload
            );
        },
        setSortBy(state, payload) {
            state.sortBy = payload;
            state.param = helper.updateUrlParameter(
                state.param,
                "sortBy",
                payload
            );
        },
        setSortType(state, payload) {
            state.sortType = payload;
            state.param = helper.updateUrlParameter(
                state.param,
                "sortType",
                payload
            );
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        resetForm(state) {
            state.form = {
                id: null,
                page_id: null,
                featured: false,
                zipcode: null,
                media_id: [],
                gallery_images: [],
                start_date: null,
                end_date: null,
                event_website: null,
                exibitors_url: null,
                visitors_url: null,
                press_url: null,
                video_url: null,
                facebook_url: null,
                twitter_url: null,
                linkedin_url: null,
                youtube_url: null,
                pintrest_url: null,
                instagram_url: null,
                snapchat_url: null,
                registration_package_id: null,
                order_amount: 0,
                payment_method: "stripe",
                customer_payment_method_id: null,
                card_holder_name: null,
                card_no: null,
                expiry_month: null,
                expiry_year: null,
                cvc: null,
                title: {},
                country: {},
                city: {},
                street_name: {},
                venue: {},
                product_search: {},
                short_description: {},
                description: {},
                contacts: [],
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
            state.isFormEdit = false;
        },
        setContact(state, payload) {
            state.form.contacts = payload;
        },
        setForm(state, payload) {
            Object.assign(state.form, payload);
        },
        setValidationErros(state, payload) {
            state.validationErros.record(payload);
        },
        setEmptyError(state) {
            state.validationErros = new ErrorHandling();
        },
        setError(state, payload) {
            state.error = payload;
        },
        setGalleryImages(state, payload) {
            if (payload.type == "add") {
                if (state.form.gallery_images.length == 0) {
                    state.form.gallery_images = JSON.stringify([payload.value]);
                } else {
                    let gallery_images = JSON.parse(state.form.gallery_images);
                    gallery_images.push(payload.value);
                    state.form.gallery_images = JSON.stringify(gallery_images);
                }
            } else {
                let gallery_images = JSON.parse(state.form.gallery_images);
                const index = gallery_images.indexOf(payload.value);
                if (index > -1) {
                    gallery_images.splice(index, 1);
                    state.form.gallery_images = JSON.stringify(gallery_images);
                }
            }
        },
        resetGalleryImages(state, payload) {
            state.form.gallery_images = [];
        },
        recordValidationError(state, payload) {
            let fieldName = { [payload.field]: [payload.error] };
            state.validationErros.record(fieldName);
        },
        // clearValidationError(state, payload) {
        //     state.validationErros.clear(payload.field);
        // },
        clearValidationError(state, fieldName) {
            const errors = { ...state.validationErros.errors }; // Create a shallow copy of the errors
            delete errors[fieldName];  // Remove the error for the specified field
            state.validationErros.errors = errors;  // Assign the new errors object to the state
        },
        setSponsers(state, payload) {
            state.sponsers = payload;
        },
        setSponser(state, payload) {
            state.form[payload.key] = payload.value;
        },
        updateSponser(state, payload) {
            state.form[payload.key][`${payload.key}_${payload.id}`] =
                payload.value;
        },

    },
    actions: {
        addUpdateForm({ commit, state }, payload) {
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_ADMIN_API_URL}events/${state.form.id}`
                : `${process.env.MIX_ADMIN_API_URL}events`;
            if (payload && payload.type && payload.type == "web") {
                url = state.isFormEdit
                    ? `${process.env.MIX_APP_URL}/events/${state.form.id}`
                    : `${process.env.MIX_APP_URL}/events`;
            }
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios[method](url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            commit("resetForm");
                            resolve(res);
                        } else {
                            helper.swalErrorMessage(res.data.message);
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
                            helper.swalErrorMessage(
                                error.response.data.message
                            );
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchEvents({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}events?q=1`;
            if (payload && payload.type && payload.type == "web") {
                url =
                    payload && payload.url
                        ? payload.url
                        : `${process.env.MIX_APP_URL}/events?q=1`;
            }
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setEvents", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchEvent({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}events/${payload.id}?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setForm", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        deleteEvent({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}events/${payload.id}`;
            return axios
            .delete(url, {
                data: { password: payload.password },
            })
                    .then((res) => {
                        if (res.data.status == "Success") {
                            return res;
                        } else if (res.data.status == "Error") {
                            return res;
                        }
                    })
                    .catch(error => {
                        throw error;
                    })
                    .finally(() => commit("setLoading"));
        },
        fetchEventListingSetting({ commit }, payload) {
            let url = `${process.env.MIX_WEB_API_URL}event-listing-setting?q=1&findByPageId=${payload.page_id}&withEventListingSettingDetail=1`;
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
        addUpdateFormSponser({ commit, state }, payload) {
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_ADMIN_API_URL}sponsers/${state.form.id}`
                : `${process.env.MIX_ADMIN_API_URL}sponsers`;
            if (payload && payload.type && payload.type == "web") {
                url = state.isFormEdit
                    ? `${process.env.MIX_APP_URL}/sponsers/${state.form.id}`
                    : `${process.env.MIX_APP_URL}/sponsers`;
            }
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios[method](url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            commit("resetForm");
                            resolve(res);
                        } else {
                            helper.swalErrorMessage(res.data.message);
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
                            helper.swalErrorMessage(
                                error.response.data.message
                            );
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchSponsers({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}sponsers?q=1`;
            if (payload && payload.type && payload.type == "web") {
                url =
                    payload && payload.url
                        ? payload.url
                        : `${process.env.MIX_APP_URL}/sponsers?q=1`;
            }
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        console.log('res',res);
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setSponsers", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchSponser({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}sponsers/${payload.id}?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setForm", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        deleteSponser({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}sponsers/${payload.id}`;
            return axios
            .delete(url, {
                data: { password: payload.password },
            })
                    .then((res) => {
                        if (res.data.status == "Success") {
                            return res;
                        } else if (res.data.status == "Error") {
                            return res;
                        }
                    })
                    .catch(error => {
                        throw error;
                    })
                    .finally(() => commit("setLoading"));
        },
        fetchSponserListingSetting({ commit }, payload) {
            let url = `${process.env.MIX_WEB_API_URL}sponser-listing-setting?q=1&findByPageId=${payload.page_id}&withSponserListingSettingDetail=1`;
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
    },
};

export default events;
