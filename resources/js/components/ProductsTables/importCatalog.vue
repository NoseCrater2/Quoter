<template>
    <div class="text-center">
        <v-card class="ma-4">

            <v-data-iterator
            :items="catalogs"
            :items-per-page="10">
            <template v-slot:header>
                <v-toolbar
                  class="mb-2"
                  color="#47a5ad"
                  dark
                  flat>
                    <v-toolbar-title>CATÁLOGOS PDF</v-toolbar-title>
                    <v-spacer></v-spacer>
                     <v-btn @click="openPriceDialog(null)" rounded icon color="white">
                        <v-icon size="60">mdi-plus</v-icon>
                    </v-btn>
                </v-toolbar>
            </template>

            <template v-slot:default="props">
              <v-row>
                <v-col
                  v-for="item in props.items"
                  :key="item.id"
                  cols="12"
                  sm="6"
                  md="4"
                  lg="3"
                >
                  <v-card width="290" height="340" >
                      <v-card-text class="pa-0 ma-0">
                           <v-img width="290" height="290" class="white--text align-end" :src="`/img/${item.thumbnail}`">
                      <v-card-title
                      style="background-color: rgba(0,0,0,0.5)"
                      >
                      {{ item.title }}
                    </v-card-title>
                      </v-img>
                      </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-btn rounded icon color="red" @click="openDialogDelete(item)">
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                        <v-spacer></v-spacer>
                        <v-btn rounded icon color="#47a5ad" @click="openPriceDialog(item)"><v-icon>mdi-pencil</v-icon></v-btn>
                    </v-card-actions>
                  </v-card>
                </v-col>
              </v-row>
            </template>
            </v-data-iterator>
        </v-card>
           <v-dialog persistent v-model="dialog1" max-width="500">
                <v-card tile>
                    <v-card-title>
                        {{ titleDialog }} CATÁLOGO
                    </v-card-title>
                    <v-card-text class="text-center">
                        <v-form ref="catalogForm">
                            <v-row >
                                <v-col cols="12" md="12" sm="12">
                                    <v-file-input
                                    outlined
                                    v-model="price.file"
                                    :rules="rules"
                                    show-size
                                    accept="application/pdf"
                                    prepend-icon="mdi-file-pdf-box"
                                    label="Cátalogo en pdf"
                                    ></v-file-input>
                                </v-col>
                                 <v-col cols="12" md="12" sm="12">
                                    <v-text-field
                                    prepend-icon="mdi-format-title"
                                    v-model="title"
                                    label="Título"
                                    outlined
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" md="12" sm="12">
                                    <v-file-input
                                    outlined
                                    v-model="price.thumbnail"
                                    :rules="rulesImage"
                                    show-size
                                    accept="image/jpeg"
                                    prepend-icon="mdi-image"
                                    label="Miniatura"
                                    ></v-file-input>
                                </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn text color="red"  @click="dialog1 = false; isEditing = false">CANCELAR</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn :loading="loadingSaveButton" @click="save()" color="#47a5ad" text>GUARDAR</v-btn>
                </v-card-actions>
                <v-card-text>
                    <v-progress-linear
                    v-if="$store.state.catalogsModule.progress"
                    v-model="$store.state.catalogsModule.progress"
                      color="teal"
                    ></v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-dialog persistent v-model="dialogDelete"  max-width="300">
            <v-card tile>
                <v-card-title v-if="selectedList" style="background-color: #47a5ad; color: white">
                    ¿Eliminar Lista {{selectedList.title}}?
                </v-card-title>
                <v-divider inset></v-divider>
                <v-card-actions>
                    <v-btn text color="red" @click="remove" :loading="loadinDeleteButton">ELIMINAR</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn text color="#47a5ad" @click="dialogDelete = false">CANCELAR</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>

import { mapState } from 'vuex';
const FileDownload = require('js-file-download');
export default {
    data(){
        return{
            rules: [
                value => !!value && value.size < 30000000 || 'Archivo debe ser menor a 30MB',
            ],
            rulesImage: [
                value => !!value && value.size < 100000 || 'Imagen debe ser menor a 100Kb',
            ],
            price: {
                title: null,
                file: null,
                thumbnail: null
            },

            defaultPrice: {
                title: null,
                file: null,
                thumbnail: null
            },
            isEditing: false,
            dialogDelete: false,
            loadinDeleteButton : false,
            loadingSaveButton: false,
            dialog1 : false,
            search: null,
            value: 0,
            loadingModels: false,
            selectedList: null,
        }
    },

     mounted(){
        this.$store.dispatch('getCatalogs')
    },

    computed:{
        ...mapState({
            catalogs: state => state.catalogsModule.catalogs,
        }),

        titleDialog(){
            return this.isEditing ? 'EDITAR' : 'NUEVO'
        },

        title: {
            get: function () {
                if(this.price.file){
                    let name = this.price.file.name.substring(0, this.price.file.name.length - 4)
                    return name
                }
            },
            set: function (newValue) {
                this.price.title = newValue
            }
        }
    },

    methods :{
        openPriceDialog(list){
            if(list){
                this.isEditing = true
                this.price.id = list.id
                this.price.title = list.title
                this.getImageFromServer('https://rollux.com.mx/img/'+list.thumbnail,list.title)
                this.getFileFromServer('https://rollux.com.mx/img/'+list.path,list.title)
            }

            this.dialog1 = true
        },

        openDialogDelete(selected){
             this.selectedList = selected
            this.dialogDelete = true
        },

        remove(){
            this.loadinDeleteButton = true
            this.$store.dispatch('deleteCatalog', this.selectedList.id).then(()=>{
                this.loadinDeleteButton = false
                this.dialogDelete = false
            })
        },

        getImageFromServer(url,title){
            fetch(url)
              .then(res => res.blob()) // Gets the response and returns it as a blob
              .then(blob => {
                  this.price.thumbnail =  new File([blob],title);
            });
        },

         getFileFromServer(url,title){
            fetch(url)
                .then(res => res.blob()) // Gets the response and returns it as a blob
                .then(blob => {
                    this.price.file=  new File([blob],title);
            });
        },

        save(){
            if(this.$refs.catalogForm.validate()){
                this.price.title = this.title
                this.loadingSaveButton = true
            if(this.isEditing){
                this.$store.dispatch('editCatalog', this.price).then(() => {
                    this.loadingSaveButton = false
                    this.dialog1 = false
                    this.isEditing = false
                    this.$refs.catalogForm.reset()
                    //this.price = Object.assign({},this.defaultPrice)
                })
            }else{
                this.$store.dispatch('saveCatalog', this.price).then(() => {
                    this.loadingSaveButton = false
                    this.dialog1 = false
                    this.isEditing = false
                    this.$refs.catalogForm.reset()
                })
            }
            }


        }

    }
}
</script>
