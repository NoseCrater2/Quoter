<template>
    <div id="app">
        <div class="text-center">
            <h2 class="mt-2 mb-5">USUARIOS</h2>
             	<v-card>
                	<v-data-table
					:item-class="rowClass"
                	:headers="computedTableHeaders"
                	:items="filtered"
                	:search="search"
                	:loading="loadingTable"
                	color="#3ba2a9"
					:items-per-page="10"
                	>
                		<template v-slot:top>
                            <v-row no-gutters justify="space-between" align="center">
                                <v-col cols="12" xl="11" lg="11" md="10" sm="10">
                                    <v-text-field
                                    class="ma-2"
                		            v-model="search"
                                    outlined
                                    dense
                		            prepend-inner-icon="mdi-magnify"
                		            label="BUSCAR USUARIO"
                		            single-line
                		            hide-details
                		            ></v-text-field>
                                </v-col>
                                <v-col cols="12" xl="1" lg="1" md="2" sm="2" class="d-flex justify-end">
        					        	<v-dialog v-model="usersDialog" max-width="500px" persistent>
        					        	  	<template v-slot:activator="{ on, attrs }">
        					        	  	  	<v-btn
                                                :block="!$vuetify.breakpoint.smAndUp"
                                                :class="!$vuetify.breakpoint.smAndUp ? 'mx-2' : 'mr-3'"
        					        	  	  	color="black"
                                                elevation="0"
        					        	  	  	dark
                                                small
        					        	  	  	v-bind="attrs"
        					        	  	  	v-on="on"
        					        	  	  	>NUEVO</v-btn>
        					        	  	</template>
        					        		<v-card tile>
        					        	    	<v-card-title>
        					        	    	  	<span class="headline">{{ formTitle }}</span>
        					        	    	</v-card-title>
        					        	    	<v-card-text>
        					        	      		<v-container>
        					        	        		<v-row>
        					        	          			<v-col class="pb-0" cols="12" md="6" sm="12">
        					        	          			  	<v-text-field
																dense
																hide-details
																outlined
																v-model="editedItem.name"
																label="Nombre"
																prepend-inner-icon="mdi-account"
																:error-messages="errors.name">
																</v-text-field>
        					        	          			</v-col>
        					        	          			<v-col class="pb-0" cols="12" md="6" sm="12">
        					        	          			  	<v-text-field
																:error-messages="errors.last_name"
							        							hide-details
        					        	          			  	dense
        					        	          			  	outlined
        					        	          			  	v-model="editedItem.last_name"
                                                                prepend-inner-icon="mdi-account"
        					        	          			  	label="Apellido(s)"
        					        	          			  	></v-text-field>
        					        	          			</v-col>
        					        	        		</v-row>
        					        	        		<v-row>
        					        	        		   <v-col class="pb-0" cols="12" md="6" sm="12">
        					        	        		    	<v-text-field
							        							hide-details
        					        	        		    	dense
																:error-messages="errors.phone"
        					        	        		    	outlined
        					        	        		    	v-model="editedItem.phone"
                                                                prepend-inner-icon="mdi-phone"
        					        	        		    	label="Teléfono"
        					        	        		    	></v-text-field>
        					        	        		  	</v-col>
        					        	        		  	<v-col class="pb-0" cols="12" md="6" sm="12">
        					        	        		    	<v-text-field dense hide-details outlined v-model="editedItem.email" label="Email" :error-messages="errors.email" prepend-inner-icon="mdi-email"></v-text-field>
        					        	        		  	</v-col>
        					        	        		</v-row>
        					        	        		<v-row>
        					        	        		  	<v-col class="pb-0" cols="12" md="6" sm="12">
        					        	        		    	<v-text-field
																:error-messages="errors.address"
							        							hide-details
        					        	        		    	dense
        					        	        		    	outlined
        					        	        		    	v-model="editedItem.address"
        					        	        		    	label="Dirección"
                                                                prepend-inner-icon="mdi-map-marker"
        					        	        		    	></v-text-field>
        					        	        		  		</v-col>
        					        	        		  	<v-col class="pb-0" cols="12" md="6" sm="12">
        					        	        		  	  	<v-text-field
							        							hide-details
        					        	        		  	  	dense
        					        	        		  	  	outlined
        					        	        		  	  	v-model="editedItem.city"
        					        	        		  	  	label="Ciudad"
                                                                prepend-inner-icon="mdi-city"
																:error-messages="errors.city"
        					        	        		  	  	></v-text-field>
        					        	        		  	</v-col>
        					        	        		</v-row>
        					        	        		<v-row>
        					        	          			<v-col class="pb-0" cols="12" md="6" sm="12">
        					        	          			  	<v-text-field
							        							hide-details
        					        	          			  	dense
        					        	          			  	outlined
        					        	          			  	v-model="editedItem.state"
        					        	          			  	label="Estado"
                                                                prepend-inner-icon="mdi-map"
																:error-messages="errors.state"
        					        	          			  	></v-text-field>
        					        	          			</v-col>
        					        	          			<v-col class="pb-0" cols="12" md="6" sm="12">
        					        	          			  	<v-text-field
							        							hide-details
        					        	          			  	dense
        					        	          			  	outlined
        					        	          			  	v-model="editedItem.zip_code"
        					        	          			  	label="Código Postal"
                                                                prepend-inner-icon="mdi-mailbox"
																:error-messages="errors.zip_code"
        					        	          			  	></v-text-field>
        					        	          			</v-col>
        					        	        		</v-row>
        					        	        		<v-row>
        					        	           			<v-col class="pb-0" cols="12" md="6" sm="12">
        					        	            			<v-text-field
							        							hide-details
        					        	            			dense
        					        	            			outlined
        					        	            			v-model="editedItem.company"
        					        	            			label="Compañía"
                                                                prepend-inner-icon="mdi-domain"
																:error-messages="errors.company"
        					        	            			></v-text-field>
        					        	          			</v-col>
        					        	          			<v-col class="pb-0" cols="12" md="6" sm="12">
        					        	          			  	<v-text-field
							        							hide-details
        					        	          			  	prefix="%"
        					        	          			  	v-model="editedItem.discount_percent"
        					        	          			  	dense
        					        	          			  	type="number"
        					        	          			  	outlined
        					        	          			  	label="Descuento"
																:error-messages="errors.discount_percent"
        					        	          			  	></v-text-field>
        					        	          			</v-col>
        					        	        		</v-row>
							        					<v-row>
                                                            <v-col class="pb-0" cols="12">
        					        	            			<v-text-field
							        							hide-details
        					        	            			dense
        					        	            			outlined
        					        	            			v-model="editedItem.rfc"
        					        	            			label="RFC"
                                                                prepend-inner-icon="mdi-account"
																:error-messages="errors.rfc"
        					        	            			></v-text-field>
        					        	          			</v-col>
        					        	           			<v-col class="pb-0" cols="12">
        					        	            			<v-text-field
							        							hide-details
        					        	            			dense
        					        	            			outlined
        					        	            			v-model="editedItem.ship_address"
        					        	            			label="Dirección de envío"
                                                                prepend-inner-icon="mdi-truck-delivery-outline"
																:error-messages="errors.ship_address"
        					        	            			></v-text-field>
        					        	          			</v-col>
        					        	          			<v-col class="pb-0" cols="12">
        					        	          			  	<v-text-field
							        							hide-details
        					        	          			  	v-model="editedItem.second_ship_address"
        					        	          			  	dense
        					        	          			  	outlined
																:error-messages="errors.second_ship_address"
        					        	          			  	label="Dirección de envío alterna"
                                                                prepend-inner-icon="mdi-truck-delivery"
        					        	          			  	></v-text-field>
        					        	          			</v-col>
        					        	        		</v-row>
							        					<v-row v-if="user.role == 'Superadministrador'">
							        						<v-col cols="12" >
							        							<v-select
																:error-messages="errors.role"
							        							v-model="editedItem.role"
        					        	          			  	:items="roles"
							        							item-value="name"
							        							item-text="name"
        					        	          			  	dense
        					        	          			  	outlined
        					        	          			  	label="Tipo de usuario"
                                                                prepend-inner-icon="mdi-arrow-vertical-lock"
        					        	          			  	></v-select>
							        						</v-col>
							        					</v-row>
							        					<v-row class="my-2" align="center">
							        						<v-col cols="12">
                                                                <v-alert
                                                                    dense
                                                                    class="mb-2"
                                                                    outlined
                                                                    color="#3ba2a9"
                                                                  >
                                                                    Haz clic sobre el recuadro para subir el logo
                                                                </v-alert>
							        							<input type="file" ref="btnUploadImage" style="display:none" @change="selectImage($event)" accept="image/*"/>
							        							<v-card width="100%" class="d-flex justify-center align-center" height="100"  @click="$refs.btnUploadImage.click()">
							        								<v-img v-if="urlTemporal != null"  width="100%" height="100%" :src="urlTemporal">
							        								</v-img>
							        								<v-img v-else-if="editedItem.logo != null && editedItem.logo != Object"  width="100%" height="100%" :src="`/img/${editedItem.logo}`">
							        								</v-img>
							        								<div v-else >
							        									<v-icon size="50">mdi-image</v-icon>
							        								</div>
							        							</v-card>
							        						</v-col>
							        					</v-row>
        					        	      		</v-container>
        					        	    	</v-card-text>
        					        	    	<v-card-actions class="mt-n6">
        					        	    	  	<v-spacer></v-spacer>
        					        	    	  	<v-btn color="blue darken-1" text @click="close">Cancelar</v-btn>
        					        	    	  	<v-btn color="blue darken-1" text @click="save">Guardar</v-btn>
        					        	    	</v-card-actions>
        					        		</v-card>
        					        	</v-dialog>
                                </v-col>
                            </v-row>
                            <v-row class="my-n2" :class="$vuetify.breakpoint.smAndUp ? 'mr-3' : ''" justify="center" justify-xl="end" justify-lg="end" justify-md="end" justify-sm="end">
							    <v-switch
                                    inset
							        color="#47a5ad"
      						        v-model="swToInactive"
      						        label="Mostrar solo usuarios inactivos"
      						    ></v-switch>
							    <!-- <v-select
							    v-model="selectedRoles"
							    outlined
							    dense
							    multiple
							    :items="roles"
							    label="filtrar"
							    item-value="nombre"
							    item-text="name">
							    </v-select> -->
                            </v-row>
      					</template>
                        <template v-slot:item.name="{ item }">
                		  {{item.name+' '+item.last_name}}
                		</template>
                		<template v-if="user.role == 'Superadministrador' || user.role == 'Administrador'" v-slot:item.actions="{ item }">
                		  	<v-icon small class="mr-2" @click="editItem(item)">
                		    	mdi-pencil
                		  	</v-icon>
                		  	<v-icon class="mr-2" :disabled="user.id == item.id ? true : false" small @click="deleteItem(item)">
                		  	  	mdi-delete
                		  	</v-icon>
							<v-switch
							:hint="item.active?'Desactivar':'Activar'"
							flat
							@click="openActitveUserDialog(item)"
							v-model="item.active"
							dense
							style="display: inline-flex;"
							color="#47a5ad"
							readonly>
							</v-switch>
							<!-- <v-icon  v-if="!item.active" small @click="openActitveUserDialog(item)">
                		  	  	mdi-shield-check
                		  	</v-icon> -->
                              <!-- editUserActiveState(item) -->
                		</template>
                	</v-data-table>
            	</v-card>

            <!-- Dialogo eliminar usuario -->
        	<v-dialog v-model="deleteUserDialog" max-width="500px" persistent>
        		<v-card tile>
        	    	<v-card-title>
        	    	  	¿ELIMINAR USUARIO?
        	    	</v-card-title>
        	    	<v-card-text>
        	      		¿Esta seguro de eliminar al usuario? Esta acción no se puede deshacer
        	    	</v-card-text>
        	    	<v-card-actions class="mt-n6">
        	    	  	<v-spacer></v-spacer>
        	    	  	<v-btn color="red" text @click="closeDialogDeleteUser">CANCELAR</v-btn>
        	    	  	<v-btn color="blue darken-1" text @click="dialogAcceptDeleteUser">ELIMINAR</v-btn>
        	    	</v-card-actions>
        		</v-card>
        	</v-dialog>
			<v-dialog v-model="activeUserDialog" max-width="500px" persistent>
        		<v-card tile>
        	    	<v-card-title>
        	    	  	¿ACTIVAR USUARIO?
        	    	</v-card-title>
        	    	<v-card-text>
        	      		Asegurese de revisar la información de este usuario ya que al activarlo se le enviará un email
						con la contraseña de acceso a Rollux. 

						Si ya se le asignó contraseña el correo de notificación no será enviado.
        	    	</v-card-text>
        	    	<v-card-actions class="mt-n6">
        	    	  	<v-spacer></v-spacer>
        	    	  	<v-btn color="red" text @click="activeUserDialog = false">CANCELAR</v-btn>
        	    	  	<v-btn color="#47a5ad" text @click="active" :loading="loadingActive">Activar</v-btn>
        	    	</v-card-actions>
        		</v-card>
        	</v-dialog>
			<v-dialog v-model="inactiveUserDialog" max-width="500px" persistent>
        		<v-card tile>
        	    	<v-card-title>
        	    	  	¿DESACTIVAR USUARIO?
        	    	</v-card-title>
        	    	<v-card-text>
        	      		El usuario no podrá iniciar sesión pero su información seguirá almacenada en la base de datos.
        	    	</v-card-text>
        	    	<v-card-actions class="mt-n6">
        	    	  	<v-spacer></v-spacer>
        	    	  	<v-btn color="red" text @click="inactiveUserDialog = false">CANCELAR</v-btn>
        	    	  	<v-btn color="#47a5ad" text @click="active" :loading="loadingActive">Desactivar</v-btn>
        	    	</v-card-actions>
        		</v-card>
        	</v-dialog>
        </div>
    </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex';
export default {
    data(){
        return {
			inactiveUserDialog: false,
			loadingActive: false,
			activeUserDialog: false,
			swToInactive: false,
			selectedRoles: [],
			urlTemporal: null,
      		currentLogo: null,
          	loadingTable: false,
          	deleteUserDialog: false,
          	localDeletinItem: {},
            usersDialog: Object.keys(this.$route.query).length == 0?false:true,
            tab: null,
            search: "",
            searchRole: "",
            headers: [
                {
                  text: 'ID',
                  value: 'id',
                  align: 'center',
                  sortable: false,
                },
                { text: 'Nombre', value: 'name', align: 'center' },
                { text: 'Email', value: 'email', align: 'center' },
                { text: 'Compañia', value: 'company', align: 'center' },
                { text: 'Rol', value: 'role', align: 'center' },
                { text: 'Descuento(%)', value: 'discount_percent', align: 'center' },
				{ text: 'Acciones', value: 'actions', align: 'center', sortable: false },

            ],
      //  headersRoles: [
      //   {
      //     text: 'ID',
      //     align: 'start',
      //     sortable: false,
      //     value: 'id',
      //   },
      //   { text: 'Nombre', value: 'name' },
      //   { text: 'Url amigable', value: 'slug' },
      //   { text: 'Descripción', value: 'description' },
      //   { text: 'Permiso(s)', value: 'permissions' },
      //   { text: 'Acciones', value: 'actions', sortable: false },

      // ],

      editedIndex: -1,
    editedItem: {
        name: this.$route.query.name || null,
        last_name: this.$route.query.last_name || null,
        rfc: this.$route.query.rfc || null,
        email: this.$route.query.email || null,
        phone: this.$route.query.phone || null,
        address: this.$route.query.address || null,
        company: this.$route.query.company || null,
        city: this.$route.query.city || null,
        state: this.$route.query.state || null,
        zip_code: this.$route.query.zip_code || null,
		role: null,
		logo: null,
        discount_percent: 0,
		active: 1,
    },
    defaultItem: {
      name: null,
      last_name: null,
      rfc: null,
      email: null,
      phone: null,
      address: null,
      company: null,
      city: null,
      state: null,
      zip_code: null,
	  role: null,
	  logo: null,
      discount_percent: 0,
	  active: 1,
    },

        }
    },

    mounted(){
      	this.loadingTable = true,
     	this.$store.dispatch('getusers').then(()=>{
          	if(this.getUsersStatus === 200){
            	this.loadingTable = false
         	}

			this.loadingTable = false
        })
        this.$store.dispatch('getroles')
    },

    computed:{
      ...mapGetters([
      'getUsersStatus',
      'getRolesStatus',
     ]),

     ...mapState({
       status: state => state.usersModule.usersStatus,
      users: state => state.usersModule.users,
      user: state => state.user,
      roles: state => state.rolesModule.roles,
      errors: state => state.usersModule.usersErrors,
    }),
    computedTableHeaders(){
        if(this.user.role === 'Superadministrador' || this.user.role === 'Administrador'){
            return this.headers;
        }
        else if(this.user.role === 'Vendedor'){
            let arr = this.headers;
            arr.pop()
            return arr;
        }
    },
    formTitle () {
      return this.editedIndex === -1 ? 'Nuevo Usuario' : 'Editar Usuario'
    },

	filtered(){
		if(this.swToInactive){
			return this.users.filter(user => !user.active)
		}else{
			return this.users
		}

	}

  },

  methods:{
      ...mapActions(['actionDeleteUserAXIOS']),
	selectImage(event){
    	this.currentLogo = event.target.files[0]
    	this.editedItem.logo = this.currentLogo
    	const reader = new FileReader();
    	reader.readAsDataURL(this.currentLogo)
    		reader.onload = (e) => {
    			this.urlTemporal = e.target.result;

			};
    	this.currentLogo = null
   	},

     editItem (item) {
      this.editedIndex = this.users.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.usersDialog = true
    },

    editUserActiveState(item){
        this.editedIndex = this.users.indexOf(item)
        if(item.active == 1){
            item.active = 0;
        }
        else if(item.active == 0){
            item.active = 1;
        }
        this.editedItem = Object.assign({}, item)
        this.save();
    },

	rowClass(item){
		if(item.active === 0){
			return 'no-active'
		}
	},

    dialogAcceptDeleteUser(){
        this.actionDeleteUserAXIOS(this.localDeletinItem).then(()=>{
            this.closeDialogDeleteUser();
        }).catch(()=>{
            this.closeDialogDeleteUser();
        });
    },

    closeDialogDeleteUser(){
        this.deleteUserDialog = false;
        this.localDeletinItem = {}
    },

    deleteItem (item) {
        this.deleteUserDialog = true;
        Object.assign(this.localDeletinItem, item);
    },
	openActitveUserDialog(item){
		Object.assign(this.localDeletinItem, item);
		if(item.active){
			this.inactiveUserDialog = true
		}else{
			this.activeUserDialog = true
		}
	},

	active(){
		this.loadingActive = true
		this.$store.dispatch('activeUser',this.localDeletinItem.id).then(()=>{
			this.loadingActive = false
			this.activeUserDialog = false
			this.inactiveUserDialog = false
		})
	},

    close () {
      this.usersDialog = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
	  this.urlTemporal = null
    },

    save () {

      if (this.editedIndex > -1) {
        //console.log(this.editedItem)
       this.$store.dispatch('editUser',this.editedItem).then(()=>{
          if(this.status=== 200){
              this.close()
          }
        })
      } else {

        this.$store.dispatch('saveUser',this.editedItem).then(()=>{
          if(this.status=== 200){
              this.close()
          }
        })
      }

    },
  }


}
</script>
<style>
.no-active{
	color: white;
    background-color: #f4433694!important;
}
</style>
