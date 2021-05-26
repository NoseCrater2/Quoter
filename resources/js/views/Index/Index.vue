<template>
    <v-app>
        <v-navigation-drawer app v-model="drawer" style="z-index: 8;" temporary>
            <v-divider></v-divider>
            <v-list dense>
                <v-list-item :to="{name:'Home'}">
                    <v-list-item-icon>
                        <v-icon>mdi-home</v-icon>
                    </v-list-item-icon>
                </v-list-item>
                
                <v-divider></v-divider>
                <v-list-item to="/contact">
                    <v-list-item-content>
                        <v-list-item-title>CONTACTO</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item :to="{name: 'Register'}">
                    <v-list-item-content>
                        <v-list-item-title>INTERIORISTAS</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item  to='/aboutus'>
                    <v-list-item-content>
                        <v-list-item-title>NOSOTROS</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-group  v-model="showProducts" no-action>
                    <template v-slot:activator>
                        <v-list-item-content>
                            <v-list-item-title >PRODUCTOS</v-list-item-title>
                        </v-list-item-content> 
                    </template>
                    <v-list-item v-for="p in products" :key="p.name" :to="{name: 'Categories', params: {slugProduct: p.slug}}">
                        <v-list-item-title> {{ p.name }} </v-list-item-title>
                    </v-list-item>
                </v-list-group>
            </v-list>
      </v-navigation-drawer>
     
            <!-- COMIENZA BARRA BLANCA -->
          <whiteBar v-if="!isMobile"/>
            <!-- TERMINA BARRA BLANCA -->
           
              
         

            <!-- COMIENZA BARRA DE NAVEGACIÓN -->         
            <v-app-bar ref="mybar" :color="isMobile?'white':'#47a5ad'" style="position: sticky; top:0; z-index: 7; max-height: 64px">
             
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
                        <v-btn class="white--text " style="justify-content:left" depressed tile color="#404042" width="250px" height="65px" v-bind="attrs" v-on="on">
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
                                        <v-list-item v-for="(t, index) in p.types" :key="index" :to=" t.lines > 0?{name: 'Lines', params: {slugProduct: p.slug ,slugType: t.slug,}}:{name: 'Products', params: {slugProduct: p.slug ,slugType: t.slug}}"  style="border-bottom: 1px solid gray" >
                                          <v-list-item-content>
                                            <v-list-item-title > {{ t.name }} </v-list-item-title>
                                          </v-list-item-content>
                                        </v-list-item>
                                      </v-list>
                                  </v-menu>
                                </v-list-item-content>
                              </v-list-item>
                             
                            </v-list-item-group>
                        </v-list>
                </v-menu>
                <v-btn icon color="white" :to="{name:'Home'}" >
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
                    <!-- <v-list-item-action>
                      <v-icon color="#47a5ad" v-if="item.searchable.type.product.slug === 'PERSIANAS'">mdi-blinds</v-icon>
                      <v-icon color="#47a5ad" v-else-if="item.searchable.type.product.slug === 'CORTINAS'" >mdi-script</v-icon>
                       <v-icon color="#47a5ad" v-else>mdi-storefront</v-icon>
                    </v-list-item-action> -->
                  </v-list-item>
                </template>
              </v-list>
              </v-menu>
       
       
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

import {mapState} from 'vuex';
import btnCotizador from '../../components/Index/TheCuoterButton';
import btnMail from '../../components/Index/TheMailButton';
import whiteBar from '../../components/Index/TheWhiteBar';
import theFooter from '../../components/Index/TheFooter';
import mailDialog from '../../components/Index/TheMailDialog';
// import DialogInvite from '../../components/DialogInvite';
// import FakeNotification from '../../components/FakeNotification';


export default {    
    data(){
        return{
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

     beforeRouteEnter(to, from, next){
        next(um => {
            um.$store.dispatch('getLines')
           
             
        })
    },



    mounted(){ 
        this.$store.dispatch('getProducts') 
        this.$store.dispatch('getAllVariants')
        this.$store.dispatch('getManufacturers')
        this.onResize()
        window.addEventListener('resize', this.onResize, { passive: true })
    },

    computed:{
      ...mapState({
      products: state => state.productsModule.products,
      // items: state => state.variantsModule.searchedVariants,
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
}

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
