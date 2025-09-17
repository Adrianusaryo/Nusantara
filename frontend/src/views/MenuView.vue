<template>
    <div>
        <NavBar :name="name" />
        <div class="container my-4">
            <!-- Header -->
            <div class="text-center mb-4">
                <h2 class="text-success fw-bold">Nusantara Taste</h2>
                <h6 class="text-muted fst-italic">Savor the essence of Indonesia</h6>
                <!-- <hr class="w-50 mx-auto my-3" /> -->
            </div>

            <div
                class="toast align-items-center text-white bg-success border-0 position-fixed bottom-0 end-0 mb-4 me-4 shadow"
                style="width: 360px; z-index: 99"
                role="alert"
                aria-live="assertive"
                aria-atomic="true"
                ref="toast"
            >
                <div class="d-flex">
                    <div class="toast-body small">{{ toastMessage }}</div>
                    <button
                        type="button"
                        class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast"
                        aria-label="Close"
                    ></button>
                </div>
            </div>

            <!-- Loading State -->
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
                <p class="text-success fw-semibold mb-0 fs-5">Loading the menu...</p>
                <small class="text-muted fst-italic"
                    >Good things take time — tasty things even more!</small
                >
            </div>

            <!-- Menu Content -->
            <div v-else>
                <!-- Category Tabs -->
                <ul class="nav nav-tabs justify-content-center mb-4 border-2">
                    <li v-for="(category, index) in CategoryList" class="nav-item" :key="index">
                        <button
                            class="nav-link fw-semibold"
                            :class="activeTab === index ? 'active text-success' : 'text-success'"
                            :id="`tab-${index}`"
                            data-bs-toggle="tab"
                            :data-bs-target="`#pane-${index}`"
                            type="button"
                            role="tab"
                            :aria-controls="`pane-${index}`"
                            :aria-selected="activeTab === index ? 'true' : 'false'"
                            @click="setActiveTab(index)"
                        >
                            {{ typeof category === 'string' ? category : category.name }}
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    <div
                        v-for="(category, index) in CategoryList"
                        :key="index"
                        class="tab-pane fade"
                        :class="{ show: index === 0, active: index === 0 }"
                        :id="`pane-${index}`"
                        role="tabpanel"
                    >
                        <div class="row g-4">
                            <!-- Menu Card -->
                            <div
                                class="col-md-3"
                                v-for="menu in paginatedMenus(
                                    filteredMenus(
                                        typeof category === 'string' ? category : category.name,
                                    ),
                                )"
                                :key="menu.id"
                            >
                                <div
                                    class="card border-0 shadow-sm rounded-4 h-100 text-center hover-shadow"
                                >
                                    <img
                                        v-if="menu.image"
                                        :src="url + menu.image"
                                        class="card-img-top rounded-circle bg-light mx-auto p-2 mt-3 border border-success fixed-img"
                                        alt="..."
                                    />
                                    <img
                                        v-else
                                        src="@/assets/image/null.png"
                                        class="card-img-top rounded-circle bg-light mx-auto p-2 border border-success fixed-img"
                                        alt="..."
                                    />

                                    <div class="card-body">
                                        <h5 class="fw-bold text-dark">{{ menu.name }}</h5>
                                        <p class="text-success fw-semibold fst-italic small mb-1">
                                            {{ menu.category?.category_name || 'Uncategorized' }}
                                        </p>

                                        <p class="text-muted small">{{ menu.desc }}</p>
                                        <p class="fw-bold text-dark fs-6">
                                            Rp {{ formatPrice(menu.price) }}
                                        </p>
                                        <button
                                            class="btn btn-success btn-sm rounded-pill px-4 py-2 mt-2"
                                            @click="addToCart(menu)"
                                        >
                                            <i class="fa fa-basket-shopping me-2"></i> Order Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <nav>
                                <ul class="pagination gap-2 flex-wrap">
                                    <li>
                                        <button
                                            class="btn btn-light border-success text-success rounded-circle shadow-sm hover-success"
                                            style="width: 40px; height: 40px"
                                            @click="currentPage--"
                                            :disabled="currentPage === 1"
                                        >
                                            <i class="fa fa-chevron-left"></i>
                                        </button>
                                    </li>

                                    <li
                                        v-for="page in totalPages(
                                            filteredMenus(
                                                typeof category === 'string'
                                                    ? category
                                                    : category.name,
                                            ),
                                        )"
                                        :key="page"
                                    >
                                        <button
                                            class="btn fw-semibold rounded-circle shadow-sm"
                                            style="width: 40px; height: 40px"
                                            :class="
                                                currentPage === page
                                                    ? 'btn-success text-white'
                                                    : 'btn-outline-success'
                                            "
                                            @click="currentPage = page"
                                        >
                                            {{ page }}
                                        </button>
                                    </li>

                                    <li>
                                        <button
                                            class="btn btn-light border-success text-success rounded-circle shadow-sm hover-success"
                                            style="width: 40px; height: 40px"
                                            @click="currentPage++"
                                            :disabled="
                                                currentPage ===
                                                totalPages(
                                                    filteredMenus(
                                                        typeof category === 'string'
                                                            ? category
                                                            : category.name,
                                                    ),
                                                )
                                            "
                                        >
                                            <i class="fa fa-chevron-right"></i>
                                        </button>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Footer />
</template>
<script>
import NavBar from '@/components/NavBar.vue'
import router from '@/router'
import Footer from '@/components/Footer.vue'
import { userOrderStore } from '@/stores/orderStore'

export default {
    components: {
        NavBar,
        Footer,
    },
    data() {
        return {
            name: '',
            orderStore: userOrderStore(),
            url: 'https://nusantara.up.railway.app/storage/',
            toastMessage: '',
            isLoading: false,
            currentPage: 1,
            itemsPerPage: 8,
            activeTab: 0,
        }
    },
    mounted() {
        this.name = sessionStorage.getItem('name')
        this.token = sessionStorage.getItem('token')
        if (!this.token || this.token == '' || this.token == null) {
            router.push({ name: 'login' })
        }
    },

    computed: {
        CategoryList() {
            const categoryMap = new Map()

            this.orderStore.menus.forEach((item) => {
                const category = item.category
                if (category && !categoryMap.has(category.id)) {
                    categoryMap.set(category.id, {
                        id: category.id,
                        name: category.category_name,
                    })
                }
            })

            return ['Nusantara', ...Array.from(categoryMap.values())]
        },

        AllMenus() {
            return this.orderStore.menus
        },

        paginatedMenus() {
            return (menus) => {
                const start = (this.currentPage - 1) * this.itemsPerPage
                const end = start + this.itemsPerPage
                return menus.slice(start, end)
            }
        },

        totalPages() {
            return (menus) => Math.ceil(menus.length / this.itemsPerPage)
        },
    },
    created() {
        this.isLoading = true
        this.orderStore
            .getMenu()
            .then(() => {
                this.isLoading = false
            })
            .catch(() => {
                this.isLoading = false
            })
    },
    methods: {
        filteredMenus(categoryName) {
            if (categoryName === 'Nusantara') return this.AllMenus
            return this.AllMenus.filter(
                (menu) => menu.category.category_name.trim() === categoryName,
            )
        },
        formatPrice(value) {
            return new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
                useGrouping: true,
            }).format(value)
        },
        addToCart(item) {
            this.orderStore.addItemToCart(item)
            this.toastMessage = `${item.name} has been added to the cart !`

            const toastEl = this.$refs.toast
            const toast = new bootstrap.Toast(toastEl)
            toast.show()
        },
        setActiveTab(index) {
            this.activeTab = index
            this.currentPage = 1
        },
    },
}
</script>
<style scoped>
.fixed-img {
    width: 150px;
    height: 150px;
    object-fit: cover;
}

.hover-success:hover {
    background-color: #198754 !important;
    color: #fff !important;
}
</style>
