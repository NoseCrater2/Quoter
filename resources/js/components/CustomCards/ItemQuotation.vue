<template>
    <v-hover v-slot="{ hover }">
        <v-card min-width="228" max-width="228" :flat="hover?false:true"  :outlined="hover?false:true" :class="[hover?'grow':'', !$vuetify.breakpoint.mdAndUp ? 'mx-auto' : '']">
            <v-card-title class="py-1">
                {{ item.blinds }} PERSIANA(S)
                <v-spacer></v-spacer>
                <v-menu bottom offset-x>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn icon v-bind="attrs" v-on="on">
                                <v-icon color="#3ba2a9">mdi-dots-vertical</v-icon>
                            </v-btn>
                        </template>
                        <v-list dense>
                            <v-list-item dense link @click="localMethodIsOrdersAndQuotationsDialogActivatedOn(item)">
                                <v-list-item-icon>
                                    <v-icon >mdi-clipboard-list</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Ver detalles</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item dense link @click="openDialogAddToCartQuotation(item.id)">
                                <v-list-item-icon>
                                    <v-icon >mdi-cart</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Agregar al carrito</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item dense link @click="methodWatchOnQuoter(item.id)">
                                <v-list-item-icon>
                                    <v-icon >mdi-pencil</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Ver en cotizador</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item dense link @click="openDeleteDialogQuotation(item.id)">
                                <v-list-item-icon>
                                    <v-icon >mdi-delete</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Eliminar</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                    </v-menu>

            </v-card-title>
            <v-card-title class="font-weight-bold py-1">
                <h3>Cotizacion</h3>
                <h3 style="color: #3ba2a9">{{item.order}}</h3>
            </v-card-title>
            <v-list-item >
                <v-list-item-content class="py-1" >
                    <v-col cols="3">
                        <div>
                            <v-badge
                              class="font-weight-bold isHoverBadge"
                              :content="item.blinds"
                              :value="item.blinds"
                              color="#3ba2a9"
                              overlap
                              :offset-x="item.blinds > 9 ? '39' : '37'"
                              offset-y="28"
                            >
                              <v-icon color="#3ba2a9" size="55">
                                mdi-blinds
                              </v-icon>
                            </v-badge>
                        </div>
                    </v-col>
                    <v-col cols="9" class="text-right">
                        <span :style="$vuetify.breakpoint.lgAndUp ? 'font-size: 1.2rem' : $vuetify.breakpoint.md ? 'font-size: 1.1rem' : 'font-size: 1.2rem'" class="font-weight-bold">
                           {{mxCurrencyFormat.format(item.total)}}
                        </span>
                        <span class="text-center">MXN</span>
                    </v-col>
                </v-list-item-content>
            </v-list-item>
            <v-card-actions >
                <v-btn x-small outlined rounded text @click="localMethodIsOrdersAndQuotationsDialogActivatedOn(item)">Ver Detalles</v-btn>
                <v-spacer></v-spacer>
                <v-btn x-small rounded color="#f99404" class="white--text" @click="openDialogAddToCartQuotation(item.id)">
                    <v-icon left>mdi-cart</v-icon>
                    Comprar
                </v-btn>
                <!-- <v-btn x-small rounded color="#3ba2a9" class="white--text" @click="methodUpdatePriceAndVigencyQuoting(item)">
                    Actualizar
                </v-btn> -->
            </v-card-actions>
            <v-card-text class="pa-2 text-center" >
                <v-chip small label style="width: 100%" class="d-flex justify-center">
                    VIGENCIA {{item.validity}}
                </v-chip>
            </v-card-text>
            <v-card-text class="pa-2 d-flex" v-if="hover" >
                <v-list-item class="mb-n4">
                <v-list-item-content class="mx-n4">
                    <v-col cols="6">
                        <v-icon>mdi-calendar-check</v-icon>
                        <span class="subtitle-2">Fecha de cotización</span>
                        <div class="caption">
                            {{item.created_at}}
                        </div>
                    </v-col>
                    <v-divider vertical></v-divider>
                    <v-col cols="6">
                        <v-icon>mdi-calendar-edit</v-icon>
                        <span class="subtitle-2">Última actualización</span>
                        <div class="caption">
                            {{item.updated_at}}
                        </div>
                    </v-col>
                </v-list-item-content>
            </v-list-item>
            </v-card-text>
            <DashboardOrdersAndQuotationsDialog @emitClickCloseFromOrdersAndQuotationsDialog="emitClickCloseFromOrdersAndQuotationsDialog" :isOrdersAndQuotationsDialogActivated="isOrdersAndQuotationsDialogActivated" :propTotalPrice="localToPropTotalPrice" :propIsOrderOrQuotationString="'quotation'" :propItemQuotationOrderNumberID="item.order"></DashboardOrdersAndQuotationsDialog>
            <v-dialog v-model="localDialogAddToCartQuotation" persistent max-width="290">
              <v-card>
                <v-card-title class="headline">¿Agregar al carrito?</v-card-title>
                <v-card-text>
                  Esta COTIZACIÓN está a punto de convertise en una ORDEN.
                  ¿Desea continuar?
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="gray darken-1" text @click="closeDialogAddToCartQuotation()">CANCELAR</v-btn>
                  <v-btn color="primary" text @click="methodAddToCartQuotation(localIDQuotation)">ACEPTAR</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>

            <v-dialog v-model="localDialogDeleteQuotation" persistent max-width="290">
              <v-card>
                <v-card-title class="headline">¿Eliminar cotización?</v-card-title>
                <v-card-text>
                  Está a punto de eliminar está cotización.
                  Esta acción no se puede deshacer. ¿Continuar?
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="gray darken-1" text @click="closeDeleteDialogQuotation()">CANCELAR</v-btn>
                  <v-btn color="red darken-1" text @click="deleteQuotation(localIDQuotation)">ELIMINAR</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
        </v-card>
    </v-hover>
</template>

<script>
import { mapState } from 'vuex';
import axios from 'axios';
import woodMatrix from '../../utils/woodMatrixOne';
import woodMotorized from '../../utils/woodMatrixTwo';
import DashboardOrdersAndQuotationsDialog from '../../components/Dashboard/OrdersAndQuotations/DashboardOrdersAndQuotationsDialog.vue'
export default {
    data(){
        return {
            localToPropTotalPrice: 0,
            localIDQuotation: -1,
            localDialogAddToCartQuotation: false,
            localDialogDeleteQuotation: false,
            isOrdersAndQuotationsDialogActivated: false,
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
        }
    },
    computed:{
        ...mapState({
            orders: state => state.ordersModule.orders,
            quotingOrders: state => state.ordersModule.quotingOrders,
            quotingOrder : state => state.ordersModule.quotingOrder,
            user: (state) => state.user,
        }),
    },
    methods:{
        // methodUpdatePriceAndVigencyQuoting(localItemQuotation){
        //     let localNewPrice = [];

        //     console.log(localItemQuotation)
        //     let localDate = new Date();
        //     let dateString = localDate.getFullYear() + "-" +
        //         ("0" + (localDate.getMonth()+1)).slice(-2) + "-" +
        //         ("0" + localDate.getDate()).slice(-2) + " " +
        //         ("0" + localDate.getHours()).slice(-2) + ":" +
        //         ("0" + localDate.getMinutes()).slice(-2) + ":" +
        //         ("0" + localDate.getSeconds()).slice(-2);
        //     console.log(dateString)
        //     this.$store.dispatch('getQuotingOrder', localItemQuotation.id).then(()=>{

        //         if (this.quotingOrder) {
        //             let localVariant;
        //             let localVariantTwo;



        //             for (let indexQuotingOrder = 0; indexQuotingOrder < this.quotingOrder.blinds.length; indexQuotingOrder++) {
        //                 let idCurrentQuotingOrder = this.quotingOrder.blinds[indexQuotingOrder].id;
        //                 if (this.quotingOrder.blinds[indexQuotingOrder].variant) {
        //                   localVariant = this.$store.state.productsModule.variants.find((variant) => variant.id === this.quotingOrder.blinds[indexQuotingOrder].variant)
        //                 }
        //                 if (this.quotingOrder.blinds[indexQuotingOrder].variant2) {
        //                   localVariantTwo = this.$store.state.productsModule.variants.find((variant) => variant.id === this.quotingOrder.blinds[indexQuotingOrder].variant2)
        //                 }


        //                 if(this.quotingOrder.blinds[indexQuotingOrder].variant2 != null){
        //                     let partialHeight = this.quotingOrder.blinds[indexQuotingOrder].canvas[0].height / 2
        //                     let price = 0
        //                     if (this.quotingOrder.blinds[indexQuotingOrder].canvas[0].width > 1 && partialHeight > 1) {
        //                         localNewPrice.push({ id: idCurrentQuotingOrder , price : parseFloat((localVariant.price * this.quotingOrder.blinds[indexQuotingOrder].canvas[0].width * partialHeight) + (localVariantTwo.price * this.quotingOrder.blinds[indexQuotingOrder].canvas[0].width * partialHeight))});
        //                     }
        //                     else if (this.quotingOrder.blinds[indexQuotingOrder].canvas[0].width > 1) {
        //                         price =  parseFloat((localVariant.price * this.quotingOrder.blinds[indexQuotingOrder].canvas[0].width) + (localVariantTwo.price * this.quotingOrder.blinds[indexQuotingOrder].canvas[0].width));
        //                         localNewPrice.push({id: idCurrentQuotingOrder, price: price});
        //                     }
        //                     else if (partialHeight > 1) {
        //                         price =  parseFloat((localVariant.price * partialHeight) + (localVariantTwo.price * partialHeight));
        //                         localNewPrice.push({id: idCurrentQuotingOrder, price: price});
        //                     }
        //                     else {
        //                         price = parseFloat(localVariant.price) + parseFloat(localVariantTwo.price)
        //                         localNewPrice.push({id: idCurrentQuotingOrder, price: price});
        //                     }
        //                 }
        //                 else if (this.quotingOrder.blinds[indexQuotingOrder].canvas.length > 0 && localVariant) {
        //                     let price = 0;
        //                     for (let index = 0; index < this.quotingOrder.blinds[indexQuotingOrder].canvas.length; index++) {
        //                         if (this.quotingOrder.blinds[indexQuotingOrder].canvas[index].width > 1 && this.quotingOrder.blinds[indexQuotingOrder].canvas[index].height > 1) {
        //                           price += parseFloat(localVariant.price * this.quotingOrder.blinds[indexQuotingOrder].canvas[index].width * this.quotingOrder.blinds[indexQuotingOrder].canvas[index].height);
        //                         }
        //                         else if (this.quotingOrder.blinds[indexQuotingOrder].canvas[index].width > 1) {
        //                           price += parseFloat(localVariant.price * this.quotingOrder.blinds[indexQuotingOrder].canvas[index].width);
        //                         }
        //                         else if (this.quotingOrder.blinds[indexQuotingOrder].canvas[index].height > 1) {
        //                           price += parseFloat(localVariant.price * this.quotingOrder.blinds[0].canvas[index].height);
        //                         }
        //                         else {
        //                           price += parseFloat(localVariant.price);
        //                         }
        //                     }
        //                     localNewPrice.push({id: idCurrentQuotingOrder, price: price});
        //                 }
        //                 else if (localVariant) {
        //                     localNewPrice.push({id: idCurrentQuotingOrder, price: localVariant.price});
        //                 }
        //                 else {
        //                     localNewPrice.push({id: idCurrentQuotingOrder, price: 0});
        //                 }
        //             }

        //             axios.post('/api/revalidate-item-quotation/'+localItemQuotation.id, localNewPrice).then((response)=>{
        //                 if(response.status == 200){
        //                     this.$store.dispatch('getQuotingOrders');
        //                 }
        //             });

        //             // console.log("MODIFICADO", localNewPrice, this.quotingOrder.blinds)
        //         }
        //     });
        // },
        localMethodIsOrdersAndQuotationsDialogActivatedOn(localItem){
            this.$store.dispatch('getQuotingOrder', localItem.id).then(()=>{
                this.localToPropTotalPrice = localItem.total;
                this.isOrdersAndQuotationsDialogActivated = true;
            });

        },
        emitClickCloseFromOrdersAndQuotationsDialog(){
            this.localToPropTotalPrice = 0;
            this.isOrdersAndQuotationsDialogActivated = false;
        },
        methodAddToCartQuotation(idQuotation){
            this.localIDQuotation = idQuotation;
            if(this.localIDQuotation > -1){
                this.$store.dispatch('changeToOrder', this.localIDQuotation).then(()=>{
                    this.closeDialogAddToCartQuotation();
                }).catch(()=>{
                    this.closeDialogAddToCartQuotation();
                })
            }
        },
        openDialogAddToCartQuotation(idQuotation){
            this.localDialogAddToCartQuotation = true;
            this.localIDQuotation = idQuotation;
        },
        closeDialogAddToCartQuotation(){
            this.localDialogAddToCartQuotation = false;
            this.localIDQuotation = -1;
        },
        methodWatchOnQuoter(idQuotation){
            this.$store.dispatch('editQuotingOrder',idQuotation).then(()=>{
                this.$router.push({name: 'Quoter', params:{order_id: idQuotation}})
            });
        },
        openDeleteDialogQuotation(idQuotation){
            this.localDialogDeleteQuotation = true;
            this.localIDQuotation = idQuotation;
        },
        closeDeleteDialogQuotation(){
            this.localDialogDeleteQuotation = false;
            this.localIDQuotation = -1;
        },
        deleteQuotation(idQuotation){
            this.localIDQuotation = idQuotation;
            if(this.localIDQuotation > -1){
                this.$store.dispatch('deleteQuotingOrder', this.localIDQuotation).then(()=>{
                    this.closeDeleteDialogQuotation();
                }).catch(()=>{
                    this.closeDeleteDialogQuotation();
                })
            }
        }
    },
    components:{
        DashboardOrdersAndQuotationsDialog
    },
    props: {
        item: {
            type: Object,
            required: true
        }
    }
}
</script>

<style>
    .grow{
        position: absolute;
        transition: 0.1s ease-in-out 0.1s;
        box-shadow: 0 9.7906861202px 11.7906861202px rgba(0, 0, 0, 0.3), 0 9.7906861202px 11.7906861202px rgba(0, 0, 0, 0.06) !important;
        z-index: 2 !important;
        transform: translateY(-2px) !important;
    }
</style>
