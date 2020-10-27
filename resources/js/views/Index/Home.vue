<template>
<<<<<<< HEAD
  <div id="app">
    <v-app>
   <v-navigation-drawer app
      v-model="drawer"
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
        <v-list-item @click="showComponent = 3">
            <v-list-item-icon>
              <v-icon>mdi-account</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Perfil</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item @click="showComponent = 1">
            <v-list-item-icon>
              <v-icon>mdi-calculator</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Cotizador</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item v-if="user.roles.includes('Administrador') || user.roles.includes('Distribuidor')" @click="showComponent = 4">
            <v-list-item-icon>
              <v-icon>mdi-truck</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Pedidos</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item v-if="user.roles.includes('Administrador')" @click="showComponent = 5">
            <v-list-item-icon>
              <v-icon>mdi-clipboard-list</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Inventario</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item v-if="user.roles.includes('Administrador')" @click="showComponent = 2">
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

        <div>
      <v-app-bar app
        color="#3ba2a9"
        class="white--text"
        dense
      >
        <v-app-bar-nav-icon v-if="isMobile" @click="drawer = true"></v-app-bar-nav-icon>
  
        <v-toolbar-title>ROLLUX</v-toolbar-title>
  
         <v-spacer></v-spacer>
          
          
          <v-toolbar-items v-if="loggedIn && !isMobile">
       
              <v-btn class="white--text" v-if="user.roles.includes('Administrador')" text @click="showComponent = 2">
                Usuarios
              </v-btn>
              <v-divider inset vertical></v-divider>
               <v-btn class="white--text" v-if="user.roles.includes('Administrador')" text @click="showComponent = 5">Inventario</v-btn>
              <v-divider inset vertical></v-divider>
            <v-divider inset vertical></v-divider>
            <v-btn class="white--text" v-if=" user.roles.includes('Administrador') || user.roles.includes('Distribuidor')"  text @click="showComponent = 4">Pedidos</v-btn>
            <v-divider inset vertical></v-divider>
             <v-btn class="white--text" v-if=" user.roles.includes('Administrador') || user.roles.includes('Distribuidor')" text @click="showComponent = 1">Cotizador</v-btn>
            <v-divider inset vertical></v-divider>

           
           
          </v-toolbar-items>
           <v-btn icon class="ma-1" rounded depressed dark>
=======
  <div id="imageBackground" :style="{'background-image': 'url(' + image + ')'}">
    <v-app id="inspire">
      <div>
        <v-app-bar dense flat color="#3ba2a9" dark>
          <v-toolbar-title>ROLLUX</v-toolbar-title>

          <v-spacer></v-spacer>

          <v-btn icon class="ma-1" rounded depressed dark>
>>>>>>> master
            <v-badge color="red" content="3" overlap>
              <v-icon>mdi-cart-outline</v-icon>
            </v-badge>
          </v-btn>
<<<<<<< HEAD
          <v-divider v-if="!isMobile" inset vertical></v-divider>

          <v-menu
           v-if="!isMobile"
            bottom
            offset-y
            transition="slide-y-transition">
           <template v-slot:activator="{ on, attrs }">
              <v-btn icon class="ma-1" rounded depressed dark v-bind="attrs" v-on="on">
                <v-avatar color="#3ba2a9">
                  <v-icon dark>mdi-account-circle</v-icon>
                </v-avatar>
              </v-btn>
           </template>

           <v-list v-if="loggedIn " >
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
              <v-list-item v-if="loggedIn" @click="showComponent = 3">
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
        </v-list>
           </v-menu>
      </v-app-bar>

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

    </div>

    <v-main>
      <v-container fluid><!--AQUÍ VAN TODOS LOS COMPONENTES  -->
        
        <div v-if="showComponent === 1">
        <Quoter/>
      </div>
      <div v-if="showComponent  === 2">
        <Users/>
      </div>
      <div v-if="showComponent  === 3">
        <Profile/>
      </div>
      <div v-if="showComponent  === 4">
        <Orders/>
      </div>
      <div v-if="showComponent  === 5">
        <Stock/>
      </div>
      </v-container>
    </v-main>
      
     
    </v-app>

=======

          <v-btn icon class="ma-1" rounded depressed dark>
            <v-icon>mdi-account-circle</v-icon>
          </v-btn>
        </v-app-bar>
      </div>
      <v-card class="mx-auto my-auto" width="500" elevation="9" color="rgba(255,255,255,0.8)">
        <Quoter></Quoter>
      </v-card>
    </v-app>
>>>>>>> master
  </div>
</template>

<script>
<<<<<<< HEAD

import {mapGetters, mapActions, mapState } from 'vuex';
export default {

beforeDestroy () {
   if (typeof window === 'undefined') return

      window.removeEventListener('resize', this.onResize, { passive: true })
  },
  mounted() {
    this.onResize()

    window.addEventListener('resize', this.onResize, { passive: true })
   if(this.loggedIn){
     
     this.$store.dispatch('getUser').then(()=>{
          if(this.getUserStatus === 200){
          
         }
        
      })
   }
  },


  data() {
    return {
      isMobile: false,
      drawer: false,
      showComponent: 1,
      right: null,
      snackbar: false,
      timeout: 3000,
=======
import Quoter from "../../components/Quoter";

export default {
  mounted() {},
  data() {
    return {
>>>>>>> master
      image: "/storage/img/Madera.jpeg",
    };
  },
  components: {
<<<<<<< HEAD
    Quoter: () => import('../../components/Quoter'),
    //Quoter,
    Users: () => import("../../components/Users"),
    Profile: () => import("../../views/Profile"),
    Orders: () => import("../../components/Orders"),
    Stock: () => import("../../components/Stock"),
  },

  methods: {
    onResize(){
      this.isMobile = window.innerWidth < 732
    },

    logout(){
      this.$store.dispatch('destroyToken',this.credentials).then(()=>{
          if(this.getLoginStatus === 200){
           this.snackbar = true
         this.$router.push({name:'login'});
         
         }
        
        })
    }
  },
 computed:{

    ...mapState({
      user: state => state.userModule.user,
     // loggedIn: state => state.loginModule.loggedIn,
    }),

      ...mapGetters([
      'loggedIn',
      'getLoginErrors',
      'getLoginStatus',
      'getUserStatus'
     ]),
=======
    Quoter,
>>>>>>> master
  },
};
</script>

<style scoped>
#inspire {
  background: rgba(0, 0, 0, 0);
}

#imageBackground {
  background-size: cover;
  -webkit-transition: background-image 0.2s ease-in-out;
  transition: background-image 0.2s ease-in-out;
}
</style>
