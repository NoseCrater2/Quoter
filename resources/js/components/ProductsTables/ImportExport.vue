<template>
    <div>
        <div class="text-center">
            <input type="file" id="file" ref="btnUploadFile" style="display:none" @change="selectImage($event)" accept=".xlsx,.csv"/>
            <v-btn rounded color="#47a5ad" dark class="ma-4" @click="dialog1 = true">
                IMPORTAR INFORMACIÓN GENERAL
            </v-btn>
        <v-card>
            <v-data-table
            v-if="products"
            :loading="loadingModels"
            :headers="modelsHeaders"
            :items="products"  
            :search="search"
            :items-per-page="5"
            class="elevation-1"
            >
             <!-- :src="`img/modelos/medium/${item.image}`" -->
                <template v-slot:top>
                    <h2>{{product.name}}</h2>
                    <v-spacer></v-spacer>
                    <v-text-field  
                    v-model="search"
                    append-icon="mdi-magnify"
                    :label="`BUSCAR ${product.name}`"
                    hide-details
                    ></v-text-field>
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
            </v-data-table>

            <v-card-actions>      
                <v-btn color="#188038" rounded dark @click="exportModels()"> 
                    EXPORTAR DATOS
                    <v-icon right>mdi-table-arrow-right</v-icon>
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn color="#188038" rounded dark @click="dialog2 = true">
                    IMPORTAR DATOS
                    <v-icon right>mdi-table-arrow-left</v-icon>
                </v-btn>     
            </v-card-actions>
        </v-card>
        </div>

        <v-dialog v-model="dialog1" width="600" >
            <v-row justify="center" align="center">
                <v-card max-width="600" max-height="600">
                    <v-card-title>
                        IMPORTAR INFORMACIÓN DESDE ARCHIVO XSLX O CSV
                    </v-card-title>
                    <v-card-text>
                        Asegurate de que tu archivo cumpla con los requisitos para ser reconocido por el sistema.
                        <ol>
                            <li>EL nombre de los encabezados debe ser correcto.</li>
                            <li>Evita escribir incorrectamente nombres de modelos, telas, persianas y fabricantes.</li>
                            <li>Evita las celdas vacías donde debe ir algún dato.</li>
                            <li>Evita poner letras donde solo van números y viceversa.</li>
                        </ol>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn dark color="#188038" @click="$refs.btnUploadFile.click()" >
                            SUBIR ARCHIVO
                        <v-icon right> mdi-microsoft-excel</v-icon>
                        </v-btn>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-progress-circular
                        v-if="showProgressBar"
                        :rotate="360"
                        :size="200"
                        :width="15"
                        :value="value"
                        color="#47a5ad"
                        >
                        {{ value }}%
                        </v-progress-circular>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                    <v-card-text>
                        {{ errors }}
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text color="#47a5ad" @click="dialog1 = false">CANCELAR</v-btn>
                    </v-card-actions>
                </v-card>
            </v-row>
        </v-dialog>

        <v-dialog v-model="dialog2" width="600" >
            <v-row justify="center" align="center">
                <v-card max-width="600" max-height="600">
                    <v-card-title>
                        ACTUAIZACIÓN MASIVA DE PRECIOS
                    </v-card-title>
                    <v-card-text>
                        Asegurate de que tu archivo cumpla con los requisitos para ser reconocido por el sistema.
                        <ol>
                            <li>Solo modificar precios.</li>
                            <li>Escribir solo valores numéricos absolutos.</li>
                        </ol>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <input type="file" id="file" ref="btnUploadFile2" style="display:none" @change="importModels($event)" accept=".xlsx,.csv"/>
                        <v-btn dark color="#188038" @click="$refs.btnUploadFile2.click()" >
                            SUBIR ARCHIVO
                            <v-icon right> mdi-microsoft-excel</v-icon>
                        </v-btn>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-progress-circular
                        v-if="showProgressBar2"
                        :rotate="360"
                        :size="200"
                        :width="15"
                        :value="value2"
                        color="#47a5ad"
                        >
                        {{ value2 }}%
                        </v-progress-circular>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                    <v-card-text>
                        {{ errors2 }}
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text color="#47a5ad" @click="dialog2 = false">CANCELAR</v-btn>
                        </v-card-actions>
                </v-card>
            </v-row>
        </v-dialog>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
const FileDownload = require('js-file-download');
export default {
    data(){
        return{
            dialog1: false,
            dialog2: false,
            value: 0,
            value2: 0,
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
                    text: 'id',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                { text: 'Nombre', value: 'name' },
                { text: 'Precio', value: 'price' },
                { text: 'Linea', value: 'line' },
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
     products: state => state.productsModule.variants,
    }),
       
    },

    methods:{
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
            this.showProgressBar2 = true
            this.file2 = event.target.files[0];
            let formData = new FormData();

            formData.append('file',this.file2);

            axios.post( '/api/importModels',
                formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: function (progressEvent) {
                        this.value2 = parseInt( Math.round((progressEvent.loaded / progressEvent.total) * 100) )
                            if(this.value2 === 100){
                                this.value2 = 'IMPORTANDO...'
                            }
                    }.bind(this),
                }
            ).then(response =>{
                this.errors2 = response.data
                  if(!this.errors2){
                    this.dialog2 = false
                  }
                this.$store.dispatch('getModels').then(()=>{
                    this.loadingModels = false
                    this.showProgressBar2 = false
                })         
            })
            .catch( errors => {
                this.errors =  errors.response.data.errors
            });
        },

        selectImage(event){
            this.showProgressBar = true
            this.file = event.target.files[0];
            let formData = new FormData();
            
            formData.append('file',this.file);

            axios.post( '/api/importExcel',
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