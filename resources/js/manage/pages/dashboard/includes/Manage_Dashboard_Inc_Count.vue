<template>
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12 q-pa-sm">
            <q-card v-if="items" class="bg-blue-8 text-white">
                <q-card-section>
                    <strong class="float-right font-32">{{items.admins}}</strong>

                    <div class="text-h6">System Administrator</div>

                    <div class="text-subtitle2 q-mt-sm">
                        system managers count
                    </div>
                </q-card-section>
                <q-card-actions>
                    <router-link :to="{name:'users_managers'}">
                    <q-btn glossy color="dark" class="w-100" >All managers</q-btn>
                    </router-link>
                </q-card-actions>
            </q-card>
            <Global_Loading v-else></Global_Loading>

        </div>
        <div class="col-md-4 col-sm-6 col-xs-12 q-pa-sm">
            <q-card v-if="items" class="bg-deep-orange text-white">
                <q-card-section>
                    <strong class="float-right font-32">{{items.users}}</strong>

                    <div class="text-h6">All Members</div>

                    <div class="text-subtitle2 q-mt-sm">
                        system members count
                    </div>
                </q-card-section>

                <q-card-actions>
                    <router-link :to="{name:'users_members'}">
                    <q-btn glossy color="dark" class="w-100" >Members management</q-btn>
                    </router-link>

                </q-card-actions>
            </q-card>
            <Global_Loading v-else></Global_Loading>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12 q-pa-sm">
            <q-card v-if="items" class="bg-green-7 text-white">
                <q-card-section>
                    <strong class="float-right font-32">{{items.episodes}}</strong>

                    <div class="text-h6">All Episodes</div>

                    <div class="text-subtitle2 q-mt-sm">
                        episodes count
                    </div>
                </q-card-section>

                <q-card-actions>
                    <router-link :to="{name:'episodes'}">
                    <q-btn  glossy color="dark" class="w-100" >Episodes management</q-btn>
                    </router-link>
                </q-card-actions>
            </q-card>
            <Global_Loading v-else></Global_Loading>

        </div>
    </div>
</template>

<script>
export default {
    name: "Manage_Dashboard_Inc_Count",
    created() {
      this.GetCounts();

    },
    data(){
        return {
            items:null,

        }
    },
    methods:{
        GetCounts(){
            axios.get('dashboard/counts').then(res => {
                this.items = res.data.result;
            }).catch(e => {
                return this.NotifyServerError();
            })

        }
    }

}
</script>

<style scoped>

</style>
