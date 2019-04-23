import Vue from "vue";
import './plugins/vuetify'
import App from "./App.vue";
import 'material-design-icons-iconfont/dist/material-design-icons.css'
Vue.config.devtools = true
//Vue.config.productionTip = false;

new Vue({
  render: h => h(App)
}).$mount("#welcome-panel");
