<template>
    <div id="app">
         <v-carousel :hide-delimiters="!isMobile"  :show-arrows="!isMobile" :height="scHeight-140" continuous   > 
            <v-carousel-item
            
            v-for="(item, i) in persianas"
            :key="i">
                <v-parallax  :src="item.src"  :height="scHeight-140">
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
                            <v-btn style="border: 2px solid white" color="transparent" depressed  large  :to="{name: 'Categories', params: {slugType: 'PERSIANAS'}}">
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
                    <v-card :elevation="hover ? 2: 6"  height="250px" :to="{name: 'Categories', params: {slugType: item.title}}">
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

        <v-row class="grey lighten-3 "      justify="space-around" >
            
                <v-card width="1000px"  max-height="350px" tile flat class="grey lighten-3 ">
                    <Slogan/>                
                <v-card-actions class="mt-n5">
                    <v-spacer></v-spacer>
                    <v-btn class="grey lighten-3"  depressed :to="{name: 'About us'}">
                    <v-icon size="35"  left>mdi-plus-circle-outline</v-icon>Conocer más
                </v-btn>
                     <v-spacer></v-spacer>
                </v-card-actions>
                </v-card>
            
        </v-row>
    </div>
</template>

<script>
import Slogan from '../../components/Slogan';
export default {
    data(){
        return{
            scHeight : screen.height,
            showProducts: true,
            showSearch: false,
            drawer: false,
            dialog: false,
            isMobile:false,   
            icons: [
                {image: 'img/cortinas.png', width:130, mobilew:55},
                {image: 'img/toldos.png', width:180, mobilew:80}
                ],
            offsetTop: 0,
            persianas: [
            {
              src: 'img/home/PERSIANAS/RolluxSlide1.jpg',
            },
            {
              src: 'img/home/PERSIANAS/RolluxSlide2.jpg',
            },
            {
              src: 'img/home/PERSIANAS/RolluxSlide3.jpg',
            },
            {
              src: 'img/home/PERSIANAS/RolluxSlide4.jpg',
            },
        ],
        items: [
      {
        title: 'CORTINAS',
        subtext: 'Contamos con una extensa línea de cortinas para la decoración de tu hogar u oficina',
        img: 'img/home/CORTINAS.jpg',
      },
      {
        title: 'TOLDOS',
        subtext: 'Contamos con una gran varidad de diseños para que se adapten a tus necesidades',
        img: 'img/home/TOLDOS.jpg',
      },
    ],
     transparent: 'rgba(255, 255, 255, 0)',

        }
    },

    components: {
        Slogan,
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
    transition-duration: .25s;
    
 }

 .condensed{
   font-stretch: ultra-expanded;
     font-weight: normal !important;
      transition-duration: 1.5s;
      font-weight: bolder !important;
     
 }

 .reset {
    transition-duration: .25s;
 }


.marco{
    border: 4px solid white;
   
}

.force-center{
    flex-grow: 0 !important;
}
</style>