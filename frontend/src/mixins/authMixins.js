import NavBar from '@/components/NavBar.vue'

export default {
    components: {
        NavBar,
    },
    data() {
        return {
            name: '',
        }
    },
    mounted() {
        this.name = localStorage.getItem('name')
    },
}
