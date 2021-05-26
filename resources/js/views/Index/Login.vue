<template>

    <v-app style="background-color:#3ba2a9 " >
      <v-dialog v-model="dialog" persistent max-width="500px">
        <v-card class="elevation-4">
          <v-toolbar color="#3ba2a9" dark flat>
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

              <p class="text-center">
                ¿Quieres cotizar y no eres distribuidor?
                <router-link :to="{name:'Register', hash: '#formulary'}"> Reguistrate aquí</router-link>
              </p>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-btn color="red" dark @click="cancel()">
              <v-icon left>mdi-arrow-left-bold</v-icon>
              Cancelar
            </v-btn>

            <v-spacer></v-spacer>

            <v-btn :loading="loading" @click="login()" dark color="#3ba2a9">
              Entrar
              <v-icon right>mdi-login</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-app>
 
</template>

<script>
import {logIn, logOut} from "../../utils/auth"
export default {
  data() {
    return {
      getLoginErrors: {
        email: null,
        password: null,
      },
      dialog: true,
      loading: false,
      credentials: {
        email: null,
        password: null,
      },
    };
  },
  props: {},

  // computed: {
  //   ...mapGetters(["getLoginErrors", "getLoginStatus", "loggedIn"]),
  // },
  methods: {

    async login(){
      this.loading = true
      try {
        await axios.get('/sanctum/csrf-cookie');
        await axios.post("/login",{
            email: this.credentials.email,
            password: this.credentials.password
        })

        logIn()

        this.$store.dispatch("loadUser").then(()=>{
          const redirectPath = this.$route.query.redirect || '/dashboard';

          this.$router.push(redirectPath)
        })
        
      } catch (error) {
        this.getLoginErrors = error.response && error.response.data.errors
      }
      this.loading = false
    },
    // login() {
    //   this.loading = true;
    //   this.$store.dispatch("retrieveToken", this.credentials).then(() => {
    //     if (this.getLoginStatus === 200) {
    //       this.$router.push({ name: "Dashboard" });
    //       //

    //       this.loading = false;
    //     }
    //     this.loading = false;
    //   });
    // },

    cancel() {
      this.$router.back()
    },
  },
  components: {},
};
</script>