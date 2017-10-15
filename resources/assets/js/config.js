import state from './store/state';
import mutations from './store/mutations';
import actions from './store/actions';
import getters from './store/getters';
import routes from './routes';


export default {


    'pageTitle': document.title,


    /*
     | Store settings
     */

    'store' : {state, mutations, actions, getters},


    /*
     | Router settings
     */

    'router': {
        mode    : 'history',
        routes  : routes
    },


    'api': {
        baseURL : '/r'
    },

    googleSignInParams: {
        client_id: document.head.querySelector('meta[name="g-client-id"]').content,
        scope: 'email'
    },

    /*
     | Localization settings
     */
    'localization': {
        'locale'            : document.documentElement.getAttribute('lang'),
        'fallbackLocale'    : document.head.querySelector('meta[name="app-fallback-locale"]').content,
    },


    'auth': {
        landingRoute    : '/'
    },


    /*
     | Progressbar settings
     */
    'vue-progressbar': {
        color           : '#a33',
        failedColor     : '#FF4949',
        thickness       : '5px',
        transition      : {
            speed           : '0.2s',
            opacity         : '0.6s',
            termination     : 300
        },
        autoRevert      : true,
        location        : 'bottom',
        inverse         : false
    }

}