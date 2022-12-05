import ExampleComponent from "./components/ExampleComponent.vue";
import LoginComponent from "./components/LoginComponent.vue";
import RegisterComponent from "./components/RegisterComponent.vue";
import User from "./components/User.vue";


export default {
    mode: 'hash',
    routes: [
        {
            path: '/',
            name: 'login',
            component: LoginComponent,
            meta: { needAuth: false }

        },
        {
            path: '/login',
            name: 'login',
            component: LoginComponent,
            meta: { needAuth: false },
        },
        {
            path: '/register',
            name: 'register',
            component: RegisterComponent,
            meta: { needAuth: false },
        },
        {
            path: '/qr',
            name: 'user',
            component: User,
            meta: { needAuth: true },
        }
    ]
}