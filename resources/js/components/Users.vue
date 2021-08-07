<template>
    <div id="app">
        <div class="text-center">
            <h2 class="mt-2 mb-5">USUARIOS</h2>
             	<v-card>
                	<v-data-table
                	:headers="headers"
                	:items="users"
                	:search="search"
                	:loading="loadingTable"
                	color="#3ba2a9"
                	>
                		<template v-slot:top>
                            <v-row no-gutters justify="space-between">
                                <v-col cols="11">
                                    <v-text-field
                                    class="mx-2"
                		            v-model="search"
                                    outlined
                                    dense
                		            prepend-inner-icon="mdi-magnify"
                		            label="BUSCAR USUARIO"
                		            single-line
                		            hide-details
                		            ></v-text-field>
                                </v-col>
                                <v-col cols="1">
        					        	<v-dialog v-model="usersDialog" max-width="500px" persistent>
        					        	  	<template v-slot:activator="{ on, attrs }">
        					        	  	  	<v-btn
        					        	  	  	color="black"
                                                class="mt-2"
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
        					        	          			  	<v-text-field dense hide-details outlined v-model="editedItem.name" label="Nombre" prepend-inner-icon="mdi-account" :error-messages="errors.name"></v-text-field>
        					        	          			</v-col>
        					        	          			<v-col class="pb-0" cols="12" md="6" sm="12">
        					        	          			  	<v-text-field
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
        					        	          			  	></v-text-field>
        					        	          			</v-col>
        					        	        		</v-row>
							        					<v-row>
        					        	           			<v-col class="pb-0" cols="12">
        					        	            			<v-text-field
							        							hide-details
        					        	            			dense
        					        	            			outlined
        					        	            			v-model="editedItem.ship_address"
        					        	            			label="Dirección de envío"
                                                                prepend-inner-icon="mdi-truck-delivery-outline"
        					        	            			></v-text-field>
        					        	          			</v-col>
        					        	          			<v-col class="pb-0" cols="12">
        					        	          			  	<v-text-field
							        							hide-details
        					        	          			  	v-model="editedItem.second_ship_address"
        					        	          			  	dense
        					        	          			  	outlined
        					        	          			  	label="Dirección de envío alterna"
                                                                prepend-inner-icon="mdi-truck-delivery"
        					        	          			  	></v-text-field>
        					        	          			</v-col>
        					        	        		</v-row>
							        					<v-row>
							        						<v-col cols="12">
							        							<v-select
							        							hide-details
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
      					</template>
                        <template v-slot:item.name="{ item }">
                		  {{item.name+' '+item.last_name}}
                		</template>
                		<template v-slot:item.actions="{ item }">
                		  	<v-icon small class="mr-2" @click="editItem(item)">
                		    	mdi-pencil
                		  	</v-icon>
                		  	<v-icon small @click="deleteItem(item)">
                		  	  	mdi-delete
                		  	</v-icon>
                		</template>
                	</v-data-table>
            	</v-card>

        </div>

        <!-- <v-tabs v-model="tab" fixed-tabs color="#17767c" background-color="white" >
            <v-tab>Usuarios</v-tab>
		</v-tabs>
		<v-tabs-items v-model="tab">
            <v-tab-item >
              	<v-row justify="center">
                 	<v-card >
                  		<v-card-title>
                    		<v-text-field
                    		v-model="search"
                    		append-icon="mdi-magnify"
                    		label="Buscar Usuario"
                    		single-line
                    		hide-details
                    		></v-text-field>
                  		</v-card-title>
                    	<v-data-table
                    	:headers="headers"
                    	:items="users"
                    	:search="search"
                    	:loading="loadingTable"
                    	color="#3ba2a9"
                    	>
                    		<template v-slot:item.name="{ item }">
                    		  {{item.name+' '+item.last_name}}
                    		</template>
                    		<template v-slot:top>
        						<v-toolbar flat color="white">
									<v-spacer></v-spacer>
        							<v-dialog v-model="usersDialog" max-width="500px">
        							  	<template v-slot:activator="{ on, attrs }">
        							  	  	<v-btn
        							  	  	color="black"
        							  	  	dark
        							  	  	class="mb-2"
        							  	  	v-bind="attrs"
        							  	  	v-on="on"
        							  	  	>NUEVO</v-btn>
        							  	</template>
        								<v-card>
        							    	<v-card-title>
        							    	  	<span class="headline">{{ formTitle }}</span>
        							    	</v-card-title>

        							    	<v-card-text>
        							      		<v-container>
        							        		<v-row>
        							          			<v-col class="pb-0" cols="12" md="6" sm="12">
        							          			  	<v-text-field dense hide-details outlined v-model="editedItem.name" label="Nombre" :error-messages="errors.name"></v-text-field>
        							          			</v-col>
        							          			<v-col class="pb-0" cols="12" md="6" sm="12">
        							          			  	<v-text-field
															hide-details
        							          			  	dense
        							          			  	outlined
        							          			  	v-model="editedItem.last_name"
        							          			  	label="Apellido(s)"
        							          			  	></v-text-field>
        							          			</v-col>
        							        		</v-row>

        							        		<v-row>
        							        		   <v-col class="pb-0" cols="12" md="6" sm="12">
        							        		    	<v-text-field
															hide-details
        							        		    	dense
        							        		    	outlined
        							        		    	v-model="editedItem.phone"
        							        		    	label="Teléfono"
        							        		    	></v-text-field>
        							        		  	</v-col>
        							        		  	<v-col class="pb-0" cols="12" md="6" sm="12">
        							        		    	<v-text-field dense hide-details outlined v-model="editedItem.email" label="Email" :error-messages="errors.email"></v-text-field>
        							        		  	</v-col>
        							        		</v-row>
        							        		<v-row>
        							        		  	<v-col class="pb-0" cols="12" md="6" sm="12">
        							        		    	<v-text-field
															hide-details
        							        		    	dense
        							        		    	outlined
        							        		    	v-model="editedItem.address"
        							        		    	label="Dirección"
        							        		    	></v-text-field>
        							        		  		</v-col>
        							        		  	<v-col class="pb-0" cols="12" md="6" sm="12">
        							        		  	  	<v-text-field
															hide-details
        							        		  	  	dense
        							        		  	  	outlined
        							        		  	  	v-model="editedItem.city"
        							        		  	  	label="Ciudad"
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
        							          			  	></v-text-field>
        							          			</v-col>
        							          			<v-col class="pb-0" cols="12" md="6" sm="12">
        							          			  	<v-text-field
															hide-details
        							          			  	dense
        							          			  	outlined
        							          			  	v-model="editedItem.zip_code"
        							          			  	label="Código Postal"
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
        							            			label="Empresa"
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
        							          			  	></v-text-field>
        							          			</v-col>
        							        		</v-row>
													<v-row>
        							           			<v-col class="pb-0" cols="12">
        							            			<v-text-field
															hide-details
        							            			dense
        							            			outlined
        							            			v-model="editedItem.ship_address"
        							            			label="Dirección de envío"
        							            			></v-text-field>
        							          			</v-col>
        							          			<v-col class="pb-0" cols="12">
        							          			  	<v-text-field
															hide-details
        							          			  	v-model="editedItem.second_ship_address"
        							          			  	dense
        							          			  	outlined
        							          			  	label="Dirección de envío alterna"
        							          			  	></v-text-field>
        							          			</v-col>
        							        		</v-row>

													<v-row>
														<v-col cols="12">
															<v-select
															hide-details
															v-model="editedItem.role"
        							          			  	:items="roles"
															item-value="name"
															item-text="name"
        							          			  	dense
        							          			  	outlined
        							          			  	label="Tipo de usuario"
        							          			  	></v-select>
														</v-col>
													</v-row>

													<v-row class="my-2" align="center">
														<v-col cols="12">
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
															<v-card-text class="d-block">
																Haz clic sobre el recuadro para subir el logo
															</v-card-text>
														</v-col>
													</v-row>
        							      		</v-container>
        							    	</v-card-text>
        							    	<v-card-actions>
        							    	  	<v-spacer></v-spacer>
        							    	  	<v-btn color="blue darken-1" text @click="close">Cancelar</v-btn>
        							    	  	<v-btn color="blue darken-1" text @click="save">Guardar</v-btn>
        							    	</v-card-actions>
        								</v-card>
        							</v-dialog>
        						</v-toolbar>
      						</template>
                    		<template v-slot:item.actions="{ item }">
                    		  	<v-icon small class="mr-2" @click="editItem(item)">
                    		    	mdi-pencil
                    		  	</v-icon>
                    		  	<v-icon small @click="deleteItem(item)">
                    		  	  	mdi-delete
                    		  	</v-icon>
                    		</template>
                    	</v-data-table>
                	</v-card>
              	</v-row>
            </v-tab-item>
            <v-tab-item >
               <v-row justify="center">
                 <v-card >
                  <v-card-title>
                    <v-text-field
                      v-model="search"
                      append-icon="mdi-magnify"
                      label="Buscar Rol"
                      single-line
                      hide-details
                    ></v-text-field>
                  </v-card-title>
                    <v-data-table
                    :headers="headersRoles"
                    :items="roles"
                    :search="search"
                    >
                    <template v-slot:item.actions="{ item }">
                      <v-icon small class="mr-2" @click="editItem(item)">
                        mdi-pencil
                      </v-icon>
                      <v-icon small @click="deleteItem(item)">
                        mdi-delete
                      </v-icon>
                    </template>
                    </v-data-table>
                </v-card>
              </v-row>
            </v-tab-item>
        </v-tabs-items> -->
    </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
export default {
    data(){
        return {
			urlTemporal: null,
      		currentLogo: null,
          loadingTable: false,
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
    },
    defaultItem: {
      name: null,
      last_name: null,
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
      roles: state => state.rolesModule.roles,
      errors: state => state.usersModule.usersErrors,
    }),

    formTitle () {
      return this.editedIndex === -1 ? 'Nuevo Usuario' : 'Editar Usuario'
    },

  },

  methods:{

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

    deleteItem (item) {
      const index = this.users.indexOf(item)
      confirm('Are you sure you want to delete this item?') && this.users.splice(index, 1)
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
