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
                <q-card style="max-width: 850px;width: 850px">
                    <q-card-section class="bg-deep-orange-9 text-white">
                        <div class="text-h6">Add new item</div>
                    </q-card-section>
                    <q-card-section >
                        <q-input v-model="add.name"  lazy-rules type="text" outlined label="Episode name" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'name')">
                            <template v-slot:error>
                                <Error_Validation :errors="this.MixinValidation(errors,'name')"></Error_Validation>
                            </template>
                        </q-input>
                        <q-input v-model="add.subtitle"  lazy-rules type="text" outlined label="Subtitle" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'subtitle')">
                            <template v-slot:error>
                                <Error_Validation :errors="this.MixinValidation(errors,'subtitle')"></Error_Validation>
                            </template>
                        </q-input>
                        <q-input v-model="add.price"  lazy-rules type="text" outlined label="Price($)" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'price')">
                            <template v-slot:error>
                                <Error_Validation :errors="this.MixinValidation(errors,'price')"></Error_Validation>
                            </template>
                        </q-input>
                        <q-input v-model="add.sale"  lazy-rules type="text" outlined label="Sale($)" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'sale')">
                            <template v-slot:error>
                                <Error_Validation :errors="this.MixinValidation(errors,'sale')"></Error_Validation>
                            </template>
                        </q-input>
                        <q-file outlined bottom-slots v-model="add.file" label="Episode File" counter class="q-my-xs q-mb-md">
                            <template v-slot:prepend>
                                <q-icon name="mdi-file" @click.stop.prevent />
                            </template>
                            <template v-slot:append>

                                <q-icon name="mdi-close" @click.stop.prevent="add.file = null" class="cursor-pointer" />
                            </template>
                            <template v-slot:hint >
                                The file must be of Zip ( zip-rar-apk ) type
                            </template>
                            <template v-slot:error>
                                <Error_Validation :errors="this.MixinValidation(errors,'file')"></Error_Validation>
                            </template>
                        </q-file>

                        <q-file outlined bottom-slots v-model="add.image" label="Episode image" counter class="q-my-xs q-mb-md">
                            <template v-slot:prepend>
                                <q-icon name="mdi-image" @click.stop.prevent />
                            </template>
                            <template v-slot:append>
                                <q-icon name="mdi-close" @click.stop.prevent="add.image = null" class="cursor-pointer" />
                            </template>
                            <template v-slot:hint >
                                The file must be of ( jpg-png ) type
                            </template>
                            <template v-slot:error>
                                <Error_Validation :errors="this.MixinValidation(errors,'image')"></Error_Validation>
                            </template>
                        </q-file>

                        <div class="q-my-xs q-gutter-sm">
                            <q-editor
                                v-model="add.description"
                                :definitions="{}"
                            />
                        </div>

                    </q-card-section>

                    <q-card-actions align="right">
                        <q-btn  label="Close" color="red" v-close-popup />
                        <q-btn @click="AddItem" :loading="loading_add" label="Add item" color="green-9"/>
                    </q-card-actions>
                </q-card>
            </q-dialog>

            <strong class="font-16">Episodes List</strong>
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
                       <q-avatar class="q-ml-md" square size="65px">
                           <img v-if="props.row.image_url" :src="props.row.image_url">
                           <img v-else src="/assets/images/default/episode.png">
                       </q-avatar>
                    </q-td>
                </template>

                <template v-slot:body-cell-is_active="props">
                    <q-td :props="props">
                        <q-toggle
                            v-model="props.row.is_active"
                            :false-value="0"
                            :true-value="1"
                            icon="mdi-check"
                            color="green-7"
                            @click="ChangeStatus(props.row.id)"
                        />
                    </q-td>
                </template>

                <template v-slot:body-cell-file="props">
                    <q-td :props="props">
                        <q-btn v-if="props.row.file" push color="teal" size="small" icon="mdi-download"  >
                            Download file
                        </q-btn>
                        <q-btn v-else push color="dark" size="small" icon="mdi-cancel" disable >
                            No file
                        </q-btn>
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
                                <q-input v-model="props.row.name"  lazy-rules type="text" outlined label="Episode name" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'name')">
                                    <template v-slot:error>
                                        <Error_Validation :errors="this.MixinValidation(errors,'name')"></Error_Validation>
                                    </template>
                                </q-input>
                                <q-input v-model="props.row.subtitle"  lazy-rules type="text" outlined label="Subtitle" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'subtitle')">
                                    <template v-slot:error>
                                        <Error_Validation :errors="this.MixinValidation(errors,'subtitle')"></Error_Validation>
                                    </template>
                                </q-input>
                                <q-input v-model="props.row.price"  lazy-rules type="text" outlined label="Price($)" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'price')">
                                    <template v-slot:error>
                                        <Error_Validation :errors="this.MixinValidation(errors,'price')"></Error_Validation>
                                    </template>
                                </q-input>
                                <q-input v-model="props.row.sale"  lazy-rules type="text" outlined label="Sale($)" color="primary" class="q-my-xs" :error="this.MixinValidationCheck(errors,'sale')">
                                    <template v-slot:error>
                                        <Error_Validation :errors="this.MixinValidation(errors,'sale')"></Error_Validation>
                                    </template>
                                </q-input>
                                <q-banner  rounded class="bg-orange text-dark">
                                    <q-icon name="mdi-alert" size="large"></q-icon>
                                    Only when editing the current file. Select the new file
                                </q-banner>
                                <q-file outlined bottom-slots v-model="edit_file" label="Episode File" counter class="q-my-xs q-mb-md">
                                    <template v-slot:prepend>
                                        <q-icon name="mdi-file" @click.stop.prevent />
                                    </template>
                                    <template v-slot:append>
                                        <q-icon name="mdi-close" @click.stop.prevent="edit_file = null" class="cursor-pointer" />
                                    </template>
                                    <template v-slot:hint >
                                        The file must be of Zip ( zip-rar-apk ) type
                                    </template>
                                    <template v-slot:error>
                                        <Error_Validation :errors="this.MixinValidation(errors,'file')"></Error_Validation>
                                    </template>
                                </q-file>
                                <div class="q-my-xs q-gutter-sm">
                                    <q-editor
                                        v-model="props.row.description"
                                        :definitions="{}"
                                    />
                                </div>

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
    name: "Manage_Episodes",
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
                    name:'price',
                    required: true,
                    label: 'Price',
                    align: 'left',
                    field: row => row.price,
                    sortable: true
                },
                {
                    name:'sale',
                    required: true,
                    label: 'Sale',
                    align: 'left',
                    field: row => row.sale,
                    sortable: true
                },
                {
                    name:'is_active',
                    required: true,
                    label: 'Status',
                    align: 'left',
                    field: row => row.is_active,
                    sortable: true
                },
                {
                    name:'file',
                    required: true,
                    label: 'File',
                    align: 'left',

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
            "EpisodesIndex",
            "EpisodesStore",
            "EpisodesDelete",
            "EpisodesEdit",
            "EpisodesChangeStatus",

        ]),
        GetItems(){

            this.EpisodesIndex().then(res => {
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
        ChangeStatus(id){
            this.EpisodesChangeStatus(id).then(res => {
                return this.NotifySuccess('Account status change successful');
            }).catch(error => {
                return this.NotifyServerError();
            })
        },

    }
}
</script>

<style scoped>

</style>
