<template>
    <q-card flat bordered>

        <q-card-section class="bg-blue-grey-14 text-white q-pb-lg">


            <strong class="font-16">Invoices List</strong>
        </q-card-section>

        <q-card-section>

            <q-table
                :rows="items"
                row-key="id"
                :columns="item_columns"
                color="indigo"
                table-header-class="text-indigo"
                :loading="loading_get"
            >
                <template v-slot:loading>
                    <Global_Loading></Global_Loading>
                </template>

                <template v-slot:body-cell-id="props">

                    <q-td :props="props">
                        <strong>
                            {{props.row.id}}
                        </strong>
                    </q-td>
                </template>

                <template v-slot:body-cell-is_pay="props">
                    <q-td :props="props">
                        <q-btn @click="ChangePayment(props.row.id)" push glossy v-if="props.row.is_pay" color="positive" title="invoice is paid success" icon="mdi-check" size="sm">
                            Paid
                        </q-btn>
                        <q-btn @click="ChangePayment(props.row.id)" push glossy v-else color="negative" title="invoice is unpaid" icon="mdi-close" size="sm" >
                            Unpaid
                        </q-btn>
                    </q-td>
                </template>
                <template v-slot:body-cell-price="props">
                    <q-td :props="props">
                        <strong class="font-14 text-green-7">
                            {{this.$filters.numbers(props.row.price)}}
                        </strong>
                    </q-td>
                </template>
                <template v-slot:body-cell-method="props">
                    <q-td :props="props">
                        <q-badge color="primary">
                            {{props.row.method}}
                        </q-badge>
                    </q-td>
                </template>

                <template v-slot:body-cell-tools="props">
                    <q-td :props="props">
                        <q-btn @click="dialog_edit[props.row.id] = true;errors=[];edit_file=null" glossy color="primary" size="sm" icon="mdi-pen" class="q-mx-xs">
                            <q-tooltip class="bg-grey-9">Edit this item</q-tooltip>
                        </q-btn>
                        <q-btn @click="DeleteItem(props.row.id)" glossy color="red-9" size="sm" icon="mdi-delete" class="q-mx-xs">
                            <q-tooltip class="bg-grey-9">Delete this item</q-tooltip>
                        </q-btn>
                    </q-td>
                </template>

            </q-table>

        </q-card-section>


    </q-card>

</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "Manage_Invoices",
    created() {
        this.GetItems();

    },
    data(){
        return{
            items:[],
            loading_get:true,
            loading_add:false,
            errors:[],
            dialog_add:false,
            dialog_edit:[],
            edit_file:null,
            add:{
                name:null,
                subtitle:null,
                price:null,
                sale:null,
                description:null,
                image:null,
                file:null,
            },
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
                    name:'code',
                    required: true,
                    label: 'Code',
                    align: 'left',
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
                    label: 'Paid',
                    align: 'left',
                    field: row => row.is_pay,
                    sortable: true
                },
                {
                    name:'paid_at',
                    required: true,
                    label: 'Paid at',
                    align: 'left',
                    field: row => row.paid_at,
                    sortable: true
                },
                {
                    name:'ref_id',
                    required: true,
                    label: 'Ref ID',
                    align: 'left',
                    field: row => row.ref_id,
                },
                {
                    name:'gateway',
                    required: true,
                    label: 'Gateway',
                    align: 'left',
                    field: row => row.gateway,
                },
                {
                    name:'method',
                    required: true,
                    label: 'Method',
                    align: 'left',
                    field: row => row.method,
                },
                {
                    name:'tools',
                    required: true,
                    label: 'Tools',
                    align: 'left',


                },

            ]
        }
    },
    methods:{
        ...mapActions([
            "InvoicesIndex",
            "InvoicesChangePay"

        ]),
        GetItems(){

            this.InvoicesIndex().then(res => {
                this.items = res.data.result;
                this.loading_get=false;
            }).catch(error => {
                this.NotifyServerError();
            });
        },
        AddItem(){
            if(this.add.image){
                if (this.add.image.type !== 'image/png' && this.add.image.type !== 'image/jpeg'){
                    return this.NotifyError('this file is not valid image')
                }
            }
            this.loading_add=true;
            this.EpisodesStore(this.add).then(res => {
                this.items.unshift(res.data.result);
                this.loading_add=false;
                this.dialog_add=false;
                this.add={};
                return this.NotifyCreate();
            }).catch(error => {
                this.loading_add=false;
                if (error.response.status === 422) {
                    return this.errors = error.response.data
                }
                return  this.NotifyServerError();

            })
        },
        EditItem(item){
            this.loading_add=true;
            if (this.edit_file){
                item.file = this.edit_file;
            }else {
                item.file = null;
            }
            this.EpisodesEdit(item).then(res => {
                this.loading_add=false;
                this.items = this.items.filter(item_get =>{
                    if (item_get.id === item.id){
                        item_get=res.data.result
                    }
                    return item_get;
                })
                this.dialog_edit[item.id]=false;
                return this.NotifyUpdate();
            }).catch(error => {
                this.loading_add=false;
                if (error.response.status === 422) {
                    return this.errors = error.response.data
                }
                return  this.NotifyServerError();

            })
        },
        DeleteItem (id) {
            this.$q.dialog({
                title: 'Confirm',
                message: 'Are you sure to delete this item?',

                ok: {
                    push: true,
                    color:'green-9',
                },
                cancel: {
                    push: true,
                    color: 'negative'
                },
                persistent: true
            }).onOk(() => {
                this.EpisodesDelete(id).then(res => {
                    this.items = this.items.filter(item =>{
                        return item.id !== id;
                    })
                    return this.NotifyDelete();
                }).catch(error => {
                    return  this.NotifyServerError();
                })

            }).onCancel(() => {
                // console.log('>>>> Cancel')
            }).onDismiss(() => {
                // console.log('I am triggered on both OK and Cancel')
            })
        },
        ChangePayment (id) {
            this.$q.dialog({
                title: 'Confirm',
                message: 'Are you sure you want to change the payment status of the invoice?',

                ok: {
                    push: true,
                    color:'green-9',
                },
                cancel: {
                    push: true,
                    color: 'negative'
                },
                persistent: true
            }).onOk(() => {
                this.InvoicesChangePay(id).then(res => {
                    this.items = this.items.filter(item =>{
                        if (item.id === id){
                            item = res.data.result;
                            item.is_pay = !item.is_pay;
                        }
                        return item
                    })
                    return this.NotifyDelete();
                }).catch(error => {
                    return  this.NotifyServerError();
                })

            }).onCancel(() => {
                // console.log('>>>> Cancel')
            }).onDismiss(() => {
                // console.log('I am triggered on both OK and Cancel')
            })
        },
        ChangeStatus(id){
            this.EpisodesChangeStatus(id).then(res => {
                return this.NotifySuccess('Account status change successful');
            }).catch(error => {
                return this.NotifyServerError();
            })
        },

        DownloadFile(link,file=null,name=null) {

            var ex=this.MixinFileExtension(file);
            axios({
                url: link,
                method: 'GET',
                responseType: 'blob',
            }).then((response) => {
                var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                var fileLink = document.createElement('a');

                fileLink.href = fileURL;
                fileLink.setAttribute('download', name+"."+ex);
                document.body.appendChild(fileLink);

                fileLink.click();
            });
        }

    }
}
</script>

<style scoped>

</style>
