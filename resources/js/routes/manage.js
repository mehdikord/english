import { createRouter, createWebHistory } from "vue-router";
import Manage_Dashboard from "../manage/pages/dashboard/Manage_Dashboard.vue";
import Manage_Auth from "../manage/pages/auth/Manage_Auth.vue";
import store from "../store"
import Manage_Users_Managers from "@/manage/pages/users/Manage_Users_Managers.vue";
import Manage_Users_Members from "../manage/pages/users/Manage_Users_Members.vue";
import Manage_Faqs from "@/manage/pages/faqs/Manage_Faqs.vue";
import Manage_Episodes from "../manage/pages/episodes/Manage_Episodes.vue";
import Manage_Invoices from "../manage/pages/invoices/Manage_Invoices.vue";
import Manage_Configs from "../manage/pages/configs/Manage_Configs.vue";

const routes = [

    {
        path : "/management/login",
        name : "login",
        component : Manage_Auth,
        meta : { title : "Management Login"}
    },
    {
        path : "/management/dashboard",
        name : "dashboard",
        component : Manage_Dashboard,
        meta : { title : "Management Dashboard"}
    },
    {
        path : "/management/users/managers",
        name : "users_managers",
        component : Manage_Users_Managers,
        meta : { title : "Users Managers"}
    },
    {
        path : "/management/users/members",
        name : "users_members",
        component : Manage_Users_Members,
        meta : { title : "Users Members"}
    },
    {
        path : "/management/faqs",
        name : "faqs",
        component : Manage_Faqs,
        meta : { title : "Faqs"}
    },
    {
        path : "/management/episodes",
        name : "episodes",
        component : Manage_Episodes,
        meta : { title : "Episodes"}
    },
    {
        path : "/management/invoices",
        name : "invoices",
        component : Manage_Invoices,
        meta : { title : "Invoices"}
    },
    {
        path : "/management/configs",
        name : "configs",
        component : Manage_Configs,
        meta : { title : "Configs"}
    },

]


const router = createRouter({
    history: createWebHistory(),
    routes : routes

})

router.beforeEach((to, from, next) => {
    // trying to access a restricted page + not logged in
    // redirect to login page


    if (to.path !== '/management/login' && !store.getters.AuthManageCheck) {
        next('/management/login');
    }else if (to.path === '/management/login' && store.getters.AuthManageCheck){
        next('/management/dashboard');
    }
    else {
        next();
    }

});

export default router
