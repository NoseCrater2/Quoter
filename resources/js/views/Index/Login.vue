<template>

    <v-app style="background-color:#3ba2a9 " >
      <v-dialog v-model="dialog" persistent max-width="500px">
        <v-card class="elevation-4" v-if="!showResetPasswordForm">
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
                <router-link :to="{name:'Register', hash: '#formulary'}">Regístrate aquí</router-link>
              </p>
              <p class="text-center">
                ¿Olvídaste tu contraseña?
                <a @click="showResetPasswordForm = true"  >Recupérala aquí</a>
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


        <v-card v-else>
          <v-toolbar color="#3ba2a9" dark flat>
            <v-spacer></v-spacer>
            <p class="font-weight-bold text-center mt-4">Ingresa tu correo electrónico donde se te enviará una nueva contraseña</p>
            <v-spacer></v-spacer>
          </v-toolbar>
          <v-card-text>
            <v-form>
              <v-text-field
                class="mt-7"
                outlined
                color="#3ba2a9"
                label="Email"
                name="Email"
                v-model="resetEmail"
                :error-messages="errorResetPassword"
                prepend-icon="mdi-account"
                type="text"
              ></v-text-field>
            <v-card-actions>
            <v-btn color="red" dark @click="cancelReset()">
              <v-icon left>mdi-arrow-left-bold</v-icon>
              Cancelar
            </v-btn>

            <v-spacer></v-spacer>

            <v-btn :loading="loadingReset"
            class="white--text"
            color="#3ba2a9"
            @click="resetPassword()">
              ENVIAR
              <v-icon right>mdi-login</v-icon>
            </v-btn>
          </v-card-actions>
            </v-form>
          </v-card-text>
        </v-card>
          <v-snackbar
           v-model="emailSendeded"
            :timeout="2000"
          >
      <span class="ml-4">Nueva contraseña ha sido enviada a su correo</span>
       <template v-slot:action>
        <v-icon>mdi-check</v-icon>
        </template>
      </v-snackbar>
      </v-dialog>
    </v-app>

</template>

<script>
import {logIn, logOut} from "../../utils/auth"
import { mapState } from 'vuex';
export default {
  data() {
    return {
      loadingReset: false,
      emailSendeded: false,
      errorResetPassword: null,
      resetEmail: null,
      showResetPasswordForm: false,
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
      ...mapState({
        orders: (state) => state.ordersModule.orders,
        user: (state) => state.user,
      }),
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

          if(this.$route.query.is_quotation == 0 || this.$route.query.is_quotation == 1){
              this.$router.push({path: redirectPath, query: {is_quotation: this.$route.query.is_quotation}});
          }
          else{
              this.$router.push(redirectPath)
          }
        })

      } catch (error) {
        this.getLoginErrors = error.response && error.response.data.errors
      }
      this.loading = false
    },

    cancel() {
      this.$router.back()
    },
    cancelReset(){
      this.showResetPasswordForm = false
      this.resetEmail = null
    },

    resetPassword(){
      this.loadingReset = true
      axios.get("/api/reset-password/"+this.resetEmail).then((response) => {
        if(response.status === 200){
          this.loadingReset = false
          this.showResetPasswordForm = false
          this.emailSendeded = true

        }
      }).catch((error)=>{
        this.errorResetPassword = 'El email proporcionado no es válido o no existe en el sistema'
      })
    }
  },
  components: {},
};
</script>
