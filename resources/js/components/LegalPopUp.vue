<template>
    <v-snackbar left centered timeout="-1" height="150" max-width="230" color="#47a5ad" dark :value="Object.keys(isSettedLocalStorage).length > 0 ? false : snackbarValue">
        <div class="d-flex flex-no-wrap mx-2 align-center">
            <span>
                Utilizamos cookies propias y de terceros para mejorar la experiencia del usuario a través de su navegación. Si
                continúas navegando aceptas su uso. Leer más sobre el
                <router-link :to="{name: 'Legal'}" class="white--text">
                    <span>
                        Aviso de Privacidad.
                    </span>
                </router-link>
            </span>
            <v-btn
            class="d-block"
                rounded
                dark
                small
                @click="btnAceptLegal"
              >
                Acepto
            </v-btn>
        </div>
    </v-snackbar>
</template>

<script>
export default {
    data(){
        return{
            isSettedLocalStorage: JSON.parse(localStorage.getItem('legalPrivacy')) || {},
            snackbarValue: true
        }
    },
    methods:{
        btnAceptLegal(){
            if(!localStorage.getItem('legalPrivacy')){
                localStorage.setItem('legalPrivacy', JSON.stringify({accepted: 'yes'}))
                this.snackbarValue = false;
            }
        }
    }
}
</script>

<style >
.v-snack__content{
    padding: 0;
}
</style>
