window.Vue = require("vue");

Vue.component("customers", require("./components/customers.vue").default);

const app = new Vue({
    el: "#app",
    data: {}
});
