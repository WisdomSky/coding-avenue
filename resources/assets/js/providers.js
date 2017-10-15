/**
 * Import CSS dependencies
 */
import "normalize.css/normalize.css";
import "basscss/css/basscss.css";
import 'animate.css';



/**
 * Install progressbar component
 */
import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, config['vue-progressbar']);



/**
 * Install Element UI
 */
import Element from 'element-ui'
import ElementLocale from 'element-ui/lib/locale'
import 'element-ui/lib/theme-default/index.css';
Vue.use(Element, {
    i18n: (key, value) => {
        return app.i18n.t(key, value);
    }
});
ElementLocale.i18n((key, value) => {
    return app.i18n.t(key, value);
});



/**
 * Install Vue Filters
 */
import Vue2Filters from 'vue2-filters';

Vue.use(Vue2Filters);



/**
* Install Moment JS
*/
import moment from "moment-timezone";
import VueMomentJS from "vue-momentjs";

Vue.use(VueMomentJS, moment);


Vue.filter('ucword', function (value) {
    return _.startCase(_.toLower(value));
});

Vue.filter('ucfirst', function (value) {
    return value.substring(0,1).toUpperCase() + value.substring(1);
});





import VueSmoothScroll from 'vue-smoothscroll-websites';
Vue.use(VueSmoothScroll);


import VueClipboards from 'vue-clipboards';
Vue.use(VueClipboards);

import GoogleAuth from 'vue-google-oauth'

Vue.use(GoogleAuth, config.googleSignInParams);
Vue.googleAuth().load();

import VueMarkdown from 'vue-markdown';
Vue.component('VueMarkdown', VueMarkdown);