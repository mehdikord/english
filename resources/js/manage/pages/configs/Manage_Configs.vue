<template>
    <q-card flat bordered>

        <q-card-section class="bg-blue-grey-14 text-white q-pb-lg">
            <q-btn @click="SetDefault" color="green-7" icon="mdi-refresh" push class="float-right" label="Reset Configs"></q-btn>

            <strong class="font-16">System Configs</strong>
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
                <template v-slot:body-cell-key="props">
                    <q-td :props="props">
                        <q-chip color="green-9" text-color="white">
                            {{props.row.conf_key}}
                        </q-chip>
                    </q-td>
                </template>
                <template v-slot:body-cell-value="props">
                    <q-td :props="props">
                        <q-chip color="red" text-color="white">
                            {{props.row.conf_val}}
                        </q-chip>
                    </q-td>
                </template>

                <template v-slot:body-cell-tools="props">
                    <q-td :props="props">
                        <q-btn @click="dialog_edit[props.row.id] = true;errors=[]" glossy color="primary" size="sm" icon="mdi-pen" class="q-mx-xs">
                            <q-tooltip class="bg-grey-9">Edit this item</q-tooltip>
                        </q-btn>

                    </q-td>
                    <q-dialog
                        v-model="dialog_edit[props.row.id]"
                        transition-show="scale"
                        transition-hide="scale"
                        position="top"
                    >
                        <q-card style="max-width: 700px;width: 700px">
                            <q-card-section class="bg-primary text-white">
                                <div class="text-h6">Edit item : {{props.row.conf_key}}</div>
                            </q-card-section>
                            <q-card-section >

                                <q-input v-model="props.row.conf_val"  lazy-rules type="text" outlined label="Value" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'conf_val')">
                                    <template v-slot:error>
                                        <Error_Validation :errors="this.MixinValidation(errors,'conf_val')"></Error_Validation>
                                    </template>
                                </q-input>

                                <q-input v-model="props.row.description"  lazy-rules type="textarea" outlined label="Description" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'description')">
                                    <template v-slot:error>
                                        <Error_Validation :errors="this.MixinValidation(errors,'description')"></Error_Validation>
                                    </template>
                                </q-input>

                            </q-card-section>

                            <q-card-actions align="right">
                                <q-btn  label="Close" color="red" v-close-popup />
                                <q-btn @click="EditItem(props.row)" :loading="loading_add" label="Update item" color="indigo"/>
                            </q-card-actions>
                        </q-card>
                    </q-dialog>

                </template>


            </q-table>

        </q-card-section>


    </q-card>

</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "Manage_Configs",
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
            add:{
                title:null,
                question:null,
                answer:null,

            },
            item_columns:[

                {
                    name:'key',
                    required: true,
                    label: 'Title / Key',
                    align: 'left',
                    field: row => row.conf_key,
                    sortable: true
                },
                {
                    name:'value',
                    required: true,
                    label: 'Value',
                    align: 'left',
                    field: row => row.conf_val,
                    sortable: true
                },
                {
                    name:'description',
                    required: true,
                    label: 'Description',
                    align: 'left',
                    field: row => row.description,
                    sortable: true
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
            "ConfigsIndex",
            "ConfigsEdit",
            "ConfigsSetDefault",

        ]),
        GetItems(){

            this.ConfigsIndex().then(res => {
                this.items = res.data.result;
                this.loading_get=false;
            }).catch(error => {
                this.NotifyServerError();
            });
        },
        EditItem(item){
            this.loading_add=true;
            this.ConfigsEdit(item).then(res => {
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
        SetDefault () {
            this.$q.dialog({
                title: 'Confirm',
                message: 'Are you sure to set to default all configs ?',

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
                this.ConfigsSetDefault().then(res => {
                    this.GetItems();
                    return this.NotifySuccess("all settings reset success");
                }).catch(error => {
                    return  this.NotifyServerError();
                })

            }).onCancel(() => {
                // console.log('>>>> Cancel')
            }).onDismiss(() => {
                // console.log('I am triggered on both OK and Cancel')
            })
        }

    }
}
</script>

<style scoped>

</style>
