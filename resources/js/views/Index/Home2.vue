<template>
    <div id="app">
        <v-app  >

          <!-- COMIENZA BARRA NEGRA -->
           <div  class="d-block black white--text text-center" >
                <div style="font-size:14px" class="my-2" >
                    BIENVENIDO A ROLLUX - PERSIANAS ENROLLABLES DE MÉXICO 
                </div>
            </div>
            <!-- TERMINA BARRA NEGRA -->


            <!-- COMIENZA BARRA BLANCA -->
            <v-card >
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

            <!-- COMIENZA BARRA DE NAVEGACIÓN-->
            <v-app-bar ref="mybar" color="#47a5ad"  style="position: sticky; top:0; z-index: 6" >
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-menu open-on-hover offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn class="white--text " style="justify-content:left" depressed tile color="#404042" width="250px"  v-bind="attrs" v-on="on">
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
                                    <v-list-item >
                                        <v-list-item-title class="white--text">PERSIANAS</v-list-item-title>
                                    </v-list-item>
                                    <v-divider class="white--text"></v-divider>
                                    <v-list-item>
                                        <v-list-item-title class="white--text">CORTINAS</v-list-item-title>
                                    </v-list-item>
                                    <v-divider class="white--text"></v-divider>
                                    <v-list-item>
                                        <v-list-item-title class="white--text">TOLDOS</v-list-item-title>
                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </v-card>
                    </v-menu>
                    <v-btn icon color="white">
                        <v-icon size="30">mdi-home</v-icon>
                    </v-btn>
                    <v-btn color="white" text @click="test()">Nosotros</v-btn>
                    <v-btn color="white" text>Galería</v-btn>
                    <v-btn color="white" text>Contáctanos</v-btn>
                    
                </v-toolbar-items>
                <v-spacer></v-spacer>
                    <v-text-field
                 
                    color="#47a5ad" 
                    class="mt-8"
                    single-line
                    solo
                    placeholder="Buscar producto"
                    append-icon="mdi-magnify">
                </v-text-field>
                <v-spacer></v-spacer>
               
             </v-app-bar>
             <!-- TERMINA BARRA DE NAVEGACIÓN -->

             <v-main >
               
                 <!-- BOTÓN FLOTANTE CALCULADORA-->
              
                   <!-- BOTÓN FLOTANTE MAIL-->
                     <div>
                      <v-btn class="vertical" right fixed top tile height="86px"  width="270px" style="margin-top: 275px!important; margin-right:-113px; z-index:4; border-radius: 15px 15px 0px 0px;"  dark x-large color="#f1c40f">
                         
                      <v-icon size="60" class="horizontal" left>mdi-calculator</v-icon>
                       <b><p style="font-size: 1.5em" class="my-4 ml-4 mr-n5">COTIZADOR</p></b>
                    </v-btn>
                 </div>
        
                    <v-btn   @click="dialog = true" right fixed top tile height="70px" width="85px" style="margin-top: 453px!important; margin-right:-20px; z-index:4; border-radius: 15px 0px 0px 15px;"   dark large color="#47a5ad"><v-icon size="50" dark>mdi-email</v-icon></v-btn>  
        
                 <v-carousel hide-delimiters > 
                    <v-carousel-item
                    v-for="(item, i) in persianas"
                    :key="i">
                        <v-parallax :src="item.src" >
                           
                                <v-row  align="center" justify="center" class="mt-16 " style="flex: none;">
                                    <v-col
                                      class="text-center"
                                      cols="4"
                                      style="background-color: rgba(10, 10, 10, 0.5);"
                                    >
                                        <h1 class="display-1  mb-4"> PERSIANAS ENROLLABLES</h1>    
                                        <h4 class="subheading"> La más amplia gama de texturas y colores del Mercado Nacional</h4>
                                    </v-col>
                                </v-row>
                            <v-col align-self="center" class="text-center mb-16 pb-n5" cols="2" >
                                <v-btn style="background-color: rgba(255, 255, 255, 0);" depressed >
                                    <v-icon size="35" class="mr-4" left>mdi-plus-circle-outline</v-icon>Ver más
                                </v-btn>
                            </v-col>
                        </v-parallax>
                    </v-carousel-item>
                </v-carousel>
                 <!-- TERMINA CARRUSEL -->
                
                <!-- EMPIEZA SEGUNDA SECCIÓN -->
                <v-row justify="space-around" class="ma-4" >
                    
                        <v-col  v-for="(item, i) in items" :key="i" cols="12" md="6"  >
                            <v-hover v-slot:default="{ hover }" >
                                <v-card :elevation="hover ? 2: 6"  height="250px">
                                    <v-img  class="transparent--text  text-left align-center reset"  :src="item.img" :class="{'on-hover':hover}"  :gradient="hover?'rgba(71, 165, 173, 0.5) 100%, transparent 72px':''" height="250px">
                                                        
                                            <v-row  class="mx-10 "  :class="{'marco white--text':hover}">
                                                 <v-col  class="force-center " >                                                  
                                                        <v-img :max-width="icons[i].width" class="text-start reset" :class="{'on-hover':hover}"   color="transparent"  :src="hover?icons[i].image:null">
                                                        </v-img>                                                 
                                                </v-col>
                                                  <v-col cols="7"  class="force-center reset" :class="{'on-hover':hover}">
                                                      <p class="text-h2 " style="letter-spacing:0.125em" color="transparent" >
                                                         {{ item.title }}
                                                        </p>
                                                    <p  class="text-h6  text-justify reset " :class="{'on-hover':hover}" style="line-height: 1em;" color="transparent" >
                                                        {{ item.subtext }}
                                                    </p>
                                                </v-col>
                                            </v-row>
                                       
                                    </v-img>
                                </v-card>
                            </v-hover>
                        </v-col>
               
                  
                </v-row>
                <!-- TERMINA SEGUNDA SECCIÓN -->                

                <!-- EMPIEZA TERCERA SECCIÓN -->
                <v-row class="grey lighten-3 " height="350" align="center" justify="center" >
                   
                    <v-col class="text-center" cols="12" md="3" sm="6">
                        <p style="font-size:25px" class=" mb-n3 mt-6">
                         Para nosotros las persianas no son solo un elemento decorativo en tu ventana,
                         </p>
                   
                        <p style="font-size:30px" >
                        las  <b>Persianas de Rollux</b> crean ambientes, emociones y sensaciones.
                        </p>
                         <v-btn class="grey lighten-3 mb-6"  depressed>
                             <v-icon size="35" class="mr-4" left>mdi-plus-circle-outline</v-icon>Conocer más
                         </v-btn>
                    </v-col>
                   
                </v-row>
                <!-- TERMINA TERCERA SECCIÓN -->

                   <!-- BOTÓN FLOTANTE MESSENGER-->           
                    <v-btn right  bottom  fixed style="margin-bottom: 80px!important;" fab dark large color="#0084ff"><v-icon size="50" dark>mdi-facebook-messenger</v-icon></v-btn> 
              
               <!-- BOTÓN FLOTANTE WHATSAPP-->
                     <v-btn right  bottom  fixed    fab dark large color="#26d367"><v-icon size="50" dark>mdi-whatsapp</v-icon></v-btn> 

            </v-main>

          

             <!-- EMPIEZA FOOTER -->
             <v-footer color="#47a5ad" >
                 <v-row justify="center" align="center">
                     <v-col cols="6" md="2" sm="4" class=" white--text ma-3" align-self="center">
                       <v-list-item>
                           <v-img width="250px" src="/img/white-logo.svg" > </v-img>
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

                     <v-col cols="6" md="2" sm="4"  class=" white--text ma-4" align-self="start">
                         <v-list-item dark>
                             <v-list-item-icon>
                                <v-icon size="50">mdi-cellphone-android</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                  <strong> DESCARGA LA APP DEL COTIZADOR</strong>
                            </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-img width="250px" class="mt-2" src="/img/googleplay.png" ></v-img>
                            </v-list-item>
                            <v-list-item dark>
                                <v-list-item-content>
                                <div class="text-center"> <b>SÍGUENOS EN:</b> </div>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>                           
                                <v-btn dark  x-small icon  fab>
                                    <v-icon   size="30">mdi-facebook</v-icon>
                                </v-btn><v-spacer></v-spacer>
                                 <v-btn dark icon  x-small  fab>
                                    <v-icon size="30">mdi-twitter</v-icon>
                                </v-btn><v-spacer></v-spacer>
                                <v-btn dark  icon x-small fab>
                                    <v-icon size="30">mdi-instagram</v-icon>
                                </v-btn><v-spacer></v-spacer>
                                <v-btn dark icon  x-small fab>
                                    <v-icon size="30">mdi-pinterest</v-icon>
                                </v-btn>                          
                            </v-list-item>     
                     </v-col>

                     <v-col cols="6" md="2" sm="4" class=" white--text ma-4" align-self="start">
                          <v-list-item dark> <b>PRODUCTOS</b> </v-list-item>
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

                     </v-col>
                     <v-col cols="6" md="2" sm="4" class=" white--text ma-4" align-self="start">
                         
                         <v-list-item dark> <b>POLÍTICAS</b> </v-list-item>
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
            dialog: false,
            isMobile:false,   
            icons: [
                {image: 'img/cortinas.png', width:150},
                {image: 'img/toldos.png', width:200}
                ],
            offsetTop: 0,
            persianas: [
            {
              src: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg',
            },
            {
              src: 'https://cdn.vuetifyjs.com/images/carousel/sky.jpg',
            },
            {
              src: 'https://cdn.vuetifyjs.com/images/carousel/bird.jpg',
            },
            {
              src: 'https://cdn.vuetifyjs.com/images/carousel/planet.jpg',
            },
        ],
        items: [
      {
        title: 'CORTINAS',
        subtext: 'Contamos con una extensa línea de cortinas para la decoración de tu hogar u oficina',
        img: 'https://images.unsplash.com/photo-1498038432885-c6f3f1b912ee?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2100&q=80',
      },
      {
        title: 'TOLDOS',
        subtext: 'Contamos con una gran varidad de diseños para que se adapten a tus necesidades',
        img: 'https://cdn.vuetifyjs.com/images/carousel/sky.jpg',
      },
    ],
     transparent: 'rgba(255, 255, 255, 0)',

        }
    },
    mounted(){
      this.$forceUpdate();
      this.onResize()
      window.addEventListener('resize', this.onResize, { passive: true })
      
    },

    computed:{},

    methods:{
        onResize(){
      this.isMobile = window.innerWidth < 732
    },
    },

   
}
</script>

<style >
*{
    font-family: 'Raleway';
}
.v-window__next, .v-window__prev {    
	margin: 0 115px !important;
	background: none !important; 
   
}

.v-window__next > button > span > i{
  font-size: 100px !important;
}

.v-window__prev > button > span > i{
  font-size: 100px !important;
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
.v-card {
transition: opacity .4s ease-in-out;
}

/* rgba(71, 165, 173, 0.7) */
.on-hover {
    
    transform: scale(1.02);
    -moz-transform: scale(1.02);
    -webkit-transform: scale(1.02);
    -o-transform: scale(1.02);
    -ms-transform: scale(1.02);
    transition-duration: 1s;
 }

 .reset {

    transition-duration: 1s;
 }


.marco{
    border: 4px solid white;
}

.force-center{
    flex-grow: 0 !important;
}
</style>