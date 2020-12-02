<template>
    <div id="products">
        <v-container fluid style="max-width: 1200px" class="my-4">
         
            <v-row justify="space-between">
                <v-col md="3" v-if="!isMobile">
                  <v-card flat >
                      <v-list shaped v-if="lines">
                        <v-subheader>PRODUCTOS DE TIPO</v-subheader>
                        <v-list-item-group v-model="selectedType" color="#47a5ad">
                            <v-list-item v-for="line in lines" :key="line.id" :to="{name: 'Products', params: {slugModel: line.slug}}">
                                <v-list-item-content>
                                    <v-list-item-title v-text="line.name"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                      </v-list>
                  </v-card>
                  <v-divider></v-divider>
                  <v-card flat>
                   
                    <v-list shaped v-if="types" >
                        <v-subheader>PRODUCTOS DE ESTA CATEGORÍA</v-subheader>
                        <v-list-item-group v-model="selectedLine" color="#47a5ad">
                            <v-list-item 
                            v-for="type in types" 
                            :key="type.id" 
                            :to="type.lines > 0 ?{name: 'Lines', params: {slugLine: type.slug}}
                            :{name: 'Products', params: {slugModel: type.slug}}">
                                <v-list-item-content>
                                    <v-list-item-title v-text="type.name"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                      </v-list>
                  
                  </v-card>
                </v-col>
                <v-col cols="12" md="9" sm="12" >
                  <h1>{{getProduct.name}}</h1>
                  <v-data-iterator
                  v-if="products || sunblinds"
                  :items="chargeVariants ? products : sunblinds"
                  :items-per-page="itemsPerPage"
                  :page="page"
                  :search="search"
                  :sort-by="sortBy"
                  :sort-desc="sortDesc"
                  hide-default-footer
                  >
                    <template v-slot:header>
                       <v-row
                        class="mt-2"
                        align="center"
                        justify="center"
                        >
                     <v-spacer></v-spacer>

                     <span class="mr-4 grey--text"> Página {{page}} de {{numberOfPages}}</span>
                     <v-btn
                     fab
                     dark
                     depressed
                     color="white"
                     class="mr-1"
                     @click="formerPage()"
                     ><v-icon color="black">mdi-chevron-left</v-icon>
                     </v-btn>

                     <v-btn
                     depressed
                     fab
                     dark
                     color="white"
                     class="mr-1"
                     @click="nextPage()"
                     ><v-icon color="black">mdi-chevron-right</v-icon>
                     </v-btn>
                     <v-spacer></v-spacer>
                      <v-toolbar
                     
                      flat
                      class="mb-1"
                      >
                        <template >
                            
                            <v-select
                            color="black"
                            v-model="sortBy"
                            flat
                            hide-details
                            :items="keys"
                            label="Ordenar por"
                            ></v-select>
                            <v-spacer></v-spacer>
                        </template>
                      </v-toolbar>
                        </v-row>
                     
                      <v-divider></v-divider>
                    </template>
                    
                    <template v-slot:default="props">
                      <v-row>
                        <v-col
                        v-for="item in props.items"
                        :key="item.name"
                        cols="12"
                        sm="6"
                        md="4"
                        lg="3"
                        >
                        <v-hover v-slot="{ hover }">
                          <v-card max-width="240" height="340" color="grey lighten-4" class="mx-auto" flat>
                             <!-- -->
                            <v-img class="white--text align-end"  :class="{'escalada':hover}" width="240" height="270" :aspect-ratio="16/9"  :src="`../../img/modelos/medium/${item.image}.jpg`" :gradient="hover?'rgba(71, 165, 173, 0.7) 100%, transparent 72px':''"  >
                              <v-slide-y-reverse-transition>
                                <v-card-title v-if="!hover" class="title d-flex transition-fast-in-fast-out justify-center"> <b class="text-center">{{ item.name}}</b> </v-card-title> 
                              </v-slide-y-reverse-transition>
                              <v-slide-x-transition>
                                 <div
                              v-if="hover"
                              class="d-flex transition-fast-in-fast-out  v-card--reveal white--text "
                              style="height: 100%;"
                              >
                              <v-hover v-slot="{ hover }">
                              <v-btn :to="item.isSunblind?{name: 'SunblindDetails', params: {slugDetail2: item.slug}}:{name: 'Details', params: {slugDetail: item.slug}}" depressed :outlined="!hover" tile color="white"  small>Detalles del producto</v-btn>
                              </v-hover>
                              </div>
                              </v-slide-x-transition>
                            <v-expand-transition>
                                <div
                              v-if="hover"
                              class="d-flex transition-fast-in-fast-out  v-card--reveal white--text"
                              style="height: 20%;"
                              >
                              <v-hover v-slot="{ hover }">
                              <v-btn @click="openDialog(item.id)" depressed :outlined="!hover" tile color="white"  small><v-icon>mdi-arrow-expand</v-icon></v-btn>
                              </v-hover>
                              </div>
                            </v-expand-transition>
                            </v-img>
                            <v-card-text
                            
                            style="position: relative"
                            >
                            <h2 class=" font-weight-light black--text text-center">
                             ${{ item.price}}
                            </h2>
                           
                            </v-card-text>
                          </v-card>
                        </v-hover>
                          
                        </v-col>
                        
                      </v-row>
                    <v-divider></v-divider>
                    </template>

                    <template v-slot:footer>
                        
                        <v-row
                        class="mt-2"
                        align="center"
                        justify="center"
                        >
                     <v-spacer></v-spacer>

                     <span class="mr-4 grey--text"> Página {{page}} de {{numberOfPages}}</span>
                     <v-btn
                     fab
                     dark
                     depressed
                     color="white"
                     class="mr-1"
                     @click="formerPage()"
                     ><v-icon color="black">mdi-chevron-left</v-icon>
                     </v-btn>

                     <v-btn
                     depressed
                     fab
                     dark
                     color="white"
                     class="mr-1"
                     @click="nextPage()"
                     ><v-icon color="black">mdi-chevron-right</v-icon>
                     </v-btn>
                     <v-spacer></v-spacer>
                        </v-row>
                    </template>

                    </v-data-iterator>
                </v-col>
            </v-row>
            <v-dialog
            v-model="dialog"
            width="700px"
            
            >
            <v-card width="700px" height="500px">
              <v-row justify="space-around">
                <v-col cols="12" md="6"  sm="12">
                  <!-- :src="`img/modelos/medium/${item.image}`" -->
                  <vue-h-zoom :width="350" :height="475" :image="`../../img/modelos/full/${getSelectedProduct.image}.jpg`"  :zoom-level="2" :zoom-window-size="1">

                  </vue-h-zoom>
               
                </v-col>
                 <v-col cols="12" md="6"  sm="12">
                  <v-card-title>
                    <span> {{getProduct.name}} </span>
                    <v-spacer></v-spacer>
                    <v-tooltip top>
                      <template v-slot:activator="{ on, attrs }">
                         <v-btn icon v-bind="attrs" v-on="on" @click="dialog = false">
                           <v-icon>mdi-close-thick</v-icon>
                          </v-btn>
                      </template>
                      <span>Cerrar</span>
                    </v-tooltip>
                  </v-card-title>
                  <v-card-subtitle class="display-1" >
                    <p style="color: #000"> {{ getSelectedProduct.name }}</p>
                  </v-card-subtitle>
                  <v-card-subtitle class="display-2" >
                    <p style="color: #47a5ad">$ {{ getSelectedProduct.price }}</p>
                  </v-card-subtitle>
                  <v-card-text>
                   <v-list-item v-if="true" >
                     <v-list-item-icon><v-icon color="#47a5ad">mdi-clipboard-check</v-icon></v-list-item-icon>
                     <v-list-item-title style="color: #47a5ad" >En Stock</v-list-item-title>
                   </v-list-item>
                   <v-list-item v-else >
                     <v-list-item-icon><v-icon color="red">mdi-cancel</v-icon></v-list-item-icon>
                     <v-list-item-title style="color: red">Fuera de stock</v-list-item-title>
                   </v-list-item>
                  </v-card-text>
                  <div id="box2">

                  </div>
                  
                </v-col>
              </v-row>
            </v-card>
            </v-dialog>
        </v-container>
    </div>
</template>

<script>
import VueHZoom from 'vue-h-zoom';
import { mapActions, mapState, productModule} from 'vuex';
export default {
    data(){
        return{
          selectedLine: 1,
          selectedType: 1,
          productName: null,
          selectedIndex: 1,
           isMobile:false, 
          dialog: false,
          model: null,
          search: '',
          filter: {},
          sortDesc: false,
          page: 1,
          itemsPerPage: 16,
          sortBy: 'price',
          keys: ['name', 'price', 'created_date'],
          chargeVariants : null,
        }
    },

     mounted(){  

       if(this.isWeave){
         this.chargeVariants = false
         this.$store.dispatch('getSunblinds',this.getProduct.id) 
       }else if(this.getProduct.hasOwnProperty('lines')){
         this.chargeVariants = true
           this.$store.dispatch('getVariantsByType',this.getProduct.id) 
        }else{
          this.chargeVariants = true
          this.$store.dispatch('getVariantsByLine',this.getProduct.id) 
        }
    
      this.onResize()
      window.addEventListener('resize', this.onResize, { passive: true })

      console.log(this.sunblinds)

     
    },

    props:{
        slugModel: {
          type: String,
          required: true,
        },

        isWeave:{
           type: Boolean,
        }
    },

    computed:{
      ...mapState({
     products: state => state.productsModule.variants,
     sunblinds: state => state.productsModule.sunblinds,
      types: state => state.productsModule.types,
      lines: state => state.productsModule.lines,
    }),
      numberOfPages(){
        return Math.ceil(this.products.length / this.itemsPerPage)
      },

      filteredKeys(){
        return this.keys.filter( key => key !== 'name')
      },

      getProduct(){
         return  this.$store.state.productsModule.lines.find((line => line.slug === this.slugModel)) ||
                this.$store.state.productsModule.types.find((type => type.slug === this.slugModel)) ||
                this.$store.state.productsModule.weaves.find((weave => weave.slug == this.slugModel))
      },

      getSelectedProduct(){
        return  this.$store.state.productsModule.variants.find((variant => variant.id === this.selectedIndex)) ||
                this.$store.state.productsModule.sunblinds.find((sunblind => sunblind.id === this.selectedIndex)) || 
                0
      },
    },


    methods: {
      nextPage(){
        if(this.page + 1 <= this.numberOfPages) this.page += 1
      },

      formerPage(){
        if(this.page - 1 >= 1) this.page -= 1
      },

      updateItemsPerPage(number){
        this.itemsPerPage = number
      },
      onResize(){
      this.isMobile = window.innerWidth < 767
    },

    openDialog(id){
      this.dialog = true
      this.selectedIndex = id;
    }
    },
    components:{
      VueHZoom,
    }
}
</script>

<style>

.v-card--reveal {
align-items: center;
bottom: 0;
justify-content: center;
position: absolute;
width: 100%;

}

.title{
  background-color: #47a5ad; padding: 5px; font-size: 1rem; word-break: break-word !important;
}

.escalada{
   transform: scale(1.02);
    -moz-transform: scale(1.02);
    -webkit-transform: scale(1.02);
    -o-transform: scale(1.02);
    -ms-transform: scale(1.02);
    transition-duration: 0.5s;
}

</style>