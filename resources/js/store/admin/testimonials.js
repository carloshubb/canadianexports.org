import ErrorHandling from "../../ErrorHandling";

const testimonials = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            // business_category_id: null,
            business_categories: [],
            name: {},
            place: {},
            comment: {},
            email: {},
        },
        testimonials: null,
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
        setName(state, payload){
            state.form.name = payload;
        },
        updateName(state, payload){
            state.form.name[`name_${payload.id}`] = payload.name;
        },
        setPlace(state, payload){
            state.form.place = payload;
        },
        updatePlace(state, payload){
            state.form.place[`place_${payload.id}`] = payload.place;
        },
        setComment(state, payload){
            state.form.comment = payload;
        },
        updateComment(state, payload){
            state.form.comment[`comment_${payload.id}`] = payload.comment;
        },
        setEmail(state, payload){
            state.form.email = payload;
        },
        updateEmail(state, payload){
            state.form.email[`email_${payload.id}`] = payload.email;
        },
        updateForm(state, payload){
            state.form[payload.fieldName] = payload.value;
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setTestimonials(state, payload) {
            state.testimonials = payload;
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
                name: {},
                place: {},
                comment: {},
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
        updateTestimonialStatus(state, { id, status }) {
            const testimonial = state.testimonials.find((t) => t.id === id);
            if (testimonial) testimonial.status = status;
          },
    },
    actions: {
        async updateTestimonialStatus({ commit }, payload) {
            commit("updateTestimonialStatus", payload);
          },
        addUpdateForm({ commit, state }) {
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_ADMIN_API_URL}testimonials/${state.form.id}`
                : `${process.env.MIX_ADMIN_API_URL}testimonials`;
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
        fetchTestimonials({ commit, state }, payload) {
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}testimonials?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setTestimonials", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchTestimonial({ commit, state }, payload) {
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}testimonials/${payload.id}?q=1`;
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
        deleteTestimonial({ commit }, payload) {
            commit("setLoading");
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}testimonials/${payload.id}`;
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

export default testimonials;
