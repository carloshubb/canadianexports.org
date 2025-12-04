import ErrorHandling from "../../ErrorHandling";

const email_setting = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            no_of_emails: {},
            canadian_exporters_emails: {},
        },
        loading: false,
    },
    mutations: {
        setCanadianExportersEmails(state, payload){
            state.form.canadian_exporters_emails = payload;
        },
        updateCanadianExportersEmails(state, payload){
            state.form.canadian_exporters_emails[`canadian_exporters_emails_${payload.id}`] = payload.canadian_exporters_emails;
        },
        setNoOfEmails(state, payload){
            state.form.no_of_emails = payload;
        },
        updateNoOfEmails(state, payload){
            state.form.no_of_emails[`no_of_emails_${payload.id}`] = payload.no_of_emails;
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        resetForm(state) {
            state.form = {
                no_of_emails: {},
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
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
            let url = `${process.env.MIX_ADMIN_API_URL}email-setting`;
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
        fetchEmailSetting({ commit, state }, payload) {
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}email-setting`;
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
    },
};

export default email_setting;
