import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import ProductView from '@/views/ProductView.vue'
import RegisterView from '@/views/RegisterView.vue'
import MenuView from '@/views/MenuView.vue'
import ShoppingCartView from '@/views/ShoppingCartView.vue'
import AdminView from '@/views/AdminView.vue'
import ReservationView from '@/views/ReservationView.vue'
import OrderView from '@/views/OrderView.vue'
import PaymentView from '@/views/PaymentView.vue'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView,
        },
        {
            path: '/admin',
            name: 'admin',
            component: AdminView,
        },
        {
            path: '/login',
            name: 'login',
            component: LoginView,
        },
        {
            path: '/register',
            name: 'register',
            component: RegisterView,
        },
        {
            path: '/menu',
            name: 'menu',
            component: MenuView,
        },
        {
            path: '/shopping-cart',
            name: 'shopping-cart',
            component: ShoppingCartView,
        },
        {
            path: '/product',
            name: 'product',
            component: ProductView,
        },
        {
            path: '/reservation',
            name: 'reservation',
            component: ReservationView,
        },
        {
            path: '/order',
            name: 'order',
            component: OrderView,
        },
        {
            path: '/payment',
            name: 'payment',
            component: PaymentView,
        },
    ],
})

export default router
