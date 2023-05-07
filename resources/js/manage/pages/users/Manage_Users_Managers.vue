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
                        <q-input v-model="add.name"  lazy-rules type="text" outlined label="Name" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'name')">
                            <template v-slot:error>
                                <Error_Validation :errors="this.MixinValidation(errors,'email')"></Error_Validation>
                            </template>
                        </q-input>
                        <q-input v-model="add.email"  lazy-rules type="email" outlined label="Email" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'email')">
                            <template v-slot:error>
                                <Error_Validation :errors="this.MixinValidation(errors,'email')"></Error_Validation>
                            </template>
                        </q-input>
                        <q-input v-model="add.phone" lazy-rules type="number" outlined label="Phone" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'phone')">
                            <template v-slot:error>
                                <Error_Validation :errors="this.MixinValidation(errors,'phone')"></Error_Validation>
                            </template>
                        </q-input>
                        <q-input v-model="add.password" lazy-rules type="password" outlined label="Password" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'password')">
                            <template v-slot:error>
                                <Error_Validation :errors="this.MixinValidation(errors,'password')"></Error_Validation>
                            </template>
                        </q-input>
                        <q-input v-model="add.password_confirmation" lazy-rules type="password" outlined label="Password confirmation" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'password_confirmation')">
                            <template v-slot:error>
                                <Error_Validation :errors="this.MixinValidation(errors,'password_confirmation')"></Error_Validation>
                            </template>
                        </q-input>

                    </q-card-section>

                    <q-card-actions align="right">
                        <q-btn  label="Close" color="red" v-close-popup />
                        <q-btn @click="AddItem" :loading="loading_add" label="Add item" color="green-9"/>
                    </q-card-actions>
                </q-card>
            </q-dialog>

            <strong class="font-16">System admins list</strong>
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
                <template v-slot:body-cell-phone="props">
                    <q-td :props="props">
                        <div v-if="props.row.phone">
                            <q-chip color="teal-4" class="font-12">{{props.row.phone}}</q-chip>
                        </div>
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
                                <q-input v-model="props.row.name"  lazy-rules type="text" outlined label="Name" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'name')">
                                    <template v-slot:error>
                                        <Error_Validation :errors="this.MixinValidation(errors,'email')"></Error_Validation>
                                    </template>
                                </q-input>
                                <q-input v-model="props.row.email"  lazy-rules type="email" outlined label="Email" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'email')">
                                    <template v-slot:error>
                                        <Error_Validation :errors="this.MixinValidation(errors,'email')"></Error_Validation>
                                    </template>
                                </q-input>
                                <q-input v-model="props.row.phone" lazy-rules type="number" outlined label="Phone" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'phone')">
                                    <template v-slot:error>
                                        <Error_Validation :errors="this.MixinValidation(errors,'phone')"></Error_Validation>
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
    name: "Manage_Users_Managers",
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
                email:null,
                phone:null,
                password:null,
                password_confirmation:null,
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
            "UserManagersIndex",
            "UserManagersStore",
            "UserManagersDelete",
            "UserManagersEdit"

        ]),
        GetItems(){

            this.UserManagersIndex().then(res => {
                this.items = res.data.result;
                this.loading_get=false;
            }).catch(error => {
                this.NotifyServerError();
            });
        },
        AddItem(){
            this.loading_add=true;
            this.UserManagersStore(this.add).then(res => {
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
            this.UserManagersEdit(item).then(res => {
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
                this.UserManagersDelete(id).then(res => {
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
}
</script>

<style scoped>

</style>
