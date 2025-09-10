<template>
    <section class="login d-flex vh-100">
        <div class="login-left w-50 h-100">
            <div
                id="carouselExampleFade"
                class="carousel slide carousel-fade"
                data-bs-ride="carousel"
                data-bs-pause="false"
            >
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="4000">
                        <img src="@/assets/image/nasi-telor.jpg" class="d-block w-100" alt="..." />
                    </div>
                    <div class="carousel-item" data-bs-interval="4000">
                        <img src="@/assets/image/ayam-goreng.jpg" class="d-block w-100" alt="..." />
                    </div>
                    <div class="carousel-item" data-bs-interval="4000">
                        <img src="@/assets/image/cendol.jpg" class="d-block w-100" alt="..." />
                    </div>
                </div>
            </div>
        </div>
        <div class="login-right w-50 h-100 bg-light-subtle">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-7">
                    <div class="header text-center">
                        <h2 class="fw-semibold text-success">
                            <i class="fa-brands fa-bitcoin px-2"></i>Nusantara Foods
                        </h2>
                        <p class="text-muted fs-6">
                            Join us and start your journey to delicious moments!
                        </p>
                    </div>
                    <div class="login-form">
                        <form @submit.prevent="">
                            <div class="mb-2">
                                <label for="name" class="form-label fw-medium text-success">
                                    Name
                                </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="name"
                                    placeholder="John Lennon"
                                    v-model="name"
                                    :class="{ 'is-invalid': errors.name }"
                                />
                                <div v-if="errors.name" class="invalid-feedback">
                                    {{ errors.name[0] }}
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="email" class="form-label fw-medium text-success"
                                    >Email</label
                                >
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    placeholder="you@example.com"
                                    :class="{ 'is-invalid': errors.email }"
                                    v-model="email"
                                />
                                <div v-if="errors.email" class="invalid-feedback">
                                    {{ errors.email[0] }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label fw-medium text-success"
                                    >Password</label
                                >
                                <div class="input-group">
                                    <input
                                        :type="showPassword ? 'text' : 'password'"
                                        class="form-control"
                                        id="password"
                                        placeholder="••••••••"
                                        v-model="password"
                                        :class="{ 'is-invalid': errors.password }"
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
                                </div>
                                <div v-if="errors.password" class="invalid-feedback">
                                    {{ errors.password[0] }}
                                </div>
                            </div>
                            <button @click="register()" class="btn btn-success w-100">
                                Register
                            </button>
                        </form>
                        <div class="text-center mt-2">
                            <span class="text-muted"
                                >Already have an account ?
                                <RouterLink to="/login" class="text-success fst-italic fw-medium"
                                    >Login Now</RouterLink
                                >
                            </span>
                        </div>
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
        register() {
            axios
                .post(
                    'https://nusantara-production-a567.up.railway.app//api/auth/register',
                    {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                    },
                    {
                        headers: {
                            Accept: 'application/json',
                        },
                    },
                )
                .then((response) => {
                    router.push({ name: 'login' })
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

* {
    box-sizing: border-box;
}

.login {
    overflow: hidden;
}
</style>
