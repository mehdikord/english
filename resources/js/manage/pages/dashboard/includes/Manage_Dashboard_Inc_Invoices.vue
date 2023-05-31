<template>
    <div class="row">
        <div class="col-12 q-pa-md">
            <q-card  bordered>
                <q-card-section class="bg-purple text-white">
                    <div class="text-h6">Latest invoices</div>
                </q-card-section>
                <q-table
                    :rows="items"
                    row-key="id"
                    :columns="item_columns"
                    color="indigo"
                    table-header-class="text-indigo"
                    :loading="loading_get"
                >
                    <template v-slot:body-cell-user="props">
                        <q-td :props="props">
                            <q-avatar >
                                <img src="/assets/images/default/user.png" alt="">
                            </q-avatar>
                            <strong class="q-ml-sm">
                                {{props.row.user.name}}
                            </strong>
                        </q-td>
                    </template>
                    <template v-slot:body-cell-price="props">
                        <q-td :props="props">
                            <strong class="font-14 text-green-7">
                                {{this.$filters.numbers(props.row.price)}}
                            </strong>
                        </q-td>
                    </template>
                    <template v-slot:body-cell-is_pay="props">
                        <q-td :props="props">
                           <q-chip v-if="props.row.is_pay" color="green" icon-right="mdi-check" text-color="white" size="md">paid</q-chip>
                           <q-chip v-else color="negative" icon-right="mdi-close" text-color="white" size="md">unpaid</q-chip>
                        </q-td>
                    </template>
                </q-table>


            </q-card>
        </div>
    </div>
</template>

<script>
export default {
    name: "Manage_Dashboard_Inc_Invoices",
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
                    name:'user',
                    required: true,
                    label: 'User',
                    align: 'left',
                    field: row => row.user.name,
                    sortable: true
                },
                {
                    name:'title',
                    required: true,
                    label: 'Title',
                    align: 'left',
                    field: row => row.title,
                    sortable: true
                },

                {
                    name:'price',
                    required: true,
                    label: 'Price',
                    align: 'left',
                    field: row => row.price,
                    sortable: true
                },
                {
                    name:'is_pay',
                    required: true,
                    label: 'Status',
                    align: 'left',
                    field: row => row.is_pay,
                    sortable: true
                },
            ]

        }
    },
    methods:{
        GetUsers(){
            axios.get('dashboard/latest/invoices').then(res => {
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
