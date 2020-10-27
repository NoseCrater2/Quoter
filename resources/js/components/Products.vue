<template>
    <div id="products">
        <v-container fluid style="max-width: 1400px" class="my-4">
         
            <v-row justify="space-around">
                <v-col md="3" v-if="!isMobile">
                  <v-card flat>
                    <v-card-title >PRODUCTOS DESTACADOS</v-card-title>
                    <v-card-subtitle v-if="false" style="background: lightgoldenrodyellow;">No hay productos</v-card-subtitle>
                    <v-row v-else justify="space-around" class="ma-4">
                      <v-col>
                        <v-img width="50" height="90" src="https://cdn.vuetifyjs.com/images/cards/kitchen.png"></v-img>
                      </v-col>
                      <v-col>
                        <v-btn text color="primary"> SCREEN VX STUCCO</v-btn>
                      </v-col>
                    </v-row>
                  </v-card>
                  <v-card flat>
                    <v-card-title>PRODUCTOS MÁS VISTOS</v-card-title>
                    <v-card-subtitle v-if="false" style="background: lightgoldenrodyellow;">No hay productos</v-card-subtitle>
                    <v-row v-else justify="space-around" class="ma-4">
                      <v-col>
                        <v-img width="50" height="90" src="https://cdn.vuetifyjs.com/images/cards/kitchen.png"></v-img>
                      </v-col>
                      <v-col>
                        <v-btn text color="primary"> SCREEN VX STUCCO</v-btn>
                      </v-col>
                    </v-row>
                  </v-card>
                  <v-card flat>
                    <v-card-title>INFORMACIÓN ADICIONAL</v-card-title>
                    <v-card-text color="yellow">
                      Transformer theme is an elegant, powerful and fully responsive
                      prestashop theme with modern design. Suitable for every type of store.
                      This is a custom block edited from admin panel.You can insert any content here.
                      Any orders placed through this store will not be honored or fulfilled
                      </v-card-text>
                  </v-card>
                </v-col>
                <v-col cols="12" md="9" sm="12">
                   <h1 class="ma-4">{{ productName }}</h1>
                  <v-data-iterator
                  :items="products"
                  :items-per-page="itemsPerPage"
                  :page="page"
                  :search="search"
                  :sort-by="sortBy"
                  :sort-desc="sortDesc"
                  hide-default-footer
                  >
                    <template v-slot:header>
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
                            <v-img class="white--text align-end" :class="{'escalada':hover}" width="240" height="270" :aspect-ratio="16/9" :src="item.image" :gradient="hover?'rgba(71, 165, 173, 0.7) 100%, transparent 72px':''"  >
                              <v-slide-y-reverse-transition>
                                <v-card-title v-if="!hover" class="title d-flex transition-fast-in-fast-out"  > <b class="text-center">{{ item.name}}</b> </v-card-title> 
                              </v-slide-y-reverse-transition>
                              <v-slide-x-transition>
                                 <div
                              v-if="hover"
                              class="d-flex transition-fast-in-fast-out  v-card--reveal white--text"
                              style="height: 100%;"
                              >
                              <v-hover v-slot="{ hover }">
                              <v-btn :to='"/details/type/"+productId+"/product/"+item.id' depressed :outlined="!hover" tile color="white"  small>Detalles del producto</v-btn>
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
 
                  <vue-h-zoom :width="350" :height="475" :image="products[selectedIndex -1].image"  :zoom-level="2" :zoom-window-size="1">

                  </vue-h-zoom>
               
                </v-col>
                 <v-col cols="12" md="6"  sm="12">
                  <v-card-title>
                    <span> {{products[selectedIndex - 1].name }} </span>
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
                  <v-card-subtitle class="display-2" >
                    <p style="color: #47a5ad">$ {{ products[selectedIndex - 1].price }}</p>
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
export default {
    data(){
        return{
          productName: null,
          productId: 0,
          selectedIndex: 1,
           isMobile:false, 
          dialog: false,
          model: null,
          search: '',
          filter: {},
          sortDesc: false,
          page: 1,
          itemsPerPage: 4,
          sortBy: 'price',
          keys: ['name', 'price', 'created_date'],
        }
    },

     mounted(){  
      this.onResize()
      window.addEventListener('resize', this.onResize, { passive: true })
      this.productName = this.$route.params.name
      this.productId = this.$route.params.id
     
    },

    props:{
        value: null,
        products: {
            type: Array,
            required: true
        }
    },

    computed:{
      numberOfPages(){
        return Math.ceil(this.products.length / this.itemsPerPage)
      },

      filteredKeys(){
        return this.keys.filter( key => key !== 'name')
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
      this.selectedIndex = id;  
      this.dialog = true;
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