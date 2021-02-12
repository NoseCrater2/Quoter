<template>
    <div id="app">
      
            <v-tabs v-model="tab" fixed-tabs color="#17767c" background-color="white" >
                <v-tabs-slider></v-tabs-slider>
                <v-tab>Usuarios</v-tab>
                <v-tab>Roles</v-tab>
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
                      <v-text-field dense outlined v-model="editedItem.name" label="Nombre" :error-messages="errors.name"></v-text-field>
                    </v-col>
                    <v-col class="pb-0" cols="12" md="6" sm="12">
                      <v-text-field
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
                      dense
                      outlined
                      v-model="editedItem.phone"
                      label="Teléfono"
                      ></v-text-field>
                    </v-col>
                    <v-col class="pb-0" cols="12" md="6" sm="12">
                      <v-text-field dense outlined v-model="editedItem.email" label="Email" :error-messages="errors.email"></v-text-field>
                    </v-col>
                    
                  </v-row>
                  <v-row>
                    <v-col class="pb-0" cols="12" md="6" sm="12">
                      <v-text-field
                      dense
                      outlined
                      v-model="editedItem.address"
                      label="Dirección"
                      ></v-text-field>
                    </v-col>
                    <v-col class="pb-0" cols="12" md="6" sm="12">
                      <v-text-field
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
                      dense
                      outlined 
                      v-model="editedItem.state"
                      label="Estado"
                      ></v-text-field>
                    </v-col>
                    <v-col class="pb-0" cols="12" md="6" sm="12">
                      <v-text-field
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
                      dense
                      outlined
                      v-model="editedItem.company"
                      label="Empresa"
                      ></v-text-field>
                    </v-col>
                    <v-col class="pb-0" cols="12" md="6" sm="12">
                      <v-text-field
                      prefix="%"
                      v-model="editedItem.discount_percent"
                      dense
                      type="number"
                      outlined
                      label="Descuento"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
  
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="save">Save</v-btn>
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
            </v-tabs-items>

       
    </div>
</template>

<script>
import { mapActions, mapState, mapGetters } from 'vuex';
export default {
    data(){
        return {
          loadingTable: false,
            usersDialog: Object.keys(this.$route.query).length == 0?false:true,
            tab: null,
            search: "",
            searchRole: "",
            headers: [
        {
          text: 'ID',
          align: 'start',
          sortable: false,
          value: 'id',
        },
        { text: 'Nombre', value: 'name' },
        { text: 'Email', value: 'email' },
        { text: 'Rol(es)', value: 'roles' },
        { text: 'Acciones', value: 'actions', sortable: false },

      ],
       headersRoles: [
        {
          text: 'ID',
          align: 'start',
          sortable: false,
          value: 'id',
        },
        { text: 'Nombre', value: 'name' },
        { text: 'Url amigable', value: 'slug' },
        { text: 'Descripción', value: 'description' },
        { text: 'Permiso(s)', value: 'permissions' },
        { text: 'Acciones', value: 'actions', sortable: false },

      ],

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
      ddiscount_percent: 0,
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
        // this.$store.dispatch('getroles').then(()=>{
        //   if(this.getRolesStatus === 200){
           
        //  }
        
        // })

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