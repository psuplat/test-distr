import Vue from "vue";
import Router from "vue-router";
import Login from "./views/Login.vue";
import Page404 from "./views/404.vue";

Vue.use(Router);

export default new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes: [
    {
      path: "/",
      name: "Login",
      component: Login
    },
    {
      path: "*",
      name: "Error 404 - Page Missing",
      component: Page404
    }
  ]
});
