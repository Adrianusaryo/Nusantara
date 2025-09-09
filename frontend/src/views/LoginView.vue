<template>
    <section class="login d-flex vh-100">
        <div class="login-left w-50 h-100 bg-light-subtle">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-7">
                    <div class="header text-center">
                        <h2 class="fw-semibold text-success">
                            <i class="fa-brands fa-bitcoin px-2"></i>
                            Nusantara Foods
                        </h2>
                        <p class="text-muted fs-6">
                            Access your account to explore delicious meals and place your order
                        </p>
                    </div>
                    <div class="login-form">
                        <form @submit.prevent="">
                            <div class="mb-2">
                                <label for="email" class="form-label fw-medium text-success"
                                    >Email</label
                                >
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    placeholder="you@example.com"
                                    v-model="email"
                                    :class="{ 'is-invalid': errors.email }"
                                />
                                <div v-if="errors.email" class="invalid-feedback">
                                    {{ errors.email[0] }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label fw-medium text-success"
                                    >Password</label
                                >
                                <div class="input-group has-validation">
                                    <input
                                        :type="showPassword ? 'text' : 'password'"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.password }"
                                        id="password"
                                        v-model="password"
                                        placeholder="••••••••"
                                    />
                                    <span
                                        class="input-group-text text-success"
                                        @click="togglePassword"
                                        style="cursor: pointer"
                                    >
                                        <i
                                            :class="showPassword ? 'fas fa-unlock' : 'fas fa-lock'"
                                        ></i>
                                    </span>
                                    <!-- Masukkan invalid-feedback di dalam input-group -->
                                    <div v-if="errors.password" class="invalid-feedback d-block">
                                        {{ errors.password[0] }}
                                    </div>
                                </div>
                            </div>

                            <button @click="login()" class="btn btn-success w-100">Login</button>
                        </form>
                        <div class="text-center mt-2">
                            <span class="text-muted"
                                >Don't have an account ?
                                <RouterLink to="/register" class="text-success fst-italic fw-medium"
                                    >Sign up for free</RouterLink
                                >
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="login-right w-50 h-100">
            <div
                id="carouselExampleFade"
                class="carousel slide carousel-fade"
                data-bs-ride="carousel"
                data-bs-pause="false"
            >
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="4000">
                        <img src="@/assets/image/food.jpg" class="d-block w-100" alt="..." />
                    </div>
                    <div class="carousel-item" data-bs-interval="4000">
                        <img src="@/assets/image/bubur.jpg" class="d-block w-100" alt="..." />
                    </div>
                    <div class="carousel-item" data-bs-interval="4000">
                        <img src="@/assets/image/sate.jpg" class="d-block w-100" alt="..." />
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import axios from 'axios'
import router from '@/router'
export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            errors: [],
            showPassword: false,
        }
    },
    methods: {
        login() {
            axios
                .post('https://nusantara-production-2267.up.railway.app/api/auth/login', {
                    email: this.email,
                    password: this.password,
                })
                .then((response) => {
                    sessionStorage.setItem('email', response.data.data.email)
                    sessionStorage.setItem('name', response.data.data.name)
                    sessionStorage.setItem('roles', response.data.data.roles)
                    sessionStorage.setItem('token', response.data.data.token)
                    router.push({ name: 'menu' })
                })
                .catch((error) => {
                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        togglePassword() {
            this.showPassword = !this.showPassword
        },
    },
    mounted() {
        this.token = sessionStorage.getItem('token')
        if (this.token) {
            router.push({ name: 'home' })
        }
    },
}
</script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');

.login {
    font-family: 'Roboto', sans-serif;
}

.carousel-inner {
    height: 100vh;
    display: flex;
    align-items: center;
}

.carousel-item {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

.carousel-item img {
    max-height: 100vh;
    width: auto;
    object-fit: cover;
    object-position: center center;
}

.form-control:focus {
    border-color: green;
    box-shadow: 0 0 0 0.2rem rgba(9, 238, 28, 0.25);
}
</style>
