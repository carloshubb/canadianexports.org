import ErrorHandling from "../../ErrorHandling";

const coffee_wall_faqs = {
    namespaced: true,
    state: {
        faqs: [],
        form: { 
            id: null, 
            type: 'donor',
            question: "", 
            answer: "",
            sort_order: 0,
            is_active: true
        },
        loading: false,
        validationErros: new ErrorHandling(),
        isFormEdit: false,
        error: null,
        filterType: 'all', // 'all', 'donor', 'beneficiary'
    },
    getters: {
        filteredFaqs: (state) => {
            if (state.filterType === 'all') {
                return state.faqs;
            }
            return state.faqs.filter(faq => faq.type === state.filterType);
        }
    },
    mutations: {
        setFaqs(state, payload) {
            state.faqs = payload;
        },
        setForm(state, payload) {
            Object.assign(state.form, payload);
        },
        resetForm(state) {
            state.form = { 
                id: null, 
                type: 'donor',
                question: "", 
                answer: "",
                sort_order: 0,
                is_active: true
            };
            state.validationErros = new ErrorHandling();
            state.isFormEdit = false;
            state.error = null;
        },
        setLoading(state, payload) {
            state.loading = payload !== undefined ? payload : !state.loading;
        },
        setValidationErros(state, payload) {
            state.validationErros.record(payload);
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setError(state, payload) {
            state.error = payload;
        },
        setFilterType(state, payload) {
            state.filterType = payload;
        },
    },
    actions: {
        fetchFaqs({ commit, state }) {
            commit("setLoading", true);
            let url = `/api/admin/coffee-wall-faqs`;
            if (state.filterType !== 'all') {
                url += `?type=${state.filterType}`;
            }
            return axios.get(url)
                .then(res => {
                    if (res.data.status === "Success") {
                        commit("setFaqs", res.data.data);
                    }
                })
                .catch(error => {
                    commit("setError", error);
                })
                .finally(() => commit("setLoading", false));
        },
        addUpdateForm({ commit, state }) {
            commit("setLoading", true);
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `/api/admin/coffee-wall-faqs/${state.form.id}`
                : `/api/admin/coffee-wall-faqs`;
            return axios[method](url, state.form)
                .then(res => {
                    if (res.data.status === "Success") {
                        commit("resetForm");
                        return res;
                    } else {
                        commit("setValidationErros", res.data.errors);
                        throw new Error(res.data.message);
                    }
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        commit("setValidationErros", error.response.data.errors);
                    } else {
                        commit("setError", error);
                    }
                    throw error;
                })
                .finally(() => commit("setLoading", false));
        },
        deleteFaq({ commit }, id) {
            commit("setLoading", true);
            return axios.delete(`/api/admin/coffee-wall-faqs/${id}`)
                .then(res => {
                    // Optionally handle success
                    return res;
                })
                .catch(error => {
                    commit("setError", error);
                    throw error;
                })
                .finally(() => commit("setLoading", false));
        },
        fetchFaq({ commit }, id) {
            commit("setLoading", true);
            return axios.get(`/api/admin/coffee-wall-faqs/${id}`)
                .then(res => {
                    if (res.data.status === "Success") {
                        commit("setForm", res.data.data);
                        commit("setIsFormEdit", true);
                    }
                })
                .catch(error => {
                    commit("setError", error);
                })
                .finally(() => commit("setLoading", false));
        },
    },
};

export default coffee_wall_faqs;

