<template>
    <div class="text-center">
            <h2 class="mt-2 mb-5">MOTORIZACIÓN AUTOMÁTICA</h2>
        <v-card>
            <v-card-actions>
                <v-row justify="center" align="center">
                    <v-col cols="12" xl="12" lg="12" md="12" sm="12" xs="12">
                        <input type="file" id="file" ref="btnUploadFile" style="display:none" @change="selectImage($event)" accept=".xlsx,.csv"/>
                        <v-btn rounded color="#47a5ad" dark @click="dialog1 = true">
                            IMPORTAR INFORMACIÓN DE GALERIAS
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
            <v-data-table
            v-if="galleries"
            :loading="loadingModels"
            :headers="galleriesHeaders"
            :items="galleries"
            :search="search"
            :items-per-page="15"
            class="elevation-1"
            >

                <template v-slot:top>
                    <v-spacer></v-spacer>
                    <v-text-field
                    class="mx-2"
                    v-model="search"
                    prepend-inner-icon="mdi-magnify"
                    outlined
                    dense
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
                        v-if="(showProgressBar && (errors != null || errors != ''))"
                        :rotate="360"
                        :size="$vuetify.breakpoint.lgAndUp ? 200 : 160"
                        :width="15"
                        :value="value"
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
                    value: 'model',
                    align: 'center',
                    sortable: false,
                },
                { text: 'Tipo', value: 'type', align: 'center' },
                { text: 'Precio', value: 'price', align: 'center' },
                { text: 'Color(es)', value: 'colors', align: 'center' }
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
