<template>
    <v-container fluid>
        <v-data-iterator
        :items="orders"
        :items-per-page="itemsPerPage"
        :search="search"
        sort-by="created_date"
        :sort-desc="false"
        hide-default-footer>
            <template v-slot:header>
                <v-toolbar dark color="#3ba2a9" class="mb-1">
                    <v-text-field
                    v-model="search"
                    clearable
                    flat
                    solo-inverted
                    hide-details
                    prepend-inner-icon="mdi-magnify"
                    label="Buscar orden"
                    ></v-text-field>
                </v-toolbar>
            </template>

            <template v-slot:default="props">
                <v-row>
                    <v-col v-for="item in props.items" :key="item.id" cols="12" sm="6" md="4">
                        <v-card class="mx-auto"  outlined >
                            <div class="text-right">
                              <v-menu offset-y>
                                <template v-slot:activator="{ on, attrs }">
                                  <v-btn
                                    icon
                                   color="#3ba2a9"
                                    dark
                                    v-bind="attrs"
                                    v-on="on"
                                  >
                                  <v-icon>mdi-dots-vertical</v-icon>
                                  </v-btn>
                                </template>
                                <v-list>
                                  <v-list-item link @click="openDetailsDialog(item.id)">
                                    <v-list-item-icon><v-icon>mdi-clipboard-list</v-icon></v-list-item-icon>
                                    <v-list-item-title>Ver detalles</v-list-item-title>
                                  </v-list-item>
                                  <v-list-item link @click="changeQuotation(item.id)">
                                    <v-list-item-icon><v-icon>mdi-truck</v-icon></v-list-item-icon>
                                    <v-list-item-title>Hacer orden</v-list-item-title>
                                  </v-list-item>
                                   <v-list-item link @click="editQuotation(item.id)">
                                    <v-list-item-icon><v-icon>mdi-pencil</v-icon></v-list-item-icon>
                                    <v-list-item-title>Ver en cotizador</v-list-item-title>
                                  </v-list-item>
                                   <v-list-item link @click="deleteQuotation(item.id)">
                                    <v-list-item-icon><v-icon>mdi-delete</v-icon></v-list-item-icon>
                                    <v-list-item-title>Eliminar</v-list-item-title>
                                  </v-list-item>
                                </v-list>
                              </v-menu>
                            </div>
                            <v-list-item three-line>
                                <v-list-item-content>
                                    <v-list-item-title class="headline mb-1">
                                      {{ item.blinds}} PERSIANA(S)
                                    </v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content  style="font-size: 1.8rem">
                                  TOTAL: {{mxCurrencyFormat.format(item.total)}}
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content >
                                    Fecha de creación: 
                                </v-list-item-content>
                                <v-list-item-icon>
                                    {{item.created_at}}
                                </v-list-item-icon>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content >
                                    Última actualización: 
                                </v-list-item-content>
                                <v-list-item-icon>
                                    {{item.updated_at}}
                                </v-list-item-icon>
                            </v-list-item>
                            <!-- <v-card-actions>
                                <v-hover v-slot="{ hover }">
                                    <v-btn :outlined="hover?false:true" :class="hover?'white--text':''" rounded color="#3ba2a9"  >
                                        Ver detalles
                                        <v-icon>mdi-clipboard-list</v-icon>
                                    </v-btn>
                                </v-hover>
                                <v-spacer></v-spacer>
                                    <v-btn outlined rounded color="#3ba2a9" >
                                        Editar
                                        <v-icon right>mdi-calculator</v-icon>
                                    </v-btn>
                                <v-spacer></v-spacer>
                                    <v-btn outlined rounded color="#3ba2a9" >
                                        Eliminar
                                        <v-icon right>mdi-delete</v-icon>
                                    </v-btn>
                            </v-card-actions> -->
                        </v-card>
                        
                    </v-col>
                </v-row>
            </template>

            <template v-slot:footer>
                <v-row class="mt-2" align="center" justify="center">
                    <span class="grey--text">Ordenes por página</span>
                    <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs}">
                            <v-btn dark text color="#3ba2a9" class="ml-2" v-bind="attrs" v-on="on">
                                {{itemsPerPage}}
                                <v-icon>mdi-chevron-down</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item v-for="(number, index) in itemsPerPageArray" :key="index" @click="updateItemsPerPage(number)">
                                <v-list-item-title>
                                    {{number}}
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                    <v-spacer></v-spacer>
                    <span>Página {{page}} de {{ numberOfPages }}</span>
                    <v-btn icon color="#3ba2a9" class="mr-1" @click="formerPage">
                        <v-icon>mdi-chevron-left</v-icon>
                    </v-btn>
                    <v-btn icon color="#3ba2a9" class="mr-1" @click="nextPage">
                        <v-icon>mdi-chevron-right</v-icon>
                    </v-btn>
                </v-row>
            </template>
        </v-data-iterator>
        <v-row justify="center">
            <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
                <v-card flat>
                    <v-toolbar dark>
                        <v-btn icon dark @click="dialog = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-toolbar>
                    <v-row align="center" justify="center" >
                        <v-col cols="12" v-for="blind in order.blinds" :key="blind.id">

                            <v-card height="300" >
                                <div style="border: 1px solid black; height: 85%; width: 90%; margin: auto" class="d-flex">
                                    <v-card flat class="d-flex"   style="border: 1px solid black; width: 40px; height: 253px">
                                        <div class="rotado">
                                            PERSIANA {{ blind.id }}
                                        </div>
                                    </v-card>
                                    <v-card flat class="d-flex align-center text-center" style="margin: auto;width: 100%; height: 85%" >
                                        <div style="width: 50%">
                                            <div class="d-block" style="font-weight: bolder;">
                                                Modelo: {{$store.getters.getVariant(blind.variant).name}}
                                            </div>
                                            <div class="d-block" style="font-weight: bolder;" v-if="blind.variant2 != null">
                                                Modelo 2:  {{$store.getters.getVariant(blind.variant2).name}}
                                            </div>
                                            <div class="d-block">
                                                <b> Color:</b>{{blind.color.color}}
                                                <b>Código:</b>{{blind.color.code}} 
                                            </div>
                                            <div class="d-block" v-if="blind.second_color != null">
                                                <b> Color 2:</b>{{blind.second_color.color}}
                                                <b>Código:</b>{{blind.second_color.code}} 
                                            </div>
                                            <div class="d-block">
                                                <b>Tipo:</b>Persiana {{blind.type}}
                                                <b>Línea: </b>{{blind.line}}
                                            </div>
                                            <div  class="d-block">
                                                <b v-if="blind.cloth_holder">CON PORTATELA</b> 
                                                <div style="display: inline" v-if="blind.celular_type != null">
                                                  {{blind.celular_type}}
                                                </div>
                                                <div style="display: inline" v-if="blind.celular_drive != null">
                                                  {{blind.celular_drive}}
                                                </div>
                                                <div style="display: inline" v-if="blind.instalation_side != null">
                                                  <b>Tipo de instalación: </b> {{blind.motor.instalation_side}}
                                                </div>
                                                <div style="display: inline" v-if="blind.motor.instalation_side != null">
                                                 <b>Tipo de instalación: </b> {{blind.motor.instalation_side}}
                                                </div>
                                            </div>
                                            <div class="d-block">
                                                <div style="display: inline" v-if="blind.motor.frame != null">
                                                    <b>Marco: </b>{{blind.motor.frame}}
                                                </div>
                                                <div style="display: inline" v-if="blind.motor.rail_color != null">
                                                    <b>Riel: </b> {{blind.motor.rail_color}}
                                                </div>
                                                <div style="display: inline" v-if="blind.motor.height_control != null">
                                                    <b>Alura de mando: </b> {{blind.motor.height_control}} mts
                                                </div>
                                                <div style="display: inline" v-if="blind.motor.selected_panel && blind.motor.selected_panel != 0">
                                                    <b>Agrupamiento: </b> {{blind.motor.selected_panel}}
                                                </div>
                                            </div>
                                            <div class="d-block">
                                                <b>Precio (m2):</b>${{$store.getters.getVariant(blind.variant).price}} MXN | 
                                                <b>Subtotal:</b>${{blind.price}} MXN
                                            </div>
                                            <br>
                                            <div class="d-block">
                                                <div v-if="blind.motor_type != null"><b>Accionamiento:</b>{{blind.motor_type}}</div>
                                                <div v-if="blind.motor.drive != null"><b>Control/Motor:</b>{{blind.motor.drive}}</div>
                                            </div>
                                            <div class="d-block">
                                                <div style="display: inline" v-if="blind.motor.manufacturer != null">
                                                    <b>Marca:</b>{{blind.motor.manufacturer}}
                                                </div>
                                                <div style="color: #47a5ad;display: inline" v-if="blind.motor.manufacturerPrice > 0">(+${{blind.motor.manufacturerPrice}})</div>
                                                <div style="display: inline" v-if="blind.motor.control_color != null &&  blind.motor.control_color != 0">
                                                    <b>Color:</b>{{blind.motor.control_color}}
                                                </div>
                                                <div style="display: inline" v-if="blind.motor.string_type != null" >
                                                    <b>Cadena:</b>{{blind.motor.string_type}}
                                                </div>
                                                <div style="color: #47a5ad; display: inline" v-if="blind.motor.stringPrice > 0">(+${{blind.motor.stringPrice}})</div>
                                            </div>
                                            <div class="d-block" v-if="blind.motor.gallery != null">
                                                <b>Galeria/Fascia:</b>{{blind.motor.gallery.model}}
                                                <div style="color: #47a5ad;display: inline" v-if="blind.motor.galleryPrice > 0">(+${{blind.motor.galleryPrice}})</div>
                                                <div style="color: #47a5ad;display: inline" v-else > 0">(+${{blind.motor.gallery.price}})</div>
                                                <b v-if="blind.motor.gallery.color != null">Color: {{blind.motor.gallery.color}}</b> 
                                                <b v-else>Color: n/a</b>
                                            </div>
                                            <div class="d-block" v-if="blind.motor.motor != 0 && blind.motor.motor != null">
                                                <b>Motor:</b>
                                                <div style="display: inline">{{$store.getters.getMotor(blind.motor.motor).system}}</div> 
                                                <div style="display: inline"> <b>Tipo: </b>{{$store.getters.getMotor(blind.motor.motor).motorizationType}}</div>
                                                <div style="display: inline"> <b>Precio: </b>{{mxCurrencyFormat.format($store.getters.getMotor(blind.motor.motor).price)}}MXN</div>
                                            </div>
                                            <div class="d-block" v-if="blind.motor.control != null">
                                                <b>Control: </b>
                                                <div style="display: inline">{{blind.motor.control.description}}</div> 
                                                <div style="display: inline; color: #47a5ad">{{mxCurrencyFormat.format(blind.motor.control.price)}}MXN</div>
                                            </div>
                                            <div class="d-block" v-if="blind.motor.flexiballetPrice > 0">
                                                <b>EXTRA:</b>${{blind.motor.flexiballetPrice}} MXN
                                            </div>
                                        </div>
                                        <div style="width: 25%" >
                                            <div class="d-block" style="margin-top: 15px;" v-for="(c, index) in blind.canvas" :key="index">
                                                <div class="d-block" style="font-weight: bolder; color: #47a5ad">Lienzo {{index + 1}}:</div>
                                                <div class="d-block" style="font-weight: bolder">Ancho:{{c.width}}m | Alto: {{c.height}}m</div>
                                            </div>
                                        </div>
                                        <div style="width: 25%">
                                            <v-img 
                                            v-if="blind.second_color == null" 
                                            width="150" 
                                            :src="`/img/modelos/medium/${blind.color.code}.jpg`"
                                            >
                                                <template v-slot:placeholder>
                                                    <img  width="150" height="150"  src="/img/modelos/medium-unavailable.jpg">
                                                </template>
                                            </v-img>
                                            <div v-else class="d-flex justify-space-around">
                                                <div>
                                                    <div class="d-block">DIA</div>
                                                    <v-img
                                                    :src="`/img/modelos/medium/${blind.color.code}.jpg`"
                                                    width="100" 
                                                    height="130">
                                                        <template v-slot:placeholder>
                                                            <img src="/img/modelos/medium-unavailable.jpg">
                                                        </template>
                                                    </v-img>
                                                </div>
                                                <div>
                                                    <div>NOCHE</div>
                                                    <v-img
                                                    :src="`/img/modelos/medium/${blind.second_color.code}.jpg`"
                                                    width="100" 
                                                    height="130">
                                                        <template v-slot:placeholder>
                                                            <img src="/img/modelos/medium-unavailable.jpg">
                                                        </template>
                                                    </v-img>
                                                </div>
                                            </div>
                                        </div>
                                    </v-card>
                                </div>
                                <v-card class="d-flex justify-end" style="width: 95%; height: 10%;">
                                    <div style="border: 1px solid black">
                                        <div class="d-inline">TOTAL: </div>
                                        <div class="d-inline" style="color: #47a5ad;">
                                            {{mxCurrencyFormat.format(
                                            blind.price + 
                                            blind.motor.price +
                                            blind.motor.flexiballetPrice +
                                            blind.motor.galleryPrice +
                                            blind.motor.manufacturerPrice +
                                            blind.motor.stringPrice
                                            )}} MXN
                                        </div> 
                                    </div>   
                                </v-card>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-card>
            </v-dialog>
        </v-row>
    </v-container>
</template>

<script>
import { mapState } from "vuex";
export default {
    data(){
        return{
            dialog: false,
            page: 1,
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
            itemsPerPageArray: [4, 8, 12],
            itemsPerPage: 4,
            search: '',
        }
    },

    computed:{
        numberOfPages () {
            return Math.ceil(this.orders.length / this.itemsPerPage)
        },
        ...mapState({
            orders: state => state.ordersModule.quotingOrders,
            order: state => state.ordersModule.quotingOrder,
        }),
    },

    methods:{
        causeError(event){
            console.log(event)
        },
        updateItemsPerPage (number) {
            this.itemsPerPage = number
        },
        nextPage () {
            if (this.page + 1 <= this.numberOfPages) this.page += 1
        },
        formerPage () {
            if (this.page - 1 >= 1) this.page -= 1
        },
        openDetailsDialog(id){
            this.$store.dispatch('getQuotingOrder',id).then(()=>{
                 this.dialog = true
            });
           
        },
        deleteQuotation(id){
            this.$store.dispatch('deleteQuotingOrder',id).then(()=>{
                //  this.dialog = true
            });
        },

        editQuotation(id){
            this.$store.dispatch('editQuotingOrder',id).then(()=>{
                 this.$router.push({name: 'Quoter', params:{order_id: id}})
            });
        },

        changeQuotation(id){
            this.$store.dispatch('changeToOrder',id).then(()=>{
                 
            });
        }
    },

    mounted(){
        this.$store.dispatch('getQuotingOrders');
        
    }
}
</script>
<style scoped>
.rotado{
  writing-mode: vertical-lr;
  transform: rotate(180deg);
  text-align:center;
}
</style>