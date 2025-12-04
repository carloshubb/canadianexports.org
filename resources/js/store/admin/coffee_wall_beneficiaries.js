import ErrorHandling from "../../ErrorHandling";

const coffee_wall_beneficiaries = {
    namespaced: true,
    state: {
        beneficiaries: [],
        form: { id: null, name: "" },
        loading: false,
        validationErros: new ErrorHandling(),
        isFormEdit: false,
        error: null,
    },
    mutations: {
        setBeneficiaries(state, payload) {
            state.beneficiaries = payload;
        },
        setForm(state, payload) {
            Object.assign(state.form, payload);
        },
        resetForm(state) {
            state.form = { id: null, name: "" };
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
    },
    actions: {
        fetchBeneficiaries({ commit }) {
            commit("setLoading", true);
            return axios.get(`/api/admin/coffee-wall-beneficiaries`)
                .then(res => {
                    if (res.data.status === "Success") {
                        commit("setBeneficiaries", res.data.data);
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
                ? `/api/admin/coffee-wall-beneficiaries/${state.form.id}`
                : `/api/admin/coffee-wall-beneficiaries`;
            return axios[method](url, state.form)
                .then(res => {
                    if (res.data.status === "Success") {
                        commit("resetForm");
                    } else {
                        commit("setValidationErros", res.data.errors);
                    }
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        commit("setValidationErros", error.response.data.errors);
                    } else {
                        commit("setError", error);
                    }
                })
                .finally(() => commit("setLoading", false));
        },
        deleteBeneficiary({ commit }, id) {
            commit("setLoading", true);
            return axios.delete(`/api/admin/coffee-wall-beneficiaries/${id}`)
                .then(res => {
                    // Optionally handle success
                })
                .catch(error => {
                    commit("setError", error);
                })
                .finally(() => commit("setLoading", false));
        },
        fetchBeneficiary({ commit }, id) {
            commit("setLoading", true);
            return axios.get(`/api/admin/coffee-wall-beneficiaries/${id}`)
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

export default coffee_wall_beneficiaries;
