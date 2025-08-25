<template>
    <navbar :name="name" />
    <div class="container">
        <div class="row d-flex min-vh-75 justify-content-center align-items-center">
            <div class="col-md-7 hero-left">
                <h4 class="text-success fw-bold" style="line-height: 0.9rem">
                    Welcome To Nusantara
                </h4>
                <h1 class="fw-semibold fst-italic">Original Taste Of Indonesia</h1>
                <p class="text-muted">
                    We Guarantee To Use Fresh Food With The Best Quality, Customers Will Enjoy
                    Indonesian Cuisine With Explosive, Sophistaceted Flavors
                </p>
                <RouterLink
                    class="btn btn-success px-3 py-2 w-25 fw-medium rounded-pill"
                    to="/menu"
                >
                    <i class="fa fa-bowl-food me-2"></i> Order Now
                </RouterLink>
            </div>
            <div class="col-md-5">
                <img src="@/assets/image/nasi-kuning.png" alt="" class="w-100" />
            </div>
        </div>
        <!-- <div class="mb-5 text-center">
            <h1 class="text-success fw-bold mb-4">Best Nusantara Food</h1>
        </div> -->
        <div class="row g-4 mb-5">
            <div class="col-md-2">
                <div class="category-card text-center">
                    <img src="@/assets/image/sate.png" class="rounded-circle w-75" alt="Sate" />
                    <span class="fw-medium fs-6 d-block">Sate Ayam</span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="category-card text-center">
                    <img
                        src="@/assets/image/gado.png"
                        class="rounded-circle w-75"
                        alt="Gado-Gado"
                    />
                    <span class="fw-medium fs-6">Gado-Gado</span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="category-card text-center">
                    <img src="@/assets/image/kondro.png" class="rounded-circle w-75" alt="Kondro" />
                    <span class="fw-medium fs-6 d-block">Sop Kondro</span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="category-card text-center">
                    <img
                        src="@/assets/image/rendang.png"
                        class="rounded-circle w-75"
                        alt="Rendang"
                    />
                    <span class="fw-medium fs-6">Rendang</span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="category-card text-center">
                    <img
                        src="@/assets/image/nasi-padang.png"
                        class="rounded-circle w-75"
                        alt="Rendang"
                    />
                    <span class="fw-medium fs-6">Nasi Padang</span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="category-card text-center">
                    <img
                        src="@/assets/image/mie-ayam.png"
                        class="rounded-circle w-75"
                        alt="Rendang"
                    />
                    <span class="fw-medium fs-6 d-block">Mie Ayam</span>
                </div>
            </div>
        </div>
        <div class="row mb-5 bg-body-tertiary rounded px-5">
            <div class="col-md-6">
                <img src="@/assets/image/paket.png" class="w-100" alt="" />
            </div>
            <div class="col-md-6">
                <h4 class="text-success fw-semibold mt-5 hero-tagline">
                    Experience the True Taste of Indonesia
                </h4>
                <p class="text-muted">
                    Nusantara is a vibrant archipelago rich in culture, tradition, and taste. With
                    thousands of islands, it offers a diverse culinary heritage rooted in bold
                    spices and authentic flavors. Every dish tells a story — from the smoky skewers
                    of Sate to the rich, savory depths of Rendang. This is the true taste of
                    Indonesia, where food is more than a meal — it’s a journey through islands and
                    history.
                </p>
                <button class="btn btn-success fw-medium rounded-pill w-25">Read More</button>
            </div>
        </div>
    </div>
    <Footer />
</template>
<script>
import navbar from '@/components/NavBar.vue'
import Footer from '@/components/Footer.vue'
export default {
    components: {
        navbar,
        Footer,
    },
    data() {
        return {
            name: '',
        }
    },
    mounted() {
        this.name = sessionStorage.getItem('name')
    },
}
</script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

.hero-tagline {
    font-family: 'Poppins', sans-serif;
}
.hero-about .hero-left {
    padding-left: 70px;
}

.category-card {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 5px;
    transition: all 0.3s ease-in-out;
}

.category-card:hover {
    background-color: #00985b;
    transform: scale(1.05);
}

.category-card:hover span {
    color: white;
}
</style>
