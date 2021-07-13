<template>
  <v-app v-if="loading === true">
    <!-- <v-dialog
        v-model="loading"
        hide-overlay
        persistent
      >
        <v-card
          color="#47a5ad"
          dark
        >
          <v-card-text>
            Please stand by
            <v-progress-linear
              indeterminate
              color="white"
              class="mb-0"
            ></v-progress-linear>
          </v-card-text>
        </v-card>
      </v-dialog> -->
    <div id="divBody">
        <!-- Deja la etiqueta 'img' en vez de 'v-img' -->
        <img src="/img/white-r.png" id="pngRolluxInOut">
        <p id="loading">Cargando<span>.</span><span>.</span><span>.</span></p>
    </div>
  </v-app>
    <v-app v-else>
      <v-navigation-drawer app v-model="drawer" style="z-index: 8;" temporary>
        <v-list dense>
          <v-list-group color="#47a5ad"   no-action>
            <template v-slot:activator>
              <v-list-item >
                <v-list-item-avatar>
                  <v-icon>mdi-account</v-icon>
                </v-list-item-avatar>
                <v-list-item-content>

                  <v-list-item-title v-if="$store.state.user != null" > {{ $store.state.user.name +' '+ $store.state.user.last_name }}</v-list-item-title>
                   <v-list-item-title v-else  >CUENTA</v-list-item-title>
                </v-list-item-content>
              </v-list-item >
            </template>

            <div v-if="$store.state.isLoggedIn === false || $store.state.isLoggedIn === 'false'">
              <v-list-item :to="{name: 'login'}">
                <v-list-item-title >Iniciar Sesión</v-list-item-title>
              </v-list-item>
            </div>

            <div v-else>
              <v-list-item  :to="{name: 'Orders'}">
                <v-list-item-title  class="text-center">ORDENES</v-list-item-title>
              </v-list-item>
              <v-list-item :to="{name: 'Quotations'}">
                <v-list-item-title class="text-center">COTIZACIONES</v-list-item-title>
              </v-list-item>
              <v-list-item :to="{name: 'Profile'}">
                <v-list-item-title class="text-center">MI PERFIL</v-list-item-title>
              </v-list-item>
            </div>

          </v-list-group>

          <v-list-item style="background-color: black;"  :to="{name: 'Quotations'}">
            <v-list-item-icon>
              <v-icon dark>mdi-cart</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title style="color: white">
                CARRITO ({{ quotingOrders.length }})
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-divider></v-divider>
          <v-list-item color="#47a5ad" :to="{name:'Home'}">
            <v-list-item-icon>
              <v-icon>mdi-home</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-divider></v-divider>
          <v-list-item color="#47a5ad" to="/contact">
            <v-list-item-content>
              <v-list-item-title>CONTACTO</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-divider></v-divider>
          <v-list-item color="#47a5ad" :to="{name: 'Register'}">
              <v-list-item-content>
                  <v-list-item-title>INTERIORISTAS</v-list-item-title>
              </v-list-item-content>
          </v-list-item>
          <v-divider></v-divider>
          <v-list-item color="#47a5ad" to='/aboutus'>
              <v-list-item-content>
                  <v-list-item-title>NOSOTROS</v-list-item-title>
              </v-list-item-content>
          </v-list-item>
          <v-divider></v-divider>
          <v-list-group color="#47a5ad"  v-model="showProducts" no-action>
            <template v-slot:activator>
              <v-list-item-content>
                <v-list-item-title >PRODUCTOS</v-list-item-title>
              </v-list-item-content>
            </template>
            <v-list-item color="#47a5ad" v-for="p in products" :key="p.name" :to="{name: 'Categories', params: {slugProduct: p.slug}}">
              <v-list-item-title> {{ p.name }} </v-list-item-title>
            </v-list-item>
            <v-list-item :to="{name:'Motorized'}">
                <v-list-item-title>MOTORIZACIÓN</v-list-item-title>
            </v-list-item>
          </v-list-group>
          <v-divider></v-divider>
        </v-list>
      </v-navigation-drawer>

      <blackBar v-if="!isMobile" />
            <!-- COMIENZA BARRA BLANCA -->
      <whiteBar v-if="!isMobile" />
            <!-- TERMINA BARRA BLANCA -->




            <!-- COMIENZA BARRA DE NAVEGACIÓN -->
            <v-app-bar ref="mybar" :color="isMobile?'white':'#47a5ad'" style="position: sticky; z-index: 2; max-height: 64px" :style="isMobile?'top: 0;':'top:28px;'">

                 <v-app-bar-nav-icon v-if="isMobile" @click="drawer = true">
                 </v-app-bar-nav-icon>
                 <v-spacer></v-spacer>
                 <v-card v-if="isMobile" :to="{name:'Home'}" flat height="56" max-height="56" width="180" tile>
                    <v-img max-width="170"  src="/img/logo.svg"  ></v-img>
                 </v-card>

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

             <template v-if="!isMobile" v-slot:default="{}" >

                  <v-menu  offset-y>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn class="white--text " style="justify-content:left" depressed tile color="#404042" width="200px" height="65px" v-bind="attrs" v-on="on">
                              <div v-if="$refs.mybar">

                               <v-img v-if="$refs.mybar._data.currentScroll >= 138" width="40px" class="ml-n2" :src="'/img/white-r.png'"></v-img>
                                <v-icon  v-else left>mdi-menu</v-icon>
                              </div>
                            PRODUCTOS

                        </v-btn>
                    </template>
                        <v-list  flat dark>
                            <v-list-item-group  >
                              <v-list-item v-for="p in products" :key="p.id" :to="{name: 'Categories', params: {slugProduct: p.slug}}" style="border-bottom: 1px solid gray">
                                <v-list-item-content>

                                  <v-menu  open-on-hover offset-x>
                                     <template v-slot:activator="{ on, attrs }">
                                        <v-list-item-title class="white--text" v-bind="attrs" v-on="on" >  {{ p.name }}  </v-list-item-title>
                                      </template>
                                      <v-list flat dark>
                                        <v-list-item v-for="(t, index) in p.types" :key="index" :to="{name: 'Lines', params: {slugProduct: p.slug,slugType: t.slug}}"  style="border-bottom: 1px solid gray" >
                                          <v-list-item-content>
                                            <v-list-item-title > {{ t.name }} </v-list-item-title>
                                          </v-list-item-content>
                                        </v-list-item>
                                      </v-list>
                                  </v-menu>
                                </v-list-item-content>
                              </v-list-item>
                                <v-list-item :to="{name:'Motorized'}">
                                    <v-list-item-title>MOTORIZACIÓN</v-list-item-title>
                                </v-list-item>

                            </v-list-item-group>
                        </v-list>
                </v-menu>
                <v-btn class="ml-1" icon color="white" :to="{name:'Home'}" >
                    <v-icon size="30">mdi-home</v-icon>
                </v-btn>
                <v-btn color="white" text height="65px" to="/aboutus" >Nosotros</v-btn>
                <v-btn color="white" text height="65px" to="/client-register">Interioristas</v-btn>
                <!-- <v-btn color="white" text height="65px">Galería</v-btn> -->
                <v-btn color="white" text height="65px" to="/contact">Contáctanos</v-btn>
                <v-spacer  ></v-spacer>
                <v-menu :offset-y="true" max-width="370" >
                  <template v-slot:activator="{on, attrs }">
                <v-text-field
                title
                flat
                v-bind="attrs"
                v-on="on"
                color="#47a5ad"
                class="mt-8"
                single-line
                solo
                placeholder="Buscar producto"
                append-icon="mdi-magnify"
                v-model="query"
                >
              </v-text-field>
              </template>

              <v-list three-line max-height="500" color="white">
                <!-- '/:slugProduct/:slugType/:slugLine?/detalles/:slugDetail' -->
                <template v-for="(item, index) in items" >
                  <v-list-item :key="index" style="background-color: white"
                  :to="{name: 'Details', params: {slugProduct:item.product,slugType:item.type,slugDetail: item.slug, id: item.id}}"
                  >
                      <v-img max-width="60" :src="`../img/modelos/tumb/${item.image}.jpg`"></v-img>

                    <v-list-item-content class="ma-1">
                      <v-list-item-title style="font-size: 1em;" >{{item.name}}</v-list-item-title>
                      <v-list-item-subtitle style="color: #47a5ad; font-size: 1em" >${{item.price}}MXN</v-list-item-subtitle>
                    </v-list-item-content>
                  </v-list-item>
                </template>
              </v-list>
              </v-menu>
              <v-btn
              :to="{name: 'Quotations'}"
              height="65px"
              class="white--text ml-2"
              depressed tile color="#404042">
                <v-icon left>mdi-cart</v-icon>
                CARRITO ({{ quotingOrders.length }})
              </v-btn>


            </template>

             </v-app-bar>



             <!-- TERMINA BARRA DE NAVEGACIÓN -->

             <v-main>
                <!-- <v-btn max-width="500" tile left fixed style="z-index: 100"> -->
                 <!--  <v-container  style="width: 1200px; margin: auto" class="pa-0">

                 <v-breadcrumbs
               :items="breadCrumbs"
               divider=">"
               class="pa-3"
               v-if="breadCrumbs.length > 1"
               >

               <template v-slot:divider>
                <v-icon>mdi-chevron-right</v-icon>
                </template>
                 <template v-slot:item="props">
                   <router-link style="text-decoration: none" :to="props.item.to" v-if="!props.item.disabled">
                      <v-breadcrumbs-item
                      style="color: #47a5ad"
                      :class="[props.item.disabled && 'disabled']">
                       {{props.item.text}}
                      </v-breadcrumbs-item>
                    </router-link>
                  </template>

               </v-breadcrumbs>
               </v-container> -->
                  <btnCotizador />
                  <btnMail @clicked="btnMailCliked"></btnMail>

                  <router-view :key="$route.path"></router-view>

               <!-- <btnSocialMedia/> -->
            </v-main>
            <!-- <DialogInvite/>
             <FakeNotification/> -->
             <!-- EMPIEZA FOOTER -->
             <theFooter v-if="!$route.path.includes('quoter')"  :isMobile="isMobile"/>
             <!-- TERMINA FOOTER -->
             <mailDialog @clickCloseDialog="closeDialog" :openDialog="dialog"/>

             <div class="d-flex justify-center" style="background-color: black; color: #616161; font-size: 10px">
               <span>Rollux México® {{(new Date()).getFullYear()}}  |  Hecho por Grupo Lidhber®</span>
             </div>
        </v-app>
</template>

<script>

import { mapState } from 'vuex';
import btnCotizador from '../../components/Index/TheCuoterButton';
import btnMail from '../../components/Index/TheMailButton';
import whiteBar from '../../components/Index/TheWhiteBar';
import blackBar from '../../components/Index/TheBlackBar';
import theFooter from '../../components/Index/TheFooter';
import mailDialog from '../../components/Index/TheMailDialog';
// import DialogInvite from '../../components/DialogInvite';
// import FakeNotification from '../../components/FakeNotification';


export default {
    data(){
        return{
          loading: false,
          query: null,
          items: [],
          showSearch: false,
          dialog: false,
          isMobile:false,
          drawer: false,
          transparent: 'rgba(255, 255, 255, 0)',
          routes: [],
          showProducts: true,
        }
    },

    components: {
      btnCotizador,
      btnMail,
      whiteBar,
      blackBar,
      theFooter,
      mailDialog,

      // DialogInvite,
      // FakeNotification,
    },
    watch:{
      query(after, before){
        if(this.query !== ''){
          this.searchProducts();
        }

      }
    },

    //  beforeRouteEnter(to, from, next){
    //     next(um => {


    //     })
    // },



    mounted(){
        this.loading = true
        this.$store.dispatch('getQuotingOrders');
        this.$store.dispatch('getSubweaves')
        this.$store.dispatch('getProducts')
        this.$store.dispatch('getAllVariants').then( () =>{
        this.loading = false;
        })
        // this.$store.dispatch('getManufacturers')
        this.onResize()
        window.addEventListener('resize', this.onResize, { passive: true })
    },

    computed:{
      ...mapState({
      products: state => state.productsModule.products,
      quotingOrders: state => state.ordersModule.quotingOrders,
    }),


    //  breadCrumbs() {

    //   let pathArray = this.$route.path.split("/")
    //   pathArray.shift()


    //   let breadcrumbs = pathArray.reduce((breadcrumbArray, path, idx) => {

    //     breadcrumbArray.push({
    //       path: path,
    //       to: this.$route.meta.name,
    //       text: path.split('-').join(' ').toUpperCase() || this.$route.matched[idx+1].meta.breadCrumb,
    //     });


    //     return breadcrumbArray;
    //   }, [])


    //   return breadcrumbs;
    //   }

     },
    methods:{
        onResize(){
      this.isMobile = window.innerWidth < 780
    },

    searchProducts(){
     this.items = this.$store.state.productsModule.variants.filter((t) => t.name.includes(this.query))
    },

    btnMailCliked(value){
      this.dialog = value
    },
    closeDialog(value){
      this.dialog = value
    }
    },


}
</script>

<style >
*{
    font-family: 'Raleway';
    -webkit-box-sizing: border-box;
    -khtml-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -ms-box-sizing: border-box;
    box-sizing: border-box;
}

/* INICIA CODIGO PARA LOADING */
#divBody{
    display:flex;
    width:100%;
    height:100vh;
    justify-content:center;
    align-items:center;
    background:#47a5ad;
}

#pngRolluxInOut{
    position:absolute;
    width:90px;
    height:64px;
    margin: 0 0 0 -1px;
    transform: translatey(-85px) translatex(-20px);
    z-index:6;
    animation: float_pngRolluxInOut .5s infinite , scale 2s infinite;
}

#loading {
	text-align: center;
	margin: 117px auto 0 auto;
    font-weight: bold;
    font-size:16px;
    color: white;
}

#loading span {
	-webkit-animation-name: opacity;
	-webkit-animation-duration: 2.2s;
	-webkit-animation-iteration-count: infinite;

	-moz-animation-name: opacity;
	-moz-animation-duration: 2.2s;
	-moz-animation-iteration-count: infinite;
}

#loading span:nth-child(2) {
	-webkit-animation-delay: 100ms;
	-moz-animation-delay: 100ms;
}

#loading span:nth-child(3) {
	-webkit-animation-delay: 190ms;
	-moz-animation-delay: 190ms;
}

/* KEYFRAME pngRolluxInOut INICIA */
@keyframes float_pngRolluxInOut{
    0%{
      transform: translatey(-85px) translatex(-20px);
    }
    50%{
      transform: translatey(-80px) translatex(-20px);
    }
    100%{
      transform: translatey(-85px) translatex(-20px);
    }
}
@keyframes scale{
    0%{
      transform: scale(.93);
    }
    50%{
      transform: scale(1);
    }
    100%{
      transform: scale(.93);
    }
}
/* KEYFRAME pngRolluxInOut TERMINA */

/* KEYFRAME CARGANDO INICIA */
@-webkit-keyframes opacity {
	0% { opacity: 1; }
	100% { opacity: 0; }
}
@-moz-keyframes opacity {
	0% { opacity: 1; }
	100% { opacity: 0; }
}
/* KEYFRAME CARGANDO TERMINA */
/* TERMINA CODIGO PARA LOADING */

.slide-enter-active,
.slide-leave-active{
    transition: opacity 0.5s, transform 0.5s;
}

.slide-enter,
.slide-leave-to{
    opacity: 0;
    transform: translateX(-30%);
}

.v-btn--absolute.v-btn--top, .v-btn--fixed.v-btn--top {
    right: 0px;
    top: 240px;
}

.v-toolbar__content{
    max-width: 1205px;
    margin: auto !important;
}

</style>
