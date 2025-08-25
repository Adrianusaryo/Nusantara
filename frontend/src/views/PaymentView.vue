<template>
    <div>
        <NavBar :name="name" />

        <div class="container my-5 d-flex justify-content-center">
            <div class="card shadow-sm" style="width: 100%; max-width: 500px">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">Form Pembayaran</h5>

                    <form @submit.prevent="submitPayment">
                        <!-- Alamat -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Pengiriman</label>
                            <textarea
                                id="alamat"
                                v-model="alamat"
                                class="form-control"
                                rows="3"
                                required
                                placeholder="Masukkan alamat lengkap"
                            ></textarea>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="mb-3">
                            <label for="payment" class="form-label">Metode Pembayaran</label>
                            <select id="payment" v-model="metode" class="form-select" required>
                                <option disabled value="">Pilih metode pembayaran</option>
                                <option value="midtrans">Midtrans</option>
                                <option value="cod">Cash on Delivery</option>
                            </select>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Bayar Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <Footer />
    </div>
</template>

<script>
import NavBar from '@/components/NavBar.vue'
import Footer from '@/components/Footer.vue'
import router from '@/router'

export default {
    components: {
        NavBar,
        Footer,
    },
    data() {
        return {
            name: '',
            token: '',
            alamat: '',
            metode: '',
        }
    },
    mounted() {
        this.name = sessionStorage.getItem('name')
        this.token = sessionStorage.getItem('token')
        if (!this.token) {
            router.push({ name: 'login' })
        }
    },
    methods: {
        submitPayment() {
            if (!this.alamat || !this.metode) return

            // Simulasi submit, nanti bisa dipakai untuk Midtrans
            alert(`Pembayaran dengan metode ${this.metode} akan diproses.\nAlamat: ${this.alamat}`)

            // TODO: Integrasi dengan Midtrans Snap atau API di sini
        },
    },
}
</script>

<style scoped></style>
