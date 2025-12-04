import ErrorHandling from "../../ErrorHandling";

const footer_settings = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            fb_link: null,
            twitter_link: null,
            google_link: null,
            youtube_link: null,
            linkedin_link: null,
            widget1_menu_id: null,
            widget2_menu_id: null,
            widget3_menu_id: null,
            is_active: false,
            widget1: {},
            widget2: {},
            widget3: {},
            copyright_text: {},
        },
        footer_settings: null,
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
        setFooterSettings(state, payload) {
            state.footer_settings = payload;
        },
        setFooterSetting(state, payload) {
            state.form[payload.key] = payload.value;
        },
        updateFooterSetting(state, payload) {
            state.form[payload.key][`${payload.key}_${payload.id}`] = payload.value;
        },
        setPagination(state, pagination) {
            if (pagination.meta) {
                state.pagination = {
                    current_page: pagination.meta.current_page,
                    last_page: pagination.meta.last_page,
                    next_page_url: pagination.links ? pagination.links.next : null,
                    prev_page_url: pagination.links ? pagination.links.prev : null,
                };
            }
        },
        setSearchParam(state, payload) {
            state.searchParam = payload;
            state.param = helper.updateUrlParameter(state.param, "searchParam", payload);
        },
        setLimit(state, payload) {
            state.limit = payload;
            state.param = helper.updateUrlParameter(state.param, "limit", payload);
        },
        setSortBy(state, payload) {
            state.sortBy = payload;
            state.param = helper.updateUrlParameter(state.param, "sortBy", payload);
        },
        setSortType(state, payload) {
            state.sortType = payload;
            state.param = helper.updateUrlParameter(state.param, "sortType", payload);
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        resetForm(state) {
            state.form = {
                id: null,
                fb_link: null,
                twitter_link: null,
                google_link: null,
                youtube_link: null,
                linkedin_link: null,
                widget1_menu_id: null,
                widget2_menu_id: null,
                widget3_menu_id: null,
                is_active: false,
                widget1: {},
                widget2: {},
                widget3: {},
                copyright_text: {},
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
            state.isFormEdit = false;
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
    },
    actions: {
        addUpdateForm({ commit, state }) {
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_ADMIN_API_URL}footer-setting/${state.form.id}`
                : `${process.env.MIX_ADMIN_API_URL}footer-setting`;
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
                            commit("setValidationErros", error.response.data.errors);
                        } else if (
                            error.response &&
                            error.response.data &&
                            error.response.data.status == "Error"
                        ) {
                            helper.swalErrorMessage(error.response.data.message);
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchFooterSettings({ commit, state }, payload) {
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}footer-setting?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setFooterSettings", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchFooterSetting({ commit, state }, payload) {
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}footer-setting/${payload.id}?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
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
        deleteFooterSetting({ commit }, payload) {
            commit("setLoading");
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}footer-setting/${payload.id}`;
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
    },
};

export default footer_settings;
