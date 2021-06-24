<template>
    <div class="d-flex justify-center" style="background-color: black; position: sticky; top: 0; z-index: 2;">
        <v-row no-gutters justify="space-between" style="max-width: 1180px;" class="white--text">
                <h1 
                v-if="user != null"
                style="font-size: 14px;margin-top: 4px;font-weight: normal">
                    Hola {{ user.name }},&nbsp; 
                </h1>
                <h1 class="text-center" style="font-size: 14px;margin-top: 4px;font-weight: normal">
                    Bienvenido(a) a Rollux México
                </h1>
                <v-spacer></v-spacer>
                <v-btn class="white--text" small text>
                    <v-img class="mr-1" src="https://cdn.iconscout.com/icon/free/png-256/mexico-flag-country-nation-union-empire-33133.png" width="20px"></v-img>
                    Español MX
                </v-btn>
                <v-divider vertical dark></v-divider>
                <v-btn class="white--text" small text>
                   Moneda: MXN
                </v-btn>
                <v-divider vertical dark></v-divider>
                <v-menu offset-y>
                  <template v-slot:activator="{attrs, on}">
                    <v-btn
                    small
                    v-bind="attrs" 
                    v-on="on" 
                    class="white--text" 
                    text >
                    Mi cuenta
                    <v-icon right>mdi-menu-down</v-icon>
                    </v-btn>
                  </template>
                   <v-list dense flat style="elevation: 0">
                        <div v-if="$store.state.isLoggedIn === false || $store.state.isLoggedIn === 'false'">
                            <v-list-item :to="{name: 'login'}">
                                <v-list-item-title >Iniciar Sesión</v-list-item-title>
                            </v-list-item>
                        </div>
                        <div v-else>
                            <v-list-item  :to="{name: 'Orders'}">
                              <v-list-item-title >Ordenes</v-list-item-title>
                            </v-list-item>
                            <v-list-item :to="{name: 'Quotations'}">
                              <v-list-item-title >Cotizaciones</v-list-item-title>
                            </v-list-item>
                            <v-list-item :to="{name: 'Profile'}">
                              <v-list-item-title >Mi perfil</v-list-item-title>
                            </v-list-item>
                        </div>
                    </v-list>
                </v-menu>
        </v-row>
    </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
    data(){
        return{

        }
    },

    computed:{
        ...mapState({
            user: state => state.user,
        }),
    }
}
</script>