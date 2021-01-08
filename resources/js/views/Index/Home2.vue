<template>
    <div id="app">
         <v-carousel :hide-delimiters="isMobile?false:true" :show-arrows="!isMobile" height="50vh" style="min-height: 350px" continuous  cycle  > 
            <v-carousel-item
            :to="{name: 'Categories', params: {slugProduct: 'PERSIANAS'}}"
            v-for="(item, i) in persianas"
            :key="i">
                <v-img  :src="item.src" height="50vh" min-height="50vh" max-height="600"  position="center center" eager>
                </v-img>
            </v-carousel-item>
        </v-carousel>
        
        <MobileCards v-if="isMobile"/>
        <DesktopCards v-else/>

        <v-row class="grey lighten-3 ma-0" justify="center">
            <v-card  max-height="350px" tile flat class="grey lighten-3 ">
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
import MobileCards from '../../components/Index/Home/MobileCards';
import DesktopCards from '../../components/Index/Home/DesktopCards';
export default {
    data(){
        return{
            isMobile:false,
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
        }
    },

    components: {
        Slogan,
        MobileCards,
        DesktopCards,
    },

    created(){
        document.title = 'Rollux México'
    },

    mounted(){
        this.onResize()
        window.addEventListener('resize', this.onResize, { passive: true }) 
    },

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