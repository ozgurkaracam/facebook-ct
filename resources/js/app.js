import store from "./store";
import VueSweetalert2 from "vue-sweetalert2";
import 'sweetalert2/dist/sweetalert2.min.css';
require('./bootstrap');

require('alpinejs');
import {createApp} from 'vue';
import App from "./components/App";
import router from "./router";


var app=createApp(App)
app.use(router)
app.use(store)
app.use(VueSweetalert2)
app.mount('#app');
