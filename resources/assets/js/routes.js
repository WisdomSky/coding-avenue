import * as Components from '@components';
import { AuthService } from '@services';

export default [
    {
        path: '/',
        component: Components.IndexPage,
    },
    {
        path: '/dashboard',
        component: Components.DashboardPage,
    },
    {
        path: '/edit/:id',
        component: Components.EditPostPage,
    },
    {
        path: '/logout',
        component: Components.Logout,
        name: 'logout',
        beforeEnter(to, from, next) {
            if (to.params.explicit) next(); else next(from);
        }
    },
    {
        path: '/login',
        component: Components.Login,
        meta: {
            noAuth: true,
        }
    },
    {
        path: '/p/:slug',
        component: Components.PostPage,
        meta: {
            noAuth: true,
        }
    }
];
