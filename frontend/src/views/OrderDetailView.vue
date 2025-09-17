<template>
    <NavBar :name="name" :role="roleId" />
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4">
                    <!-- Header -->
                    <div class="card-header text-white text-center bg-gradient bg-dark">
                        <h6 class="m-0 fw-bold">
                            {{ order.customer_name }} - Table {{ order.table_no }}
                        </h6>
                    </div>

                    <!-- Lottie Animation -->
                    <div class="d-flex justify-content-center py-3">
                        <dotlottie-player
                            src="https://lottie.host/bc47a307-7626-4484-9733-373fc00a859f/YZNkCgmcKc.lottie"
                            background="transparent"
                            speed="0.5"
                            style="width: 250px; height: 200px"
                            loop
                            autoplay
                        ></dotlottie-player>
                    </div>

                    <!-- Order Details -->
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-semibold"
                                    ><i class="bi bi-cash text-warning"></i> Total</span
                                >
                                <strong class="text-dark">Rp{{ formatPrice(order.total) }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-semibold"
                                    ><i class="bi bi-calendar text-primary"></i> Date & Time</span
                                >
                                <span class="fw-medium"
                                    >{{ order.order_date }} {{ order.order_time }}</span
                                >
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-semibold"
                                    ><i class="bi bi-person text-secondary"></i> Waitress</span
                                >
                                <span class="text-capitalize fw-medium" v-if="order.waitress">{{
                                    order.waitress.name
                                }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-semibold"
                                    ><i class="bi bi-person text-secondary"></i> Cashier</span
                                >
                                <span class="text-capitalize fw-medium" v-if="order.cashier">{{
                                    order.cashier.name
                                }}</span>
                            </li>
                            <li
                                class="list-group-item text-center d-flex justify-content-center gap-2"
                            >
                                <span
                                    class="badge px-3 py-2 mt-2"
                                    :class="{
                                        'bg-primary text-white text-capitalize':
                                            order.status === 'done',
                                        'bg-warning text-white text-capitalize':
                                            order.status === 'ordered',
                                        'bg-success': order.status === 'paid',
                                    }"
                                >
                                    <i
                                        class="fas"
                                        :class="{
                                            'fa-square-check px-1': order.status === 'done',
                                            'fa-hourglass-half px-1': order.status === 'ordered',
                                            'fa-file-invoice-dollar px-1': order.status === 'paid',
                                        }"
                                    ></i>
                                    {{ order.status }}
                                </span>
                                <span
                                    v-if="order.status !== 'paid'"
                                    class="badge px-3 py-2 mt-2 cursor-pointer"
                                    :class="
                                        order.status === 'ordered' ? 'bg-primary' : 'bg-success'
                                    "
                                    @click="setStatus()"
                                >
                                    <i
                                        class="fa"
                                        :class="
                                            order.status === 'ordered'
                                                ? 'fa-circle-check px-1'
                                                : 'fa-check px-1'
                                        "
                                    ></i>
                                    {{ order.status === 'ordered' ? 'Done' : 'Paid' }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4">
                    <!-- Header -->
                    <div class="card-header text-white text-center bg-gradient bg-dark">
                        <h6 class="m-0 fw-bold">Order Detail</h6>
                    </div>

                    <!-- Lottie Animation -->
                    <div class="d-flex justify-content-center py-3">
                        <dotlottie-player
                            src="https://lottie.host/dca67250-aee4-43d6-8ffa-5e0eb5dff435/zV73oYNkBx.lottie"
                            background="transparent"
                            speed="0.5"
                            style="width: 250px; height: 200px"
                            loop
                            autoplay
                        ></dotlottie-player>
                    </div>

                    <!-- Order Details -->
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li
                                class="list-group-item"
                                v-for="(item, index) in order.order_detail"
                                :key="index"
                            >
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-semibold text-capitalize">
                                            <i class="bi bi-burger text-warning"></i>
                                            {{ item.item.name }}
                                        </span>
                                        <br />
                                        <small class="text-muted">Qty : {{ item.qty }}</small>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block"
                                            >Rp {{ formatPrice(item.price) }}</small
                                        >
                                        <strong class="text-dark"
                                            >Rp {{ formatPrice(item.price * item.qty) }}</strong
                                        >
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import NavBar from '@/components/NavBar.vue'
import router from '@/router'
import axios from 'axios'

export default {
    components: {
        NavBar,
    },
    data() {
        return {
            name: '',
            token: '',
            roleId: '',
            order: [],
        }
    },
    mounted() {
        this.name = sessionStorage.getItem('name')
        this.token = sessionStorage.getItem('token')
        this.roleId = sessionStorage.getItem('role_id')
        this.getOrder()
    },
    methods: {
        getOrder() {
            axios
                .get('https://nusantara.up.railway.app/api/order/' + this.$route.params.orderId, {
                    headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                })
                .then((response) => {
                    this.order = response.data.data
                })
                .catch(function (error) {
                    if (error.response.status == 401) {
                        sessionStorage.removeItem('token')
                        sessionStorage.removeItem('name')
                        sessionStorage.removeItem('email')
                        sessionStorage.removeItem('role_id')
                        router.push({ name: 'login' })
                    }
                })
        },
        formatPrice(value) {
            return new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
                useGrouping: true,
            }).format(value)
        },
        setStatus() {
            if (this.order.status === 'ordered') {
                axios
                    .get(
                        'https://nusantara.up.railway.app/api/order/' +
                            this.$route.params.orderId +
                            '/set-as-done',
                        {
                            headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                        },
                    )
                    .then((response) => {
                        this.getOrder()
                    })
                    .catch(function (error) {
                        if (error.response.status == 401) {
                            sessionStorage.removeItem('token')
                            sessionStorage.removeItem('name')
                            sessionStorage.removeItem('email')
                            sessionStorage.removeItem('role_id')
                            router.push({ name: 'login' })
                        }
                        console.log(error)
                    })
            } else if (this.order.status === 'done') {
                axios
                    .get(
                        'https://nusantara.up.railway.app/api/order/' +
                            this.$route.params.orderId +
                            '/payment',
                        {
                            headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                        },
                    )
                    .then((response) => {
                        this.getOrder()
                    })
                    .catch(function (error) {
                        if (error.response.status == 401) {
                            sessionStorage.removeItem('token')
                            sessionStorage.removeItem('name')
                            sessionStorage.removeItem('email')
                            sessionStorage.removeItem('role_id')
                            router.push({ name: 'login' })
                        }
                        console.log(error)
                    })
            }
        },
    },
}
</script>
<style></style>
