<template>
    <NavBar :name="name" :role="roleId" />
    <div class="container">
        <h3 class="my-3">Update Product</h3>
        <form @submit.prevent="updateProduct()">
            <div class="container my-2">
                <div class="row">
                    <div class="col-md-4">
                        <label for="" class="mb-1 fw-bold">Name</label>
                        <input class="form-control" type="text" v-model="items.name" />
                    </div>
                    <div class="col-md-4">
                        <label for="price" class="mb-1 fw-bold">Price</label>
                        <input class="form-control" type="number" v-model="items.price" />
                    </div>
                    <div class="col-md-4">
                        <label for="" class="mb-1 fw-bold">Food Image</label>
                        <input type="file" class="form-control" @change="imageChange($event)" />
                    </div>
                    <div class="mt-3">
                        <label for="" class="mb-1 fw-bold">Product Image</label><br />
                        <img
                            v-if="items.image"
                            class="img-thumbnail"
                            :src="url + items.image"
                            alt=""
                            style="width: 200px; height: 200px; object-fit: cover"
                        />
                        <img
                            v-else
                            class="img-thumbnail"
                            src="@/assets/image/null.png"
                            alt=""
                            style="width: 200px; height: 200px; object-fit: cover"
                        />
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-success my-3 form-control">Submit</button>
                </div>
            </div>
        </form>
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
            token: '',
            name: '',
            role: '',
            url: 'http://127.0.0.1:8000/storage/items/',
            productId: '',
            items: {},
        }
    },
    mounted() {
        this.productId = this.$route.params.productId
        this.token = sessionStorage.getItem('token')
        this.roleId = sessionStorage.getItem('role_id')
        this.name = sessionStorage.getItem('name')
        this.showItem()
    },
    methods: {
        showItem() {
            axios
                .get('http://127.0.0.1:8000/api/item/' + this.productId, {
                    headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                })
                .then((response) => {
                    this.items = response.data.data
                    console.log(this.url + this.items.image)
                })
                .catch(function (error) {
                    console.log(error)
                })
        },
        updateProduct() {
            let formData = new FormData()
            formData.append('name', this.items.name)
            formData.append('price', this.items.price)
            if (this.file) {
                formData.append('image_file', this.file)
            }
            formData.append('_method', 'patch')

            axios
                .post('http://127.0.0.1:8000/api/item/' + this.productId, formData, {
                    headers: {
                        Authorization: `Bearer ${sessionStorage.getItem('token')}`,
                        'Content-Type': 'multipart/form-data',
                    },
                })
                .then((response) => {
                    sessionStorage.setItem('successMessage', 'Product Has Been Updated')
                    this.$router.push('/product')
                })
                .catch((error) => {
                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        imageChange(e) {
            let file = e.target.files[0]
            this.file = file
        },
    },
}
</script>
<style lang=""></style>
