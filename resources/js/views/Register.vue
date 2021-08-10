<template>
    <div>
        <v-img  height="50vh" min-height="50vh" max-height="600"  position="center center" src="/img/register/slide_interiores.jpg">
        </v-img>
        <v-card flat class="mt-10">
            <v-row justify="center" class="pa-0  ma-0" >
                <v-col cols="12" class="text-center pa-0 ma-0" style="min-width: 300px" >
                    <div  class="d-inline-flex my-1">
                        <h1>BENEFICIOS</h1>
                    </div>
                    <div  class="d-inline-flex my-1" style="color: #47a5ad;">
                        <h1>EXCLUSIVOS</h1>
                    </div>
                    <div class="d-flex justify-center">
                        <hr align="center"  noshade="noshade" class="divider" style="height: 5px" size="3" width="20%" />
                    </div>
                </v-col>
            </v-row>
            <v-row class="pa-0 ma-0" >
                <v-col cols="12" md="7" sm="12" class="text-center pa-0" style="margin:auto;">
                    <p style="font-size: 1.4em">
                        En Rollux México queremos ser tu mejor proveedor de confianza y apoyarte en todos los proyectos de tus clientes
                        con productos de calidad y diseños de vanguardia.
                    </p>
                </v-col>
            </v-row>
        </v-card>
        <v-container class="pa-0" fluid style="max-width: 1200px; margin: auto">
        <v-row class="space-between pa-0 ma-0"  >

            <v-col class="pa-0" cols="12" md="4" sm="12" v-for="(b, index) in benefits" :key="index">
                <v-card flat max-height="330">
                    <div class="d-flex justify-center">
                        <v-avatar  size="75">
                            <v-img  :src="b.icon" >
                            </v-img>
                        </v-avatar>
                    </div>
                    <div class="justify-center mt-10 mb-5" >
                        <h3 class="text-center">{{b.title}}</h3>
                    </div>
                    <div class="justify-center">
                        <p class="text-center mx-15" style="font-size: 17.5px;">
                            {{b.text}}
                        </p>
                    </div>
                </v-card>
            </v-col>

        </v-row>
        </v-container>
        <v-row style="background-color: #EEEEEE" class="pa-0 ma-0">
            <v-col cols="12" align-self="center" class="text-center mt-10 pa-0" >
                    <div  class="d-inline-flex my-1">
                        <h1>OBTÉN LOS</h1>
                    </div>
                    <div  class="d-inline-flex my-1" style="color: #47a5ad;">
                        <h1>BENEFICIOS</h1>
                    </div>
                    <div class="d-flex justify-center">
                        <hr align="center"  noshade="noshade" class="divider" style="height: 5px" size="3" width="20%" />
                    </div>
                </v-col>
                <v-row class="pa-0 ma-0">
                    <v-col  cols="12" md="7" sm="12" class="text-center pa-0" style="margin:auto;">
                        <p style="font-size: 1.4em">
                           Completa la siguiente forma y recibirás un correo de bienvenida con todos
                           los detalles para que puedas aprovechar los beneficios y hacer tus primeas
                           compras de forma inmediata.
                        </p>
                    </v-col>
                </v-row>
            <v-container class="pa-0" fluid style="max-width: 950px; margin: auto">


                <v-form @submit.prevent="register" ref="form" id="formulary" class="mb-16" >
                    <div class="justify-center" >
                        <h1 class="text-center">DATOS BÁSICOS</h1>
                    </div>
                    <v-text-field
                    :error-messages="registerErrors.name"
                    color="#47a5ad"
                    background-color="white"
                    solo
                    v-model="client_information.name"
                    label="Tu Nombre (requerido)"

                    rounded>
                    </v-text-field>
                    <v-text-field
                    :error-messages="registerErrors.last_name"
                    v-model="client_information.last_name"
                    label="Tu Apellido (requerido)"
                    solo
                    rounded>
                    </v-text-field>
                    <v-text-field v-model="client_information.company" label="Nombre de tu empresa" solo rounded>
                    </v-text-field>
                    <v-text-field
                    :error-messages="registerErrors.email"
                    v-model="client_information.email"
                    label="Email (requerido)"
                    solo rounded>
                    </v-text-field>
                    <v-text-field
                    :error-messages="registerErrors.phone"
                    v-model="client_information.phone"
                    label="Teléfono (requerido)"
                    solo rounded>
                    </v-text-field>
                    <div class="justify-center" >
                        <h1 class="text-center">DIRECCIÓN</h1>
                    </div>
                    <v-text-field
                    :error-messages="registerErrors.address"
                    v-model="client_information.address"
                    label="Calle, Número y Colonia (requerido)"
                    solo rounded>
                    </v-text-field>
                    <v-text-field v-model="client_information.city" label="Ciudad" solo rounded>
                    </v-text-field>
                    <v-row class="ma-0 pa-0">
                        <v-col class="pl-0" cols="12" md="6" sm="12">
                            <v-text-field v-model="client_information.state" label="Estado" solo rounded>
                            </v-text-field>
                        </v-col>
                        <v-col class="pr-0" cols="12" md="6" sm="12">
                            <v-text-field
                            :error-messages="registerErrors.zip_code"
                            v-model="client_information.zip_code"
                            label="Código Postal (requerido)"
                            solo rounded>
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <div class="justify-center" >
                        <h1 class="text-center">COMENTARIOS</h1>
                    </div>
                    <v-textarea v-model="client_information.comments" label="Mensaje: Déjanos cualquier información adicional" solo rounded>
                    </v-textarea>
                    <div class="d-flex justify-center" >
                        <v-checkbox :rules="[v => !!v || 'Debes aceptar los términos para continuar']" v-model="checkbox" color="#47a5ad" label="Acepto los Términos de Privacidad y Condiciones de Uso">
                        </v-checkbox>
                    </div>
                    <!-- INICIA CAPTCHA -->
                    <div class="d-flex justify-center mb-5">
                        <vue-recaptcha ref="recaptcha"
                            v-if="checkbox"
                          @verify="onVerifyCaptcha" sitekey='6Lds0O0bAAAAADGJgJ5vvOIfKnsGrVmmYqzBJEBJ' :loadRecaptchaScript="true" >
                        </vue-recaptcha>
                    </div>
                    <!-- TERMINA CAPTCHA -->
                    <div class="d-flex justify-center" >
                        <v-btn type="submit" :loading="loading" :disabled="!captchaRobot" rounded class="white--text" x-large color="#47a5ad">
                            Enviar
                        </v-btn>

                    </div>
                    <div class="d-block ma-4">
                        <v-alert
                        dismissible
                        v-if="registerStatus == 200"
                        dense
                        text
                        type="success"
                        >
                         Su petición ha sido enviada, en unos momentos le llegará un email de confirmación de envío. Cuando aprobemos su petición le llegará una clave de acceso al sistema.
                        </v-alert>
                        <v-alert
                        dismissible
                        v-if="registerStatus == 422 || registerStatus == 502"
                        dense
                        text
                        type="error"
                        >
                         Ha ocurrido un error al intentar enviar su petición, verifique sus datos o intente más tarde.
                        </v-alert>
                    </div>
                </v-form>

            </v-container>
        </v-row>
        <!-- <DialogInvite/>
        <FakeNotification/> -->
    </div>
</template>

<script>
// import DialogInvite from '../components/DialogInvite';
// import FakeNotification from '../components/FakeNotification';
import { mapState} from 'vuex';
import VueRecaptcha from 'vue-recaptcha';
export default {
    data(){
        return{
            captchaRobot: false,
            success: false,
            error : false,
            checkbox: false,
            client_information: {
                name: null,
                last_name: null,
                company: null,
                email: null,
                phone: null,
                address: null,
                city: null,
                state: null,
                zip_code: null,
                comments: null,
            },
            loading: false,
            benefits:[
                {
                    title: 'COTIZADOR EN LÍNEA',
                    text: 'Cotiza inmediatamente la persiana o toldo que más se ajuste a tus necesidades',
                    icon:'/img/register/cotizador_icon.png'
                },
                {
                    title: 'DESCUENTOS ESPECIALES',
                    text: 'Obtén los mejores precios del mercado y atrae más clientes potenciales para tus proyectos',
                    icon:'/img/register/descuentos_icon.png'
                },
                {
                    title: 'ATENCIÓN PERSONALIZADA',
                    text: 'Comunicate con nosotros por correo electrónico o Whatsapp y con gusto te asesoraremos',
                    icon:'/img/register/atencion_cliente_icon.png'
                },
            ]
        }
    },

    methods:{
        register(){
            if (this.captchaRobot) {
                if(this.$refs.form.validate()){
                    this.loading = true
                    this.$store.dispatch('registerClient',this.client_information)
                    .then(()=>{
                        this.loading = false;
                        this.$refs.form.reset();
                        this.$refs.recaptcha.reset();
                        this.checkbox = false;
                        this.captchaRobot = false;
                    })
                }
            }
        },
        onVerifyCaptcha(response) {
            if (response) {
                this.captchaRobot = true
            }
        },
    },



    computed: {
        ...mapState({
        registerErrors: state => state.usersModule.registerErrors,
        registerStatus: state => state.usersModule.registerStatus,
        }),
    },

    components:{
        'vue-recaptcha': VueRecaptcha
        // FakeNotification,
        // DialogInvite,
    }

}
</script>

<style scoped>
.divider{
    border: none;
    height: 5px;
    background-color: #47a5ad;
}
.v-label{
    color: #c3c3c3 !important;
    font-size: 1.1em !important;
    font-weight: bolder !important;
}

</style>
