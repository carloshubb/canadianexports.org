import ErrorHandling from "../../ErrorHandling";
let formData = new FormData();
formData.append('video', '')
formData.append('company_name', '')
formData.append('add_new_user', false)
const business_profiles = {
    namespaced: true,
    state: {
        form: formData,
        validationErros: new ErrorHandling(),
        error: null,
        business_profiles: null,
        loading: false,
        sortBy: "id",
        sortType: "desc",
        searchParam: null,
        pagination: {},
        limit: 10,
        param: "withFlagIcon=1",
        isFormEdit: false,
    },
    mutations: {
        resetForm(state) {
            formData = new FormData();
            formData.append('video', '')
            formData.append('company_name', '')
            formData.append('add_new_user', false)
            state.form = formData;
            state.validationErros = new ErrorHandling();
            state.error = null;
            state.isFormEdit = false;
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
        setSortBy(state, payload) {
            state.sortBy = payload;
            state.param = helper.updateUrlParameter(state.param, "sortBy", payload);
        },
        setSortType(state, payload) {
            state.sortType = payload;
            state.param = helper.updateUrlParameter(state.param, "sortType", payload);
        },
        setSearchParam(state, payload) {
            state.searchParam = payload;
            state.param = helper.updateUrlParameter(state.param, "searchParam", payload);
        },
        setLimit(state, payload) {
            state.limit = payload;
            state.param = helper.updateUrlParameter(state.param, "limit", payload);
        },
        setBusinessProfiles(state, payload) {
            state.business_profiles = payload;
        },
        setForm(state, payload) {
            state.form.set(payload.field, payload.value);
        },
        setBusinessCategoriesForm(state, payload) {
            if(payload.type == 'add'){
                if(!state.form.get('business_categories_id')){
                    state.form.set('business_categories_id', JSON.stringify([payload.value]));
                }
                else{
                    let business_categories_id = JSON.parse(state.form.get('business_categories_id'));
                    business_categories_id.push(payload.value);
                    state.form.set('business_categories_id', JSON.stringify(business_categories_id));
                }
            }
            else{
                let business_categories_id = JSON.parse(state.form.get('business_categories_id'));
                const index = business_categories_id.indexOf(payload.value);
                if (index > -1) {
                    business_categories_id.splice(index, 1);
                    state.form.set('business_categories_id', JSON.stringify(business_categories_id));
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
            if(state.validationErros.has('email')){
                state.validationErros.clear('email');
            }
        },
        setError(state, payload) {
            state.error = payload;
        },
        resetGalleryImages(state, payload) {
            state.form.set("gallery_images", []);
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
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
    },
    actions:{
        addUpdateForm({ commit, state }) {
            let method = state.isFormEdit ? "post" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_ADMIN_API_URL}business-profiles/${state.form.get('id')}`
                : `${process.env.MIX_ADMIN_API_URL}business-profiles`;
            let config = {
                headers : {
                    'Content-Type': 'multipart/form-data'
                }
            }
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios[method](url, state.form, config)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            resolve(res);
                        } else {
                            helper.swalErrorMessage(res.data.message);
                            reject(res);
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
        checkCustomerEmail({ commit }, payload) {
            let url = `${process.env.MIX_WEB_API_URL}check-customer-email`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.post(url, payload)
                    .then((res) => {
                        if(res.data.status == 'Success'){
                            commit("setEmailErrorEmpty");
                        }
                    })
                    .catch((error) => {
                        commit("setEmailErrorEmpty");
                        if (error.response && error.response.status == 422) {
                            commit("setValidationErros", error.response.data.errors);
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchBusinessProfiles({ commit, state }, payload) {
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}business-profiles?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setBusinessProfiles", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchBusinessProfile({ commit, state }, payload) {
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}business-profiles/${payload.id}?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
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
        deleteBusinessProfile({ commit }, payload) {
            commit("setLoading");
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}business-profiles/${payload.id}`;
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
        sendWelcomeEmail({ commit }, payload) {
            commit("setLoading");
            let url = `${process.env.MIX_ADMIN_API_URL}send-welcome`;
            return new Promise(function (resolve, reject) {
                axios.post(url, payload)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            resolve(res);
                        } else if (res.data.status == "Error") {
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
    }
};

export default business_profiles;
