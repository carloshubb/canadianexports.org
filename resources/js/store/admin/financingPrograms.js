import ErrorHandling from "../../ErrorHandling";

const financingPrograms = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            // business_category_id: null,
            business_categories: [],
            name_title: {},
            business_name: {},
            zipcode: {},
            needs_intentions: {},
            company_ownership: {},
            revenue_last_year: {},
            incorporation: {},
            full_time_employees: {},
            email: {},
        },
        financingPrograms: null,
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
        setNameTitle(state, payload){
            state.form.name_title = payload;
        },
        updateNameTitle(state, payload){
            state.form.name_title[`name_title_${payload.id}`] = payload.name_title;
        },
        setBusinessName(state, payload){
            state.form.business_name = payload;
        },
        updateBusinessName(state, payload){
            state.form.business_name[`business_name_${payload.id}`] = payload.business_name;
        },
        setZipcode(state, payload){
            state.form.zipcode = payload;
        },
        updateZipcode(state, payload){
            state.form.zipcode[`zipcode_${payload.id}`] = payload.zipcode;
        },
        setRevenueLastYear(state, payload){
            state.form.revenue_last_year = payload;
        },
        updateRevenueLastYear(state, payload){
            state.form.revenue_last_year[`revenue_last_year_${payload.id}`] = payload.revenue_last_year;
        },
        setEmail(state, payload){
            state.form.email = payload;
        },
        updateEmail(state, payload){
            state.form.email[`email_${payload.id}`] = payload.email;
        },
        setIncorporation(state, payload){
            state.form.incorporation = payload;
        },
        updateIncorporation(state, payload){
            state.form.incorporation[`incorporation_${payload.id}`] = payload.incorporation;
        },
        setFullTimeEmployees(state, payload){
            state.form.full_time_employees = payload;
        },
        updateFullTimeEmployees(state, payload){
            state.form.full_time_employees[`full_time_employees_${payload.id}`] = payload.full_time_employees;
        },
        setNeedsIntentions(state, payload){
            state.form.needs_intentions = payload;
        },
        updateNeedsIntentions(state, payload){
            state.form.needs_intentions[`needs_intentions_${payload.id}`] = payload.needs_intentions;
        },
        setCompanyOwnership(state, payload){
            state.form.company_ownership = payload;
        },
        updateCompanyOwnership(state, payload){
            state.form.company_ownership[`company_ownership_${payload.id}`] = payload.company_ownership;
        },

        updateForm(state, payload){
            state.form[payload.fieldName] = payload.value;
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setFinancingPrograms(state, payload) {
            state.financingPrograms = payload;
        },
        setPagination(state, pagination) {
            if (pagination && pagination.meta) {
                state.pagination = {
                    current_page: pagination.meta.current_page,
                    last_page: pagination.meta.last_page,
                    next_page_url: pagination.links ? pagination.links.next : null,
                    prev_page_url: pagination.links ? pagination.links.prev : null,
                };
            } else {
                state.pagination = {
                    current_page: 1,
                    last_page: 1,
                    next_page_url: null,
                    prev_page_url: null,
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
                // business_category_id: null,
                business_categories: [],
                name_title: {},
                business_name: {},
                zipcode: {},
                needs_intentions: {},
                company_ownership: {},
                revenue_last_year: {},
                incorporation: {},
                full_time_employees: {},
                email: {},
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
            state.isFormEdit = false;
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
        sendEmailToUsers({ commit }) {
            return new Promise((resolve, reject) => {
                axios
                    .post(`${process.env.MIX_ADMIN_API_URL}financingPrograms/send-email`)
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        addUpdateForm({ commit, state }) {
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_ADMIN_API_URL}financingPrograms/${state.form.id}`
                : `${process.env.MIX_ADMIN_API_URL}financingPrograms`;
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
        fetchFinancingPrograms({ commit, state }, payload) {
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}financingPrograms?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data.data.business_category_detail);
                            commit("setFinancingPrograms", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchFinancingProgram({ commit, state }, payload) {
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}financingPrograms/${payload.id}?q=1`;
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
        deleteFinancingProgram({ commit }, payload) {
            commit("setLoading");
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}financingPrograms/${payload.id}`;
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

export default financingPrograms;
