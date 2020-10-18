<template>
    <div id="app">
        <v-app id="inspire">
            <div class="text-center">
                <input type="file" id="file" ref="btnUploadFile" style="display:none" @change="selectImage($event)" accept=".xlsx,.csv"/>
                <v-btn rounded color="#188038" dark class="ma-4" @click="$refs.btnUploadFile.click()">
                  IMPORTAR
                  <v-icon right> mdi-microsoft-excel</v-icon>
                </v-btn>
                <v-row justify="center" >
                  <v-col cols="12" md="6" sm="12">
                     <v-card>
                    <v-data-table
                        :loading="loadingModels"
                        :headers="modelsHeaders"
                        :items="models"
                        :items-per-page="5"
                        class="elevation-1"
                    ></v-data-table>
                </v-card>
                  </v-col>
                  <v-col cols="12" md="6" sm="12">
                     <v-card>
                    <v-data-table
                        :loading="loadingColors"
                        :headers="colorsHeaders"
                        :items="colors"
                        :items-per-page="5"
                        class="elevation-1"
                    ></v-data-table>
                </v-card>
                  </v-col>
                </v-row>
                <v-row justify="center">
                  <v-col cols="4" md="4" sm="12">
                    <v-card >
                    <v-toolbar color="black" class="white--text">
                    <v-toolbar-title>Persianas</v-toolbar-title>
                    </v-toolbar>  
                    <v-list >
                        <v-list-item-group
                            v-model="selected"
                            active-class="black--text"
                            multiple
                          >
                            <template v-for="(type, index) in types">
                              <v-list-item :key="type.id">
                                <template v-slot:default="{ active }">
                                  <v-list-item-content>
                                    <v-list-item-title v-text="type.name"></v-list-item-title>
                                  </v-list-item-content> 
                                </template>
                              </v-list-item>
                              <v-divider
                                v-if="index < types.length - 1"
                                :key="index"
                              ></v-divider>
                            </template>
                          </v-list-item-group>
                        </v-list>
                </v-card>
                  </v-col>
                  <v-col cols="4" md="4" sm="12">
                     <v-card >
                    <v-toolbar color="black" class="white--text">
                    <v-toolbar-title>Líneas</v-toolbar-title>
                    </v-toolbar>  
                    <v-list>
                        <v-list-item-group
                            v-model="selected"
                            active-class="black--text"
                            multiple
                          >
                            <template v-for="(line, index) in lines">
                              <v-list-item :key="line.id">
                                <template v-slot:default="{ active }">
                                  <v-list-item-content>
                                    <v-list-item-title v-text="line.name"></v-list-item-title>
                                  </v-list-item-content> 
                                </template>
                              </v-list-item>
                              <v-divider
                                v-if="index < lines.length - 1"
                                :key="index"
                              ></v-divider>
                            </template>
                          </v-list-item-group>
                        </v-list>
                </v-card>
                  </v-col>
                  <v-col cols="4" md="4" sm="12">
                    <v-card >
                    <v-toolbar color="black" class="white--text">
                    <v-toolbar-title>Fabricantes</v-toolbar-title>
                    </v-toolbar>  
                    <v-list>
                        <v-list-item-group
                            v-model="selected"
                            active-class="black--text"
                            multiple
                          >
                            <template v-for="(manufacturer, index) in manufacturers">
                              <v-list-item :key="manufacturer.id">
                                <template v-slot:default="{ active }">
                                  <v-list-item-content>
                                    <v-list-item-title v-text="manufacturer.name"></v-list-item-title>
                                  </v-list-item-content> 
                                </template>
                              </v-list-item>
                              <v-divider
                                v-if="index < manufacturers.length - 1"
                                :key="index"
                              ></v-divider>
                            </template>
                          </v-list-item-group>
                        </v-list>
                </v-card>
                  </v-col>
                </v-row>
            </div>
        </v-app>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
export default {

    data () {
    return {
      file: null,
      loadingModels: false,
      loadingColors: false,
      selected: [2],

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

      colorsHeaders: [
        {
          text: 'Color',
          align: 'start',
          sortable: true,
          value: 'color',
        },
        { text: 'Imagen', value: 'image', sortable: false},
       
      ],
    }
  },

  mounted(){
    this.loadingModels = true
    this.loadingColors = true
    this.loadData()
   
  },

  computed:{
     ...mapState({
      models: state => state.modelsModule.models,
      types: state => state.modelsModule.types,
      lines: state => state.modelsModule.lines,
      colors: state => state.modelsModule.colors,
      manufacturers: state => state.modelsModule.manufacturers,
    }),
  },
  methods:{
       selectImage(event){
         console.log('llegó aquí')
         
     this.file = event.target.files[0];
     let formData = new FormData();

     formData.append('file',this.file);

     axios.post( '/api/importExcel',
                    formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(function(){
                   this.loadData();
                })
                .catch(function(){
                    console.log('FAILURE!!');
                });
    //this.file = null
   },

   loadData(){
      this.$store.dispatch('getModels').then(()=>{
      this.loadingModels = false
    })
    this.$store.dispatch('getColors').then(()=>{
      this.loadingColors = false
    })
    this.$store.dispatch('getTypes')
    this.$store.dispatch('getLines')
    this.$store.dispatch('getManufacturers')
   }
  }
    
}
</script>