import { defineStore } from 'pinia'
import axios from 'axios'
import { useCartStore } from './cartStore'

export const userOrderStore = defineStore('orderStore', {
    state: () => ({
        menus: [],
        category: [],
    }),
    actions: {
        async getMenu() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/menu', {
                    headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                })
                this.menus = response.data.data
                this.category = this.menus
                    .map((item) => item.category)
                    .filter(
                        (value, index, self) =>
                            value && self.findIndex((v) => v.id === value.id) === index,
                    )
            } catch (error) {
                console.log(error)
            }
        },
        addItemToCart(item) {
            const cartStore = useCartStore()
            cartStore.addItem(item)
        },
    },
})
