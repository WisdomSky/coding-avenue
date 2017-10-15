/**
 * Created by webdev on 6/7/2017.
 */
import Service from '@system/classes/Service';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/observable/fromPromise';
import 'rxjs/add/operator/do';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/mergeMap';

export default class extends Service {

    constructor() {
        super();
    }

    login() {
        window.Vue.googleAuth().directAccess();
        return Observable
            .create((observer) => {
                window.Vue.googleAuth().signIn(function (googleUser) {
                    observer.next(googleUser);
                    observer.complete();
                }, function (error) {
                    observer.error(error);
                });
            })
            .flatMap((res) => Observable.fromPromise(axios.post('/login', res)))
            .do(({ data }) => this.$store.commit('login', data.user));
    }


    logout() {
        return Observable.fromPromise(axios.post('/logout')).do(() => {
            this.$store.commit('flushUser');
            window.location.href = '/login';
        });
    }

}