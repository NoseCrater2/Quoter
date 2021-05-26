<template>
    <div id="app">  
      	<v-tabs right>
        	<v-tab>
          		<v-icon left>mdi-account</v-icon>CUENTA
        	</v-tab>
        	<v-tab>
        	  	<v-icon left>mdi-phone</v-icon>GENERAL
        	</v-tab>
        	<!-- <v-tab>
        	  	<v-icon left>mdi-cancel</v-icon>ROLES
        	</v-tab> -->

        	<v-tab-item>
            	<v-row justify="space-around">
              		<v-card min-width="350" max-width="600" flat>
                		
							<v-row justify="center" class="ma-4">
								<v-avatar :color="getColor" size="150">
                   			  		<span v-if="user.name" class="white--text headline">
                   			  		 	<div class="d-inline " >
                   			  		 	   {{user.name[0]}}
                   			  		 	</div>
										<div class="d-inline " >
                   			  		 	   {{user.last_name[0]}}
                   			  		 	</div>

                   			 		</span>
                  				</v-avatar>
							</v-row>
                   			<v-row justify="center">
								<v-card-title>
									Descuento: {{ user.discount_percent}}%
								</v-card-title>
							</v-row>
							<v-row no-gutters >
							  	<v-col cols="6" >
								  	<v-text-field class="text-center" prepend-inner-icon="mdi-account" placeholder="Nombre(s)" v-model="user.name" :error-messages="errors.name" outlined></v-text-field> 
                  				</v-col>
								<v-col class="6">
									<v-text-field placeholder="Apellido(s)" v-model="user.last_name" :error-messages="errors.name" outlined></v-text-field> 
								</v-col>
							</v-row>

							<v-row>
								<v-col cols="12" >
                     			<v-text-field prepend-inner-icon="mdi-email" placeholder="Email" v-model="user.email" :error-messages="errors.email" outlined></v-text-field>    
                    		</v-col>               
                     
                    		<v-col cols="12" v-if="ableToChangePassword" >
                    			<v-text-field  prepend-inner-icon="mdi-lock" placeholder="Nueva contraseña" v-model="user.password"  :error-messages="errors.password" outlined></v-text-field> 
                  			</v-col>
                  
                  			<v-col cols="12" v-if="ableToChangePassword" >
                     			<v-text-field prepend-inner-icon="mdi-lock-alert" placeholder="Confirmar nueva contraseña" v-model="user.confirmed_password" outlined></v-text-field>    
                    		</v-col>

                  			<v-col cols="12" v-else >
                  			   	<v-btn large color="black" class="white--text" block @click="confirmPassword()">Cambiar contraseña</v-btn> 
                  			</v-col>

                      		<v-col cols="12" >
                        		<v-btn @click="editar()" large color="#3ba2a9" class="white--text" block>Guardar</v-btn>
                        	</v-col>
							</v-row>

              		</v-card>
					
          		</v-row>
       		</v-tab-item>

        	<v-tab-item>
        		<v-row> 
        		    <v-col cols="12" md="6" sm="12" xs="2" >
        		    	<input type="file" ref="btnUploadImage" style="display:none" @change="selectImage($event)" accept="image/*"/>
        		       	<v-card  height="300"  class="d-flex justify-center mx-3"  @click="$refs.btnUploadImage.click()">
        		        	<v-icon size="100" v-if="!user.logo">mdi-image</v-icon>
        		        	<v-img v-else
        		        	class="align-center white--text"
        		        	:src="(urlTemporal === null) ? (`/img/${user.logo}`) : urlTemporal"
        		        	aspect-ratio="1.7" contain
        		        	></v-img>
						</v-card>
						<v-card-title class="justify-center text--secondary">
						  	Haz clic sobre el recuadro para subir o actualizar el logo de tu empresa
					  </v-card-title>
        		    </v-col>

        		    <v-col cols="12" md="6" sm="12" >
						<v-text-field  prepend-inner-icon="mdi-domain" v-model="user.company" placeholder="Compañia" :error-messages="errors.fiscal_address" dense :outlined="false" solo flat></v-text-field>
        		      	<v-divider  class="mt-n5 mb-3 mx-3" ></v-divider>
						<v-row no-gutters>
							<v-text-field prepend-inner-icon="mdi-map-marker" v-model="user.address" placeholder="Dirección Fiscal" :error-messages="errors.address" dense :outlined="false" solo flat></v-text-field>
							<v-text-field  v-model="user.city" placeholder="Ciudad" :error-messages="errors.city" dense :outlined="false" solo flat></v-text-field>
							<v-text-field  v-model="user.zip_code" placeholder="C.P" :error-messages="errors.zip_code" dense :outlined="false" solo flat></v-text-field>
							<v-text-field  v-model="user.state" placeholder="Estado" :error-messages="errors.state" dense :outlined="false" solo flat></v-text-field>
						</v-row>
						
        		        
        		      	<v-divider  class="mt-n5 mb-3 mx-3" ></v-divider>
        		        <v-text-field prepend-inner-icon="mdi-truck-delivery-outline" v-model="user.ship_address" placeholder="Direccón de envío" dense :error-messages="errors.shipping_address" :outlined="false" solo flat></v-text-field>
        		      	<v-divider  class="mt-n5 mb-3 mx-3" ></v-divider>
						<v-text-field prepend-inner-icon="mdi-truck-delivery" v-model="user.second_ship_address" placeholder="Direccón de envío" dense :error-messages="errors.shipping_address" :outlined="false" solo flat></v-text-field>
        		      	<v-divider  class="mt-n5 mb-3 mx-3" ></v-divider>
        		        <v-text-field prepend-inner-icon="mdi-whatsapp" v-model="user.phone" placeholder="WhatsApp" dense :error-messages="errors.movil_number" :outlined="false" solo flat></v-text-field>
        		       	<v-divider  class="mt-n5 mb-3 mx-3" ></v-divider>
        		        <v-col>
        		            <v-btn @click="editar()" color="#3ba2a9" class="white--text mt-5 mx-n20" block>Guardar</v-btn>
        		        </v-col>
        		    </v-col>      
        		</v-row>
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

      	<v-dialog v-model="dialog"  max-width="400px">
        	<v-card class="elevation-4">
          		<v-toolbar color="#3ba2a9" dark flat> Confirme su contraseña actual para continuar</v-toolbar>
                	<v-card-text>
                  		<v-text-field
                  		v-model="intent"
                  		:append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                  		:type="show ? 'text' : 'password'"
                  		class="mt-8"
                  		hint="6 caracteres mínimo"
                  		@click:append="show = !show"
                  		:error-messages="noAccess"
                  		></v-text-field>
                	</v-card-text>
                	<v-card-actions>
                	  	<v-spacer></v-spacer>
                	  	<v-btn :loading="loading"  dark color="#3ba2a9" @click="checkAccess()">Comprobar 
                	    	<v-icon right>mdi-lock-open-check</v-icon>
                	    </v-btn>
                	  	<v-spacer></v-spacer>
                	</v-card-actions>
            	</v-card>
     	</v-dialog>
	</div>
</template>

<script>
import {mapGetters,mapState } from 'vuex';
export default {
  	data() {
    	return {
      		intent: null,
      		noAccess: null,
      		urlTemporal: null,
      		currentLogo: null,
      		ableToChangePassword: false,
      		loading: false,
     		image: null,
      		colors: [
        		'red',
        		'pink',
        		'purple',
        		'deep-purple',
        		'indigo',
        		'blue',
        		'light-blue',
        		'cyan',
        		'teal',
        		'green',
        		'light-green',
        		'lime',
        		'yellow',
        		'amber',
        		'orange',
        		'deep-orange',
        		'brown',
        		'blue-grey',
        		'grey'
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
    	 	this.$store.dispatch('editUser',this.user).then(()=>{
    	      	if(this.status=== 200){
    	          
    	      	}
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
    
  },
};
</script>

<style>
.v-text-field--outlined .v-input__slot {
  border-color: #fff;
}



</style>