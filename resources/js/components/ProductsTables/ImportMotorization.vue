<template>
    <div class="text-center">
        <h2 class="mt-2 mb-5">MOTORIZACIÓN AUTOMÁTICA</h2>
        <v-card>
            <v-card-actions>
                <v-spacer></v-spacer>
                <div>
                    <input type="file" id="file" ref="btnUploadFile" style="display:none" @change="selectImage($event)" accept=".xlsx,.csv"/>
                    <v-btn rounded color="#47a5ad" dark @click="dialog1 = true">
                        IMPORTAR INFORMACIÓN DE MOTORIZACIÓN
                         <v-icon right>mdi-database-import-outline</v-icon>
                    </v-btn>
                </div>
                <v-spacer></v-spacer>
                 <v-btn rounded @click="exportarAExcel()" color="#47a5ad" dark >
                    EXPORTAR INFORMACIÓN DE MOTORIZACIÓN
                    <v-icon right>mdi-database-export-outline</v-icon>
                </v-btn>
                <v-spacer></v-spacer>
            </v-card-actions>
            <v-data-table
            v-if="motorizations"
            :loading="loadingModels"
            :headers="motorizationHeaders"
            :items="motorizations"
            :search="search"
            :items-per-page="15"
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

                <template v-slot:item.actions="{ item }">
                    <v-btn rounded color="transparent" @click="showEditMotorizationDialog(item)" depressed>
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                </template>
            </v-data-table>
        </v-card>
        <v-dialog persistent v-model="dialog1" :width="$vuetify.breakpoint.xl ? '1000' : $vuetify.breakpoint.lg ? '900' : '600'">
             <v-card tile :width="$vuetify.breakpoint.xl ? '1000' : $vuetify.breakpoint.lg ? '900' : '600'" :height="$vuetify.breakpoint.xl ? '800' : $vuetify.breakpoint.lg ? '700' : '580'" class="d-flex flex-column justify-center align-center">
                 <v-card-title>
                     IMPORTAR INFORMACIÓN DESDE ARCHIVO .XSLX O .CSV
                 </v-card-title>
                 <v-card-text class="text-center">
                     Asegurate de que tu archivo cumpla con los requisitos para ser reconocido por el sistema.
                         <div>El nombre de los encabezados debe ser correcto.</div>
                         <div>Evita escribir incorrectamente nombres de modelos, telas, persianas y fabricantes.</div>
                         <div>Evita las celdas vacías donde debe ir algún dato.</div>
                         <div>Evita poner letras donde solo van números y viceversa.</div>
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
        <v-dialog persistent v-model="showEditingDialog" max-width="500">
            <v-card >
                <v-card-title>Editar información del motor</v-card-title>
                <v-card-text>
                    <v-form >
                    <v-row no-gutters>
                        <v-col cols="6">
                             <v-text-field
                            color="#47a5ad"
                            class="ma-1"
                            dense
                            label="Código"
                            outlined
                            v-model="editedItem.code"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-select
                            :items="motorizationTypes"
                            item-text="name"
                            item-value="id"
                            item
                            color="#47a5ad"
                            class="ma-1"
                            dense
                            label="Tipo de Motorizacion"
                            outlined
                            v-model="editedItem.motorization_type_id"
                            ></v-select>
                        </v-col>
                    </v-row>
                    <v-text-field
                    color="#47a5ad"
                    class="ma-1"
                    dense
                    label="Sistema"
                    outlined
                    v-model="editedItem.system"
                    ></v-text-field>
                    <v-select
                    :items="types"
                    item-text="name"
                    item-value="id"
                    color="#47a5ad"
                    class="ma-1"
                    dense
                    label="Tipo"
                    outlined
                    v-model="editedItem.type_id"
                    ></v-select>
                    <v-row no-gutters>
                        <v-col cols="6">
                             <v-select
                            :items="lines"
                            item-text="name"
                            item-value="id"
                            item
                            color="#47a5ad"
                            class="ma-1"
                            dense
                            label="Línea"
                            outlined
                            v-model="editedItem.line_id"
                            ></v-select>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                            color="#47a5ad"
                            class="ma-1"
                            dense
                            label="Precio"
                            prefix="$"
                            outlined
                            v-model="editedItem.price"
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row no-gutters>
                        <v-col cols="6">
                        <v-text-field
                        color="#47a5ad"
                        class="ma-1"
                        dense
                        label="Alto"
                        outlined
                        v-model="editedItem.height"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                        color="#47a5ad"
                        class="ma-1"
                        dense
                        label="Ancho"
                        outlined
                        v-model="editedItem.width"
                        ></v-text-field>
                    </v-col>
                    </v-row>
                    <v-row no-gutters>
                        <v-col cols="6">
                        <v-text-field
                        color="#47a5ad"
                        class="ma-1"
                        dense
                        label="Lienzo"
                        outlined
                        v-model="editedItem.canvas"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                        color="#47a5ad"
                        class="ma-1"
                        dense
                        label="Vía"
                        outlined
                        v-model="editedItem.via"
                        ></v-text-field>
                    </v-col>
                    </v-row>
                </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="red" class="white--text" @click="closeEditingDialog()">cancelar</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="#47a5ad" class="white--text" @click="save()" :loading="loadingSaveData">guardar</v-btn>
                </v-card-actions>
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
             motorizationHeaders: [
                {
                    text: 'Código',
                    value: 'code',
                    align: 'center',
                    sortable: false,
                },
                { text: 'Sistema', value: 'system', align: 'center' },
                { text: 'Tipo', value: 'type', align: 'center' },
                { text: 'Tipo de Motorización', value: 'motorizationType', align: 'center' },
                { text: 'Precio', value: 'price', align: 'center' },
                { text: 'Linea', value: 'manufacturer', align: 'center' },
                { text: 'Lienzo', value: 'canvas', align: 'center' },
                { text: 'Alto', value: 'height', align: 'center' },
                { text: 'Ancho', value: 'width', align: 'center' },
                { text: 'Via', value: 'via', align: 'center' },
                { text: 'Acciones', value: 'actions', align: 'center' }
            ],
            editedItem: {
                canvas: null,
                code: null,
                height: null,
                id: null,
                price: null,
                system: null,
                via: null,
                width: null,
                motorization_type_id: null,
                line_id: null,
                type_id: null,
                price: null
            },
            defaultEditedItem: {
                canvas: null,
                code: null,
                height: null,
                id: null,
                price: null,
                system: null,
                via: null,
                width: null,
                motorization_type_id: null,
                line_id: null,
                type_id: null,
                price: null
            },
            showEditingDialog: false,
            loadingSaveData: false,
            motorizationTypes: [
                {
                    id: 1,
                    name: 'ELECTRICO',
                },
                {
                    id: 2,
                    name: 'RECARGABLE',
                }
            ]

        }
    },

    mounted(){
        this.$store.dispatch('getMotorizations')
    },

    computed:{
        ...mapState({
            motorizations: state => state.motorizationModule.motorizations,
            products: state => state.productsModule.products,
        }),
        types () {
            if(this.products.length > 0){
                return this.products.find(p => p.name == 'PERSIANAS').types
            }
            return []

        },
        lines () {
            if(this.types.length > 0){
                return this.types.map(t => t.lines).flat()
            }

            return [];

        }
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

        exportarAExcel(){
              axios.get('/api/exportMotorizations',{responseType: 'blob',}).then(response => {
                FileDownload(response.data, 'motorizacion.xlsx')
            });
        },

        showEditMotorizationDialog (item) {
            this.editedItem = Object.assign(this.editedItem, item)
            this.showEditingDialog = true
        },

        closeEditingDialog(){
            this.showEditingDialog = false
            this.editedItem = Object.assign(this.defaultEditedItem, {})
        },

        save(){
            if(this.editedItem.id != null){
                this.loadingSaveData = true
                 this.$store.dispatch('editMotorization', this.editedItem).then(() => {
                     this.loadingSaveData = false
                     this.closeEditingDialog();
                 }).catch(() => {
                     this.loadingSaveData = false
                 })
            }
        }
    }
}
</script>
