import ErrorHandling from "../../ErrorHandling";

const general_setting = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: [],
        general_setting: null,
        loading: false,
        param: "withFlagIcon=1",
    },
    mutations: {
        setGeneralSetting(state, payload) {
            state.general_setting = payload;
            state.general_setting.map(res => {
                state.form.push({
                    'key': res.key,
                    'value': res.value,
                })
            })
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        resetForm(state) {
            state.validationErros = new ErrorHandling();
            state.error = null;
        },
        updateForm(state, payload) {
            state.form.map(res => {
                if(res.key == payload.key){
                    res.value = payload.value;
                    return true;
                }
            })
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
    },
    actions: {
        addUpdateForm({ commit, state }) {
            let method = "post";
            let url = `${process.env.MIX_ADMIN_API_URL}general-setting`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios[method](url, state.form)
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
        fetchGeneralSetting({ commit, state }, payload) {
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}general-setting?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setGeneralSetting", res.data.data);
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

export default general_setting;
