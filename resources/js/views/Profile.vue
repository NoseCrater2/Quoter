<template>
    <div id="app">
      	<v-tabs centered icons-and-text grow background-color="white" color="#3ba2a9">
            <v-tabs-slider color="#3ba2a9"></v-tabs-slider>
        	<v-tab>
                CUENTA
          		<v-icon left>mdi-account</v-icon>
        	</v-tab>
        	<v-tab>
                GENERAL
        	  	<v-icon left>mdi-notebook</v-icon>
        	</v-tab>
        	<!-- <v-tab>
        	  	<v-icon left>mdi-cancel</v-icon>ROLES
        	</v-tab> -->

        	<v-tab-item :style="$vuetify.breakpoint.xl ? 'margin-top: 8%; margin-bottom: 8%' : $vuetify.breakpoint.lg ? 'margin-top: 3%; margin-bottom: 3%' : 'margin-top: 3%; margin-bottom: 3%'">
                <v-container fluid>
            	    <v-row align="center" justify="center">
              	    	<v-card flat>
				    		<v-row justify="center" align="center" class="my-4">
				    			<div :style="`background-color: ${getColor};`" style="border-radius: 50%; height: 150px; width: 150px; text-align: center; line-height: 150px;">
                       		  		<div v-if="user.name" class="white--text headline d-block mt-11">
                       		  		 	<h3>
                       		  		 	   {{user.name[0]}}{{user.last_name[0]}}
                       		  		 	</h3>
                       		 		</div>
                                    <h5 class="white--text d-block mt-n16">Descuento: {{ user.discount_percent}}%</h5>
                      			</div>
				    		</v-row>
				    		<v-row no-gutters class="mt-9">
				    		  	<v-col cols="12" xl="6" lg="6" md="6" sm="12">
				    			  	<v-text-field class="text-center" dense prepend-inner-icon="mdi-account" placeholder="Nombre(s)" v-model="user.name" :error-messages="errors.name" outlined></v-text-field>
                      			</v-col>
				    			<v-col cols="12" xl="6" lg="6" md="6" sm="12">
				    				<v-text-field placeholder="Apellido(s)" dense :prepend-inner-icon="!$vuetify.breakpoint.mdAndUp ? 'mdi-account' : ''" v-model="user.last_name" :error-messages="errors.name" outlined></v-text-field>
				    			</v-col>
				    		</v-row>
				    		<v-row class="mt-n3">
				    		    <v-col cols="12">
                         	    	<v-text-field prepend-inner-icon="mdi-email" dense placeholder="Email" v-model="user.email" :error-messages="errors.email" outlined></v-text-field>
                        	    </v-col>

                        	    <v-col cols="12" xl="6" lg="6" md="6" sm="12" :class="!$vuetify.breakpoint.mdAndUp ? 'mt-n2' : ''" v-if="ableToChangePassword">
                        	    	<v-text-field type="password" dense prepend-inner-icon="mdi-lock" placeholder="Nueva contraseña" v-model="user.password"  :error-messages="errors.password" outlined></v-text-field>
                      		    </v-col>

                      		    <v-col cols="12" xl="6" lg="6" md="6" sm="12" :class="!$vuetify.breakpoint.mdAndUp ? 'mt-n6' : ''" v-if="ableToChangePassword">
                         	    	<v-text-field type="password" dense prepend-inner-icon="mdi-lock-alert" placeholder="Confirmar nueva contraseña" v-model="user.password_confirmation" outlined></v-text-field>
                        	    </v-col>

                      		    <v-col cols="12" xl="6" lg="6" md="6" sm="12" v-else>
                      		       	<v-btn large color="black" class="white--text" block @click="confirmPassword()">Cambiar contraseña</v-btn>
                      		    </v-col>

                          	    <v-col cols="12" xl="6" lg="6" md="6" sm="12">
                                	<v-btn @click="editar()" :loading="isEditingButton" :disabled="(isEditingButton || computedBlockButtonWhenSetPass == true)" large color="#3ba2a9" class="white--text" block>Guardar</v-btn>
                                </v-col>
				    		</v-row>
              	    	</v-card>
          		    </v-row>
                </v-container>
       		</v-tab-item>

        	<v-tab-item>
                <v-container fluid>
        		    <v-row justify="center">
        		        <v-col cols="12" xl="6" lg="6" md="6" sm="12">
                                <v-alert
                                    dense
                                    outlined
                                    color="#3ba2a9"
                                    class="mt-auto"
                                  >
                                    Haz clic sobre el recuadro para subir o actualizar el logo de tu empresa
                                </v-alert>
        		        	<input type="file" ref="btnUploadImage" style="display:none" @change="selectImage($event)" accept="image/*"/>
        		           	<v-card height="350" class="d-flex justify-center mb-auto"  @click="$refs.btnUploadImage.click()">
        		            	<v-icon size="100" v-if="!user.logo">mdi-image</v-icon>
        		            	<v-img v-else
        		            	class="align-center white--text"
        		            	:src="(urlTemporal === null) ? (`/img/${user.logo}`) : urlTemporal"
        		            	aspect-ratio="1.7" contain
        		            	></v-img>
				    		</v-card>
        		        </v-col>

        		        <v-col cols="12" xl="6" lg="6" md="6" sm="12">
				    		<v-text-field outlined prepend-inner-icon="mdi-domain" v-model="user.company" placeholder="Compañia" :error-messages="errors.fiscal_address" dense></v-text-field>
				    		<v-row no-gutters>
				    			<v-text-field outlined prepend-inner-icon="mdi-map-marker" v-model="user.address" placeholder="Dirección Fiscal" :error-messages="errors.address" dense></v-text-field>
				    			<v-text-field outlined prepend-inner-icon="mdi-city" v-model="user.city" placeholder="Ciudad" :error-messages="errors.city" dense></v-text-field>
				    			<v-text-field outlined prepend-inner-icon="mdi-mailbox" v-model="user.zip_code" placeholder="C.P" :error-messages="errors.zip_code" dense></v-text-field>
				    			<v-text-field outlined prepend-inner-icon="mdi-map" v-model="user.state" placeholder="Estado" :error-messages="errors.state" dense></v-text-field>
				    		</v-row>

                            <v-text-field outlined prepend-inner-icon="mdi-account" v-model="user.rfc" placeholder="RFC" :error-messages="errors.rfc" dense></v-text-field>
        		            <v-text-field outlined prepend-inner-icon="mdi-truck-delivery-outline" v-model="user.ship_address" placeholder="Direccón de envío" dense :error-messages="errors.shipping_address"></v-text-field>
				    		<v-text-field outlined prepend-inner-icon="mdi-truck-delivery" v-model="user.second_ship_address" placeholder="Direccón de envío" dense :error-messages="errors.shipping_address"></v-text-field>
        		            <v-text-field outlined prepend-inner-icon="mdi-whatsapp" v-model="user.phone" placeholder="WhatsApp" dense :error-messages="errors.movil_number"></v-text-field>
                            <v-btn @click="editar()" :loading="isEditingButton" :disabled="(isEditingButton || computedBlockButtonWhenSetPass == true)" color="#3ba2a9" class="white--text" block>Guardar</v-btn>
        		        </v-col>
        		    </v-row>
                </v-container>
    		</v-tab-item>
        	<!-- <v-tab-item>
        	  	<v-card flat>
        	  	  	<v-list shaped>
        	  	  	  	<v-list-item-group>

        	  	  	  	</v-list-item-group>
        	  	  	</v-list>
        	  	</v-card>
        	</v-tab-item> -->
    	</v-tabs>

      	<v-dialog v-model="dialog" persistent max-width="400px">
        	<v-card class="elevation-4">
          		<v-toolbar color="#3ba2a9" dark flat>SE REQUIERE LA CONTRASEÑA ACTUAL PARA CONTINUAR</v-toolbar>
                	<v-card-text>
                  		<v-text-field
                          outlined
                          dense
                  		v-model="intent"
                  		:append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                  		:type="show ? 'text' : 'password'"
                  		class="mt-8"
                  		hint="6 caracteres mínimo"
                  		@click:append="show = !show"
                  		:error-messages="noAccess"
                  		></v-text-field>
                	</v-card-text>
                	<v-card-actions class="mt-n4">
                        <v-btn dark color="red" @click="dialog = !dialog">Cerrar
                	    	<v-icon right>mdi-close</v-icon>
                	    </v-btn>
                        <v-spacer></v-spacer>
                	  	<v-btn :loading="loading" dark color="#3ba2a9" @click="checkAccess()">Comprobar
                	    	<v-icon right>mdi-lock-open-check</v-icon>
                	    </v-btn>
                	</v-card-actions>
            	</v-card>
     	</v-dialog>
         <v-fab-transition>
            <v-snackbar
                :timeout="localSnackbar.time"
                :value="localSnackbar.isActive"
                :color="localSnackbar.color"
                absolute
                right
                bottom
                rounded="pill"
              >
                {{localSnackbar.message}}
            </v-snackbar>
         </v-fab-transition>
	</div>
</template>

<script>
import {mapGetters,mapState } from 'vuex';
export default {
  	data() {
    	return {
            isEditingButton: false,
            localSnackbar: {
                message: '',
                time: 0,
                isActive: false,
                color: ''
            },
      		intent: null,
      		noAccess: null,
      		urlTemporal: null,
      		currentLogo: null,
      		ableToChangePassword: false,
      		loading: false,
     		image: null,
      		colors: [
        		'#F44336',
        		'#E91E63',
        		'#9C27B0',
        		'#673AB7',
        		'#3F51B5',
        		'#2196F3',
        		'#03A9F4',
        		'#00BCD4',
        		'#009688',
        		'#4CAF50',
        		'#8BC34A',
        		'#CDDC39',
        		'#FFEB3B',
        		'#FFC107',
        		'#FF9800',
        		'#FF5722',
        		'#795548',
        		'#607D8B',
        		'#9E9E9E'
				],

      		flat: true,
      		outlined: false,
      		dialog: false,
      		editable: true,
      		show: false,
		};
  	},

  	components: {

  	},

  	methods: {
          resetLocalSnackbar(){
                this.localSnackbar.message = ''
                this.localSnackbar.time = 0
                this.localSnackbar.isActive = false
                this.localSnackbar.color = ''
          },
    	confirmPassword(){
      		this.dialog = true;
    	},

   		checkAccess(){
    	  	this.$store.dispatch('checkPasword',this.intent).then(()=>{
    	      	if(this.checkStatus === 200){
    	         	this.ableToChangePassword  = true
    	        	this.dialog = false
    	     	}else{
    	     	  this.noAccess = "Las contraseñas no coinciden"
    	     	}
    	    })
   		},

   		selectImage(event){
    	 	this.currentLogo = event.target.files[0]
    	 	this.user.logo = this.currentLogo

    	 	const reader = new FileReader();

    	 	reader.readAsDataURL(this.currentLogo)
    	 		reader.onload = (e) => {
    	    		this.urlTemporal = e.target.result;

				};
    		this.currentLogo = null
   		},

   		editar(){
            this.isEditingButton = true;
            this.resetLocalSnackbar();
    	 	this.$store.dispatch('editUser',this.user).then(()=>{
                 this.isEditingButton = false;
				 console.log('intento de edición')
    	      	if(this.status=== 200){
                      this.ableToChangePassword = false;
                      this.user.password = '';
                      this.user.password_confirmation = '';
                    this.localSnackbar.message = 'Datos guardados correctamente'
                    this.localSnackbar.time = 3000
                    this.localSnackbar.isActive = true
                    this.localSnackbar.color = 'success'
    	      	}
    	  	}).catch(()=>{
                  this.isEditingButton = false;
                this.localSnackbar.message = 'Ha ocurrido un error al guardar'
                this.localSnackbar.time = 3000
                this.localSnackbar.isActive = true
                this.localSnackbar.color = 'red'
              })
   		}
  	},

  	created(){
 		this.r = Math.floor(Math.random() * (this.colors.length - 0)) + 0;
  	},

 	computed:{
    	...mapState({
    	   	errors: state => state.usersModule.usersErrors,
    	   	status: state => state.usersModule.usersStatus,
    	  	user: state => state.user,
    	  	checkStatus: state => state.loginModule.checkStatus,
    	}),

      ...mapGetters([
      'loggedIn',
      'getLoginErrors',
      'getLoginStatus',
      'getUserStatus'
     ]),

    getColor:{
        get( ){
          return this.colors[this.r]
        }
    },
    computedBlockButtonWhenSetPass(){
        return ((this.user.password !== this.user.password_confirmation) && this.ableToChangePassword) || (((this.user.password == null || this.user.password_confirmation == null) || this.user.password == '' || this.user.password_confirmation == '') && this.ableToChangePassword) ? true : false;
    }

  },
};
</script>

<style>
.v-text-field--outlined .v-input__slot {
  border-color: #fff;
}



</style>
