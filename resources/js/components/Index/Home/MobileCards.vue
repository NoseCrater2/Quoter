<template>
     <v-row justify="space-around" class="ma-4" >
            <v-col  v-for="(item, i) in items" :key="i" cols="12" md="6" sm="6" >
                
                    <v-card   :to="{name: 'Categories', params: {slugProduct: item.title}}" height="400" width="350">
                        <v-img  class="transparent--text text-center align-center reset on-hover"  :src="item.img" height="400"  gradient="rgba(71, 165, 173, 0.5) 100%, transparent 72px" >                            
                            <v-col class=" white--text pa-0" align-self="center">
                                <v-row justify="center" align="center" >                                                  
                                    <v-img style="max-width: 150px" class="on-hover"  color="transparent"  :src="icons[i].image">
                                    </v-img>                                                 
                                </v-row>
                                <v-row class="reset " justify="center" align="center" >
                                    <div class="text-h4">
                                        <p style="letter-spacing:0.125em; "  class="condensed"  >
                                            {{ item.title }}
                                        </p>
                                    </div>
                                    <div class=" text-justify reset mx-10 mt-2">
                                        <p  style="line-height: 0.9em;" color="transparent" >
                                            {{ item.subtext }}
                                        </p>
                                    </div>
                                </v-row> 
                            </v-col>               
                        </v-img>
                    </v-card>

            </v-col>
        </v-row>
</template>

<script>
export default {
    data(){
        return {
            icons: [
                {image: 'img/cortinas.png', width:130, mobilew:55},
                {image: 'img/toldos.png', width:180, mobilew:80}
            ],
            transparent: 'rgba(255, 255, 255, 0)',
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
        }
    }
}
</script>

<style  scoped>
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

</style>