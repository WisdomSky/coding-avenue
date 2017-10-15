/**
 * Created by webdev on 6/7/2017.
 */
import Service from '@system/classes/Service';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/observable/fromPromise';
import 'rxjs/add/observable/of';
import 'rxjs/add/operator/do';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/mergeMap';
import { Post } from '@classes';

export default class extends Service {

    constructor() {
        super();
    }

    fetch(page = 1, my_posts = false, per_page = 5) {
        return Observable
            .of(`posts?page=${page}&my_posts=${my_posts ? 1 : 0}&per_page=${per_page}`)
            .flatMap((url) => Observable.fromPromise(this.$http.get(url)))
            .map(({ data }) => {

                if (Array.isArray(data.data)) {
                    data.data = data.data.map((p) => new Post(p));
                }

                return data;
            });
    }


    get(post_id) {
        return Observable
            .of(`posts/${post_id}`)
            .flatMap((url) => Observable.fromPromise(this.$http.get(url)))
            .map(({ data }) => new Post(data));
    }


    update(post_id, data) {

        if (Array.isArray(post_id)) {
            return Observable
                .of(`posts`)
                .flatMap((url) => Observable.fromPromise(this.$http.put(url, _.extend({}, data, {post_ids: post_id}))));
        } else {
            return Observable
                .of(`posts/${post_id}`)
                .flatMap((url) => Observable.fromPromise(this.$http.put(url, data)));
        }
    }

    delete(post_id) {

        if (Array.isArray(post_id)) {
            return Observable
                .of(`posts?post_ids=${post_id.join(',')}`)
                .flatMap((url) => Observable.fromPromise(this.$http.delete(url)));

        } else {
            return Observable
                .of(`posts/${post_id}`)
                .flatMap((url) => Observable.fromPromise(this.$http.delete(url)));

        }
    }

    logout() {
        return Observable.fromPromise(axios.post('/logout')).do(() => {
            this.$store.commit('flushUser');
            window.location.href = '/login';
        });
    }

}