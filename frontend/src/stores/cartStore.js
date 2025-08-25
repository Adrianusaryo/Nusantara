import { defineStore } from 'pinia'

export const useCartStore = defineStore('cartStore', {
    state: () => ({
        cartItems: JSON.parse(localStorage.getItem('cartItems')) || [],
    }),
    actions: {
        addItem(item) {
            const items = this.cartItems.find((i) => i.id === item.id)
            if (items) {
                items.qty += 1
            } else {
                this.cartItems.push({
                    ...item,
                    qty: 1,
                })
            }
            localStorage.setItem('cartItems', JSON.stringify(this.cartItems))
        },
        removeItem(itemId) {
            const index = this.cartItems.findIndex((item) => item.id === itemId)
            if (index !== -1) {
                this.cartItems.splice(index, 1)
                localStorage.setItem('cartItems', JSON.stringify(this.cartItems))
            }
        },
        updateQty(id, qty) {
            const item = this.cartItems.find((item) => item.id === id)
            if (item) {
                item.qty = qty
            }
        },
        clearCart() {
            this.cartItems = []
            localStorage.setItem('cartItems', JSON.stringify(this.cartItems))
        },
    },
    getters: {
        total: (state) => state.cartItems.reduce((sum, item) => sum + item.qty, 0),
    },
})
