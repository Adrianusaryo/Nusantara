<template>
    <NavBar :name="name" />
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="text-success fw-bold">Shopping Cart</h2>
            <h6 class="text-muted fst-italic">Everything you love, all in one place.</h6>
            <hr class="w-50 mx-auto" />
        </div>
        <div
            v-if="cartItems.length === 0"
            class="text-center d-flex flex-column justify-content-center align-items-center my-5 h-100 aligns-items-center"
        >
            <i class="fa-solid fa-basket-shopping fa-3x mb-3 text-success"></i>
            <h4 class="fw-bold mb-1 text-success">Your cart is empty</h4>
            <p class="text-muted mb-3">Choose your favorite meals and add them to your cart!</p>
            <RouterLink class="btn btn-outline-success px-4 py-2 rounded-pill fw-medium" to="/menu">
                <i class="fa fa-search me-2"></i> Browse Menu
            </RouterLink>
        </div>
        <div class="row my-3" v-else>
            <div class="col-md-8">
                <div class="d-flex align-items-center mb-3">
                    <!-- <i class="fa-solid fa-bell-concierge text-success me-2 fs-4"></i> -->
                    <h5 class="fw-bold text-success fst-italic mb-0">Meals You’ve Chosen</h5>
                </div>

                <div
                    class="row flex justify-content-between"
                    v-for="menu in cartItems"
                    :key="menu.id"
                >
                    <div class="col-md-4 d-flex justify-content-center align-items-center">
                        <img
                            v-if="menu.image"
                            :src="url + menu.image"
                            class="card-img-top rounded-pill bg-light mx-auto p-2 border border-success fixed-img"
                            alt="..."
                        />
                        <img
                            v-else
                            src="@/assets/image/null.png"
                            class="card-img-top rounded bg-light mx-auto p-2 border border-success fixed-img"
                            alt="..."
                        />
                    </div>

                    <div class="col-md-5">
                        <h5 class="fw-bold mb-1">{{ menu.name }}</h5>
                        <span class="fw-medium text-muted d-block mb-1 fst-italic"
                            >Description</span
                        >
                        <p class="text-muted small mb-1">{{ menu.desc }}</p>
                        <button
                            class="btn btn-sm btn-outline-danger mt-2"
                            @click="deleteItemInCart(menu)"
                        >
                            <i class="fa fa-trash me-1"></i>Remove Item
                        </button>
                    </div>

                    <div
                        class="col-md-3 d-flex flex-column align-items-start justify-content-start"
                    >
                        <div class="fw-semibold text-success mb-2">
                            Rp {{ (menu.price * menu.qty).toLocaleString('id-ID') }}
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button
                                class="btn btn-sm btn-outline-success"
                                @click="decreaseQty(menu)"
                            >
                                −
                            </button>
                            <span>{{ menu.qty }}</span>
                            <button
                                class="btn btn-sm btn-outline-success"
                                @click="increaseQty(menu)"
                            >
                                +
                            </button>
                        </div>
                    </div>

                    <hr class="mt-3" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-bold fst-italic mb-2 text-success">
                            Cart Summary
                        </h5>
                        <p class="mb-2 text-muted">
                            Total Items: <span class="fw-medium">{{ cartItems.length }}</span>
                        </p>
                        <p class="mb-2 text-muted">
                            Total:
                            <span class="fw-bold">Rp {{ totalPrice.toLocaleString('id-ID') }}</span>
                        </p>
                        <form>
                            <div class="mb-2">
                                <label for="city" class="form-label fw-medium">Delivery City</label>
                                <input
                                    type="text"
                                    id="city"
                                    class="form-control"
                                    placeholder="Enter your delivery city"
                                    autocomplete="off"
                                    v-model="city"
                                    :class="{ 'is-invalid': errors.city }"
                                />
                                <div v-if="errors.city" class="invalid-feedback">
                                    {{ errors.city[0] }}
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="address" class="form-label fw-medium"
                                    >Full Address</label
                                >
                                <input
                                    type="text"
                                    id="address"
                                    class="form-control"
                                    placeholder="Enter your complete address"
                                    autocomplete="off"
                                    v-model="address"
                                    :class="{ 'is-invalid': errors.address }"
                                />
                                <div v-if="errors.address" class="invalid-feedback">
                                    {{ errors.address[0] }}
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="phone" class="form-label fw-medium">Phone Number</label>
                                <input
                                    type="text"
                                    id="phone"
                                    class="form-control"
                                    placeholder="Enter your active phone number"
                                    autocomplete="off"
                                    v-model="phone"
                                    :class="{ 'is-invalid': errors.phone }"
                                />
                                <div v-if="errors.phone" class="invalid-feedback">
                                    {{ errors.phone[0] }}
                                </div>
                            </div>
                        </form>
                        <button
                            class="btn btn-success w-100 fw-medium mt-2 rounded-pill"
                            @click="payNow"
                        >
                            <i class="fa-solid fa-receipt me-2"></i>Make Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Footer></Footer>
</template>

<script>
import NavBar from '@/components/NavBar.vue'
import Footer from '@/components/Footer.vue'
import axios from 'axios'
import { useCartStore } from '@/stores/cartStore'
import Swal from 'sweetalert2'
import router from '@/router'
export default {
    components: {
        NavBar,
        Footer,
    },
    data() {
        return {
            token: '',
            name: '',
            email: '',
            phone: '',
            address: '',
            city: '',
            cartStore: useCartStore(),
            url: 'http://127.0.0.1:8000/storage/',
            errors: [],
        }
    },
    mounted() {
        this.token = sessionStorage.getItem('token')
        this.name = sessionStorage.getItem('name')
        this.email = sessionStorage.getItem('email')
        if (!this.token || this.token == '' || this.token == null) {
            this.cartStore.clearCart()
            router.push({ name: 'login' })
        }
        const script = document.createElement('script')
        script.src = 'https://app.sandbox.midtrans.com/snap/snap.js'
        script.setAttribute('data-client-key', 'Mid-client-2oG42zTZ57U3X2r4')
        document.head.appendChild(script)
    },
    computed: {
        cartItems() {
            return this.cartStore.cartItems
        },

        totalPrice() {
            return this.cartItems.reduce((sum, item) => sum + item.price * item.qty, 0)
        },
    },
    methods: {
        increaseQty(item) {
            this.cartStore.updateQty(item.id, item.qty + 1)
        },
        decreaseQty(item) {
            this.cartStore.updateQty(item.id, item.qty - 1)
            if (item.qty < 1) {
                this.cartStore.removeItem(item.id)
            }
        },
        deleteItemInCart(item) {
            this.cartStore.removeItem(item.id)
        },
        async payNow() {
            const checkOrder = sessionStorage.getItem('OrderID')
            if (checkOrder) {
                await Swal.fire({
                    icon: 'warning',
                    title: 'Pesanan Tertunda',
                    text: 'Mohon tunggu hingga pesanan sebelumnya selesai.',
                    confirmButtonText: 'OK',
                })
                return
            }

            try {
                const itemDetails = this.cartItems.map((item) => ({
                    id: item.id,
                    price: item.price,
                    quantity: item.qty,
                    name: item.name,
                }))

                const response = await axios.post('http://127.0.0.1:8000/api/midtrans/token', {
                    total: this.totalPrice,
                    items: itemDetails,
                    name: this.name,
                    email: this.email,
                    phone: this.phone,
                    address: this.address,
                    city: this.city,
                })

                const snapToken = response.data.snap_token

                window.snap.pay(snapToken, {
                    onSuccess: async (result) => {
                        try {
                            await axios.post(
                                'http://127.0.0.1:8000/api/nusantara/order',
                                {
                                    city: this.city,
                                    address: this.address,
                                    phone: this.phone,
                                    total: this.totalPrice,
                                    transaction_id: result.transaction_id,
                                    gross_amount: result.gross_amount,
                                    order_id: result.order_id,
                                    items: itemDetails,
                                },
                                {
                                    headers: {
                                        Authorization: `Bearer ${sessionStorage.getItem('token')}`,
                                    },
                                },
                            )

                            await Swal.fire({
                                title: 'Payment Successful',
                                text: 'Thank you for your order! Your delicious meal is on its way.',
                                icon: 'success',
                                confirmButtonText: 'View My Order',
                            })

                            sessionStorage.setItem('OrderID', result.order_id)
                            this.cartStore.clearCart()
                            window.location.href = '/order'
                        } catch (error) {
                            console.error(error)
                        }
                    },

                    onPending(result) {
                        alert('Menunggu pembayaran.')
                        console.log(result)
                    },

                    onError(result) {
                        alert('Pembayaran gagal.')
                        console.log(result)
                    },

                    onClose: async () => {
                        await Swal.fire({
                            title: 'Pembayaran Dibatalkan',
                            text: 'Anda telah membatalkan proses pembayaran.',
                            icon: 'warning',
                            confirmButtonText: 'Kembali ke Keranjang',
                        })
                    },
                })
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors
                } else {
                    console.error(error)
                }
            }
        },
    },
}
</script>
<style scoped>
.fixed-img {
    width: 200px;
    height: 200px;
    object-fit: cover;
}
</style>
