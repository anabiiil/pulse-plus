<template>
    <div>
        <div className="card-sigin">
            <div className="main-signup-header">
                <h3>Welcome back!</h3>
                <h6 className="fw-medium mb-4 fs-17">Please sign in to continue.</h6>
                <form id="login-form" @submit.prevent="login()">
                    <div className="form-group mb-3">
                        <label className="form-label">Email</label>
                        <input className="form-control" v-model="email" placeholder="Enter your email" type="text"
                               name="email"/>
                        <span v-if="error?.email" class="text-danger">{{ error?.email }}</span>
                    </div>
                    <div className="form-group mb-3">
                        <label className="form-label">Password</label>
                        <input className="form-control" v-model="password" name="password"
                               placeholder="Enter your password"
                               type="password"/>
                        <span v-if="error?.password" class="text-danger">{{ error?.password }}</span>
                    </div>
                    <button type="submit" className="btn btn-primary btn-block w-100">Sign In
                    </button>

                </form>

            </div>
        </div>
    </div>
</template>

<script>
import {useHead} from "@vueuse/head";


export default {
    setup() {
        useHead({
            title: 'Login',
        });
    },
    props: {

    },
    data() {
        return {
            email: '',
            password: '',
            error: null,
        };
    },
    methods: {
        async login() {
            this.error = null;
            try {
                const response = await axios.post('admin/login', {
                    email: this.email,
                    password: this.password
                });

                if (response.status === 200) {
                    localStorage.setItem('user', JSON.stringify(response.data.data.user));
                    window.location.href = '/dash/index'; // Redirect to dashboard after successful login
                }
            } catch (res) {
                if (res?.response?.data?.errors) {
                    this.error = res?.response?.data?.errors;
                    // showErrorToast('Validation Error');
                } else {
                    // showErrorToast('An error occurred.');
                }

                // if (error.response && error.response.data) {
                //     this.error = error.response.data.message || 'Login failed.';
                // } else {
                //     this.error = 'An error occurred.';
                // }
            }
            // Fetch authenticated user data
            // const response = await axios.get('/api/user');
            // // Store user data in localStorage or a state management library
            // localStorage.setItem('user', JSON.stringify(response.data));
            // Redirect to dashboard
            // this.$router.push({name: 'dashboard'});

        },
    },
};
</script>
