import './bootstrap';
import {createApp} from 'vue/dist/vue.esm-bundler.js';
import viewComponent from './components/viewComponent.vue'
import router from './router.js'
import swal from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css'

const app = createApp({
    components: {
        viewComponent
    }
})

app
.use(router)
.use(swal)
.mount("#app")
