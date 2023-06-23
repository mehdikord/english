
<template>

    <q-card flat bordered>

        <q-card-section class="bg-blue-grey-14 text-white q-pb-lg">
            <q-btn @click="dialog_add=true" color="deep-orange-7" icon="mdi-plus" push class="float-right" label="Add Item"></q-btn>
            <q-dialog
                v-model="dialog_add"

                transition-show="scale"
                transition-hide="scale"
                position="top"
            >
                <q-card style="max-width: 700px;width: 700px">
                    <q-card-section class="bg-deep-orange-9 text-white">
                        <div class="text-h6">Add new item</div>
                    </q-card-section>
                    <q-card-section >
                        <q-input v-model="add.name"  lazy-rules type="text" outlined label="Pack name" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'name')">
                            <template v-slot:error>
                                <Error_Validation :errors="this.MixinValidation(errors,'name')"></Error_Validation>
                            </template>
                        </q-input>
                        <q-input v-model="add.subtitle"  lazy-rules type="text" outlined label="Pack subtitle" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'subtitle')">
                            <template v-slot:error>
                                <Error_Validation :errors="this.MixinValidation(errors,'subtitle')"></Error_Validation>
                            </template>
                        </q-input>
                        <q-input v-model="add.life"  lazy-rules type="text" outlined label="Life quantity" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'life')">
                            <template v-slot:error>
                                <Error_Validation :errors="this.MixinValidation(errors,'life')"></Error_Validation>
                            </template>
                        </q-input>
                        <q-input v-model="add.price"  lazy-rules type="text" outlined label="Price" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'price')">
                            <template v-slot:error>
                                <Error_Validation :errors="this.MixinValidation(errors,'price')"></Error_Validation>
                            </template>
                        </q-input>


                    </q-card-section>

                    <q-card-actions align="right">
                        <q-btn  label="Close" color="red" v-close-popup />
                        <q-btn @click="AddItem" :loading="loading_add" label="Add item" color="green-9"/>
                    </q-card-actions>
                </q-card>
            </q-dialog>

            <strong class="font-16">Life packs</strong>
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
                <template v-slot:body-cell-life="props">
                    <q-td :props="props">
                        <q-chip color="deep-orange-10" class="font-13" text-color="white">
                            {{props.row.life}}
                        </q-chip>
                    </q-td>
                </template>
                <template v-slot:body-cell-use="props">
                    <q-td :props="props">
                        <q-chip color="blue-10" class="font-13" text-color="white">
                            {{props.row.invoices_count}}
                        </q-chip>
                    </q-td>
                </template>
                <template v-slot:body-cell-price="props">
                    <q-td :props="props">
                        <strong class="font-14 text-green-7">
                            {{this.$filters.numbers(props.row.price)}}
                        </strong>
                    </q-td>
                </template>

                <template v-slot:body-cell-tools="props">
                    <q-td :props="props">
                        <q-btn @click="dialog_edit[props.row.id] = true;errors=[]" glossy color="primary" size="sm" icon="mdi-pen" class="q-mx-xs">
                            <q-tooltip class="bg-grey-9">Edit this item</q-tooltip>
                        </q-btn>
                        <q-btn @click="DeleteItem(props.row.id)" glossy color="red-9" size="sm" icon="mdi-delete" class="q-mx-xs">
                            <q-tooltip class="bg-grey-9">Delete this item</q-tooltip>
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
                                <div class="text-h6">Edit item : {{props.row.name}}</div>
                            </q-card-section>
                            <q-card-section >

                                <q-input v-model="props.row.name"  lazy-rules type="text" outlined label="Pack name" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'name')">
                                    <template v-slot:error>
                                        <Error_Validation :errors="this.MixinValidation(errors,'name')"></Error_Validation>
                                    </template>
                                </q-input>
                                <q-input v-model="props.row.subtitle"  lazy-rules type="text" outlined label="Pack subtitle" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'subtitle')">
                                    <template v-slot:error>
                                        <Error_Validation :errors="this.MixinValidation(errors,'subtitle')"></Error_Validation>
                                    </template>
                                </q-input>
                                <q-input v-model="props.row.life"  lazy-rules type="text" outlined label="Life quantity" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'life')">
                                    <template v-slot:error>
                                        <Error_Validation :errors="this.MixinValidation(errors,'life')"></Error_Validation>
                                    </template>
                                </q-input>
                                <q-input v-model="props.row.price"  lazy-rules type="text" outlined label="Price" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'price')">
                                    <template v-slot:error>
                                        <Error_Validation :errors="this.MixinValidation(errors,'price')"></Error_Validation>
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

<style scoped>

</style>
<script>
import {defineComponent} from 'vue'
import {mapActions} from "vuex";

export default defineComponent({
    name: "Manage_Life_Pack",
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
                name:null,
                subtitle:null,
                life:null,
                price:null,

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
                    name:'name',
                    required: true,
                    label: 'Name',
                    align: 'left',
                    field: row => row.name,
                    sortable: true
                },
                {
                    name:'subtitle',
                    required: true,
                    label: 'Subtitle',
                    align: 'left',
                    field: row => row.subtitle,
                    sortable: true
                },
                {
                    name:'life',
                    required: true,
                    label: 'Life quantity',
                    align: 'left',
                    field: row => row.life,
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
                    name:'use',
                    required: true,
                    label: 'Uses',
                    align: 'left',
                    field: row => row.invoices_count,
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
            "PacksIndex",
            "PacksStore",
            "PacksDelete",
            "PacksEdit"

        ]),
        GetItems(){

            this.PacksIndex().then(res => {
                this.items = res.data.result;
                this.loading_get=false;
            }).catch(error => {
                this.NotifyServerError();
            });
        },
        AddItem(){
            this.loading_add=true;
            this.PacksStore(this.add).then(res => {
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
            this.PacksEdit(item).then(res => {
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
                this.PacksDelete(id).then(res => {
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
        }

    }
})
</script>
