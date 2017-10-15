import "babel-polyfill";
import lodash from 'lodash'

window.app = {};
window.config = require('@root/config').default;
window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Vue = require('vue');
window.base_url = document.head.querySelector('meta[name="base-url"]').content;

try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {}


let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN' : token.content
        }
    });
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Vue.prototype.$http = axios.create(_.extend({}, window.axios.default, config.api));


require('@system/providers');
require('@root/providers');


import Service from '@system/classes/Service';
Service.prototype.$http = Vue.prototype.$http;
_.forEach(app,(v,k) => {
    Service.prototype[`$${k}`] = v;
});

const components_req = require.context('@root/components', true, /^(.*\.(vue))[^.]*$/igm);
components_req.keys().forEach(function(key){
    const name = key.replace(/^.*\/([^\.]+)\.vue/,'$1');
    Vue.component(name, components_req(key));
});

new Vue(lodash.extend({}, {
    el: '#app'
}, app));

