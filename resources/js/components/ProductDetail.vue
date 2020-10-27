<template>
    <div>
        <v-container fluid style="max-width: 1400px" class="my-4">
            <v-row>
                <v-col cols="12" md="4" sm="12">
                    <v-card>
                        <!-- <v-img  :aspect-ratio="16/9" height="400"  :src="details.colors[position].image"></v-img> -->
                        <vue-h-zoom  :height="400" :width="442" :image="details.colors[position].image"  :zoom-level="2" :zoom-window-size="1"></vue-h-zoom>
                        <v-card-actions>
                            <v-sheet class="mx-auto" max-width="400">
                                <v-slide-group v-model="model"   show-arrows >
                                    <v-slide-item v-for="n in details.colors.length" :key="n" v-slot="{ active, toggle }"> 
                                        <v-hover   v-slot="{ hover }">
                                        <v-card
                                         :class="{'selected':hover}"
                                        outlined
                                        tile
                                      @click="changeIndex(n-1)"
                                       @mouseenter="changeIndex(n-1)"
                                        class="ma-3"
                                        height="80"
                                        width="60"
                                        
                                        >
                                        <v-tooltip bottom>
                                            <template v-slot:activator="{ on, attrs}">
                                                <div>
                                                  
                                                    <v-img  v-bind="attrs" v-on="on"   :aspect-ratio="16/9" height="80"  :src="details.colors[n-1].image"></v-img>
                                                </div>
                                            </template>
                                            <span>{{ details.colors[n-1].name }}</span>
                                        </v-tooltip>
                                        </v-card>
                                        </v-hover>
                                    </v-slide-item>
                                </v-slide-group>
                            </v-sheet>
                        </v-card-actions>
                    </v-card>
                </v-col>
                 <v-col cols="12" md="4" sm="12">
                    <v-card  flat>
                        <v-card-title>{{ details.name}}</v-card-title>
                        <v-divider></v-divider>
                        <v-card-subtitle>$ {{details.price}}</v-card-subtitle>
                        <v-card-actions>
                            Color
                            <v-spacer></v-spacer>
                            <v-item-group v-model="selected" @change="changeIndex(selected)">
                                <v-row>
                                    <v-col
                                    v-for="n in details.colors.length"
                                    :key="n"
                                    >
                                        <v-item v-slot="{ active, toggle}">
                                            <v-card
                                            
                                            outlined
                                           tile
                                            class="d-flex align-center"
                                            height="20"
                                            width="20"
                                            @click="toggle"
                                            >
                                               <v-tooltip bottom>
                                                    <template v-slot:activator="{ on, attrs}">
                                                        <div :class="{'selected':active}" v-bind="attrs" v-on="on">
                                                            <v-img  :aspect-ratio="16/9" height="20"  width="20" :src="details.colors[n-1].image"></v-img>
                                                        </div>
                                                    </template>
                                                    <span>{{ details.colors[n-1].name }}</span>
                                                </v-tooltip>   
                                            </v-card>
                                        </v-item>
                                    </v-col>
                                </v-row>
                            </v-item-group>
                        </v-card-actions>
                    </v-card>
                </v-col>
                 <v-col cols="12" md="4" sm="12">
                     PRODUCTOS RELACIONADOS
                     <v-row align="center" justify="center">
                         <v-col cols="12" md="6" sm="12" v-for="r in relationed" :key="r.id">
                                 <v-card max-width="150" height="230" color="grey lighten-4" class="mx-auto" flat>
                            <v-img class="white--text align-end"  width="150" height="170" :aspect-ratio="16/9" :src="r.image"  >
                            
                              
                          
                                 <div
                             
                              class="d-flex transition-fast-in-fast-out  v-card--reveal white--text"
                              style="height: 100%;"
                              >
                              <v-hover v-slot="{ hover }">
                              <v-btn :to='"/details/type/"+$route.params.type+"/product/"+r.id' depressed :outlined="!hover" tile color="white"  x-small>VER</v-btn>
                              </v-hover>
                              </div>
                              
                            
                               <v-card-text style="padding: 0px; padding-left: 5px; font-size: 0.8rem !important;" class="title" >{{ r.name}}</v-card-text> 
                            </v-img>
                            

                            <v-card-text
                            
                            style="position: relative"
                            >

                            <h2 class=" font-weight-light black--text text-center">
                             ${{ r.price}}
                            </h2>
                           
                            </v-card-text>
                          </v-card>
                             
                         </v-col>
                        
                     </v-row>
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="12">
                    <v-tabs v-model="tab" align-with-title  background-color="blue-grey lighten-4">
                    <v-tabs-slider color="#47a5ad"></v-tabs-slider>
                        <v-tab>FICHA TÉCNICA</v-tab>
                       
                    </v-tabs>

                    <v-tabs-items v-model="tab">
                        <v-tab-item>
                             <v-simple-table>
                                <template>
                                    <tbody>
                                        <tr
                                        v-for="item in sheets"
                                        :key="item.name"
                                        >
                                            <td> {{ item.feature  }} </td>
                                            <td> {{ item.value }} </td>
                                        </tr>
                                    </tbody>
                                </template>
                    </v-simple-table>
                        </v-tab-item>
                    </v-tabs-items>
                   
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>

import VueHZoom from 'vue-h-zoom';
export default {
    data(){
        return{
            wrapper:  null,
            selected: 0,
            position: 0,
            details: {
                name: 'SCREEN VX STUCCO',
                price: 1400.00,
                colors: [
                    {name: 'White', image:'https://images-na.ssl-images-amazon.com/images/I/71jhmi4DffL._AC_SX425_.jpg'},
                    {name: 'Ash', image:'https://cdn11.bigcommerce.com/s-r14v4z7cjw/images/stencil/256x256/attribute_value_images/2513018.preview.jpg'},
                    {name: 'Cofee', image:'https://www.fabricfarms.com/mm5/graphics/00000001/X0763_256x256.jpg'},
                    {name: 'Linen', image:'https://i.pinimg.com/474x/31/79/51/3179513990085c08d5253a0432ef4f92.jpg'},
                    {name: 'Sand', image:'https://cdn11.bigcommerce.com/s-r14v4z7cjw/images/stencil/256x256/attribute_value_images/2488034.preview.jpg'},
                ]
            },
            model: 1,
            tab: null,
            features: [
                {title: 'PAYMENT', subtitle: 'We accept Visa, MasterCard and American Express.', icon: 'mdi-credit-card'},
                {title: 'FREE SHIPPING', subtitle: 'All orders over $100 free super fast delivery.', icon: 'mdi-truck'},
                {title: 'BEST PRICE', subtitle: 'The best choice for high quality at good prices.', icon: 'mdi-trophy'},
                {title: 'SHIPPING', subtitle: 'We ship to over 100 countries worldwide through fast and reliable delivery partners.', icon: 'mdi-airplane'},
            ],

            sheets: [
                {feature: 'Ancho de tela', value: '3.00 mts'},
                {feature: 'Alto de tela', value: '5.00 mts'},
                {feature: 'GIrar tela', value: '90°'},
            ],

            relationed: [
                {id:4,name: 'SUNSCREEN HQ BASIC', price: 900.00, image: 'https://i.pinimg.com/originals/4b/63/01/4b6301946bd5495ff9c200fc4308a543.jpg'},
                {id:5,name: 'SUNSCREEN HQ SOFT', price: 990.00, image: 'https://images-na.ssl-images-amazon.com/images/I/914IWKpapWL._AC_SL1500_.jpg'},
                {id:6,name: 'SCREEN ONE', price: 1010.00, image: 'https://www.wallpaperwarehouse.com/upload_media/product/preview/1554317253BIORTEFJ_1554414773.jpg'},
                {id:7,name: 'SCREEN PRAGA', price: 2500.00, image: 'https://bhf-cdn.azureedge.net/bhf-blob-prod/0034928_arya-brown-fabric-texture-wallpaper_600.jpeg'},
            ]
        }

        
    },

    components:{
      VueHZoom,
    },

    created(){
        console.log(this.$route.params)
        
    },

    methods:{
        changeIndex(index){
           this.position = index;
        },
        change(k){
            console.log(k)
        },
    }
}
</script>

<style>
.selected{
    padding: 1px;
    border: 1px solid black;
}

.title{
  background-color: #47a5ad;  word-break: break-word !important;
}

.v-card--reveal {
align-items: center;
bottom: 0;
justify-content: center;
position: absolute;
width: 100%;

}
</style>