<template>
    <div class="text-center">
        <h2 class="mt-2 mb-5">MOTORIZACIÓN AUTOMÁTICA</h2>
        <v-card>
            <v-card-actions>
                <v-row justify="center" align="center">
                    <v-col cols="12" xl="12" lg="12" md="12" sm="12" xs="12">
                        <input type="file" id="file" ref="btnUploadFile" style="display:none" @change="selectImage($event)" accept=".xlsx,.csv"/>
                        <v-btn rounded color="#47a5ad" dark @click="dialog1 = true">
                            IMPORTAR INFORMACIÓN DE MOTORIZACIÓN
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
            <v-data-table
            v-if="motorizations"
            :loading="loadingModels"
            :headers="motorizationHeaders"
            :items="motorizations"
            :search="search"
            :items-per-page="5"
            class="elevation-1"
            >
             <!-- :src="`img/modelos/medium/${item.image}`" -->
                <template v-slot:top>
                    <v-spacer></v-spacer>
                    <v-text-field
                    class="mx-2"
                    v-model="search"
                    outlined
                    dense
                    prepend-inner-icon="mdi-magnify"
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
             motorizationHeaders: [
                {
                    text: 'Código',
                    value: 'code',
                    align: 'center',
                    sortable: false,
                },
                { text: 'Sistema', value: 'system', align: 'center' },
                { text: 'Tipo', value: 'type', align: 'center' },
                { text: 'Linea', value: 'manufacturer', align: 'center' },
                { text: 'Lienzo', value: 'canvas', align: 'center' },
                { text: 'Alto', value: 'height', align: 'center' },
                { text: 'Ancho', value: 'width', align: 'center' },
                { text: 'Via', value: 'via', align: 'center' },
                { text: 'Descripción', value: 'description', align: 'center' }
            ],

        }
    },

    mounted(){
        this.$store.dispatch('getMotorizations')
    },

    computed:{
        ...mapState({
            motorizations: state => state.motorizationModule.motorizations,
        }),
    },
    methods :{
        selectImage(event){
            this.showProgressBar = true
            this.file = event.target.files[0];
            let formData = new FormData();

            formData.append('file',this.file);

            axios.post( '/api/importMotorizations',
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
               this.$store.dispatch('getMotorizations')
                this.showProgressBar = false
            })
            .catch( errors => {
                this.errors2 =  errors2.response.data.errors
            });
        },
    }
}
</script>
