class FormErrors {

    /**
     * Create a new FormErrors instance.
     *
     * @param errors
     */
    constructor(errors = {}) {
        this.errors = errors;
    }

    /**
     * Determine if the given field has a validation error.
     *
     * @param field
     */
    has(field) {
        return this.errors.hasOwnProperty(field);
    }

    /**
     * Get the error message of the given field.
     *
     * @param field
     * @returns {*}
     */
    get(field) {
        if (this.errors[field]) {
            return Array.isArray(this.errors[field]) ? this.errors[field][0] : this.errors[field];
        }
    }

    /**
     * Record the new errors.
     *
     * @param {object} errors
     */
    record(errors) {
        for (let property in errors) {
            this.errors[property] = errors[property];
        }
    }

    /**
     * Clear error on a specific field or all errors.
     *
     * @param field
     */
    clear(field) {
        if (field) {
            delete this.errors[field];
            return;
        }

        this.errors = {};
    }
}

export default FormErrors;
