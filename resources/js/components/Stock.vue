<template>
    <div id="app">
        <v-app id="inspire">
            <div class="text-center">
               
                <v-row justify="center" >
                  <v-col cols="12" md="12" sm="12">
                      <TableProduct v-if="getProduct" :product="getProduct" />
                  </v-col>
                </v-row>
                <v-row justify="center">
                  <v-col cols="6" md="6" sm="12">
                   <TypesList v-if="getProduct" :product="getProduct"/>
                  </v-col>
                  <v-col cols="6" md="6" sm="12">
                    <v-card >
                    <v-toolbar color="black" class="white--text">
                    <v-toolbar-title>Fabricantes</v-toolbar-title>
                    </v-toolbar>  
                    <v-list>
                        <v-list-item-group
                            v-model="selected3"
                            active-class="black--text"
                            multiple
                          >
                            <template v-for="(manufacturer, m) in manufacturers">
                              <v-list-item :key="manufacturer.id">
                                <template >
                                  <v-list-item-content>
                                    <v-list-item-title v-text="manufacturer.name"></v-list-item-title>
                                  </v-list-item-content> 
                                </template>
                              </v-list-item>
                              <v-divider
                                v-if="m < manufacturers.length - 1"
                                :key="m"
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
import TableProduct from './ProductsTables/ImportExport';
import TypesList from './ProductsTables/TypesList';

export default {

    data () {
    return {
      isEdited: false,
      change: false,
     
      
      loadingFullFile: false,
      selected: [2],
      selected2: [2],
      selected3: [2],

     

      colorsHeaders: [
        {
          text: 'Color',
          align: 'start',
          sortable: true,
          value: 'color',
        },
        { text: 'Codigo', value: 'code', sortable: false},
       
      ],
    }
  },

  components: {
    TableProduct, 
    TypesList,
  },

  props:{
    slugProduct:{
      type: String,
      required: true,
    }
  },


  mounted(){

  },

  computed:{
     ...mapState({
      manufacturers: state => state.modelsModule.manufacturers,
    }),

    getProduct(){
         return  this.$store.state.productsModule.products.find((product => product.slug === this.slugProduct))
    },
  },
  methods:{
 
  },

    
}
</script>

<style scoped>

.forEdit{
  box-shadow:none !important;
  width: fit-content;
}

.v-text-field.v-text-field--solo:not(.v-text-field--solo-flat)>.v-input__control>.v-input__slot {
    box-shadow:none !important;
}
</style>