<template>
    <navbar :name="name" :role="roleId" />
    <div class="container">
        <h2 class="my-3">Product List</h2>
        <div
            v-if="successMessage"
            class="alert alert-success alert-dismissible fade-show"
            role="alert"
        >
            {{ successMessage }}
            <button type="button" class="btn-close" @click="successMessage = ''"></button>
        </div>
        <div class="d-flex justify-content-end">
            <RouterLink class="btn btn-success mb-3" to="/product-add">
                <i class="fa fa-plus px-1"></i>Add Product</RouterLink
            >
        </div>
        <table class="table align-middle table-bordered">
            <thead class="table-dark fw-semibold">
                <tr class="text-center">
                    <th scope="col" style="width: 5%">No</th>
                    <th scope="col">Image</th>
                    <th scope="col" style="width: 15">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col" style="width: 15%">Action</th>
                </tr>
            </thead>
            <tbody v-for="(item, index) in items" :key="index">
                <tr class="text-center fw-medium">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>
                        <img
                            v-if="item.image"
                            class="rounded-circle"
                            :src="url + item.image"
                            alt=""
                            style="width: 120px; height: 120px; object-fit: cover"
                        />
                        <img
                            v-else
                            class="rounded-full"
                            src="@/assets/image/null.png"
                            alt=""
                            style="width: 150px; height: 150px; object-fit: cover"
                        />
                    </td>
                    <td>{{ item.name }}</td>
                    <td>Rp {{ formatPrice(item.price) }}</td>
                    <td>
                        <RouterLink
                            :to="{ name: 'productUpdate', params: { productId: item.id } }"
                            class="btn btn-warning mx-2"
                            ><i class="fa fa-pen-to-square"></i
                        ></RouterLink>
                        <button class="btn btn-danger" @click="deleteItem(item.id)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import router from '@/router'
import navbar from '@/components/NavBar.vue'
import axios from 'axios'
export default {
    components: {
        navbar,
    },
    data() {
        return {
            token: '',
            name: '',
            role: '',
            items: [],
            successMessage: '',
            productId: '',
            url: 'https://nusantara.up.railway.app/storage/items/',
        }
    },
    mounted() {
        this.token = sessionStorage.getItem('token')
        this.roleId = sessionStorage.getItem('role_id')
        this.name = sessionStorage.getItem('name')
        this.successMessage = sessionStorage.getItem('successMessage')
        sessionStorage.removeItem('successMessage')
        if (!this.token) {
            router.push({ name: 'login' })
        }
        console.log(this.productId)
        this.getItems()
    },
    methods: {
        getItems() {
            axios
                .get('https://nusantara.up.railway.app/api/item', {
                    headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                })
                .then((response) => {
                    this.items = response.data.data
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
        deleteItem(id) {
            axios
                .delete(`https://nusantara.up.railway.app/api/item/${id}`, {
                    headers: { Authorization: `Bearer ${this.token}` },
                })
                .then((response) => {
                    this.successMessage = 'Product Deleted Successfully'
                    this.getItems()
                })
                .catch((error) => {
                    console.error('Error Deleting Item', error)
                })
        },
    },
}
</script>
<style lang=""></style>
