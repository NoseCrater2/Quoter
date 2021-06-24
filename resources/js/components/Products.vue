<template>
    <div id="products">
        <v-container fluid style="max-width: 1200px" class="my-4">
         
            <v-row justify="space-between">
              
                <v-col md="3" sm="12">
                  <v-row>
                    <v-col class="line" cols="12" md="12" sm="12">
                    
                        <v-list-group  :value="isMobile?false:true" v-if="lines && type">
                       <template v-slot:activator>
                         LÍNEAS {{ type.name }}
                        </template>
                        
                        <v-list-group
                        :append-icon="line.weaves > 0 ? 'mdi-chevron-down':''"
                        color="#47a5ad"
                        v-for="line in lines" :key="line.id">
                          <template v-slot:activator >
                            <v-list-item 
                            :class="$route.path.includes(line.slug)?'v-item--active v-list-item--active':''"
                            color="#47a5ad" 
                            :to="line.weaves > 0 ? {name: 'Tejidos', params: {slugLine: line.slug}} : {name: 'Products', params: {slugLine: line.slug}}">
                                <v-list-item-title>{{ line.name }}</v-list-item-title>
                            </v-list-item>
                          </template>
                          
                          <v-list-item  color="#47a5ad" v-for="(weave, index) in line.details" :key="index" :to="{name: 'Products', params: {slugLine: line.slug, slugWeave: weave.slug}}">
                            <v-list-item-title class="text-right">{{ weave.name }}</v-list-item-title>
                          </v-list-item>
                        </v-list-group>

                        
                        </v-list-group>
                   
              
                  <v-divider></v-divider>
               
                   <v-list-group :value="isMobile?false:true" v-if="types">
                       <template class="type" v-slot:activator>    
                      MENÚ DE {{slugProduct}} 
                    </template>
                        <v-list-item-group  color="#47a5ad">
                            <v-list-item 
                            v-model="selectedType"
                            :class="$route.path.includes(type.slug)?'v-item--active v-list-item--active':''"
                            v-for="type in types.types" 
                            :key="type.id" 
                            :to="type.lines > 0 ? {name: 'Lines', params: {slugType: type.slug}}:{name: 'Products', params: {slugType: type.slug}} ">
                                <v-list-item-content>
                                    <v-list-item-title v-text="type.name"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                      </v-list-group>
                      </v-col>
                      </v-row>
                </v-col>
                <v-col cols="12" md="9" sm="12" >
                  <v-row >
                    <v-col cols="12">
                    <h1 v-if="getProduct && type">{{ getProduct.name+' - '+ type.name}}</h1>
                    <div v-else-if="type" class="ma-4">
                      <h1 >{{type.name}}</h1>
                    </div>
                  
                  <div v-if="getProduct">
                      <Descriptions :nameLine="getProduct.name"/>
                  </div>
                  </v-col>
                  <v-col cols="12">
                  <v-data-iterator
                  
                  v-if="products"
                  :items="products"
                  :items-per-page="itemsPerPage"
                  :page="parseInt(page)"
                  :search="search"
                  :sort-by="sortBy"
                  :sort-desc="sortDesc"
                  hide-default-footer
                  no-data-text="No hay modelos disponibles"
                  >
                    <template v-slot:header>
                       <v-row
                        class="mt-2"
                        justify="space-between"
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
                        style="justify-content: center; display: flex;"
                        v-for="item in props.items"
                        :key="item.name"
                        cols="12"
                        sm="6"
                        md="4"
                        >
                          <v-img class="d-flex tag" width="70px" v-if="item.rotate == 1" src="/img/modelos/rotable.png"></v-img>
                        <v-hover v-slot="{ hover }" v-if="item">
                          <v-card width="240"  color="grey lighten-4"  flat >
                             <!-- -->
                            <v-img 
                            class="white--text align-end"   
                            :class="{'escalada':hover}" 
                            width="240" height="270" 
                            :aspect-ratio="16/9"  
                            :src="`/img/modelos/medium/${item.type}/${item.manufacturer}/${item.image}.jpg`" 
                            :gradient="hover?'rgba(71, 165, 173, 0.7) 100%, transparent 72px':''"  >
                              <template v-slot:placeholder>
                                <v-img src="/img/modelos/medium-unavailable.jpg"></v-img>
                              </template>
                              <v-slide-y-reverse-transition>
                                <v-card-title v-if="!hover" class="title d-flex transition-fast-in-fast-out">
                                  <b class="text-center" style="font-size: 12px; line-height: 20px;" >
                                    {{ item.name}}
                                  </b> 
                                </v-card-title> 
                              </v-slide-y-reverse-transition>
                              <v-slide-x-transition>
                                 <div
                              v-if="hover"
                              class="d-flex transition-fast-in-fast-out  v-card--reveal white--text "
                              style="height: 100%;"
                              >
                              <v-hover v-slot="{ hover }">
                              <v-btn :to="{name: 'Details', params: {slugWeave:item.weave, slugDetail: item.slug}}" depressed :outlined="!hover" tile color="white"  small>Detalles del producto</v-btn>
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
                            v-if="item.type != 'horizontal-madera-2'"
                            style="position: relative"
                            >
                            <h2 v-if="user != null" class="text-center">
                              <div class="d-block font-weight-light ">
                                $<div class="d-inline text-decoration-line-through">{{ maskPrice(item.price)[0] }}</div>
                                <div class="d-inline cents" >{{ maskPrice(item.price)[1] }}</div>
                               MXN
                              </div>
                              <div class="d-block red--text" >
                                $<div class="d-inline">
                                  {{ maskPrice(item.price - ((user.discount_percent / 100) * item.price))[0] }}
                                </div>
                                <div class="d-inline cents">
                                  {{ maskPrice(item.price - ((user.discount_percent / 100) * item.price))[1] }}
                                </div> MXN
                              </div>
                            </h2>
                            <h2 v-else class="font-weight-light black--text text-center">
                             $<div class="d-inline">{{ maskPrice(item.price)[0] }}</div>
                                <div class="d-inline cents">{{ maskPrice(item.price)[1] }}</div>
                               MXN
                            </h2>

                            </v-card-text>
                            <v-card-actions>
                              <v-spacer></v-spacer>
                              <v-btn
                              v-if="item.product != 'TOLDOS'"
                              color="#47a5ad"
                              class="white--text"
                              small
                              :to="{name:'Quoter', query:{type: item.type, line: item.line, manufacturer: item.manufacturer,variant: item.id}}"
                              >
                                COTIZAR
                              </v-btn>
                              <v-spacer></v-spacer>
                            </v-card-actions>
                          </v-card>
                        </v-hover>
                        </v-col>
                        
                      </v-row>
                    <v-divider></v-divider>
                    </template>

                    <template v-slot:footer="pagination">
                      <div style="display: none">
                          {{pagination.options.page = page }}
                      </div>
                      
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
                </v-col>
            </v-row>
            <v-dialog
            v-if="getSelectedProduct"
            v-model="dialog"
            width="700px"
            
            >
            <v-card width="700px" height="500px">
              <v-row justify="space-around">
                <v-col cols="12" md="6"  sm="12">
                  <!-- :src="`img/modelos/medium/${item.image}`" -->
                  <v-img :width="350" :height="475" :src="`/img/modelos/full/${getSelectedProduct.type}/${getSelectedProduct.manufacturer}/${getSelectedProduct.image}.jpg`" >
                      <template v-slot:placeholder>
                          <v-img src="/img/modelos/medium-unavailable.jpg"></v-img>
                      </template>
                  </v-img>
               
                </v-col>
                 <v-col cols="12" md="6"  sm="12">
                  <v-card-title>
                    <!-- <span> {{getProduct.name}} </span> -->
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
                </v-col>
              </v-row>
            </v-card>
            </v-dialog>
        </v-container>
    </div>
</template>

<script>
import { mapState } from 'vuex'
import Descriptions from './Descriptions.vue';
export default {
    data(){
        return{
         
          selectedLine: null,
          selectedType: null,
          productName: null,
          selectedIndex: 1,
           isMobile:false, 
          dialog: false,
          model: null,
          search: '',
          filter: {},
          sortDesc: false,
          page: this.$route.query.page || 1,
          itemsPerPage: 18,
          sortBy: 'price',
          keys: ['name', 'price', 'created_date'],
          chargeBlinds : true,
        }
    },

    created(){
        document.title = 'Catálogo de '+this.slugProduct
    },

     mounted(){

        this.onResize()
        window.addEventListener('resize', this.onResize, { passive: true })
        this.$store.dispatch('getWeaves',this.slugLine)
       
    },

    props:{
        slugLine: {
          type: String,
          required: false,
        },
         slugType: {
          type: String,
          required: true,
        },

        slugProduct: {
          type: String,
          required: true,
        },

        slugWeave:{
            type: String,
            required: false,
        }
    },

    computed:{

      ...mapState({
        weaves: state => state.productsModule.weaves,
        user: state => state.user,
      }),

      products(){
        if(this.slugWeave){
          return this.$store.state.productsModule.variants.filter((variant) => variant.type === this.slugType && variant.line === this.slugLine && variant.weave === this.slugWeave)
        }
        else if(this.slugLine){
          return this.$store.state.productsModule.variants.filter((variant) => variant.type === this.slugType && variant.line === this.slugLine)
        }else{
          return this.$store.state.productsModule.variants.filter((variant) => variant.type === this.slugType) 
        }
      },

      numberOfPages(){
        return Math.ceil(this.products.length / this.itemsPerPage)
      },

      type(){
        if(this.types){
          return this.types.types.find( type => type.slug === this.slugType)
        }
      },

      filteredKeys(){
        return this.keys.filter( key => key !== 'name')
      },

      types(){
         return  this.$store.getters.getTypes(this.slugProduct)
      },

      lines(){
         return  this.$store.getters.getLines(this.slugType)
    },

    getProduct(){
     return this.$store.state.productsModule.lines.find((line) => line.slug === this.slugLine) || null
    },

      getSelectedProduct(){
        return  this.$store.state.productsModule.variants.find((variant => variant.id === this.selectedIndex)) || 0
      },

    },

    


    methods: {
      nextPage(){
        this.page = parseInt(this.page)
        if(this.page + 1 <= this.numberOfPages){
         
         this.page += 1
         this.$router.push({query: {...this.$route.query, page: this.page}})
          
        } 
        
      },

      formerPage(){
       this.page = parseInt(this.page)
        if(this.page - 1 >= 1){
          this.page -= 1
          this.$router.push({query: {...this.$route.query, page: this.page}})
         
        } 
       
      },

      updateItemsPerPage(number){
        this.itemsPerPage = number
      },
      onResize(){
      this.isMobile = window.innerWidth < 958
    },

    openDialog(id){
      this.dialog = true
      this.selectedIndex = id;
    },
    maskPrice(price){
        return parseFloat(price).toFixed(2).toString().split('.')
      },
    },
    components:{
      Descriptions,
    },

  
}
</script>
        

<style>
.cents{
  position: relative;
  bottom: 0.4em;
  font-size: 0.7em;
  right: 0.4em;
}
.line > .v-list-group:first-child >.v-list-group__header{
background-color: #47a5ad;
color: white;
font-weight: bolder;
}

.line > .v-list-group:last-child >.v-list-group__header{
background-color: #867d7e;
color: white;
font-weight: bolder;
}


.v-card--reveal {
align-items: center;
bottom: 0;
justify-content: center;
position: absolute;
width: 100%;

}
.tag{
    margin-top: -8px;
    z-index: 1;
    position: absolute;
}

.title{
  background-color: #47a5ad; 
  padding: 5px; 
  word-break: break-word !important;
  line-height: 12px;
  font-size: 12px !important;
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