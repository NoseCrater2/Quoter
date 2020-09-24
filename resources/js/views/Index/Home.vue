<template>
  <div id="imageBackground" :style="{'background-image': 'url(' + image + ')'}">
    <v-app id="inspire">
      <div>
      
        <v-app-bar  dense flat color="#3ba2a9" dark>
          
          <v-toolbar-title>ROLLUX</v-toolbar-title>

           <v-divider class="mx-4" inset vertical></v-divider>

          <span class="subheading">Cotizador</span>

          <v-spacer></v-spacer>
          
          
          <v-toolbar-items v-if="loggedIn">
       
              <v-btn v-if="user.roles.includes('Administrador')" text to="/users">

                Usuarios
              </v-btn>
              <v-divider inset vertical></v-divider>
               <v-btn v-if="user.roles.includes('Administrador') " text>Inventario</v-btn>
              <v-divider inset vertical></v-divider>
            <v-divider inset vertical></v-divider>
            <v-btn v-if=" user.roles.includes('Administrador') || user.roles.includes('Distribuidor')"  text>Pedidos</v-btn>
            <v-divider inset vertical></v-divider>
             <v-btn v-if=" user.roles.includes('Administrador') || user.roles.includes('Distribuidor')" text>Cotizador</v-btn>
            <v-divider inset vertical></v-divider>
           
          </v-toolbar-items>
          

          <v-btn icon class="ma-1" rounded depressed dark>
            <v-badge color="red" content="3" overlap>
              <v-icon>mdi-cart-outline</v-icon>
            </v-badge>
          </v-btn>

           <v-divider inset vertical></v-divider>

           <v-menu
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

           <v-list v-if="loggedIn">
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
              <v-list-item v-if="loggedIn" to="/profile">
                <v-list-item-icon>
                  <v-icon >mdi-account</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title>Perfil</v-list-item-title>
                </v-list-item-content>    
              </v-list-item>
               
              <v-list-item v-if="!loggedIn" >
               <router-link :to="{name: 'login' }" style="text-decoration: none;">
                <v-list-item-icon>
                  <v-icon >mdi-login</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                <v-list-item-title>Entrar</v-list-item-title>
                </v-list-item-content>
                </router-link>
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

      

      <router-view></router-view>
      
    </v-app>
  </div>
</template>

<script>
import Quoter from "../../components/Quoter";
import {mapGetters, mapActions, mapState } from 'vuex';
export default {

  mounted() {
   if(this.loggedIn){
     
     this.$store.dispatch('getUser').then(()=>{
          if(this.getUserStatus === 200){
          console.log(this.user)
         }
        
        })
   }
  },
  data() {
    return {
      items: [
        { title: 'Dashboard', icon: 'mdi-view-dashboard' },
        { title: 'Photos', icon: 'mdi-image' },
        { title: 'About', icon: 'mdi-help-box' },
      ],
      right: null,
      snackbar: false,
      timeout: 3000,
      image: "/storage/img/Madera.jpeg",
    };
  },
  components: {
    Quoter,
  },

  methods: {
   

    logout(){
      this.$store.dispatch('destroyToken',this.credentials).then(()=>{
          if(this.getLoginStatus === 200){
           this.snackbar = true
           this.$router.push({path:'/'})
          this.$router.go()
         }
        
        })
    }
  },
 computed:{

    ...mapState({
      user: state => state.userModule.user,
    }),

      ...mapGetters([
      'loggedIn',
      'getLoginErrors',
      'getLoginStatus',
      'getUserStatus'
     ]),
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
