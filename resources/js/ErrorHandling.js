export default class ErrorHandling {
    constructor() {
        this.errors = {};
    }

    has(field) {
        if (this.errors.hasOwnProperty(field)) {
            return true;
        }

        return Object.keys(this.errors).some((key) =>
            key.startsWith(`${field}.`)
        );
    }

    any() {
        return Object.keys(this.errors).length > 0;
    }

    get(field) {
        if (this.errors[field]) {
            // Return errors as a string with line breaks
            return this.errors[field].join('<br/>');
        }

        const nestedMessages = Object.keys(this.errors)
            .filter((key) => key.startsWith(`${field}.`))
            .reduce((accumulator, key) => {
                return accumulator.concat(this.errors[key]);
            }, []);

        if (nestedMessages.length) {
            return nestedMessages.join('<br/>');
        }
    }


    set(field, error) {
        this.errors[field] = [error];
    }

    record(errors) {
        this.errors = errors;
    }

    clear(field) {
        delete this.errors[field]

        Object.keys(this.errors)
            .filter((key) => key.startsWith(`${field}.`))
            .forEach((key) => {
                delete this.errors[key];
            });
    }
}
