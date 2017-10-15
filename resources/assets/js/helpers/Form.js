import { FormErrors } from '@helpers';

class Form {

    /**
     * Create a new Form instance.
     *
     * @param fields
     * @param name
     */
    constructor(fields = {}, name = null) {
        this.fields = fields;
        this.name = name;
        this.errors = new FormErrors;
        this.notification = {};

        for (let field in fields) {
            this[field] = fields[field];
        }
    }

    payload() {
        let payload = {};

        for (let property in this.fields) {
            payload[property] = this[property];
        }

        return payload;
    }

    reset(field) {
        if (field) {
            this[field] = '';

            return;
        }

        for (let field in this.fields) {
            this[field] = '';
        }
    }

    setNotification(notification) {
        this.notification = notification;
    }

    hasNotification() {
        return Object.keys(this.notification).length;
    }
}

export default Form;
