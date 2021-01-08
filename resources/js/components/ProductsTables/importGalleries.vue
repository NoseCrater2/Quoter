<template>
    <div class="text-center">
            <input type="file" id="file" ref="btnUploadFile" style="display:none" @change="selectImage($event)" accept=".xlsx,.csv"/>
            <v-btn rounded color="#47a5ad" dark class="ma-4" @click="dialog1 = true">
                IMPORTAR INFORMACIÓN DE GALLERIAS
            </v-btn>
        <v-card>
            <v-data-table
            v-if="galleries"
            :loading="loadingModels"
            :headers="galleriesHeaders"
            :items="galleries"  
            :search="search"
            :items-per-page="5"
            class="elevation-1"
            >
            
                <template v-slot:top>
                    <h2>MOTORIZACIÓN AUTOMÁTICA</h2>
                    <v-spacer></v-spacer>
                    <v-text-field 
                    class="mx-4" 
                    v-model="search"
                    append-icon="mdi-magnify"
                    :label="`BUSCAR REGISTROS`"
                    hide-details
                    ></v-text-field>
                </template>

                <!-- <template v-slot:item.price="{ item }">
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
                </template>          -->
                <template v-slot:item.colors="{ item }">
                   <div class="d-inline" v-for="c in item.colors" :key="c.color">
                       {{ c.color }}
                   </div>
                </template>         
            </v-data-table>

            <!-- <v-card-actions>      
                <v-btn color="#188038" rounded dark @click="exportModels()"> 
                    EXPORTAR DATOS
                    <v-icon right>mdi-table-arrow-right</v-icon>
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn color="#188038" rounded dark @click="dialog2 = true">
                    IMPORTAR DATOS
                    <v-icon right>mdi-table-arrow-left</v-icon>
                </v-btn>     
            </v-card-actions> -->
        </v-card>
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
        </div>
</template>
<script>
import { mapActions, mapState } from 'vuex';
const FileDownload = require('js-file-download');
export default {
    data(){
        return{
            dialog1 : false,
            showProgressBar: false,
            file: null,
            search: null,
            errors: null,
            errors2: null,
            value: 0,
            loadingModels: false,
             galleriesHeaders: [
                {
                    text: 'Modelo',
                    align: 'start',
                    sortable: false,
                    value: 'model',
                },
                { text: 'Tipo', value: 'type' },
                { text: 'Precio', value: 'price' },
                { text: 'Color(es)', value: 'colors' },
            ],
        }
    },

     mounted(){
        this.$store.dispatch('getGalleries') 
    },

    computed:{
        ...mapState({
            galleries: state => state.motorizationModule.galleries,
        }),
    },

    methods :{
        selectImage(event){
            this.showProgressBar = true
            this.file = event.target.files[0];
            let formData = new FormData();
            
            formData.append('file',this.file);

            axios.post( '/api/importGalleries',
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
               this.$store.dispatch('getGalleries') 
                this.showProgressBar = false
            })
            .catch( errors => {
                this.errors2 =  errors2.response.data.errors
            });
        },
    }
}
</script>