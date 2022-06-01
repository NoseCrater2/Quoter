<template>
    <div>
        <v-carousel  :hide-delimiters="isMobile?false:true" :show-arrows="!isMobile" height="55vh" style="min-height: 350px" continuous  cycle  >
            <v-carousel-item
            eager
            :to="item.route"
            :href="item.href"
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


        <div class="mt-5">
            <div class="grey lighten-2 pa-5 text-center" style="font-size: 1.35rem">
                Área del cliente
            </div>
            <v-row class="grey lighten-3 pt-8 pb-11 mt-0" justify="center">
                <v-col cols="12" xl="4" lg="4" md="4" sm="12" v-for="(itemClientArea, index) in clientArea" :key="index">
                    <v-card
                    :to="itemClientArea.route"
                      class="mx-auto rounded-lg"
                      max-width="390"
                    >
                      <v-img aspect-ratio="1" height="170px" class="white--text text-uppercase align-end" :src="itemClientArea.icon">
                          <div class="text-end ma-4">
                              <div class="font-weight-bold mb-n5" style="font-size: 3.8rem">
                                  {{itemClientArea.title == 'Cotizaciones' ? quotingOrders.length : itemClientArea.title == 'Órdenes' ? countActiveQuotedOrders : itemClientArea.title == 'Carrito' ? computedCardMarketCount : 0}}
                              </div>
                              <div style="font-size: 1.4rem">
                                {{itemClientArea.title}}
                              </div>
                          </div>
                      </v-img>

                    </v-card>
                </v-col>
            </v-row>
        </div>




        <v-row class="justify-center align-center my-16" no-gutters>

            <v-col class="pa-0" cols="12" md="3" sm="12" v-for="(b, index) in benefits" :key="index">
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
        <v-row style="background-color: #47a5ad" no-gutters>
            <v-col cols="6" class="d-flex justify-center">
                <v-img
                style="position: absolute; z-index: 1;"
                contain
                src="/img/dashboard/mock-up-smartphone-vertical.png">

                </v-img>
            </v-col>
            <v-col cols="6">
                <v-card flat color="#47a5ad" class="white--text">
                    <v-card-title class="mt-4" style="margin-left: -110px;">
                        <span class="font-weight-thin" style="font-size: 2.5vw">Descarga la &nbsp; </span>
                        <span class="font-weight-bold" style="font-size: 2.5vw">App de Rollux</span>
                        <span style="margin-top: -15px">&reg;</span>
                    </v-card-title>
                    <v-card-text class="py-8 pl-0" style="max-width: 30vw">
                        <v-list-item class="px-0" three-line>
                            <v-list-item-avatar>
                                <v-icon
                                style="transform: rotate(90deg);"
                                color="white">mdi-navigation</v-icon>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-subtitle class="white--text" style="font-size: 1.5vw;-webkit-text-stroke-width: medium;">
                                    <span>
                                        Cotiza todas las persianas desde tu smarthpone o tablet
                                    </span>

                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item class="px-0" three-line>
                            <v-list-item-avatar>
                                  <v-icon
                                style="transform: rotate(90deg);"
                                color="white">mdi-navigation</v-icon>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-subtitle class="white--text" style="font-size: 1.5vw;-webkit-text-stroke-width: medium;">
                                    Guarda las cotizaciones y llévalas en tu bolsillo
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item class="px-0" three-line>
                            <v-list-item-avatar>
                                  <v-icon
                                style="transform: rotate(90deg);"
                                color="white">mdi-navigation</v-icon>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-subtitle class="white--text" style="font-size: 1.5vw;-webkit-text-stroke-width: medium;">
                                    Realiza los pagos de tus persianas desde la app
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-card-text>

                </v-card>
            </v-col>
        </v-row>
        <v-row style="background:  #E0E0E0" class="pb-10" justify="end" no-gutters>
            <v-col cols="6" >
                 <v-card-text class="pl-13">
                        <p class="font-weight-bold" style="font-size: 2vw">
                            DESCÁRGALA HOY MISMO
                        </p>
                        <a href="https://play.google.com/store/apps/details?id=grupo.lidhber.rollux.app" target="blank">
                            <img src="/img/dashboard/disponible-en-google-play-badge.svg" alt="">
                        </a>
                        <!-- </v-btn> -->

                    </v-card-text>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
    mounted(){
        this.$store.dispatch('getQuotedOrders');
        this.$store.dispatch('getQuotingOrders');
    },
    data () {
        return {
            isMobile: false,
            persianas: [
                {
                    // href: 'https://rollux.com.mx/img/pdfs/archivos/xBEgmFvqGbB2D5q2mtGxRvLpXdtC8kzuzxNghqd5.pdf',
                    route: {name: 'PriceListPromo'},
                    src: '/img/dashboard/slide3BuenFin.jpg'
                },
                {
                    route: {name: 'PriceList'},
                    src: '/img/dashboard/slide1.jpg'
                },
                {
                    route: '#',
                    src: '/img/dashboard/slide2.jpg'
                },
            ],

            benefits:[
                {
                    title: 'Cotizador en Línea',
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
                    title: 'Catálogos Digitales',
                    text: 'Descarga los muestrarios digitales de las líneas que Rollux México tiene para ti.',
                    icon:'/img/dashboard/icon_catalogo.svg',
                    route: {name: 'CatalogList'}
                },
                {
                    title: 'Gacetas de promociones',
                    text: 'Descarga la lista de  promociones que Rollux tiene este mes.',
                    icon:'/img/dashboard/gaceta_index.svg',
                    route: {name: 'PriceListPromo'}
                },
            ],
            clientArea: [
                {
                    title: 'Cotizaciones',
                    icon:'/img/dashboard/cotizacion_index.png',
                    route: {name: 'Orders', params: {option: 'cotizaciones'}}
                },
                {
                    title: 'Órdenes',
                    icon:'/img/dashboard/ordenes_index.png',
                    route: {name: 'Orders', params: {option: 'ordenes'}}
                },
                {
                    title: 'Carrito',
                    icon:'/img/dashboard/carrito_de_compra.png',
                    route: {name: 'Marketcar'}
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
            user: state => state.user,
            quotedOrders: state => state.ordersModule.quotedOrders,
            quotingOrders: state => state.ordersModule.quotingOrders,
        }),
        countActiveQuotedOrders(){
            return this.quotedOrders.filter(itemOrder=>itemOrder.state != 'No Pagada').length;
        },
        computedCardMarketCount(){
            return this.quotedOrders.filter(itemOrder=>(itemOrder.state == 'No Pagada')).length;
        }
    }
}
</script>
<style>

</style>
