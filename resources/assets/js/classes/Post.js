import lodash from 'lodash';
import Vue from 'vue'


export default class {
    constructor(post) {
        lodash.extend(this, post);
    }

    get key() {
        return this.post_id;
    }

    get permalink() {
        return `${window.base_url}/p/${this.slug}`;
    }

    get formatted_date() {
        return Vue.moment.utc(this.created_at).tz(Vue.moment.tz.guess()).format("dddd, MMMM Do YYYY \\a\\t h:mm a");
    }

}