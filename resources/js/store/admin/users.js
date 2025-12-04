import ErrorHandling from "../../ErrorHandling";

const users = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            name: null,
            email: null,
            password: null,
            password_confirmation: null,
            payment_frequency: null,
        },
        users: null,
        user: null,
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
        changeUserStatus(state, payload) {
            state.users.map(res => {
                if(res.id == payload.user_id){
                    res.is_active = payload.status;
                }
            })
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setUsers(state, payload) {
            state.users = payload;
        },
        setUser(state, payload) {
            state.user = payload;
        },
        setPagination(state, pagination) {
            if (pagination.meta) {
                state.pagination = {
                    current_page: pagination.meta.current_page || state.pagination.current_page || 1,
                    last_page: pagination.meta.last_page || state.pagination.last_page || 1,
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
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
                payment_frequency: null,
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
            state.isFormEdit = false;
        },
        updateForm(state, payload) {
            Object.assign(state.form, payload);
        },
        setForm(state, payload) {
            state.form.id = payload.id
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
        setCurrentPage(state, page) {
            if (!state.pagination) state.pagination = {};
            state.pagination.current_page = page;
        },
    },
    actions: {
        addUpdateForm({ commit, state }) {
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_ADMIN_API_URL}users/${state.form.id}`
                : `${process.env.MIX_ADMIN_API_URL}users`;
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
        fetchUsers({ commit, state }, payload) {
            let page = 1;
            if (payload && typeof payload.page === 'number') {
                page = payload.page;
            } else if (payload && payload.page) {
                page = parseInt(payload.page);
            }
            let url = `${process.env.MIX_ADMIN_API_URL}users?page=${page}`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setUsers", res.data.data);
                            commit('setCurrentPage', page); // Set current_page only after success
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchUser({ commit, state }, payload) {
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}users/${payload.id}?q=1`;
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
        deleteUser({ commit }, payload) {
            commit("setLoading");
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}users/${payload.id}`;
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
        updateActivationStatus({ commit }, payload) {
            commit("setLoading");
            let url = `${process.env.MIX_ADMIN_API_URL}update-activation-status`;
            return new Promise(function (resolve, reject) {
                axios.post(url, payload)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            commit('changeUserStatus', payload);
                            resolve(res);
                        } else if (res.data.status == "Error") {
                            helper.swalErrorMessage(res.data.message);
                            resolve(res);
                        }
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchUsersWithNoProfile({ commit }) {
            commit("setLoading");
            let url = `${process.env.MIX_ADMIN_API_URL}users-with-no-profile`;
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            resolve(res);
                        } else if (res.data.status == "Error") {
                            resolve(res);
                        }
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        sendWelcomeEmail({ commit }, payload) {
            commit("setLoading");
            let url = `${process.env.MIX_ADMIN_API_URL}send-welcome-email`;
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
    },
};

export default users;
