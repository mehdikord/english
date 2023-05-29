<template>
    <div class="row">
        <div class="col-12">
            <Dashboard_Count></Dashboard_Count>

        </div>


    </div>



</template>

<script>
import Manage_Dashboard_Inc_Count from "./includes/Manage_Dashboard_Inc_Count.vue";

export default {
    name: "Manage_Dashboard",
    components : {
        "Dashboard_Count" : Manage_Dashboard_Inc_Count,
    }
}
</script>

<style scoped>

</style>
