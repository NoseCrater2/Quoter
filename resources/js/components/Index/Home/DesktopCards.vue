<template>
     <v-row justify="space-around" class="ma-4" >
            <v-col  v-for="(item, i) in items" :key="i" cols="12" md="6" sm="12" >
                <v-hover v-slot:default="{ hover }" >
                    <v-card  height="250px" :to="{name: 'Categories', params: {slugProduct: item.title}}">
                        <v-img  class="transparent--text  text-left align-center reset"  :src="item.img" :class="{'on-hover ':hover}"  :gradient="hover?'rgba(71, 165, 173, 0.5) 100%, transparent 72px':''" height="250px">                            
                            <v-row class="mx-8" no-gutters style="flex-wrap: nowrap;  padding: -40px 40px;" :class="{'marco white--text':hover}">
                                <v-col cols="4"  class="flex-grow-0 flex-shrink-0 force-center mt-4 mr-10" align-self="center"> 
                                 
                                    <v-img :width="icons[i].mobilew" :class="{'on-hover':hover}" style="margin-left:auto"  color="transparent"  :src="hover?icons[i].image:null">
                                    </v-img>                                                
                                                                                
                                </v-col>
                                <v-col cols="7" class=" flex-grow-0 flex-shrink-1 reset my-8"  >
                                    <div class="text-h4 d-block">
                                        <p style="letter-spacing:0.125em;" class="ma-0"  :class="{'condensed':hover}"  >
                                            {{ item.title }}
                                        </p>
                                    </div>
                                    <div class="d-block">
                                        <p  class="text-h6  text-justify reset ma-0" style="line-height: 1em; max-width: 75%" color="transparent" >
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
</template>

<script>
export default {
    data(){
        return {
            icons: [
                {image: 'img/cortinas.png', width:130, mobilew:85},
                {image: 'img/toldos.png', width:180, mobilew:105}
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

.force-center{
    flex-grow: 0 !important;
}
</style>