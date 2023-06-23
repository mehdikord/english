import {createStore} from "vuex";
import managers from "./modules/users/managers";
import members from "./modules/users/members";
import faqs from "./modules/faqs/faqs"
import episodes from "./modules/episodes/episodes"
import invoices from "./modules/invoices/invoices"
import configs from "./modules/configs/configs"
import packs from "./modules/packs/packs"
import helpers from "./modules/helpers/helpers"
const store = createStore({
    state(){
        return {
            Auth_Manage : [],

        }
    },

    modules:{
        managers,
        members,
        faqs,
        episodes,
        invoices,
        helpers,
        configs,
        packs


    },

    mutations : {
        AuthManageLogin(state,item){
            state.Auth_Manage = item
            localStorage.setItem('manage_auth_token',item.access_token)
            localStorage.setItem('manage_auth_user',JSON.stringify(item.user))
        },
        AuthLogout(state){
            state.AAuth_Manageuth = {}
            localStorage.removeItem('manage_auth_token')
            localStorage.removeItem('manage_auth_user')
        },
        AuthManageSync(state){
            if (localStorage.getItem('manage_auth_token') && localStorage.getItem('manage_auth_user')){
                var item;
                item = {
                    token : localStorage.getItem('manage_auth_token'),
                    user : JSON.parse(localStorage.getItem('manage_auth_user')),
                }
                state.Auth_Manage = item
            }
        }
    },
    getters : {
        AuthManageCheck : state => {
            return !!state.Auth_Manage.token;
        },
        AuthManageUser : state => {
            return state.Auth_Manage.user;
        },
        AutManageToken : state => {
            return state.Auth_Manage.token;
        },

    },
    actions : {
        Auth_Manage_Login(state,item){
            state.commit('AuthManageLogin',item)
        },
        Auth_Manage_Logout(state){
            state.commit('AuthManageLogout')
        }
    }
});

export default store
