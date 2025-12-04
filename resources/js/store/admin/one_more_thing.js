import ErrorHandling from "../../ErrorHandling";

const one_more_thing = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            url: null,
            media_id: null,
            description: {},
        },
        one_more_thing: null,
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
        setOneMoreThings(state, payload) {
            state.one_more_thing = payload;
        },
        setOneMoreThing(state, payload) {
            state.form[payload.key] = payload.value;
        },
        updateOneMoreThing(state, payload) {
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
                url: null,
                media_id: null,
                description: {},
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
            let fieldName = {[payload.field]: [payload.error]};
            state.validationErros.record(fieldName)
        },
        clearValidationError(state, payload) {
            state.validationErros.clear(payload.field)
        },
    },
    actions: {
        addUpdateForm({ commit, state }, payload) {
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_ADMIN_API_URL}one-more-thing/${state.form.id}`
                : `${process.env.MIX_ADMIN_API_URL}one-more-thing`;
            if (payload && payload.type && payload.type == "web") {
                url = state.isFormEdit
                    ? `${process.env.MIX_APP_URL}/one-more-thing/${state.form.id}`
                    : `${process.env.MIX_APP_URL}/one-more-thing`;
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
        fetchOneMoreThings({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}one-more-thing?q=1`;
            if (payload && payload.type && payload.type == "web") {
                url =
                    payload && payload.url
                        ? payload.url
                        : `${process.env.MIX_APP_URL}/one-more-thing?q=1`;
            }
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setOneMoreThings", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchOneMoreThing({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}one-more-thing/${payload.id}?q=1`;
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
        deleteOneMoreThing({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}one-more-thing/${payload.id}`;
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

export default one_more_thing;
