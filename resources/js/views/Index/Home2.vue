<template>
    <div id="app">
         <v-carousel :hide-delimiters="!isMobile"  :show-arrows="!isMobile" > 
            <v-carousel-item
            v-for="(item, i) in persianas"
            :key="i">
                <v-parallax :src="item.src" >
                    <v-row align="center" justify="center" style="margin-top: 100px">
                        <div class="text-center"  style="background-color: rgba(10, 10, 10, 0.5);">
                            <p :class="isMobile?'text-h5':'text-h3'"  class=" on-hover ma-5">
                                PERSIANAS ENROLLABLES
                            </p>
                            <p class="subheading">
                            La más amplia gama de texturas y colores del Mercado Nacional
                            </p>
                        </div>
                    </v-row>
    
                    <v-row justify="center" align="start" style="margin-bottom: 100px" >
                         <div >
                            <v-btn color="transparent" depressed >
                                <v-icon size="35"  left>mdi-plus-circle-outline</v-icon>Ver más
                            </v-btn>
                        </div>  
                    </v-row>
                </v-parallax>
            </v-carousel-item>
        </v-carousel>

        <v-row justify="space-around" class="ma-4" >
            <v-col  v-for="(item, i) in items" :key="i" cols="12" md="6"  >
                <v-hover v-slot:default="{ hover }" >
                    <v-card :elevation="hover ? 2: 6"  height="250px">
                        <v-img  class="transparent--text  text-left align-center reset"  :src="item.img" :class="{'on-hover ':hover}"  :gradient="hover?'rgba(71, 165, 173, 0.5) 100%, transparent 72px':''" height="250px">                            
                            <v-row class="mx-8" no-gutters style="flex-wrap: nowrap;  padding: -40px 40px;" :class="{'marco white--text':hover}">
                                <v-col cols="4"  class="flex-grow-0 flex-shrink-0 force-center mt-4" align-self="center">                                                  
                                    <v-img :width="isMobile?icons[i].mobilew:icons[i].width" :class="{'on-hover':hover}"   color="transparent"  :src="hover?icons[i].image:null">
                                    </v-img>                                                 
                                </v-col>
                                <v-col cols="7" class=" flex-grow-0 flex-shrink-1 reset mt-4"  >
                                    <div :class="isMobile?'text-h4':'text-h3'">
                                        <p style="letter-spacing:0.125em; "  :class="{'condensed':hover}"  >
                                            {{ item.title }}
                                        </p>
                                    </div>
                                    <div>
                                        <p  class="text-h6  text-justify reset "  style="line-height: 1em;" color="transparent" >
                                            {{ item.subtext }}
                                        </p>
                                    </div>
                                </v-col> 
                            </v-row>               
                        </v-img>
                    </v-card>
                </v-hover>
            </v-col>
        </v-row>

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
    </div>
</template>

<script>
export default {
    data(){
        return{
            showProducts: true,
            showSearch: false,
            drawer: false,
            dialog: false,
            isMobile:false,   
            icons: [
                {image: 'img/cortinas.png', width:150, mobilew:75},
                {image: 'img/toldos.png', width:200, mobilew:100}
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

.on-hover {
    
    transform: scale(1.02);
    -moz-transform: scale(1.02);
    -webkit-transform: scale(1.02);
    -o-transform: scale(1.02);
    -ms-transform: scale(1.02);
    transition-duration: 1s;
    
 }

 .condensed{
   font-stretch: ultra-expanded;
     font-weight: normal !important;
      transition-duration: 1.5s;
      font-weight: bolder !important;
     
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