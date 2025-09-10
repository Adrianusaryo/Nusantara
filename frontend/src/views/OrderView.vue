<template>
    <NavBar :name="name" />
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="text-success fw-bold">Order Summary</h2>
            <h6 class="text-muted fst-italic">Just one step away from delight!</h6>
            <hr class="w-50 mx-auto my-3" />
        </div>

        <!-- Loading -->
        <div
            v-if="isLoading"
            class="d-flex flex-column align-items-center justify-content-center text-center p-5"
        >
            <div
                class="spinner-border text-success mb-3"
                role="status"
                style="width: 3rem; height: 3rem"
            >
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-success fw-semibold mb-0" style="font-size: 1.1rem">
                Loading your orders...
            </p>
            <small class="text-muted">Hang tight, deliciousness is on the way!</small>
        </div>

        <!-- Active Orders -->
        <div v-else>
            <div v-if="activeOrders.length > 0">
                <div
                    v-for="order in activeOrders"
                    :key="order.id"
                    class="card my-4 shadow-sm border-0 rounded-4"
                >
                    <!-- Header -->
                    <div
                        class="card-header bg-success text-white fw-medium d-flex justify-content-between align-items-center rounded-top-4"
                    >
                        <div>Order ID : {{ order.order_id }}</div>
                        <div class="fst-italic small">
                            <i class="fa-solid fa-clock me-1"></i> {{ order.status }}
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <h5 class="fw-bold text-success fst-italic mb-2 text-center">
                            Order Tracking
                        </h5>
                        <p class="text-muted small text-center mb-2">
                            Follow your meal journey — from kitchen to your doorstep!
                        </p>

                        <hr />
                        <!-- Progress Steps -->
                        <div class="d-flex align-items-center px-4">
                            <template v-for="(step, index) in steps" :key="step.name">
                                <!-- Circle Step -->
                                <div class="d-flex flex-column align-items-center">
                                    <div
                                        :class="[
                                            'd-flex justify-content-center align-items-center rounded-circle shadow-sm',
                                            index <= getStepIndex(order.status)
                                                ? 'bg-success text-white'
                                                : 'bg-body-secondary text-dark',
                                        ]"
                                        style="width: 65px; height: 65px"
                                    >
                                        <i :class="['fa', step.icon]" style="font-size: 28px"></i>
                                    </div>
                                    <span
                                        class="mt-2 fw-semibold small text-center"
                                        :class="
                                            index <= getStepIndex(order.status)
                                                ? 'text-success'
                                                : 'text-muted'
                                        "
                                    >
                                        {{ step.label }}
                                    </span>
                                </div>

                                <!-- Progress Bar -->
                                <div
                                    v-if="index < steps.length - 1"
                                    class="progress flex-fill mx-2"
                                    style="height: 8px"
                                >
                                    <div
                                        class="progress-bar bg-success"
                                        :style="{
                                            width:
                                                index < getStepIndex(order.status)
                                                    ? '100%'
                                                    : index === getStepIndex(order.status)
                                                      ? '50%'
                                                      : '0%',
                                        }"
                                    ></div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <hr />

                    <!-- Accordion Order Details -->
                    <div class="accordion" :id="`orderDetailsAccordion-${order.id}`">
                        <div class="accordion-item border-0 shadow-sm rounded-3 overflow-hidden">
                            <h2
                                class="accordion-header"
                                :id="`headingDetails-${order.id}`"
                                style="margin-top: -10px"
                            >
                                <button
                                    class="accordion-button collapsed fw-bold text-dark bg-white fs-6"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    :data-bs-target="`#collapseDetails-${order.id}`"
                                    aria-expanded="false"
                                    :aria-controls="`collapseDetails-${order.id}`"
                                    @click="getOrderDetail(order.id)"
                                >
                                    <i class="fa-solid fa-plate-wheat me-2 text-success fs-6"></i>
                                    <span class="text-success">Order Details</span>
                                </button>
                            </h2>
                            <div
                                :id="`collapseDetails-${order.id}`"
                                class="accordion-collapse collapse"
                                :aria-labelledby="`headingDetails-${order.id}`"
                                :data-bs-parent="`#orderDetailsAccordion-${order.id}`"
                            >
                                <div class="accordion-body bg-light rounded-bottom-3">
                                    <div
                                        class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2"
                                        v-for="item in orderDetail[order.id] || []"
                                        :key="item.id"
                                    >
                                        <div>
                                            <span class="fw-semibold text-dark">{{
                                                item.food.name
                                            }}</span>
                                            <p class="text-muted small mb-0">
                                                x{{ item.quantity }}
                                            </p>
                                        </div>
                                        <span class="fw-bold text-secondary">
                                            Rp
                                            {{
                                                (item.price * item.quantity).toLocaleString('id-ID')
                                            }}
                                        </span>
                                    </div>
                                    <!-- Total -->
                                    <div
                                        class="d-flex justify-content-between align-items-center mt-3"
                                    >
                                        <span class="fw-bold text-dark fs-6">Total</span>
                                        <span class="fw-bold text-dark fs-6">
                                            Rp {{ order.total.toLocaleString('id-ID') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="card-footer bg-light text-center py-3 rounded-bottom-4">
                        <small class="text-muted fst-italic">
                            Sit tight, your delicious meal is on the way
                        </small>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div
                v-else
                class="text-center d-flex flex-column justify-content-center align-items-center my-5 h-100"
            >
                <i class="fa-solid fa-wheat-awn-circle-exclamation fa-3x mb-3 text-success"></i>
                <h4 class="fw-bold mb-1 text-success">Your cart is still empty</h4>
                <p class="text-muted mb-3">
                    Go ahead, pick your favorite meals and add them to the cart!
                </p>
                <RouterLink
                    class="btn btn-outline-success px-4 py-2 fw-medium rounded-pill shadow-sm"
                    to="/shopping-cart"
                >
                    <i class="fa fa-cart-shopping me-2"></i> Go to Checkout
                </RouterLink>
            </div>
        </div>
    </div>
    <Footer />
</template>

<script>
import Footer from '@/components/Footer.vue'
import NavBar from '@/components/NavBar.vue'
import router from '@/router'
import axios from 'axios'

export default {
    components: { NavBar, Footer },
    data() {
        return {
            name: '',
            token: '',
            orders: [],
            isLoading: false,
            steps: [
                { name: 'confirmed', label: 'Confirmed', icon: 'fa-utensils' },
                { name: 'preparing', label: 'Preparing', icon: 'fa-fire-burner' },
                { name: 'checking', label: 'Checking', icon: 'fa-clipboard-check' },
                { name: 'delivering', label: 'Delivering', icon: 'fa-map-location-dot' },
                { name: 'delivered', label: 'Delivered', icon: 'fa-home' },
            ],
            orderDetail: [],
        }
    },
    computed: {
        activeOrders() {
            return this.orders.filter((order) => order.status !== 'delivered')
        },
    },
    mounted() {
        this.name = sessionStorage.getItem('name')
        this.token = sessionStorage.getItem('token')
        if (!this.token) {
            router.push({ name: 'login' })
        }
        this.ShowOrder()
    },
    methods: {
        ShowOrder() {
            this.isLoading = true
            axios
                .get('https://nusantara-production-a567.up.railway.app/api/nusantara/orders', {
                    headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                })
                .then((response) => {
                    this.orders = response.data.data
                    this.isLoading = false
                })
                .catch((error) => {
                    console.error(error)
                    this.isLoading = false
                })
        },
        async getOrderDetail(id) {
            if (this.orderDetail[id]) return
            try {
                const response = await axios.get(
                    `https://nusantara-production-e3d2.up.railway.app/api/nusantara/orders/${id}`,
                    {
                        headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                    },
                )
                this.orderDetail[id] = response.data.data.order_detail
            } catch (error) {
                console.error(error)
            }
        },
        getStepIndex(status) {
            return this.steps.findIndex((s) => s.name === status)
        },
    },
}
</script>

<style scoped>
.accordion-button:focus {
    box-shadow: none !important;
    outline: none !important;
}

.accordion-button:not(.collapsed) {
    background-color: white !important;
    box-shadow: none !important;
}
</style>
