import ErrorHandling from "../../ErrorHandling";

const errors = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        languageErrors: null,
        loading: false,
    },
    mutations: {
        setLanguageErrors(state, payload) {
            state.languageErrors = payload;
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
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
        addUpdateForm({ commit, state }, payload) {
            let url = `${process.env.MIX_ADMIN_API_URL}errors`
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.post(url, payload)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
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
        fetchLanguageErrors({ commit, state }, payload) {
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}errors?q=1`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setLanguageErrors", res.data.data);
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

export default errors;
