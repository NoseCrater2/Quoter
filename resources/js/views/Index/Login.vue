<template>
   <div id="app">
  <v-app id="inspire">
    <v-app id="inspire">
      <v-main>
        <v-container
          class="fill-height"
          fluid
        >
          <v-row
            align="center"
            justify="center"
          >
            <v-col
              cols="12"
              sm="8"
              md="4"
            >
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
                  </v-form>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                  :loading="loading" 
                  @click="login()"
                  dark 
                  block
                  color="#3ba2a9">
                      Entrar 
                    <v-icon right>mdi-login</v-icon>
                    </v-btn>
                  <v-spacer></v-spacer>
                </v-card-actions>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </v-main>
    </v-app>
  </v-app>
</div>
</template>

<script>
import { mapActions, mapState, mapGetters } from 'vuex';
export default {
  data() {
    return {
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
     ]),
  },
  methods:{
      login(){
        this.loading = true;
          this.$store.dispatch('retrieveToken',this.credentials).then(()=>{
          if(this.getLoginStatus === 200){
            this.loading = false
            console.log('Estás logeado!')
         }
         this.loading = false
        })

      }
  },
  components: {
   
  }
};


</script>