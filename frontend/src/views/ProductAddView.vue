<template>
    <navbar :name="name" :role="roleId" />
    <h3 class="text-center my-3">Add New Product</h3>
    <form @submit.prevent="createProduct()">
        <div class="container my-2">
            <div
                v-if="successMessage"
                class="alert alert-success alert-dismissible fade-show"
                role="alert"
            >
                {{ successMessage }}
                <button type="button" class="btn-close" @click="successMessage = ''"></button>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="" class="mb-1">Name</label>
                    <input
                        type="text"
                        v-model="product_name"
                        class="form-control"
                        placeholder="Product Name"
                        :class="{ 'is-invalid': errors.name }"
                    />
                    <div v-if="errors.name" class="invalid-feedback">
                        {{ errors.name[0] }}
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="price" class="mb-1">Price</label>
                    <input
                        type="number"
                        v-model="product_price"
                        class="form-control"
                        placeholder="Product Price"
                        :class="{ 'is-invalid': errors.price }"
                    />
                    <div v-if="errors.price" class="invalid-feedback">
                        {{ errors.price[0] }}
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="" class="mb-1">Food Image</label>
                    <input type="file" class="form-control" @change="imageSave($event)" />
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-success my-3 form-control">Submit</button>
            </div>
        </div>
    </form>
</template>
<script>
import navbar from '@/components/NavBar.vue'
import router from '@/router'
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
            url: 'https://nusantara.up.railway.app/storage/items/',
            product_name: '',
            product_price: '',
            errors: {},
            successMessage: '',
            file: '',
        }
    },
    mounted() {
        this.token = sessionStorage.getItem('token')
        this.roleId = sessionStorage.getItem('role_id')
        this.name = sessionStorage.getItem('name')
    },
    methods: {
        createProduct() {
            let formData = new FormData()
            formData.append('name', this.product_name)
            formData.append('price', this.product_price)
            formData.append('image_file', this.file)

            axios
                .post('https://nusantara.up.railway.app/api/item', formData, {
                    headers: {
                        Authorization: `Bearer ${sessionStorage.getItem('token')}`,
                        'Content-Type': 'multipart/form-data',
                    },
                })
                .then((response) => {
                    sessionStorage.setItem('successMessage', 'Product Added Successfully')
                    this.$router.push('/product')
                })
                .catch((error) => {
                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        imageSave(e) {
            let file = e.target.files[0]
            this.file = file
        },
        resetForm() {
            this.product_name = ''
            this.product_price = ''
            this.product_image = null
            this.errors = {}
        },
    },
}
</script>
<style lang=""></style>
