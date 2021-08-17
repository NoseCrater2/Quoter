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
          <v-list-item  @click="showComponent = 4" :to="{name: 'Orders'}">
            <v-list-item-icon>
              <v-icon>mdi-truck</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Pedidos</v-list-item-title>
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
                    <v-list-item-title>PDFS</v-list-item-title>
                </v-list-item>
                </v-list>
              </v-menu>
            <v-divider inset vertical></v-divider>

            <v-menu offset-y>
              <template v-slot:activator="{attrs, on}">
                <v-btn v-bind="attrs" v-on="on" class="white--text" text >Pedidos</v-btn>
              </template>
               <v-list>
                  <v-list-item :to="{name: 'Orders'}">
                    <v-list-item-title >ORDENES</v-list-item-title>
                  </v-list-item>
                  <v-list-item v-if="user.role !== 'Superadministrador'" :to="{name: 'Quotations'}">
                    <v-list-item-title >COTIZACIONES</v-list-item-title>
                  </v-list-item>
                </v-list>
            </v-menu>


            <v-divider inset vertical></v-divider>
             <v-btn class="white--text"  text :to="{name: 'Quoter'}">Cotizador</v-btn>
            <v-divider inset vertical></v-divider>



          </v-toolbar-items>




          <!-- <v-btn icon class="ma-1" rounded depressed dark> -->

          <v-btn icon large class="ma-2" rounded depressed dark>

            <v-badge color="red"
            :content="orders.length"
            :value="orders.length"
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
                                <h3>{{user.name}}</h3>
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
export default {


   data() {
    return {
      drawer: false,
      showComponent: 1,
      right: null,
      snackbar: false,
      timeout: 3000,

      image: "/storage/img/Madera.jpeg",


    }
  },

async  beforeCreate(){
  this.$store.dispatch("loadUser")
},

  mounted() {
     this.$store.dispatch('getProducts')
     this.$store.dispatch('getAllVariants')
     this.$store.dispatch("getMotorizations")

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
    }),

      ...mapGetters([
      'loggedIn',
      'getLoginErrors',
      'getLoginStatus',
      'getUserStatus'
     ]),


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
