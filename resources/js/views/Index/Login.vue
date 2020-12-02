<template>
   <div id="app">
  <v-app id="inspire">
    
      <v-dialog v-model="dialog" persistent max-width="500px">
      
         
              <v-card class="elevation-4">
                <v-toolbar
                  color="#3ba2a9"
                  dark
                  flat
                >
                 <v-spacer></v-spacer>

                 <p class="display-1 mt-4">INICIAR SESIÓN</p>
                
                  <v-spacer></v-spacer>
                  
                </v-toolbar>
                <v-card-text>
                  <v-form>
                    <v-text-field
                     color="#3ba2a9"
                      label="Email"
                      name="Email"
                      :error-messages="getLoginErrors.email"
                      v-model="credentials.email"
                      prepend-icon="mdi-account"
                      type="text"
                    ></v-text-field>
  
                    <v-text-field
                        color="#3ba2a9"
                      id="password"
                      v-model="credentials.password"
                      :error-messages="getLoginErrors.password"
                      label="Contraseña"
                      name="password"
                      prepend-icon="mdi-lock"
                      type="password"
                    ></v-text-field>
                  
                     <p   
                   class="text-center"
                    >
                    ¿Quieres cotizar y no eres distribuidor? <router-link to="/signup"> Reguistrate aquí</router-link>
                   </p>
                  </v-form>
                </v-card-text>
                <v-card-actions>
                  <v-btn color="red" dark  @click="cancel()">
                     <v-icon left>mdi-arrow-left-bold</v-icon>
                    Cancelar
                  </v-btn>

                  
                <v-spacer></v-spacer>


                  <v-btn
                  :loading="loading" 
                  @click="login()"
                  dark 
                 
                  color="#3ba2a9">
                      Entrar 
                    <v-icon right>mdi-login</v-icon>
                    </v-btn>
                  
                </v-card-actions>
              </v-card>
     </v-dialog>
  
  </v-app>
</div>
</template>

<script>
import { mapActions, mapState, mapGetters } from 'vuex';
export default {
  data() {
    return {
      dialog: true,
      loading: false,
        credentials: {
            email: null,
            password: null
        },
    
    };
  },
  props: {
   
  },

  computed:{
      ...mapGetters([
      'getLoginErrors',
      'getLoginStatus',
      'loggedIn'
     ]),

   
  },
  methods:{
      login(){
        this.loading = true;
          this.$store.dispatch('retrieveToken',this.credentials).then(()=>{
           
            if(this.getLoginStatus === 200){
                         
           
               this.$router.push({name: 'Dashboard'});
            // 
            
               this.loading = false

            }
          this.loading = false
        })

      },

      cancel(){
         this.$router.push({name: 'index'});
      }
  },
  components: {
   
  }
};


</script>