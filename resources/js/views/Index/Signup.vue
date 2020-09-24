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

                 <v-img src="http://rollux.com.mx/img/rollux-persianas-enrrollables-logo-1598474161.jpg" aspect-ratio="1.7" contain></v-img>
                
                  <v-spacer></v-spacer>
                  
                </v-toolbar>
                <v-card-text>
                  <v-form>
                      <v-text-field
                     color="#3ba2a9"
                      label="Nombre de usuario"
                      name="Username"
                      :error-messages="sErrors.name"
                      v-model="credentials.name"
                      prepend-icon="mdi-account"
                      type="text"
                    ></v-text-field>

                    <v-text-field
                     color="#3ba2a9"
                      label="Email"
                      name="Email"
                      :error-messages="sErrors.email"
                      v-model="credentials.email"
                      prepend-icon="mdi-email"
                      type="text"
                    ></v-text-field>
  
                    <v-text-field
                        color="#3ba2a9"
                      id="password"
                      v-model="credentials.password"
                      :error-messages="sErrors.password"
                      label="Contraseña"
                      name="password"
                      prepend-icon="mdi-lock"
                      type="password"
                    ></v-text-field>

                    <v-text-field
                        color="#3ba2a9"
                      id="password_confirmed"
                      v-model="credentials.password_confirmation"
                      :error-messages="getLoginErrors.password"
                      label="Confirmar contraseña"
                      name="confirmedPassword"
                      prepend-icon="mdi-lock-alert"
                      type="password"
                    ></v-text-field>
                  
                   
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
                  @click="signup()"
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
            name: null,
            email: null,
            password: null,
            password_confirmation: null,
        },
    
    };
  },
  props: {
   
  },

  computed:{
      ...mapGetters([
      'getLoginErrors',
      'getLoginStatus',
      'getSignupStatus',
     ]),

 ...mapState({
      sErrors: state => state.loginModule.signupErrors,
      loginStatus  : state => state.loginModule.loginStatus,
      registerStatus  : state => state.loginModule.signupStatus,
    }),
  },
  methods:{
      signup(){
        this.loading = true;
          this.$store.dispatch('signup',this.credentials).then(()=>{
          if(this.registerStatus === 200){
            this.loading = false
          this.$store.dispatch('retrieveToken',this.credentials).then(()=>{
          if(this.loginStatus === 200){
            console.log('se logeó')
            this.$router.push({ path: '/' })
            this.$router.go()
         }
        
        })
          
         }
         this.loading = false
        })

      },

      cancel(){
        this.$router.back()
      }
  },
  components: {
   
  }
};


</script>