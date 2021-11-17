<template>

  <div id="app">
    <v-app>
   <v-navigation-drawer
        v-model="computedDrawerSize"
        absolute
        temporary
      >

      <v-list-item>
          <v-list-item-content>
            <v-list-item-title class="title">{{user.name}}</v-list-item-title>
            <v-list-item-subtitle>-{{user.role}}-</v-list-item-subtitle>
            <v-list-item-subtitle>{{user.email}}</v-list-item-subtitle>
          </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>
      <v-list dense>
        <v-list-item v-if="loggedIn" :to="{name: 'Profile'}">
            <v-list-item-icon>
              <v-icon>mdi-account</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Perfil</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        <v-list-item :to="{name: 'Marketcar'}">
            <v-list-item-icon>
              <v-icon>mdi-cart</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Carrito de compra</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <!-- <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-bell</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Notificaciones</v-list-item-title>
            </v-list-item-content>
        </v-list-item> -->
        <!-- <v-list-item :to="{name: 'Orders', params: {option: 'cotizaciones'}}">
            <v-list-item-icon class="ml-n1 pr-n2">
              <v-img contain height="30px" width="35px" src="/img/dashboard/cotizacion.svg" ></v-img>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Cotizaciones</v-list-item-title>
            </v-list-item-content>
        </v-list-item> -->
        <v-list-item :to="'/'">
            <v-list-item-icon>
              <v-icon>mdi-home</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Ir a Rollux.com</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
          <v-list-item @click="showComponent = 1" :to="{name: 'Quoter'}">
            <v-list-item-icon>
              <v-icon>mdi-calculator</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Cotizador</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item  @click="showComponent = 4" :to="{name: 'Orders', params: {option: 'ordenes'}}">
            <v-list-item-icon>
              <v-icon>mdi-truck</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Ordenes</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        <v-list-item  @click="showComponent = 4" :to="{name: 'Orders', params: {option: 'cotizaciones'}}">
            <v-list-item-icon>
              <v-icon>mdi-truck</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Cotizaciones</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item v-if="user.role === 'Superadministrador'" @click="showComponent = 5" :to="{name: 'Stock', params: {slugProduct: 'PERSIANAS'}}">
            <v-list-item-icon>
              <v-icon>mdi-clipboard-list</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Inventario</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item v-if="user.role === 'Superadministrador' || user.role === 'Administrador' || user.role === 'Vendedor'" @click="showComponent = 2" :to="{name: 'Users'}">
            <v-list-item-icon>
              <v-icon>mdi-account-multiple</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Usuarios</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item @click="logout()">
            <v-list-item-icon>
              <v-icon>mdi-logout</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Salir</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>

      </v-navigation-drawer>


      <v-app-bar app
        color="#3ba2a9"
        class="white--text"
        dense
        elevation="0"
      >
        <v-app-bar-nav-icon class="white--text" v-if="!$vuetify.breakpoint.mdAndUp" @click.stop="drawer = true"></v-app-bar-nav-icon>

        <v-spacer v-if="!$vuetify.breakpoint.mdAndUp"></v-spacer>

        <v-card color="transparent" flat tile :to="'/dashboard'">
           <v-img  max-width="128" :src="`/img/white-logo.png`"></v-img>
        </v-card>



         <v-spacer></v-spacer>


          <v-toolbar-items v-if="$vuetify.breakpoint.mdAndUp">
              <v-btn
                class="white--text"
                text
                :to="{name: 'Home'}">
                  Ir a Rollux.com
              </v-btn>
              <v-divider inset vertical></v-divider>
              <v-btn
              v-if="user.role === 'Superadministrador' || user.role === 'Administrador' || user.role === 'Vendedor'"
              class="white--text"
              text
              :to="{name: 'Users'}">
                Usuarios
              </v-btn>

              <v-divider  v-if="user.role === 'Superadministrador'" inset vertical></v-divider>
              <v-menu offset-y  v-if="user.role === 'Superadministrador'" >
                <template v-slot:activator="{attrs, on}">
                  <v-btn v-bind="attrs" v-on="on" class="white--text"  text  >Inventario</v-btn>
                </template>
                <v-list>
                  <v-list-item v-for="product in products" :key="product.id" :to="{name: 'Stock', params: {slugProduct: product.slug}} ">
                    <v-list-item-title v-text="product.name"></v-list-item-title>
                  </v-list-item>
                  <v-list-item :to="{name: 'Motorization'}">
                    <v-list-item-title>MOTORIZACIÓN</v-list-item-title>
                  </v-list-item>
                   <v-list-item :to="{name: 'Galleries'}">
                    <v-list-item-title>GALERÍAS</v-list-item-title>
                  </v-list-item>
                <v-list-item :to="{name: 'ImportPdfs'}">
                    <v-list-item-title>PDF Listas Precios</v-list-item-title>
                </v-list-item>
                <v-list-item :to="{name: 'ImportPdfsPromo'}">
                    <v-list-item-title>PDF Gaceta Promociones</v-list-item-title>
                </v-list-item>
                <v-list-item :to="{name: 'importCatalog'}">
                    <v-list-item-title>PDF Catálogos</v-list-item-title>
                </v-list-item>
                </v-list>
              </v-menu>
            <v-divider inset vertical></v-divider>

            <v-menu offset-y>
              <template v-slot:activator="{attrs, on}">
                <v-btn v-bind="attrs" v-on="on" class="white--text" text >Pedidos</v-btn>
              </template>
                <v-list v-if="user.role === 'Superadministrador' || user.role === 'Administrador'">
                  <v-list-item :to="{name: 'Orders', params: {option: 'ordenes'}}">
                    <v-list-item-title >MIS ÓRDENES</v-list-item-title>
                  </v-list-item>
                  <v-list-item :to="{name: 'Orders', params: {option: 'ordenes-admin'}}">
                    <v-list-item-title >ORDENES DISTRIBUIDORES</v-list-item-title>
                  </v-list-item>
                  <v-list-item  :to="{name: 'Orders', params: {option: 'cotizaciones'}}">
                    <v-list-item-title >MIS COTIZACIONES</v-list-item-title>
                  </v-list-item>
                  <v-list-item  :to="{name: 'Orders', params: {option: 'cotizaciones-admin'}}">
                    <v-list-item-title >COTIZACIONES DISTRIBUIDORES</v-list-item-title>
                  </v-list-item>
                </v-list>
               <v-list v-else-if="user.role !== 'Superadministrador' || user.role !== 'Administrador'">
                  <v-list-item :to="{name: 'Orders', params: {option: 'ordenes'}}">
                    <v-list-item-title >ORDENES</v-list-item-title>
                  </v-list-item>
                  <v-list-item  :to="{name: 'Orders' ,  params: {option: 'cotizaciones'}} ">
                    <v-list-item-title >COTIZACIONES</v-list-item-title>
                  </v-list-item>
                </v-list>
            </v-menu>


            <v-divider inset vertical></v-divider>
             <v-btn class="white--text"  text :to="{name: 'Quoter'}">Cotizador</v-btn>
            <v-divider inset vertical></v-divider>



          </v-toolbar-items>




          <!-- <v-btn icon class="ma-1" rounded depressed dark> -->

          <v-btn :to="{name: 'Orders', params: {option: 'cotizaciones'}}" icon x-small fab class="mx-2">
            <v-badge color="blue"
            offset-x="17"
            offset-y="12"
            :content="computedNumberVigentQuotings"
            :value="computedNumberVigentQuotings"
            overlap>
                <v-img contain height="30px" width="35px" src="/img/dashboard/cotizacion_white.png" ></v-img>
            </v-badge>
          </v-btn>

          <v-divider inset vertical></v-divider>


          <!-- <v-menu bottom offset-y>
            <template v-slot:activator="{ on, attrs }">
              <v-btn icon large class="ma-2" v-bind="attrs" v-on="on" rounded depressed dark>
                <v-badge color="red"
                :content="notifications.length"
                :value="notifications.length"
                overlap>
                  <v-icon>mdi-bell</v-icon>
                </v-badge>
              </v-btn>
            </template>
            <v-list dense>
              <v-list-item v-for="notification in notifications" :key="notification.id">
                <v-list-item-content>
                  <v-list-item-title>
                    {{'Una orden ahora está en ' +notification.data.state }}
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list>
          </v-menu> -->



          <v-divider inset vertical></v-divider>

          <v-btn :to="{name: 'Marketcar'}" icon large class="ma-2" rounded depressed dark >

            <v-badge color="red"
            :content="computedNumberNoPaidOrders"
            :value="computedNumberNoPaidOrders"
            overlap>
              <v-icon>mdi-cart-outline</v-icon>
            </v-badge>
          </v-btn>

          <v-divider v-if="$vuetify.breakpoint.mdAndUp" inset vertical></v-divider>

            <v-menu
                v-if="$vuetify.breakpoint.mdAndUp"
                bottom
                offset-y
                transition="slide-y-transition"
            >
                <template v-slot:activator="{ on, attrs }">
                   <v-btn icon class="ma-1" rounded depressed dark v-bind="attrs" v-on="on">
                     <v-avatar color="#3ba2a9">
                       <v-icon dark>mdi-account-circle</v-icon>
                     </v-avatar>
                   </v-btn>
                </template>


                <v-card min-width="340">
                    <v-list-item-content class="justify-center">
                        <div class="mx-auto text-center">
                            <div class="px-3">
                                <h3>{{user.name}} | {{user.role}}</h3>
                                <p class="text-caption mt-1">
                                    {{user.email}}
                                </p>

                            </div>
                            <v-divider v-if="loggedIn" class="my-3"></v-divider>
                            <v-btn
                              depressed
                              rounded
                              text
                              color="#3ba2a9"
                              v-if="loggedIn"
                              :to="{name: 'Profile'}"
                            >
                                <v-icon left>mdi-account</v-icon>
                                Perfil
                            </v-btn>
                            <v-divider class="my-3"></v-divider>
                            <v-btn
                              depressed
                              rounded
                              text
                              color="#3ba2a9"
                              :to="'/'"
                            >
                                <v-icon left>mdi-home</v-icon>
                                Ir a Rollux.com
                            </v-btn>
                            <v-divider class="my-3"></v-divider>
                            <v-btn
                              depressed
                              rounded
                              text
                              color="#3ba2a9"
                              v-if="!loggedIn"
                              to="/login"
                            >
                                <v-icon left>mdi-login</v-icon>
                                Entrar
                            </v-btn>
                            <v-btn
                              depressed
                              rounded
                              text
                              color="#3ba2a9"
                              v-if="loggedIn"
                              @click="logout()"
                            >
                                <v-icon left>mdi-logout</v-icon>
                                Salir
                            </v-btn>
                        </div>
                    </v-list-item-content>
                </v-card>


                <!-- <v-list v-if="loggedIn ">
                    <v-list-item >
                        <v-list-item >
                            <v-list-item-content>
                              <v-list-item-title class="title">{{user.name}}</v-list-item-title>
                              <v-list-item-subtitle>{{user.email}}</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-divider></v-divider>
                    </v-list-item>
                </v-list>

                <v-list nav dense>
                    <v-list-item-group color="#3ba2a9">
                        <v-list-item v-if="loggedIn" :to="{name: 'Profile'}">
                            <v-list-item-icon>
                                <v-icon >mdi-account</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Perfil</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>

                      <v-list-item v-if="!loggedIn" to="/login">
                            <v-list-item-icon>
                                <v-icon >mdi-login</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content >
                                <v-list-item-title >Entrar</v-list-item-title>
                            </v-list-item-content>
                      </v-list-item>

                        <v-list-item v-if="loggedIn" @click="logout()">
                            <v-list-item-icon>
                                <v-icon >mdi-logout</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>Salir</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                </v-list> -->
            </v-menu>


      <v-snackbar
        v-model="snackbar"
        color="cyan darken 2"
        :right="true"
        :timeout="timeout"
        :top="true"
        >
        {{ getLoginErrors}}

        <template v-slot:action="{ attrs }">
          <v-btn
            dark
            text
            v-bind="attrs"
            @click="snackbar = false"
          >
            Close
          </v-btn>
        </template>
        </v-snackbar>

        </v-app-bar>


      <v-main>
        <router-view :key="$route.path"></router-view>
      </v-main>
      <v-footer color="#47a5ad" style="height: 100px" >
        <v-row justify="center" align="center" no-gutters>
          <v-col cols="12">
             <div class="white--text text-center"  style="font-weight: bolder">¿Tienes dudas?</div>
          </v-col>
          <v-col cols="12">
            <div class="white--text text-center">Envíanos un correo a distribuidores@rollux.com.mx</div>
          </v-col>
        </v-row>
      </v-footer>

    </v-app>

  </div>
</template>

<script>


import {mapGetters,mapState } from 'vuex';
import { logOut } from '../../utils/auth';
import axios from 'axios'
export default {

   data() {
    return {
      drawer: false,
      showComponent: 1,
      right: null,
      snackbar: false,
      timeout: 3000,

      image: "/storage/img/Madera.jpeg",

      arrayItemsAdminOptions: [
        {
            active: false,
            childItems: [
                { title: 'Mis Órdenes', route: {name: 'Orders', params: {option: 'ordenes'}} },
                { title: 'Ordenes Distribuidores', route: {name: 'Orders', params: {option: 'ordenes-admin'}} }
            ],
            title: 'ORDENES',
        },
        {
            active: false,
            childItems: [
                { title: 'Mis Cotizaciones', route: {name: 'Orders', params: {option: 'cotizaciones'}} },
                { title: 'Cotizaciones Distribuidores', route: {name: 'Orders', params: {option: 'cotizaciones-admin'}} }
            ],
            title: 'COTIZACIONES',
        }
      ]

    }
  },

async  beforeCreate(){
  this.$store.dispatch("loadUser").then(()=>{
     if(this.user.role != 'Superadministrador'){
        this.$store.dispatch('getQuotingOrders')
     }
  })
},

  mounted() {
    //  window.Echo.private(`App.User.4`)
    //         .notification((notification) => {
    //             console.log(notification)
    //         });
    this.$store.dispatch('getNotifications')
     this.$store.dispatch('getProducts')
     this.$store.dispatch('getAllVariants')
     this.$store.dispatch("getMotorizations")
     this.$store.dispatch('getQuotedOrders')

   },




  components: {
      // BlindSteps,
  },

  methods: {
    logout(){
     try {
       axios.post("/logout");
       this.$store.dispatch("logout").then(()=>{
         this.$router.push({name: "Home"})
       });
     } catch (error) {
       this.$store.dispatch("logout");
     }
    }
  },
 computed:{

    ...mapState({
      user: state => state.user,
      products: state => state.productsModule.products,
      loggedIn: state => state.loggedIn,
      orders: state => state.ordersModule.orders,
      quotingOrders: state => state.ordersModule.quotingOrders,
      notifications: state => state.notificationsModule.notifications,
      quotedOrders: state => state.ordersModule.quotedOrders
    }),

      ...mapGetters([
      'loggedIn',
      'getLoginErrors',
      'getLoginStatus',
      'getUserStatus',
      'currentVigentQuoutingItemListDistributors'
     ]),

    computedNumberNoPaidOrders(){
        return this.quotedOrders.filter(itemOrder=> itemOrder.state === 'No Pagada').length;
    },
    computedNumberVigentQuotings(){
        return this.currentVigentQuoutingItemListDistributors.length
    },


        //Propiedad computada que controla si debe aparecer menu hamburguesa o la barra. Necesario para casos donde resize y menu burguer este activo
        computedDrawerSize: {
            get(){
                if(this.$vuetify.breakpoint.mdAndUp){
                    return false;
                }
                else if(!this.$vuetify.breakpoint.mdAndUp){
                    return this.drawer;
                }
            },
            set(model){
                this.drawer = model;
                if(this.$vuetify.breakpoint.mdAndUp){
                    return false;
                }
                else if(!this.$vuetify.breakpoint.mdAndUp){
                    return this.drawer;
                }
            }
        }




  },
};
</script>

<style scoped>
*{
    font-family: 'Raleway';
}
#inspire {
  background: rgba(0, 0, 0, 0);
}

#imageBackground {
  -webkit-transition: background-image 0.2s ease-in-out;
  transition: background-image 0.2s ease-in-out;
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

html {
  scroll-behavior: smooth;
}
</style>
