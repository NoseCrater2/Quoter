<template>
  <div id="app">
    <v-app  >
      <v-navigation-drawer app v-model="drawer" style="z-index: 8;" temporary>
        <v-divider></v-divider>
        <v-list dense>
            <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-home</v-icon>
            </v-list-item-icon>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item >
          <v-list-item-content>
              <v-list-item-title>GALERÍA</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item to="/contact">
          <v-list-item-content>
            <v-list-item-title>CONTACTO</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item  to='/aboutus'>
          <v-list-item-content>
            <v-list-item-title>NOSOTROS</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-group  v-model="showProducts" no-action>
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title >PRODUCTOS</v-list-item-title>
            </v-list-item-content> 
          </template>
          <v-list-item v-for="p in products" :key="p.name" :to="p.route+'/name/'+p.name+'/id/'+p.id">
            <v-list-item-title> {{ p.name }} </v-list-item-title>
          </v-list-item>
           </v-list-group>
        </v-list>
      </v-navigation-drawer>
          <!-- COMIENZA BARRA NEGRA -->
           <div  class="d-block black white--text text-center" >
                <div style="font-size:14px" class="my-2" >
                    BIENVENIDO A ROLLUX - PERSIANAS ENROLLABLES DE MÉXICO 
                </div>
            </div>
            <!-- TERMINA BARRA NEGRA -->
            <!-- COMIENZA BARRA BLANCA -->
            <v-card v-if="!isMobile">
                <v-row justify="space-around"  >                   
                    <v-col class="mr-1" md="2" > 
                        <v-card tile flat  >
                             <v-img width="200"  src="/img/logo.svg" ></v-img>
                        </v-card>                          
                    </v-col >
                    <v-col class="mt-4" md="2">
                            <v-card tile  flat >
                          <v-btn  x-small icon color="#3b5999" fab>
                            <v-icon  size="30">mdi-facebook</v-icon>
                          </v-btn>
                           <v-btn icon  x-small color="#2caae1" fab>
                            <v-icon size="30">mdi-twitter</v-icon>
                          </v-btn>
                          <v-btn  icon x-small fab>
                              <v-img src="/img/instagram-logo.png" ></v-img>
                          </v-btn>
                           <v-btn icon  x-small color="#cc2127" fab>
                            <v-icon size="30">mdi-pinterest</v-icon>
                          </v-btn>
                        </v-card> 
                    </v-col>               
                </v-row>
            </v-card>
            <!-- TERMINA BARRA BLANCA -->


            <!-- COMIENZA BARRA DE NAVEGACIÓN -->         
            <v-app-bar ref="mybar" :color="isMobile?'white':'#47a5ad'" style="position: sticky; top:0; z-index: 6" >
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
             <template v-if="!isMobile" v-slot:default="{}">
                <v-spacer  ></v-spacer>
                  <v-menu open-on-hover offset-y>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn class="white--text " style="justify-content:left" depressed tile color="#404042" width="250px" height="65px" v-bind="attrs" v-on="on">
                              <div v-if="$refs.mybar">
                               <v-img v-if="$refs.mybar._data.currentScroll >= 138" width="40px" class="ml-n2" src="img/white-r.png"></v-img>
                                <v-icon  v-else left>mdi-menu</v-icon>   
                              </div>
                            PRODUCTOS
                          
                        </v-btn>
                    </template>
                    <v-card tile>
                        <v-list  flat dark>
                            <v-list-item-group  >
                              <v-list-item v-for="p in products" :key="p.id" :to="p.route+'/name/'+p.name+'/id/'+p.id" style="border-bottom: 1px solid gray">
                                <v-list-item-content>
                                  <v-list-item-title class="white--text" > {{ p.name }} </v-list-item-title>
                                </v-list-item-content>
                                
                              </v-list-item>
                             
                            </v-list-item-group>
                        </v-list>
                    </v-card>
                </v-menu>
                <v-btn icon color="white" >
                    <v-icon size="30">mdi-home</v-icon>
                </v-btn>
                <v-btn color="white" text height="65px" to="/aboutus" >Nosotros</v-btn>
                <v-btn color="white" text height="65px">Galería</v-btn>
                <v-btn color="white" text height="65px" to="/contact">Contáctanos</v-btn>
                <v-spacer  ></v-spacer>
                <v-text-field
               
                color="#47a5ad" 
                class="mt-8"
                single-line
                solo
                placeholder="Buscar producto"
                append-icon="mdi-magnify">
            </v-text-field>
            <v-spacer  ></v-spacer>
            </template>               
             </v-app-bar>
             
             <!-- TERMINA BARRA DE NAVEGACIÓN -->

             <v-main>
                <!-- <v-breadcrumbs :items="links">
                  <template v-slot:item="{ item }">
                    <v-breadcrumbs-item
                      :href="item.href"
                      :disabled="item.disabled"
                      v-if="item.disabled"
                    >
                      {{ item.text.toUpperCase() }}
                    </v-breadcrumbs-item>
                  </template>
              </v-breadcrumbs> -->
                <!-- BOTÓN FLOTANTE MAIL-->
                     <div>
                      <v-btn class="vertical" right fixed top tile height="64px"  width="270px" style="margin-top: 275px!important; margin-right:-120px; z-index:4; border-radius: 15px 15px 0px 0px;"  dark x-large color="#f1c40f">      
                      <v-icon size="60" class="horizontal" left>mdi-calculator</v-icon>
                       <b><p style="font-size: 1.5em" class="my-4 ml-4 mr-n5">COTIZADOR</p></b>
                    </v-btn>
                 </div>
                  <v-btn   @click="dialog = true" right fixed top tile height="60px" max-width="30px" style="margin-top: 443px!important; margin-right:-20px; z-index:4; border-radius: 15px 0px 0px 15px;"   dark  color="#47a5ad"><v-icon size="45" dark>mdi-email</v-icon></v-btn>  
               
                <router-view></router-view>

                   <!-- BOTÓN FLOTANTE MESSENGER-->           
                    <v-btn right  bottom  fixed style="margin-bottom: 80px!important;" fab dark color="#0084ff"><v-icon size="38" dark>mdi-facebook-messenger</v-icon></v-btn> 
              
               <!-- BOTÓN FLOTANTE WHATSAPP-->
                     <v-btn right  bottom  fixed    fab dark  color="#26d367"><v-icon size="38" dark>mdi-whatsapp</v-icon></v-btn> 

            </v-main>

             <!-- EMPIEZA FOOTER -->
             <v-footer color="#47a5ad" >
                 <v-row justify="center" align="center">
                     <v-col cols="12" md="2" sm="4" class=" white--text ma-4"  >
                       <v-list-item>
                           <v-img max-width="250px" src="/img/white-logo.svg" > </v-img>
                        </v-list-item>
                        <v-list-item dark>
                            ventas@rollux.com.mx
                        </v-list-item>
                         <v-list-item dark>
                            distribuidores@rollux.com.mx
                        </v-list-item>
                        <v-list-item dark>
                            De Lunes a Viernes
                            9:00 am a 05:00 pm      
                        </v-list-item>                                
                         </v-col>

                     <v-col cols="12" md="2" sm="4"  class=" white--text ma-4"  >
                         <v-list-item dark>
                             <v-list-item-icon>
                                <v-icon size="50">mdi-cellphone-android</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                  <strong> DESCARGA LA APP DEL COTIZADOR</strong>
                            </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-img max-width="250px" class="mt-2" src="/img/googleplay.png" ></v-img>
                            </v-list-item>
                            <v-list-item dark>
                                <v-list-item-content>
                                <div :class="{'text-center':!isMobile}"> <b>SÍGUENOS EN:</b> </div>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>                           
                                <v-btn dark  x-small icon  fab>
                                    <v-icon   size="30">mdi-facebook</v-icon>
                                </v-btn><v-spacer v-if="!isMobile"></v-spacer>
                                 <v-btn dark icon  x-small  fab>
                                    <v-icon size="30">mdi-twitter</v-icon>
                                </v-btn><v-spacer v-if="!isMobile"></v-spacer>
                                <v-btn dark  icon x-small fab>
                                    <v-icon size="30">mdi-instagram</v-icon>
                                </v-btn><v-spacer v-if="!isMobile"></v-spacer>
                                <v-btn dark icon  x-small fab>
                                    <v-icon size="30">mdi-pinterest</v-icon>
                                </v-btn>                          
                            </v-list-item>     
                     </v-col>

                     <v-col cols="12" md="2" sm="4" class=" white--text ma-4"  align-self="start">
                      
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
                     <v-col cols="12" md="2" sm="4" class=" white--text ma-4"  align-self="start">
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
                        <v-list-item dark class="mt-n6"> 
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
export default {    
    data(){
        return{
          products: [
            {id: 1, name: 'PERSIANAS', route: '/blinds'},
            {id: 2, name: 'CORTINAS', route: '/curtains'},
            {id: 3, name: 'TOLDOS', route: '/awnings'},
          ],
          showProducts: true,
          showSearch: false,
          drawer: false,
          dialog: false,
          isMobile:false,             
          transparent: 'rgba(255, 255, 255, 0)',

          links: [
            {
              text: 'Dashboard',
              disabled: false,
              href: '/home',
            },
          ],
        }
    },
    mounted(){  
      this.onResize()
      window.addEventListener('resize', this.onResize, { passive: true })
      
    },

    computed:{},

    methods:{
        onResize(){
      this.isMobile = window.innerWidth < 780
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
   
   padding-bottom:20px;
   font-size: 50px;
}

</style>