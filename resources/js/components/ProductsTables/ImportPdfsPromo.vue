<template>
    <div class="text-center">
            <!-- <h2 class="mt-2 mb-5">DOCUMENTOS PDF</h2> -->
        <v-card class="ma-4">

            <v-data-iterator
            hide-default-footer
            :items-per-page.sync="itemsPerPage"
            :page.sync="page"
            :items="promos">
            <template v-slot:header>
                <v-toolbar
                  class="mb-2"
                  color="#47a5ad"
                  dark
                  flat>
                    <v-toolbar-title>GACETA DE PROMOCIONES PDF <span style="font-size: 0.87rem important!"></span>({{promos.length}} en total)</v-toolbar-title>
                    <v-spacer></v-spacer>
                     <v-btn @click="openPriceDialog(null)" rounded icon color="white">
                        <v-icon size="60">mdi-plus</v-icon>
                    </v-btn>
                </v-toolbar>
                <v-toolbar
                  class="mt-n2"
                  flat>
                    <span>Mostrar por página</span>
                    <v-menu offset-y>
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn
                          dark
                          text
                          color="#47a5ad"
                          class="ml-2"
                          v-bind="attrs"
                          v-on="on"
                        >
                          {{ itemsPerPage }}
                          <v-icon>mdi-chevron-down</v-icon>
                        </v-btn>
                      </template>
                      <v-list>
                        <v-list-item
                          v-for="(number, index) in itemsPerPageArray"
                          :key="index"
                          @click="updateItemsPerPage(number)"
                        >
                          <v-list-item-title>{{ number }}</v-list-item-title>
                        </v-list-item>
                      </v-list>
                    </v-menu>
                    <v-spacer></v-spacer>
                    <span
                      class="mr-4
                      grey--text"
                    >
                      Página {{ page }} de {{ numberOfPages }}
                    </span>
                     <v-btn
                     elevation="0"
                     x-small
                      fab
                      dark
                      color="#47a5ad"
                      class="mr-1"
                      @click="previousPage"
                    >
                      <v-icon>mdi-chevron-left</v-icon>
                    </v-btn>
                    <v-btn
                    elevation="0"
                    x-small
                      fab
                      dark
                      color="#47a5ad"
                      class="ml-1"
                      @click="nextPage"
                    >
                      <v-icon>mdi-chevron-right</v-icon>
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
                <template v-slot:footer>
                <v-toolbar
                  class="mt-2"
                  flat>
                    <span>Mostrar por página</span>
                    <v-menu offset-y>
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn
                          dark
                          text
                          color="#47a5ad"
                          class="ml-2"
                          v-bind="attrs"
                          v-on="on"
                        >
                          {{ itemsPerPage }}
                          <v-icon>mdi-chevron-down</v-icon>
                        </v-btn>
                      </template>
                      <v-list>
                        <v-list-item
                          v-for="(number, index) in itemsPerPageArray"
                          :key="index"
                          @click="updateItemsPerPage(number)"
                        >
                          <v-list-item-title>{{ number }}</v-list-item-title>
                        </v-list-item>
                      </v-list>
                    </v-menu>
                    <v-spacer></v-spacer>
                    <span
                      class="mr-4
                      grey--text"
                    >
                      Página {{ page }} de {{ numberOfPages }}
                    </span>
                     <v-btn
                     elevation="0"
                     x-small
                      fab
                      dark
                      color="#47a5ad"
                      class="mr-1"
                      @click="previousPage"
                    >
                      <v-icon>mdi-chevron-left</v-icon>
                    </v-btn>
                    <v-btn
                    elevation="0"
                    x-small
                      fab
                      dark
                      color="#47a5ad"
                      class="ml-1"
                      @click="nextPage"
                    >
                      <v-icon>mdi-chevron-right</v-icon>
                    </v-btn>
                </v-toolbar>
                </template>
            </v-data-iterator>
        </v-card>
           <v-dialog persistent v-model="dialog1" max-width="500">
                <v-card tile >
                    <v-card-title>
                        {{ titleDialog }} LISTA DE PRECIOS
                    </v-card-title>
                    <v-card-text class="text-center">
                        <v-form ref="priceForm">
                            <v-row >
                                <v-col cols="12" md="12" sm="12">
                                    <v-file-input
                                    outlined
                                    v-model="promo.file"
                                    :rules="rules"
                                    show-size
                                    accept="application/pdf"
                                    prepend-icon="mdi-file-pdf-box"
                                    label="Archivo PDF de precios"
                                    hide-details
                                    ></v-file-input>
                                </v-col>
                                 <v-col cols="12" md="12" sm="12">
                                    <v-text-field
                                    prepend-icon="mdi-format-title"
                                    v-model="title"
                                    label="Título"
                                    outlined
                                    hide-details
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" md="12" sm="12">
                                    <v-file-input
                                    outlined
                                    v-model="promo.thumbnail"
                                    :rules="rulesImage"
                                    show-size
                                    accept="image/jpeg"
                                    prepend-icon="mdi-image"
                                    label="Miniatura"
                                    hide-details
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
                value => !value || value.size < 5000000 || 'Archivo debe ser menor a 5MB',
            ],
            rulesImage: [
                value => !value || value.size < 100000 || 'Imagen debe ser menor a 100Kb',
            ],
            promo: {
                title: null,
                file: null,
                thumbnail: null,
                is_promo: 1,
            },

            defaultPromo: {
                title: null,
                file: null,
                thumbnail: null,
                is_promo: 1,
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
            itemsPerPage: 12,
            page: 1,
            itemsPerPageArray: [4, 8, 12, 16],
        }
    },

     mounted(){
        this.$store.dispatch('getPromos')
    },

    computed:{
        ...mapState({
            promos: state => state.priceModule.promos,
        }),

        titleDialog(){
            return this.isEditing ? 'Editar' : 'Nueva'
        },

        title: {
            get: function () {
                return this.promo.file?this.promo.file.name:null
            },
            set: function (newValue) {
                this.promo.title = newValue
            }
        },

        numberOfPages () {
          return Math.ceil(this.promos.length / this.itemsPerPage)
        },
    },

    methods :{
        nextPage () {
          if (this.page + 1 <= this.numberOfPages) this.page += 1
        },
        previousPage () {
          if (this.page - 1 >= 1) this.page -= 1
        },
        updateItemsPerPage (number) {
          this.itemsPerPage = number
        },
        openPriceDialog(list){
            if(list){
                this.isEditing = true
                this.promo.id = list.id
                this.promo.title = list.title
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
            this.$store.dispatch('deletePrice', this.selectedList.id).then(()=>{
                this.$store.dispatch('getPromos').then(()=>{
                    this.loadinDeleteButton = false
                    this.dialogDelete = false
                }).catch(()=>{
                    this.loadinDeleteButton = false
                    this.dialogDelete = false
                })
            })
        },

        getImageFromServer(url,title){
            fetch(url)
              .then(res => res.blob()) // Gets the response and returns it as a blob
              .then(blob => {
                  this.promo.thumbnail =  new File([blob],title);
            });
        },

         getFileFromServer(url,title){
            fetch(url)
                .then(res => res.blob()) // Gets the response and returns it as a blob
                .then(blob => {
                    this.promo.file=  new File([blob],title);
            });
        },

        save(){
            this.loadingSaveButton = true
            if(this.isEditing){
                this.$store.dispatch('editPrice', this.promo).then(() => {
                    this.$store.dispatch('getPromos').then(()=>{
                        this.loadingSaveButton = false
                        this.dialog1 = false
                        this.isEditing = false
                        this.promo = Object.assign({},this.defaultPromo)
                    }).catch(()=>{
                        this.loadingSaveButton = false
                        this.dialog1 = false
                        this.isEditing = false
                        this.promo = Object.assign({},this.defaultPromo)
                    })
                })
            }else{
                this.$store.dispatch('savePrice', this.promo).then(() => {
                    this.$store.dispatch('getPromos').then(()=>{
                        this.loadingSaveButton = false
                        this.dialog1 = false
                        this.isEditing = false
                        this.promo = Object.assign({},this.defaultPromo)
                    }).catch(()=>{
                        this.loadingSaveButton = false
                        this.dialog1 = false
                        this.isEditing = false
                        this.promo = Object.assign({},this.defaultPromo)
                    })
                })
            }

        }

    }
}
</script>
