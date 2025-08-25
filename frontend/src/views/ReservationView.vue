<template>
    <NavBar :name="name" />
    <div class="container">
        <div class="row d-flex justify-content-center mt-4 gap-3">
            <div
                class="col-md-3 shadow-sm d-flex justify-content-center bg-body-tertiary align-items-center rounded"
            >
                <div class="d-flex flex-column gap-3">
                    <i
                        class="fa fa-calendar-days text-center text-success"
                        style="font-size: 3.5rem"
                    ></i>
                    <span class="text-center fs-6 fw-semibold text-success"
                        >07.00am To 10.00pm</span
                    >
                </div>
            </div>
            <div
                class="col-md-3 shadow-sm d-flex justify-content-center bg-body-tertiary align-items-center rounded"
            >
                <div class="d-flex flex-column gap-3">
                    <i
                        class="fa fa-phone-volume text-center text-success"
                        style="font-size: 3.5rem"
                    ></i>
                    <span class="text-center fs-6 fw-semibold text-success">+0818 0817 2250</span>
                </div>
            </div>
            <div
                class="col-md-3 shadow-sm d-flex justify-content-center bg-body-tertiary align-items-center py-5 rounded"
            >
                <div class="d-flex flex-column gap-3">
                    <i
                        class="fa fa-location-pin-lock text-center text-success"
                        style="font-size: 3.5rem"
                    ></i>
                    <span class="text-center fs-6 fw-semibold text-success"
                        >Jl. Plumpang Semper No.34A, RT.2/RW.3</span
                    >
                </div>
            </div>
        </div>

        <h3 class="text-center text-success fw-bold mt-3">Reservation Nusantara</h3>
        <div class="row mt-3 mb-5 p-3 bg-body-tertiary shadow-sm rounded">
            <div class="col-md-6">
                <label for="" class="form-label fw-semibold text-success">Full Name</label>
                <input type="text" class="form-control" placeholder="Edbert Chandra" />
            </div>
            <div class="col-md-6">
                <label for="" class="form-label fw-semibold text-success">Phone Number</label>
                <input type="text" class="form-control" placeholder="+62 851-5518-9905" />
            </div>
            <div class="col-md-6 pt-3">
                <label for="" class="form-label fw-semibold text-success">Reservation Date</label>
                <input type="date" class="form-control" value="2003-01-31" />
            </div>
            <div class="col-md-6 pt-3">
                <label for="" class="form-label fw-semibold text-success">Reservation Time</label>
                <input type="time" class="form-control" value="13:30" />
            </div>
            <div class="col-md-6 pt-3">
                <label for="" class="form-label fw-semibold text-success">Note</label>
                <textarea
                    class="form-control"
                    id="exampleFormControlTextarea1"
                    rows="3"
                    placeholder="Add a note (optional)"
                ></textarea>
                <button class="btn btn-outline-success mt-3 w-25">Book Now</button>
            </div>
            <div class="col-md-6 pt-3">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.417538753105!2d106.7808361735541!3d-6.208529460812258!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f6c544512257%3A0x116bbad595e631c2!2sRAMA%20MOTOR!5e0!3m2!1sid!2sid!4v1745139161023!5m2!1sid!2sid"
                    width="520"
                    height="300"
                    style="border: 0; border-radius: 20px"
                    class="shadow"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
            </div>
        </div>
    </div>
    <Footer />
</template>
<script>
import NavBar from '@/components/NavBar.vue'
import router from '@/router'
import Footer from '@/components/Footer.vue'
export default {
    components: {
        NavBar,
        Footer,
    },
    data() {
        return {
            name: '',
            token: '',
            role: '',
        }
    },
    mounted() {
        this.name = sessionStorage.getItem('name')
        this.role = sessionStorage.getItem('role_id')
        this.token = sessionStorage.getItem('token')
    },
}
</script>
<style></style>
