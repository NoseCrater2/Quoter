<template>
  <div id="app">
    <v-app>
      <TheNavigationDrawer v-if="drawer" :products="products" :draw="drawer" />
     
            <!-- COMIENZA BARRA BLANCA -->
            <v-row justify="center" class="mx-3">
            <v-card v-if="!isMobile" width="1200px" class="d-flex" tile flat>
            
                        <v-card tile flat class="mr-auto" :to="{name: 'Home'}">
                             <v-img width="200"  src="/img/logo.svg" ></v-img>
                        </v-card>                          
                   
                     
                            <v-card tile  flat class="mt-6" >
                          <v-btn  x-small icon color="#3b5999" fab href="https://www.facebook.com/rolluxmexico"  class="mr-3">
                            <v-icon  size="30">mdi-facebook</v-icon>
                          </v-btn>
                           <v-btn icon  x-small color="#2caae1" fab href="https://twitter.com/rolluxmexico" class="mr-3">
                            <v-icon size="30">mdi-twitter</v-icon>
                          </v-btn>
                          <v-btn  icon x-small fab  class="mr-3">
                              <v-img src="/img/instagram-logo.png" ></v-img>
                          </v-btn>
                           <v-btn icon  x-small color="#cc2127" href="https://www.pinterest.com.mx/rolluxmexico" fab class="mr-3" >
                            <v-icon size="30">mdi-pinterest</v-icon>
                          </v-btn>
                        </v-card> 
                    
            </v-card>
            </v-row>
            <!-- TERMINA BARRA BLANCA -->
           
              
         

            <!-- COMIENZA BARRA DE NAVEGACIÓN -->         
            <v-app-bar ref="mybar" :color="isMobile?'white':'#47a5ad'" style="position: sticky; top:0; z-index: 7" >
             
                 <v-app-bar-nav-icon v-if="isMobile" @click="drawer = true">
                 </v-app-bar-nav-icon>
                 <v-spacer></v-spacer>
                   <v-img v-if="isMobile" max-width="190px"  src="/img/logo.svg" ></v-img>
                   <v-spacer></v-spacer>
                   <v-expand-transition>
                   <v-text-field
                    color="#47a5ad"
                    class="mt-8"
                    placeholder="Buscar producto"
                    single-line
                    solo
                    v-if="showSearch"
                    @blur="showSearch = false"
                    >
                </v-text-field>
                  </v-expand-transition>
          <v-btn icon v-if="isMobile" @click="showSearch = true">
              <v-icon color="#47a5ad">mdi-magnify</v-icon>
          </v-btn>
           
             <template v-if="!isMobile" v-slot:default="{}" >
              
                  <v-menu open-on-hover offset-y>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn class="white--text " style="justify-content:left" depressed tile color="#404042" width="250px" height="65px" v-bind="attrs" v-on="on">
                              <div v-if="$refs.mybar">
                               
                               <v-img v-if="$refs.mybar._data.currentScroll >= 138" width="40px" class="ml-n2" :src="'../../img/white-r.png'?'../../img/white-r.png':'img/white-r.png'"></v-img>
                                <v-icon  v-else left>mdi-menu</v-icon>   
                              </div>
                            PRODUCTOS
                          
                        </v-btn>
                    </template>
                    <v-card tile>
                        <v-list  flat dark>
                            <v-list-item-group  >
                              <v-list-item v-for="p in products" :key="p.id" :to="{name: 'Categories', params: {slugType: p.slug}}" style="border-bottom: 1px solid gray">
                                <v-list-item-content>
                                  <v-list-item-title class="white--text" > {{ p.name }} </v-list-item-title>
                                </v-list-item-content>
                                
                              </v-list-item>
                             
                            </v-list-item-group>
                        </v-list>
                    </v-card>
                </v-menu>
                <v-btn icon color="white" :to="{name:'Home'}" >
                    <v-icon size="30">mdi-home</v-icon>
                </v-btn>
                <v-btn color="white" text height="65px" to="/aboutus" >Nosotros</v-btn>
                <v-btn color="white" text height="65px">Galería</v-btn>
                <v-btn color="white" text height="65px" to="/contact">Contáctanos</v-btn>
                <v-spacer  ></v-spacer>
                <v-menu :offset-y="true" max-width="370" >
                  <template v-slot:activator="{on, attrs }">
                <v-text-field
                v-bind="attrs"
                v-on="on"
                color="#47a5ad" 
                class="mt-8"
                single-line
                solo
                placeholder="Buscar producto"
                append-icon="mdi-magnify"
                v-model="query"
                >
              </v-text-field>
              </template>

              <v-list three-line max-height="500" color="white">
                <template v-for="item in items" >
                  <!-- Window-shutter
                  blinds
                  storefront -->
                   <v-divider :key="item.title"></v-divider>
                  <v-list-item :key="item.searchable.id" style="background-color: white" :to="{name: 'Details', params: {slugDetail: item.url, id: item.searchable.id}}">
                
                      <v-img max-width="60" :src="`../img/modelos/tumb/${item.searchable.colors[0].code}.jpg`"></v-img>
                 
                    <v-list-item-content class="ma-1">
                      <v-list-item-title style="font-size: 1em;" >{{item.searchable.name}}</v-list-item-title>
                      <v-list-item-subtitle style="color: #47a5ad; font-size: 1em" >${{item.searchable.price}}MXN</v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-action>
                      <v-icon color="#47a5ad" v-if="item.searchable.type_id === 1">mdi-blinds</v-icon>
                      <v-icon color="#47a5ad" v-if="item.searchable.type_id === 2">mdi-script</v-icon>
                      <v-icon color="#47a5ad" v-if="item.searchable.type_id === 3">mdi-storefront</v-icon>
                    </v-list-item-action>
                  </v-list-item>
                </template>
              </v-list>
              </v-menu>
       
       
            </template>
            
             </v-app-bar>
              
              

             <!-- TERMINA BARRA DE NAVEGACIÓN -->

             <v-main>
                <!-- <v-btn max-width="500" tile left fixed style="z-index: 100"> -->
                  <v-container  style="width: 1200px; margin: auto" class="pa-0">
                
                 <v-breadcrumbs 
               :items="breadCrumbs"
               divider=">"
               class="pa-3"
               v-if="breadCrumbs.length > 1"
               >

               <template v-slot:divider>
                <v-icon>mdi-chevron-right</v-icon>
                </template>
                 <template v-slot:item="props">
                   <router-link style="text-decoration: none" :to="props.item.to" v-if="!props.item.disabled">
                      <v-breadcrumbs-item
                      style="color: #47a5ad"
                      :class="[props.item.disabled && 'disabled']">
                       {{props.item.text}}
                      </v-breadcrumbs-item>
                    </router-link>
                  </template>
                
               </v-breadcrumbs>
               </v-container>
                     <div>
                      <v-btn v-if="$router.currentRoute.name !== 'Quoter'"  :to="{name:'Quoter'}" class="vertical" right fixed top tile height="54px"  width="240px" style="margin-right: -95px; z-index:5; border-radius: 15px 15px 0px 0px;"  dark x-large color="#f1c40f">      
                      <v-icon size="40" class="horizontal" left>mdi-calculator</v-icon>
                       <b><p style="font-size: 1.2em" class="my-4 ml-4 mr-n5">COTIZADOR</p></b>
                    </v-btn>
                 </div>
                  <v-btn   @click="dialog = true" right fixed top tile height="50px" max-width="55px" min-width="40px" style="margin-top: 150px; z-index:5; border-radius: 15px 0px 0px 15px;"   dark  color="#47a5ad"><v-icon size="30" dark>mdi-email</v-icon></v-btn>  
               
               <transition name="slide" mode="out-in">
                  <router-view :key="$route.path"></router-view>
               </transition>
               

                   <!-- BOTÓN FLOTANTE MESSENGER-->           
                    <v-btn right  bottom   fixed style="margin-bottom: 80px!important;" fab dark color="#0084ff"><v-icon size="30" dark>mdi-facebook-messenger</v-icon></v-btn> 
              
               <!-- BOTÓN FLOTANTE WHATSAPP-->
                     <v-btn right  bottom  fixed href="https://api.whatsapp.com/send?phone=5214434713271"   fab dark  color="#26d367"><v-icon size="30" dark>mdi-whatsapp</v-icon></v-btn> 

            </v-main>

             <!-- EMPIEZA FOOTER -->
             <v-footer color="#47a5ad" >
               <v-container fluid style="max-width: 1200px" >
                 <v-row justify="space-between">
                     <v-col cols="12" md="3" sm="6" class="white--text" align-self="start" >
                       <v-list-item dense> 
                           <v-img  max-width="250px" src="/img/white-logo.svg" > </v-img>
                        </v-list-item >
                        <v-list-item dark dense>
                            ventas@rollux.com.mx
                        </v-list-item>
                         <v-list-item dark dense>
                            distribuidores@rollux.com.mx
                        </v-list-item>
                        <v-list-item dark dense>
                            De Lunes a Viernes
                            9:00 am a 05:00 pm      
                        </v-list-item>                                
                         </v-col>

                     <v-col cols="12" md="3" sm="6"  class=" white--text"  >
                         <v-list-item dark>
                             <v-list-item-icon>
                                <v-icon size="50">mdi-cellphone-android</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                  <strong> DESCARGA LA APP DEL COTIZADOR</strong>
                            </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-img max-width="250px"  class="mt-2" src="/img/googleplay.png" ></v-img>
                           </v-list-item>
                            <v-list-item dark>
                                <v-list-item-content>
                                <div :class="{'text-center':!isMobile}"> <b>SÍGUENOS EN:</b> </div>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>                           
                                <v-btn dark  x-small icon href="https://www.facebook.com/rolluxmexico"  fab>
                                    <v-icon   size="30">mdi-facebook</v-icon>
                                </v-btn><v-spacer v-if="!isMobile"></v-spacer>
                                 <v-btn dark icon  x-small href="https://twitter.com/rolluxmexico"  fab>
                                    <v-icon size="30">mdi-twitter</v-icon>
                                </v-btn><v-spacer v-if="!isMobile"></v-spacer>
                                <v-btn dark  icon x-small fab>
                                    <v-icon size="30">mdi-instagram</v-icon>
                                </v-btn><v-spacer v-if="!isMobile"></v-spacer>
                                <v-btn dark icon href="https://www.pinterest.com.mx/rolluxmexico"  x-small fab>
                                    <v-icon size="30">mdi-pinterest</v-icon>
                                </v-btn>                          
                            </v-list-item>     
                     </v-col>

                     <v-col cols="12" md="3" sm="6" class=" white--text "  align-self="start">
                      
                       <v-list-group :value="isMobile?false:true"  color="white" dark >
                         <template v-slot:activator>
                          
                            <v-list-item-title style="color: white;" dark> <b>PRODUCTOS</b> </v-list-item-title>
                         </template>
                            
                         <v-list-item class="mt-n4" dark>
                             <v-list-item-icon><v-icon>mdi-chevron-right</v-icon></v-list-item-icon>
                               <v-list-item-content>PERSIANAS </v-list-item-content>
                        </v-list-item>
                        <v-list-item class="mt-n4" dark>
                             <v-list-item-icon><v-icon>mdi-chevron-right</v-icon></v-list-item-icon>                          
                             <v-list-item-content>CORTINAS </v-list-item-content>
                        </v-list-item> 
                        <v-list-item class="mt-n4" dark> 
                             <v-list-item-icon><v-icon>mdi-chevron-right</v-icon></v-list-item-icon>                          
                             <v-list-item-content>TOLDOS </v-list-item-content>  
                        </v-list-item>  
                       </v-list-group>
                      
                      
                     </v-col>
                     <v-col cols="12" md="3" sm="6" class=" white--text"  align-self="start">
                          <v-list-group :value="isMobile?false:true"  color="white" dark >
                         <template v-slot:activator>
                          <v-list-item-title style="color: white;" dark> <b>POLÍTICAS</b> </v-list-item-title>
                            </template>
                         <v-list-item dark class="mt-n6">
                             <v-list-item-icon><v-icon>mdi-chevron-right</v-icon></v-list-item-icon>
                               <v-list-item-content>Envíos</v-list-item-content>
                        </v-list-item>
                        <v-list-item dark class="mt-n6">
                             <v-list-item-icon><v-icon>mdi-chevron-right</v-icon></v-list-item-icon>                          
                             <v-list-item-content>Términos y Condiciones</v-list-item-content>
                        </v-list-item> 
                        <v-list-item dark class="mt-n6" :to="{name: 'Legal'}"> 
                             <v-list-item-icon><v-icon>mdi-chevron-right</v-icon></v-list-item-icon>                          
                             <v-list-item-content>Aviso de Privacidad</v-list-item-content>  
                        </v-list-item> 
                        <v-list-item dark class="mt-n6"> 
                             <v-list-item-icon><v-icon>mdi-chevron-right</v-icon></v-list-item-icon>                          
                             <v-list-item-content>Compra segura</v-list-item-content>  
                        </v-list-item> 
                      </v-list-group>
                     </v-col>
                 </v-row>
                 </v-container>
             </v-footer>
             <!-- TERMINA FOOTER -->
       
              <!-- EMPIEZA SEGUNDA SECCIÓN NEGRA-->
             <div class="d-block pa-4 black">
                  
            </div>
             <!-- TERMINA SEGUNDA SECCIÓN NEGRA-->
                    <v-dialog v-model="dialog" persistent max-width="600px">
                        <v-card>
                            <v-card-title>
                                Contáctanos
                            </v-card-title>
                            <v-card-text>
                      <!-- <v-btn class="mt-6" text color="error" @click="sheet = !sheet">close</v-btn> -->
                      
                           <v-container>
                               <v-row>
                                   <v-col cols="12" md="6">
                                        <v-text-field label="Nombre"></v-text-field>
                                   </v-col>
                                   <v-col cols="12" md="6">
                                         <v-text-field label="Teléfono"></v-text-field>
                                   </v-col>
                               </v-row>
                               <v-row>
                                   <v-col cols="12" md="12">
                                        <v-text-field label="Correo electrónico"></v-text-field>
                                   </v-col>
                               </v-row>

                               <v-row>
                                   <v-col cols="12" md="6">
                                         <v-text-field label="Estado"></v-text-field>
                                   </v-col>
                                   <v-col cols="12" md="6">
                                         <v-text-field label="Ciudad"></v-text-field>
                                   </v-col>
                               </v-row>
                               <v-row>
                                   <v-col cols="12" md="12">
                                         <v-textarea outlined label="Mensaje"></v-textarea>
                                   </v-col>
                                  
                               </v-row>
                            </v-container>
                      </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="dialog = false"> Cancelar </v-btn>
                            <v-btn color="blue darken-1" text @click="dialog = false"> Enviar </v-btn>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                       </v-card>
                       </v-dialog>
        </v-app>
    </div>
</template>

<script>

import { mapActions, mapState, productModule} from 'vuex';


export default {    
    data(){
        return{
          query: null,
          items: [],
          showSearch: false,
          dialog: false,
          isMobile:false,
          drawer: false,           
          transparent: 'rgba(255, 255, 255, 0)',
          routes: [],
        }
    },

    components:{
      TheNavigationDrawer: () => import('../../components/Index/TheNavigationDrawer'),
    },

    watch:{
      query(after, before){
        this.searchProducts();
      }
    },

    beforeCreate(){
      this.$options.computed.value = function() {
        if(this.route.meta.getter){
          return this.$store.getters[this.route.meta.getter]
        }else{
          return null
        }
      }
    },
    mounted(){ 
  
        this.$store.dispatch('getProducts') 
        this.onResize()
        window.addEventListener('resize', this.onResize, { passive: true })
    },

    computed:{
      ...mapState({
      products: state => state.productsModule.products,
    }),


     breadCrumbs() {

      let pathArray = this.$route.path.split("/")
      pathArray.shift()
      
      
      let breadcrumbs = pathArray.reduce((breadcrumbArray, path, idx) => {

        breadcrumbArray.push({
          path: path,
          to: this.$route.meta.name,
          text: path.split('-').join(' ').toUpperCase() || this.$route.matched[idx+1].meta.breadCrumb,
        });

        
        return breadcrumbArray;
      }, [])

      
      return breadcrumbs;
      }
      
    },
    methods:{
        onResize(){
      this.isMobile = window.innerWidth < 780
    },

    searchProducts(){
      axios.get('models/search', {params: {query: this.query}})
      .then(response => {
        this.items = response.data})
      .catch(error => {})
    },
    },

   
}
</script>

<style >
*{
    font-family: 'Raleway';
}




.vertical
{
  -webkit-transform: rotate(-90deg);
  -moz-transform: rotate(-90deg);
  -ms-transform: rotate(-90deg);
  -o-transform: rotate(-90deg);
  transform: rotate(-90deg);
 
  -webkit-transform-origin: 50% 50%;
  -moz-transform-origin: 50% 50%;
  -ms-transform-origin: 50% 50%;
  -o-transform-origin: 50% 50%;
  transform-origin: 50% 50%;
  font-size: 1em;
 
}

.horizontal
{
  -webkit-transform: rotate(90deg);
  -moz-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  -o-transform: rotate(90deg);
  transform: rotate(90deg);
 
  -webkit-transform-origin: 0% 0%;
  -moz-transform-origin: 0% 0%;
  -ms-transform-origin: 0% 0%;
  -o-transform-origin: 0% 0%;
  transform-origin: 0% 0%;
}

.slide-enter-active,
.slide-leave-active{
  transition: opacity 0.5s, transform 0.5s;
}

.slide-enter,
.slide-leave-to{
  opacity: 0;
  transform: translateX(-30%);
}

.v-btn--absolute.v-btn--top, .v-btn--fixed.v-btn--top {
    right: 0px;
    top: 240px;
}

.v-toolbar__content{
  max-width: 1205px;
  margin: auto !important;
}

</style>
