<template>
    <NavBar :name="name" :role="roleId" />
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-lg rounded-start p-4">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-3 fw-bold text-dark">
                            Order Report Per Month
                        </h4>
                        <div class="mb-3">
                            <label for="month" class="form-label text-secondary fw-semibold"
                                >Periode Bulan</label
                            >
                            <select
                                v-model="month"
                                id="month"
                                class="form-select border border-secondary-subtle"
                            >
                                <option value="">Choose Month Period</option>
                                <option v-for="month in months" :value="month.value">
                                    {{ month.name }}
                                </option>
                            </select>
                        </div>
                        <button class="btn btn-success w-100 mt-2" @click="getReport()">
                            Tampilkan Laporan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div
                    class="card my-4 shadow-lg border-0"
                    style="max-width: 350px; border-radius: 15px"
                >
                    <div class="row g-0 align-items-center">
                        <!-- Kolom ikon -->
                        <div
                            class="col-md-4 d-flex justify-content-center align-items-center bg-success text-white"
                            style="
                                border-top-left-radius: 15px;
                                border-bottom-left-radius: 15px;
                                min-height: 120px;
                            "
                        >
                            <i class="fa fa-tags" style="font-size: 60px"></i>
                        </div>
                        <!-- Kolom isi card -->
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-success fw-bold">Order Count</h5>
                                <p class="card-text fs-3 fw-bold text-dark">
                                    {{ orderReport.orderCount }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div
                    class="card my-4 shadow-lg border-0"
                    style="max-width: 350px; border-radius: 15px"
                >
                    <div class="row g-0 align-items-center">
                        <!-- Kolom ikon -->
                        <div
                            class="col-md-4 d-flex justify-content-center align-items-center bg-success text-white"
                            style="
                                border-top-left-radius: 15px;
                                border-bottom-left-radius: 15px;
                                min-height: 120px;
                            "
                        >
                            <i class="fas fa-money-bill-trend-up" style="font-size: 60px"></i>
                        </div>
                        <!-- Kolom isi card -->
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-success fw-bold">Max Payment Order</h5>
                                <p class="card-text fs-3 fw-bold text-dark">
                                    Rp {{ formatPrice(orderReport.maxPayment) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div
                    class="card my-4 shadow-lg border-0"
                    style="max-width: 350px; border-radius: 15px"
                >
                    <div class="row g-0 align-items-center">
                        <!-- Kolom ikon -->
                        <div
                            class="col-md-4 d-flex justify-content-center align-items-center bg-success text-white"
                            style="
                                border-top-left-radius: 15px;
                                border-bottom-left-radius: 15px;
                                min-height: 120px;
                            "
                        >
                            <i class="fa fa-receipt" style="font-size: 60px"></i>
                        </div>
                        <!-- Kolom isi card -->
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-success fw-bold">Min Payment Order</h5>
                                <p class="card-text fs-3 fw-bold text-dark">
                                    Rp {{ formatPrice(orderReport.minPayment) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-4" v-for="report in orderReport.order">
                <div class="card shadow-sm border-0 mb-4">
                    <!-- Header -->
                    <div class="card-header text-white text-center bg-gradient bg-dark">
                        <h6 class="m-0 fw-bold">
                            {{ report.customer_name }} - Table {{ report.table_no }}
                        </h6>
                    </div>

                    <!-- Lottie Animation -->
                    <div class="d-flex justify-content-center py-3">
                        <dotlottie-player
                            src="https://lottie.host/bc47a307-7626-4484-9733-373fc00a859f/YZNkCgmcKc.lottie"
                            background="transparent"
                            speed="1"
                            style="width: 150px; height: 150px"
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
                                <strong class="text-dark">Rp{{ formatPrice(report.total) }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-semibold"
                                    ><i class="bi bi-calendar text-primary"></i> Date & Time</span
                                >
                                <small class="fw-medium"
                                    >{{ report.order_date }} {{ report.order_time }}</small
                                >
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-semibold"
                                    ><i class="bi bi-person text-secondary"></i> Waitress</span
                                >
                                <small class="text-capitalize fw-medium">{{
                                    report.waitress.name
                                }}</small>
                            </li>
                            <li
                                class="list-group-item text-center d-flex justify-content-center gap-2"
                            >
                                <span
                                    class="badge px-3 py-2"
                                    :class="{
                                        'bg-primary text-white text-capitalize':
                                            report.status === 'done',
                                        'bg-warning text-white text-capitalize':
                                            report.status === 'ordered',
                                        'bg-success text-white text-capitalize':
                                            report.status === 'paid',
                                    }"
                                >
                                    <i
                                        class="fas"
                                        :class="{
                                            'fa-square-check px-1': report.status === 'done',
                                            'fa-hourglass-half px-1': report.status === 'ordered',
                                            'fa-file-invoice-dollar px-1': report.status === 'paid',
                                        }"
                                    ></i>
                                    {{ report.status }}
                                </span>
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
            months: [
                { value: 1, name: 'January' },
                { value: 2, name: 'February' }, // Perbaikan typo dari "Febuary" ke "February"
                { value: 3, name: 'March' },
                { value: 4, name: 'April' },
                { value: 5, name: 'May' },
                { value: 6, name: 'June' },
                { value: 7, name: 'July' },
                { value: 8, name: 'August' },
                { value: 9, name: 'September' },
                { value: 10, name: 'October' },
                { value: 11, name: 'November' },
                { value: 12, name: 'December' },
            ],
            month: '',
            orderReport: [],
        }
    },
    mounted() {
        this.name = sessionStorage.getItem('name') || ''
        this.token = sessionStorage.getItem('token') || ''
        this.roleId = sessionStorage.getItem('role_id') || ''
    },
    methods: {
        getReport() {
            axios
                .get('http://127.0.0.1:8000/api/order-report?month=' + this.month, {
                    headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                })
                .then((response) => {
                    this.orderReport = response.data.data
                    console.log(this.orderReport)
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
    },
}
</script>
