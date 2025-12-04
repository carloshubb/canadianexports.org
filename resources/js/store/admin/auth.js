import ErrorHandling from "../../ErrorHandling";

const auth = {
    namespaced: true,
    state: {
        loggedInUser: null,
        form:{
            name:null,
            email:null,
            current_password:null,
            new_password:null,
            new_password_confirmation:null,
        },
        validationErros: new ErrorHandling(),
        loading: false,
    },
    mutations: {
        setLoggedInUser(state, payload) {
            state.loggedInUser = payload;
            state.form.name = payload?.name
            state.form.email = payload?.email
        },
        resetForm(state) {
            state.form = {
                current_password:null,
                new_password:null,
                new_password_confirmation:null,
            };
            state.validationErros = new ErrorHandling();
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
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
    },
    actions: {
        fetchCurrentUser({ commit }) {
            axios.get(`${process.env.MIX_ADMIN_API_URL}user`).then((res) => {
                if (res.data.status == "Success") {
                    commit("setLoggedInUser", res.data.data);
                }
            });
        },
        updateUserProfile({ commit, state }) {
            commit("setLoading")
            return new Promise(function (resolve, reject) {
                axios.post(`${process.env.MIX_ADMIN_API_URL}update-profile`, state.form).then((res) => {
                    if (res.data.status == "Success") {
                        helper.swalSuccessMessage(res.data.message);
                        commit("resetForm");
                        commit("setLoggedInUser", res.data.data);
                        resolve(res);
                    }
                    else{
                        helper.swalErrorMessage(res.data.message);
                    }
                    reject(res);
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
    },
};

export default auth;
