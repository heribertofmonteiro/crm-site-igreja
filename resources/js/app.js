import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { Ziggy } from './ziggy';
import Login from './Pages/Auth/Login.vue';
import Register from './Pages/Auth/Register.vue';
import ForgotPassword from './Pages/Auth/ForgotPassword.vue';
import ResetPassword from './Pages/Auth/ResetPassword.vue';
import RecoverUsername from './Pages/Auth/RecoverUsername.vue';

// Login Page
const loginApp = document.getElementById('login-app');
if (loginApp) {
    const app = createApp(Login, {
        status: loginApp.dataset.status,
        systemName: loginApp.dataset.systemName,
        churchName: loginApp.dataset.churchName,
    });
    app.use(ZiggyVue, Ziggy);
    app.mount('#login-app');
}

// Register Page
const registerApp = document.getElementById('register-app');
if (registerApp) {
    const app = createApp(Register, {
        systemName: registerApp.dataset.systemName,
        churchName: registerApp.dataset.churchName,
    });
    app.use(ZiggyVue, Ziggy);
    app.mount('#register-app');
}

// Forgot Password Page
const forgotPasswordApp = document.getElementById('forgot-password-app');
if (forgotPasswordApp) {
    const app = createApp(ForgotPassword, {
        status: forgotPasswordApp.dataset.status,
        systemName: forgotPasswordApp.dataset.systemName,
        churchName: forgotPasswordApp.dataset.churchName,
    });
    app.use(ZiggyVue, Ziggy);
    app.mount('#forgot-password-app');
}

// Reset Password Page
const resetPasswordApp = document.getElementById('reset-password-app');
if (resetPasswordApp) {
    const app = createApp(ResetPassword, {
        token: resetPasswordApp.dataset.token,
        email: resetPasswordApp.dataset.email,
        systemName: resetPasswordApp.dataset.systemName,
        churchName: resetPasswordApp.dataset.churchName,
    });
    app.use(ZiggyVue, Ziggy);
    app.mount('#reset-password-app');
}

// Recover Username Page
const recoverUsernameApp = document.getElementById('recover-username-app');
if (recoverUsernameApp) {
    const app = createApp(RecoverUsername, {
        systemName: recoverUsernameApp.dataset.systemName,
        churchName: recoverUsernameApp.dataset.churchName,
    });
    app.use(ZiggyVue, Ziggy);
    app.mount('#recover-username-app');
}

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
