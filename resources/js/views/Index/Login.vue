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
            <v-form @submit.prevent="login()">
              <v-text-field
                class="mt-7"
                outlined
                color="#3ba2a9"
                label="Email"
                name="Email"
                :error-messages="getLoginErrors.email"
                v-model="credentials.email"
                prepend-icon="mdi-account"
                type="text"
              ></v-text-field>

              <v-text-field
                outlined
                color="#3ba2a9"
                id="password"
                v-model="credentials.password"
                :error-messages="getLoginErrors.password"
                label="Contraseña"
                name="password"
                prepend-icon="mdi-lock"
                :type="showPassword ? 'text' : 'password'"
                append-icon="mdi-eye"
                @click:append="showPassword = !showPassword"

              ></v-text-field>

              <p class="text-center">
                ¿Quieres cotizar y no eres distribuidor?
                <router-link :to="{name:'Register', hash: '#formulary'}"> Regístrate aquí</router-link>
              </p>
            <v-card-actions>
            <v-btn color="red" dark @click="cancel()">
              <v-icon left>mdi-arrow-left-bold</v-icon>
              Cancelar
            </v-btn>

            <v-spacer></v-spacer>

            <v-btn :loading="loading" :disabled="disableBtnEntrar" class="white--text" color="#3ba2a9" type="submit">
              Entrar
              <v-icon right>mdi-login</v-icon>
            </v-btn>
          </v-card-actions>
            </v-form>
          </v-card-text>
        </v-card>
      </v-dialog>
    </v-app>

</template>

<script>
import {logIn, logOut} from "../../utils/auth"
export default {
  data() {
    return {
        showPassword: false,
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

  computed: {
      disableBtnEntrar(){
          if(((this.credentials.email == null || this.credentials.email == '') || (this.credentials.password == null || this.credentials.password == '')) || this.loading == true){
              return true;
          }
          else{
              return false;
          }
      }
    // ...mapGetters(["getLoginErrors", "getLoginStatus", "loggedIn"]),
  },
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
