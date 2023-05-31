<template>
    <div class="row">
        <div class="col-12">
            <Dashboard_Count></Dashboard_Count>
        </div>
        <div class="col-lg-6 col-12 q-mt-sm">
            <Dashboard_User></Dashboard_User>
        </div>
        <div class="col-lg-6 col-12 q-mt-sm">
            <Dashboard_Invoices></Dashboard_Invoices>
        </div>

    </div>



</template>

<script>
import Manage_Dashboard_Inc_Count from "./includes/Manage_Dashboard_Inc_Count.vue";
import Manage_Dashboard_Inc_User from "./includes/Manage_Dashboard_Inc_User.vue";
import Manage_Dashboard_Inc_Invoices from "./includes/Manage_Dashboard_Inc_Invoices.vue";

export default {
    name: "Manage_Dashboard",
    components : {
        "Dashboard_Count" : Manage_Dashboard_Inc_Count,
        "Dashboard_User" : Manage_Dashboard_Inc_User,
        "Dashboard_Invoices" : Manage_Dashboard_Inc_Invoices,
    }
}
</script>

<style scoped>

</style>
