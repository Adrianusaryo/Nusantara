<template>
    <nav
        v-if="$route.name !== 'login'"
        ref="navbar"
        class="navbar bg-transparent sticky-top navbar-expand-lg w-100"
    >
        <div class="container">
            <RouterLink class="navbar-brand text-success fs-4 fw-bold fst-italic" to="/">
                <i class="fa-brands fa-bitcoin px-2"></i>Nusantara
            </RouterLink>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item mx-2">
                        <RouterLink class="nav-link fw-medium text-success" to="/">Home</RouterLink>
                    </li>
                    <li class="nav-item mx-2">
                        <RouterLink class="nav-link fw-medium text-success" to="/menu"
                            >Menu</RouterLink
                        >
                    </li>
                    <li class="nav-item mx-2">
                        <RouterLink class="nav-link fw-medium text-success" to="/order"
                            >Order</RouterLink
                        >
                    </li>
                    <li class="nav-item mx-2">
                        <RouterLink class="nav-link fw-medium text-success" to="/reservation"
                            >Reservation</RouterLink
                        >
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <RouterLink class="nav-link text-success fs-5 p-0" to="/shopping-cart">
                            <div class="position-relative d-inline-block">
                                <i class="fa fa-basket-shopping"></i>
                                <span
                                    v-if="cartStore.total !== 0"
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                    style="font-size: 0.65rem"
                                >
                                    {{ cartStore.total }}
                                </span>
                            </div>
                        </RouterLink>
                    </li>

                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle text-success fs-5 p-0"
                            href="#"
                            id="userDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <i class="fa fa-user-gear"></i>
                        </a>

                        <ul
                            class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3"
                            aria-labelledby="userDropdown"
                        >
                            <li v-if="!isLoggedIn">
                                <RouterLink
                                    class="dropdown-item d-flex text-success align-items-center gap-2"
                                    to="/login"
                                >
                                    <i class="fa fa-sign-in-alt"></i> Login
                                </RouterLink>
                            </li>
                            <template v-else>
                                <li class="px-3 py-2 text-muted small">Hi, {{ name }}</li>
                                <li><hr class="dropdown-divider" /></li>
                                <li>
                                    <a
                                        class="dropdown-item text-success d-flex align-items-center gap-2"
                                        href="#"
                                        @click="logout"
                                    >
                                        <i class="fa fa-sign-out-alt"></i> Logout
                                    </a>
                                </li>
                            </template>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import axios from 'axios'
import router from '@/router'
import { useCartStore } from '@/stores/cartStore'

export default {
    props: ['name'],
    data() {
        return {
            roles: sessionStorage.getItem('roles'),
            isLoggedIn: !!sessionStorage.getItem('token'),
            cartStore: useCartStore(),
        }
    },
    mounted() {
        window.addEventListener('scroll', this.handleScroll)
        this.handleScroll()
    },
    beforeUnmount() {
        window.removeEventListener('scroll', this.handleScroll)
    },
    methods: {
        handleScroll() {
            const navbar = this.$refs.navbar
            if (navbar) {
                if (window.scrollY > 1) {
                    navbar.classList.replace('bg-transparent', 'bg-body-tertiary')
                } else {
                    navbar.classList.replace('bg-body-tertiary', 'bg-transparent')
                }
            }
        },
        logout() {
            axios
                .get('https://nusantara.up.railway.app/api/auth/logout', {
                    headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                })
                .then(() => {
                    this.cartStore.clearCart()
                    sessionStorage.clear()
                    localStorage.clear()
                    this.isLoggedIn = false
                    router.push({ name: 'login' })
                })
                .catch((error) => {
                    console.error('Logout Error:', error)
                })
        },
    },
}
</script>

<style scoped>
.dropdown-item:active {
    background-color: #198754 !important;
    color: #fff !important;
}
</style>
