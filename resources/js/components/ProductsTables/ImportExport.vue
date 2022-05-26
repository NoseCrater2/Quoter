<template>
    <div>
        <div class="text-center">
            <h2 class="mt-2 mb-5">{{product.name}}</h2>
        <v-card>
            <v-card-actions>
                <v-row justify="center" align="center">
                    <v-col cols="12" xl="12" lg="12" md="12" sm="12" xs="12">
                        <input type="file" id="file" ref="btnUploadFile" style="display:none" @change="selectImage($event)" accept=".xlsx,.csv"/>
                        <v-btn rounded color="#47a5ad" dark @click="dialog1 = true">
                            IMPORTAR INFORMACIÓN GENERAL
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
            <v-data-table
            v-if="products"
            :loading="loadingModels"
            :headers="modelsHeaders"
            :items="products"
            :search="search"
            :items-per-page="15"
            class="elevation-1"
            >
             <!-- :src="`img/modelos/medium/${item.image}`" -->
                <template v-slot:top>
                    <v-row no-gutters justify="space-between">
                        <v-col cols="11">
                            <v-text-field
                            class="mx-2"
                            v-model="search"
                            outlined
                            dense
                            prepend-inner-icon="mdi-magnify"
                            :label="`BUSCAR ${product.name}`"
                            hide-details
                            ></v-text-field>
                        </v-col>
                        <v-col cols="1">

                            <v-menu transition="scroll-y-transition">

                                <template v-slot:activator="{ on: menu, attrs }">
                                  <v-tooltip top>
                                    <template v-slot:activator="{ on: tooltip }">
                                        <v-btn
                                        class="mt-1"
                                        outlined
                                        icon
                                        v-bind="attrs"
                                        v-on="{ ...tooltip, ...menu }"
                                        >
                                          <v-icon>mdi-menu</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>IMPORTAR/EXPORTAR DATOS</span>
                                  </v-tooltip>
                                </template>

                              <v-list>
                                <v-list-item @click="exportModels()">
                                    <v-list-item-title v-text="'EXPORTAR DATOS'"></v-list-item-title>
                                </v-list-item>
                                <v-list-item @click="dialog2 = true">
                                    <v-list-item-title v-text="'IMPORTAR DATOS'"></v-list-item-title>
                                </v-list-item>
                              </v-list>
                            </v-menu>

                        </v-col>
                    </v-row>
                </template>

                <template v-slot:item.subweave="{ item }">
                    {{ item.subweave == null ? 'N/A' : item.subweave.name }}
                </template>

                <template v-slot:item.price="{ item }">
                    <v-text-field
                    @change="editModel(item)"
                    class="forEdit"
                    solo
                    dense
                    prefix="$"
                    type="number"
                    v-model="item.price"
                    hide-details
                    >
                    </v-text-field>
                </template>
                <template v-slot:item.active="{ item }">
                    <v-switch
                    @click="openDeactiveDialog(item)"
                    v-model="item.active"
                    readonly
                    color="primary"
                    hide-details
                    ></v-switch>
                </template>
            </v-data-table>
        </v-card>
        </div>

        <v-dialog persistent v-model="dialog1" :width="$vuetify.breakpoint.xl ? '1000' : $vuetify.breakpoint.lg ? '900' : '600'">
                <v-card tile :width="$vuetify.breakpoint.xl ? '1000' : $vuetify.breakpoint.lg ? '900' : '600'" :height="$vuetify.breakpoint.xl ? '800' : $vuetify.breakpoint.lg ? '700' : '580'" class="d-flex flex-column justify-center align-center">
                    <v-card-title>
                        IMPORTAR INFORMACIÓN DESDE ARCHIVO .XSLX O .CSV
                    </v-card-title>
                    <v-card-text class="text-center">
                        Asegurate de que tu archivo cumpla con los requisitos para ser reconocido por el sistema.
                            <div>1. El nombre de los encabezados debe ser correcto.</div>
                            <div>2. Evita escribir incorrectamente nombres de modelos, telas, persianas y fabricantes.</div>
                            <div>3. Evita las celdas vacías donde debe ir algún dato.</div>
                            <div>4. Evita poner letras donde solo van números y viceversa.</div>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn text color="#47a5ad" @click="dialog1 = false">CANCELAR</v-btn>
                        <v-btn dark color="#188038" @click="$refs.btnUploadFile.click()" >
                            SUBIR ARCHIVO
                        <v-icon right> mdi-microsoft-excel</v-icon>
                        </v-btn>
                    </v-card-actions>
                    <v-card-actions class="mt-5">
                        <v-progress-circular
                        indeterminate
                        v-if="(showProgressBar && (errors != null || errors != ''))"
                        :rotate="360"
                        :size="$vuetify.breakpoint.lgAndUp ? 200 : 160"
                        :width="15"
                        color="#47a5ad"
                        >
                        {{ value }}%
                        </v-progress-circular>

                    </v-card-actions>
                    <v-card-text class="mt-7 text-center red--text font-weight-bold text-uppercase">
                        {{ (errors != null || errors != '') ? errors : ''}}
                    </v-card-text>
                </v-card>
        </v-dialog>

         <v-dialog persistent v-model="dialog2" :width="$vuetify.breakpoint.xl ? '1000' : $vuetify.breakpoint.lg ? '900' : '600'">
                <v-card tile :width="$vuetify.breakpoint.xl ? '1000' : $vuetify.breakpoint.lg ? '900' : '600'" :height="$vuetify.breakpoint.xl ? '800' : $vuetify.breakpoint.lg ? '700' : '580'" class="d-flex flex-column justify-center align-center">
                    <v-card-title>
                        ACTUALIZACIÓN MASIVA DE PRECIOS
                    </v-card-title>
                    <v-card-text class="text-center">
                        Asegurate de que tu archivo cumpla con los requisitos para ser reconocido por el sistema.
                            <div>Solo modificar precios.</div>
                            <div>Escribir solo valores numéricos absolutos.</div>
                    </v-card-text>
                    <v-card-actions>
                        <input type="file" id="file" ref="btnUploadFile2" style="display:none" @change="importModels($event)" accept=".xlsx,.csv"/>
                        <v-btn text color="#47a5ad" @click="dialog2 = false">CANCELAR</v-btn>
                        <v-btn dark color="#188038" @click="$refs.btnUploadFile2.click()" >
                            SUBIR ARCHIVO
                            <v-icon right> mdi-microsoft-excel</v-icon>
                        </v-btn>
                    </v-card-actions>
                    <v-card-actions class="mt-5">
                        <v-progress-circular
                        v-if="(showProgressBar2 && (errors2 != null || errors2 != ''))"
                        :rotate="360"
                        :size="$vuetify.breakpoint.lgAndUp ? 200 : 160"
                        :width="15"
                        :value="value2"
                        color="#47a5ad"
                        >
                        {{ value2 }}%
                        </v-progress-circular>
                    </v-card-actions>
                    <v-card-text class="mt-7 text-center red--text font-weight-bold text-uppercase">
                        {{ (errors2 != null || errors2 != '') ? errors2 : ''}}
                    </v-card-text>
                </v-card>
        </v-dialog>
        <v-dialog max-width="350" v-model="showDeactiveDialog">
            <v-card max-width="350">
                <v-card-text class="text-h6 pa-2 flex justify-center" v-if="selectedItem != null">
                    ¿{{selectedItem.active == 1?'Despublicar':'Publicar'}} persiana {{selectedItem.name}}?
                </v-card-text>
                <v-divider></v-divider>
                <v-card-text>
                     <v-switch
                    inset
                    v-model="inactiveForType"
                    :label="`Hacer lo mismo con todas las persianas ${selectedItem != null ? selectedItem.type.name : ''}`"
                    color="teal"
                    hide-details
                    ></v-switch>
                     <v-switch
                    inset
                    v-model="inactiveForLine"
                    :label="`Hacer lo mismo con todas las persianas ${selectedItem != null ? selectedItem.line.name : ''}`"
                    color="teal"
                    hide-details
                    ></v-switch>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                   <v-btn text @click="closeDeactiveDialog()" color="red">cancelar</v-btn>
                   <v-spacer></v-spacer>
                   <v-btn text color="teal" @click="deactiveItem()">aceptar</v-btn>
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
            selectedItem: null,
            inactiveForType: false,
            inactiveForLine: false,
            showDeactiveDialog: false,
            fab: false,
            dialog1: false,
            dialog2: false,
            value: 0,
            value2: 0,
            importSunblinds: '/api/importSunblinds',
            importVariants: '/api/importExcel',
            showProgressBar: false,
            showProgressBar2: false,
            file: null,
            file2: null,
            selected: null,
            search: null,
            errors: null,
            errors2: null,
            loadingModels: false,
            showVariants: null,
            modelsHeaders: [
                {
                    text: 'ID',
                    value: 'id',
                    sortable: false,
                    align: 'center',
                },
                { text: 'Nombre', value: 'name', align: 'center' },
                { text: 'Tipo', value: 'type.name', align: 'center' },
                { text: 'Linea', value: 'line.name', align: 'center' },
                { text: 'Tejido', value: 'weave.name', align: 'center' },
                { text: 'Modelo', value: 'subweave', align: 'center' },
                { text: 'Ancho', value: 'width', align: 'center' },
                { text: 'Lienzo', value: 'rotate', align: 'center' },
                { text: 'Precio', value: 'price', align: 'center' },
                { text: 'Publicado', value: 'active', align: 'center' },
            ],
        }
    },

    props:{
        product: {
            type: Object,
            required: true,
        },
    },

    mounted(){
        this.$store.dispatch('getVariantsByProduct',this.product.id)
    },

    computed:{
        ...mapState({
     products: state => state.productsModule.sunblinds,
    }),

    },

    methods:{
        deactiveItem(){
            const options = {
                id: this.selectedItem.id,
                line: this.inactiveForLine ? this.selectedItem.line.id : null,
                type: this.inactiveForType ? this.selectedItem.type.id : null,
            }
            this.$store.dispatch('deactiveVariant', options).then(() => {
                this.closeDeactiveDialog()
            })
        },
        closeDeactiveDialog () {
            this.selectedItem = null
            this.inactiveForType = false
            this.inactiveForLine = false
            this.showDeactiveDialog = false

        },

        openDeactiveDialog ( item ) {
            this.selectedItem = item
            this.showDeactiveDialog = true
        },
        editModel(model){
            if(model.price && model.price > 0){
                this.$store.dispatch('editModel', model).then(()=>{})
            }
        },

         exportModels(){
             axios.get('/api/exportExcel',{responseType: 'blob',}).then(response => {
                FileDownload(response.data, 'modelos.xlsx')
            });
        },

        importModels( event){
            // const endpooint;
            // if(this.product.id === 1){
            //     endpooint = this.importVariants
            // }else if(this.product.id === 3){
            //      endpooint = this.import
            // }
            this.showProgressBar2 = true
            this.file2 = event.target.files[0];
            let formData = new FormData();

            formData.append('file',this.file2);

            axios.post('/api/importModels',
                formData, {headers: {'Content-Type': 'multipart/form-data'},}
            ).then(response =>{
                this.errors2 = response.data
                  if(!this.errors2){
                    this.dialog2 = false
                  }
            })
            .catch( errors => {
                this.errors =  errors.response.data.errors
            });
        },

        selectImage(event){
            let endpooint = null
            if(this.product.id === 1){
                endpooint = this.importVariants
            }else if(this.product.id === 3){
                 endpooint = this.importSunblinds

            }
            this.showProgressBar = true
            this.file = event.target.files[0];
            let formData = new FormData();

            formData.append('file',this.file);

            axios.post( endpooint,
                formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                onUploadProgress: function (progressEvent) {
                    this.value = parseInt( Math.round((progressEvent.loaded / progressEvent.total) * 100) )
                    if(this.value === 100){
                        this.value = 'IMPORTANDO...'
                    }
                }.bind(this),
            })
            .then(response =>{
                this.errors = response.data
                if(!this.errors){
                    this.dialog1 = false
                }
               this.$store.dispatch('getVariantsByProduct',this.product.id)
                this.showProgressBar = false
            })
            .catch( errors => {
                this.errors2 =  errors2.response.data.errors
            });
        },

    }
}
</script>
