<template>
    <div>
        <v-carousel  :hide-delimiters="isMobile?false:true" :show-arrows="!isMobile" height="55vh" style="min-height: 350px" continuous  cycle  >
            <v-carousel-item
            eager
            :to="item.to"
            v-for="(item, i) in persianas"
            :key="i">
                <v-img  :src="item.src" height="55vh" min-height="55vh" max-height="750"  position="center center" eager>
                </v-img>
            </v-carousel-item>
        </v-carousel>
        <v-col cols="12" align-self="center" class="text-center">
            <div>
                <div class="display-3" style="display: inline; font-weight: bold; color: #404042">
                    ¡Hola!,
                </div>
                <div class="display-2" style="display: inline; color: #47a5ad; font-weight: bold;">
                    {{ user.name+' '+user.last_name}}
                </div >
            </div>
            <div style="max-width: 500px; margin: auto; text-align: center; color: #404042">
                 <h1> Este espacio en <strong>Rollux</strong> está especialmente pensado para ti.</h1>
            </div>
            <div class="d-flex justify-center">
                <hr align="center" noshade="noshade" class="divider" style="height: 5px; background-color: #47a5ad;" size="3" width="25%" />
            </div>
        </v-col>
        <v-row class="justify-center align-center my-16" no-gutters>

            <v-col class="pa-0" cols="12" md="4" sm="12" v-for="(b, index) in benefits" :key="index">
                <v-card flat max-height="330">
                    <div class="d-flex justify-center">
                        <v-avatar  size="75">
                            <v-img  :src="b.icon" >
                            </v-img>
                        </v-avatar>
                    </div>
                    <div class="justify-center mt-10 mb-5" >
                        <h2 class="text-center">{{b.title}}</h2>
                    </div>
                    <div class="d-flex justify-center">
                        <p class="text-center" style="font-size: 20px; max-width: 250px">
                            {{b.text}}
                        </p>
                    </div>
                    <div class="d-flex justify-center">
                        <v-btn color="#47a5ad" rounded class="white--text" :to="b.route">ENTRAR</v-btn>
                    </div>
                </v-card>
            </v-col>

        </v-row>
    </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
    data () {
        return {
            isMobile: false,
            persianas: [
                {
                    src: '/img/dashboard/slide1.jpg'
                },
                {
                    src: '/img/dashboard/slide2.jpg'
                },
            ],

            benefits:[
                {
                    title: 'Cotizador en Líena',
                    text: 'Realiza cotizaciones y pedidos en línea en nuestro cotizador web',
                    icon:'/img/dashboard/icon_cotizador.png',
                    route: {name: 'Quoter'}
                },
                {
                    title: 'Lista de Precios',
                    text: 'Descarga las listas de precios Rollux y mantente siempre actualizado',
                    icon:'/img/dashboard/icon_pdf.png',
                    route: {name: 'PriceList'}
                },
                {
                    title: 'Tus Pedidos',
                    text: 'Consulta en cualquier momento tus órdenes y cotizaciones',
                    icon:'/img/dashboard/icon_pedidos.png',
                    route: {name: 'Orders'}
                },
            ]
        }
    },

     methods:{
        onResize(){
            this.isMobile = window.innerWidth < 780
        },
    },
    computed: {
         ...mapState({
            user: state => state.user
        }),
    }
}
</script>
