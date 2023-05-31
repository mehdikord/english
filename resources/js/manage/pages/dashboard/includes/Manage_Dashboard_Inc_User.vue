<template>
    <div class="row">
        <div class="col-12 q-pa-md">
            <q-card  bordered>
                <q-card-section class="bg-teal text-white">
                    <div class="text-h6">Latest users</div>
                </q-card-section>
                <q-table
                    :rows="items"
                    row-key="id"
                    :columns="item_columns"
                    color="indigo"
                    table-header-class="text-indigo"
                    :loading="loading_get"
                >
                    <template v-slot:body-cell-name="props">
                        <q-td :props="props">
                            <q-avatar >
                                <img src="/assets/images/default/user.png" alt="">
                            </q-avatar>
                            <strong class="q-ml-sm">
                                {{props.row.name}}
                            </strong>
                        </q-td>
                    </template>
                    <template v-slot:body-cell-phone="props">
                        <q-td :props="props">
                            <div v-if="props.row.phone">
                                <q-chip color="warning" class="font-12">{{props.row.phone}}</q-chip>
                            </div>
                        </q-td>
                    </template>
                </q-table>

            </q-card>
        </div>
    </div>
</template>

<script>
export default {
    name: "Manage_Dashboard_Inc_User",
    created() {
      this.GetUsers();

    },
    data(){
        return {
            items:[],
            loading_get:true,
            item_columns:[
                {
                    name:'id',
                    required: true,
                    label: 'ID',
                    align: 'left',
                    field: row => row.id,
                    sortable: true
                },
                {
                    name:'name',
                    required: true,
                    label: 'Name',
                    align: 'left',
                    field: row => row.name,
                    sortable: true
                },
                {
                    name:'email',
                    required: true,
                    label: 'Email',
                    align: 'left',
                    field: row => row.email,
                    sortable: true
                },
                {
                    name:'phone',
                    required: true,
                    label: 'Phone',
                    align: 'left',
                    field: row => row.phone,
                    sortable: true
                },
            ]

        }
    },
    methods:{
        GetUsers(){
            axios.get('dashboard/latest/users').then(res => {
                this.loading_get = false;
                this.items = res.data.result;
            }).catch(e => {
                this.loading_get=false;
                return this.NotifyServerError();
            })

        }
    }

}
</script>

<style scoped>

</style>
