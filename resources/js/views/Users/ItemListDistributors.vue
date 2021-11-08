<template>
    <v-row>
        <v-col v-if="$vuetify.breakpoint.mdAndUp" cols="12" xl="3" lg="3" md="3" sm="3">
            <v-card outlined class="rounded-lg">
                <v-card-title style="background: #3ba2a9" class="font-weight-bold white--text">
                    Mi cuenta
                </v-card-title>
                <v-list dense color="#f0f0f0">
                    <v-list-item link :to="{name: 'Profile'}">
                        <v-list-item-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Mi Perfil</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-divider></v-divider>
                    <v-list-item link :to="{name: 'Orders', params: {option: 'ordenes'}}">
                        <v-list-item-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Ordenes</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item link :to="{name: 'Orders', params: {option: 'cotizaciones'}}">
                        <v-list-item-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Cotizaciones</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-divider></v-divider>
                    <v-list-item>
                        <v-list-item-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Mis compras</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-card>
        </v-col>
        <v-col cols="12" xl="9" lg="9" md="9" sm="12">
            <v-data-iterator
            no-data-text="NO DISPONIBLE"
            no-results-text="NO DISPONIBLE"
            :loading="loading"
            loading-text="CARGANDO..."
            :items="items('vigent')"
            :items-per-page="8"
            :search="search"
            sort-by="created_date"
            :sort-desc="false"
            hide-default-footer>
                <template v-slot:header>
                    <v-toolbar dark color="#3ba2a9" class="mb-2" flat>
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
                    <v-row justify="center" justify-xl="start" justify-lg="start" justify-md="start" v-if="option === 'ordenes'">
                        <v-col v-for="item in props.items" :key="item.id" cols="12" xl="2" lg="3" md="4" sm="5">
                            <ItemOrder @emitFromItemOrder="localMethodIsOrdersAndQuotationsDialogActivatedOn" :item="item"  />
                        </v-col>
                    </v-row>
                    <v-row justify="center" justify-xl="start" justify-lg="start" justify-md="start" v-if="option === 'cotizaciones'">
                        <v-col v-for="item in props.items" :key="item.id" cols="12" xl="2" lg="3" md="4" sm="5">
                            <ItemQuotation @emitFromItemQuotation="localMethodIsOrdersAndQuotationsDialogActivatedOn" :item="item" />
                        </v-col>
                    </v-row>
                </template>

                <template v-slot:footer>
                    <v-row align="center" class="mx-1">
                        <span class="grey--text">{{option}} por página</span>
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
                        <span>Página {{page}} de {{ numberOfPages > 0 ? numberOfPages : '1' }}</span>
                        <v-btn icon color="#3ba2a9" class="mr-1" @click="formerPage">
                            <v-icon>mdi-chevron-left</v-icon>
                        </v-btn>
                        <v-btn icon color="#3ba2a9" class="mr-1" @click="nextPage">
                            <v-icon>mdi-chevron-right</v-icon>
                        </v-btn>
                    </v-row>
                </template>
            </v-data-iterator>
            <v-divider class="my-5"></v-divider>
            <div class="d-flex">
                <h1 class="font-weight-bolder text-uppercase" style="color: #3ba2a9">{{option}}</h1>&nbsp;
                <h1 class="font-weight-light">ANTERIORES</h1>
            </div>
             <hr align="center" noshade="noshade" class="divider" style="height: 5px" size="3" width="35%" />

            <v-data-iterator
                    v-if="option === 'cotizaciones'"
                    :items="items('noVigent')"
                    :items-per-page.sync="itemsPerPageSimpleTable"
                    :page.sync="pageSimpleTable"
                    hide-default-footer
            >
                <template v-slot:default="props">

                    <v-simple-table class="my-4" style="background: #f3f3f3">
                          <template v-slot:default>
                            <thead>
                              <tr class="font-weight-bold">
                                <th class="text-center">
                                  #Cotizacion
                                </th>
                                <th class="text-center">
                                  Fecha de creación
                                </th>
                                <th class="text-center">
                                  Fecha de actualización
                                </th>
                                <th class="text-center">
                                  Total
                                </th>
                                <th class="text-center">
                                  Ver detalles
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr
                                v-for="item in props.items"
                                :key="item.name"
                              >
                                <td class="text-center">{{ item.order }}</td>
                                <td class="text-center">{{ item.created_at }}</td>
                                <td class="text-center">{{ item.updated_at }}</td>
                                <td class="text-center">{{ mxCurrencyFormat.format(item.total) + ' MXN' }}</td>
                                <td class="text-center">
                                    <v-btn icon @click="localMethodIsOrdersAndQuotationsDialogActivatedOn(item.id)">
                                        <v-icon>mdi-magnify</v-icon>
                                    </v-btn>
                                    <v-btn icon>
                                        <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                    <span>/</span>
                                    <v-btn color="#3ba2a9" small rounded class="white--text" @click="methodUpdatePriceAndVigencyQuoting(item)">ACTUALIZAR</v-btn>
                                </td>
                              </tr>
                            </tbody>
                        </template>
                    </v-simple-table>

                </template>

                <template v-slot:footer>
                    <v-row
                      class="mb-1"
                      align="center"
                      justify="center"
                    >
                        <v-spacer></v-spacer>

                        <span
                          class="mr-4"
                        >
                          Página {{ pageSimpleTable }} de {{ computedNumberPagesSimpleTable }}
                        </span>
                        <v-btn
                          icon
                          color="#3ba2a9"
                          class="mr-1"
                          @click="methodBeforePageSimpleTable"
                        >
                          <v-icon>mdi-chevron-left</v-icon>
                        </v-btn>
                        <v-btn
                          icon
                          color="#3ba2a9"
                          class="mr-1"
                          @click="methodNextPageSimpleTable"
                        >
                          <v-icon>mdi-chevron-right</v-icon>
                        </v-btn>
                    </v-row>
                </template>

            </v-data-iterator>

        </v-col>
        <DashboardOrdersAndQuotationsDialog :id="orderId" v-if="isOrdersAndQuotationsDialogActivated" @emitClickCloseFromOrdersAndQuotationsDialog="emitClickCloseFromOrdersAndQuotationsDialog" ></DashboardOrdersAndQuotationsDialog>
    </v-row>
</template>

<script>
import axios from 'axios';
import { mapState, mapGetters} from "vuex";
import woodMatrix from '../../utils/woodMatrixOne';
import woodMotorized from '../../utils/woodMatrixTwo';
import ItemOrder from '../../components/CustomCards/ItemOrder.vue'
import ItemQuotation from '../../components/CustomCards/ItemQuotation.vue'
import DashboardOrdersAndQuotationsDialog from '../../components/Dashboard/OrdersAndQuotations/DashboardOrdersAndQuotationsDialog.vue'

export default {
    data(){
        return{
            activeorder: this.$route.query.activeorder || 0,
            localToPropTotalPrice: 0,
            localPropItemQuotationOrderNumberID: '',
            isOrdersAndQuotationsDialogActivated: false,
            loading: false,
            dialog: false,
            page: 1,
            pageSimpleTable: 1,
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
            itemsPerPageArray: [4, 8, 12],
            itemsPerPageSimpleTable: 4,
            itemsPerPage: 4,
            search: '',
            vencidas: [
                {id: 'R140721/100', created_at: 'Aug 14, 2021', total: '$1,290.00 MXN'},
                {id: 'R140721/99', created_at: 'Aug 14, 2021', total: '$1,290.00 MXN'},
                {id: 'R140721/98', created_at: 'Aug 14, 2021', total: '$1,290.00 MXN'}
            ],
            orderId: 0,
        }
    },

    mounted(){
        this.loading = true
        if(this.option === 'ordenes'){
            this.$store.dispatch('getQuotedOrders').then(()=>{
                this.loading = false
            })
        }else if(this.option === 'cotizaciones'){
            this.$store.dispatch('getQuotingOrders').then(()=>{
                this.loading = false
            })
        }
        if(this.activeorder > 0){
            this.localMethodIsOrdersAndQuotationsDialogActivatedOn(parseInt(this.activeorder));
        }
    },

    computed: {
        ...mapGetters(['currentVigentQuoutingItemListDistributors', 'noVigentQuoutingItemListDistributors']),
         numberOfPages () {
            return Math.ceil(this.orders.filter(itemOrder=> itemOrder.state != 'No Pagada').length / this.itemsPerPage)
        },
        computedNumberPagesSimpleTable(){
            return Math.ceil(this.noVigentQuoutingItemListDistributors.length / this.itemsPerPageSimpleTable)
        },
         ...mapState({
            orders: state => state.ordersModule.quotedOrders,
            quotingOrder : state => state.ordersModule.quotingOrder,
            cotizaciones: state => state.ordersModule.quotingOrders,
            user: (state) => state.user,
        }),
    },

    methods:{
        methodBeforePageSimpleTable(){
            if ((this.pageSimpleTable - 1) >= 1){
                this.pageSimpleTable -= 1
            }
        },
        methodNextPageSimpleTable(){
            if (this.pageSimpleTable + 1 <= this.computedNumberPagesSimpleTable) {
                this.pageSimpleTable += 1
            }
        },
        items(value){
            if(this.option === 'ordenes'){
                return this.orders.filter(itemOrder=> itemOrder.state != 'No Pagada');
            } else if(this.option === 'cotizaciones'){
                if(value == 'vigent'){
                    return this.currentVigentQuoutingItemListDistributors
                }
                else if(value == 'noVigent'){
                    return this.noVigentQuoutingItemListDistributors
                }
            }
        },
        localMethodIsOrdersAndQuotationsDialogActivatedOn(localItem){
            axios.get('/api/orders/'+localItem).then((response)=>{
                this.orderId = response.data.data.id
                // this.localPropItemQuotationOrderNumberID = localItem.order;
                // this.localToPropTotalPrice = localItem.total;
                this.isOrdersAndQuotationsDialogActivated = true;
            })
            // this.$store.dispatch('getQuotingOrder', localItem).then(()=>{
            //     this.orderId = localItem;
            //     // this.localPropItemQuotationOrderNumberID = localItem.order;
            //     // this.localToPropTotalPrice = localItem.total;
            //     this.isOrdersAndQuotationsDialogActivated = true;
            // });

        },
        emitClickCloseFromOrdersAndQuotationsDialog(){
            this.localToPropTotalPrice = 0;
            this.localPropItemQuotationOrderNumberID = '';
            this.isOrdersAndQuotationsDialogActivated = false;
        },
        methodUpdatePriceAndVigencyQuoting(localItemQuotation){
            if(this.option === 'cotizaciones'){

                let localNewPrice = [];
                    let localDate = new Date();
                    let dateString = localDate.getFullYear() + "-" +
                        ("0" + (localDate.getMonth()+1)).slice(-2) + "-" +
                        ("0" + localDate.getDate()).slice(-2) + " " +
                        ("0" + localDate.getHours()).slice(-2) + ":" +
                        ("0" + localDate.getMinutes()).slice(-2) + ":" +
                        ("0" + localDate.getSeconds()).slice(-2);
                    this.$store.dispatch('getQuotingOrder', localItemQuotation.id).then(()=>{

                    if (this.quotingOrder) {

                        let localVariant;
                        let localVariantTwo;

                        for (let indexQuotingOrder = 0; indexQuotingOrder < this.quotingOrder.blinds.length; indexQuotingOrder++) {
                            let idCurrentQuotingOrder = this.quotingOrder.blinds[indexQuotingOrder].id;

                            if(this.quotingOrder.blinds[indexQuotingOrder].type == 'horizontal-madera-2'){
                                let result = 0;
                                if(this.quotingOrder.blinds[indexQuotingOrder].motor_type == 'Manual'){
                                   result  =  woodMatrix.filter((m) => m.width >= this.quotingOrder.blinds[indexQuotingOrder].canvas[0].width && m.height >= this.quotingOrder.blinds[indexQuotingOrder].canvas[0].height)
                                }else if(this.quotingOrder.blinds[indexQuotingOrder].motor_type == 'Motorizado'){
                                   result  =  woodMotorized.filter((m) => m.width >= this.quotingOrder.blinds[indexQuotingOrder].canvas[0].width && m.height >= this.quotingOrder.blinds[indexQuotingOrder].canvas[0].height)
                                }
                                if(result[0]){
                                  if(this.quotingOrder.blinds[indexQuotingOrder].motor_type == 'Manual' && this.quotingOrder.blinds[indexQuotingOrder].motor.drive == 'cinta'){
                                    return localNewPrice.push({id: idCurrentQuotingOrder, price: result[0].price + (result[0].price * 0.15), discountPrice: 0});
                                  }else{
                                    return localNewPrice.push({id: idCurrentQuotingOrder, price: result[0].price, discountPrice: 0});
                                  }
                                }
                            }

                            else{
                                if (this.quotingOrder.blinds[indexQuotingOrder].variant) {
                                //   localVariant = this.$store.state.productsModule.variants.find((variant) => variant.id === this.quotingOrder.blinds[indexQuotingOrder].variant)
                                    localVariant = this.$store.state.productsModule.variants.find((variant) => (variant.slug === this.quotingOrder.blinds[indexQuotingOrder].variant) && (variant.type.slug === this.quotingOrder.blinds[indexQuotingOrder].type))
                                }
                                if (this.quotingOrder.blinds[indexQuotingOrder].variant2) {
                                //   localVariantTwo = this.$store.state.productsModule.variants.find((variant) => variant.id === this.quotingOrder.blinds[indexQuotingOrder].variant2)
                                    localVariant = this.$store.state.productsModule.variants.find((variant) => (variant.slug === this.quotingOrder.blinds[indexQuotingOrder].variant2) && (variant.type.slug === this.quotingOrder.blinds[indexQuotingOrder].type))
                                }
                                if(this.quotingOrder.blinds[indexQuotingOrder].variant2 != null){
                                    let partialHeight = this.quotingOrder.blinds[indexQuotingOrder].canvas[0].height / 2
                                    let price = 0
                                    if (this.quotingOrder.blinds[indexQuotingOrder].canvas[0].width > 1 && partialHeight > 1) {
                                        localNewPrice.push({ id: idCurrentQuotingOrder , price : parseFloat((localVariant.price * this.quotingOrder.blinds[indexQuotingOrder].canvas[0].width * partialHeight) + (localVariantTwo.price * this.quotingOrder.blinds[indexQuotingOrder].canvas[0].width * partialHeight)), discountPrice: 0});
                                    }
                                    else if (this.quotingOrder.blinds[indexQuotingOrder].canvas[0].width > 1) {
                                        price =  parseFloat((localVariant.price * this.quotingOrder.blinds[indexQuotingOrder].canvas[0].width) + (localVariantTwo.price * this.quotingOrder.blinds[indexQuotingOrder].canvas[0].width));
                                        localNewPrice.push({id: idCurrentQuotingOrder, price: price, discountPrice: 0});
                                    }
                                    else if (partialHeight > 1) {
                                        price =  parseFloat((localVariant.price * partialHeight) + (localVariantTwo.price * partialHeight));
                                        localNewPrice.push({id: idCurrentQuotingOrder, price: price, discountPrice: 0});
                                    }
                                    else {
                                        price = parseFloat(localVariant.price) + parseFloat(localVariantTwo.price)
                                        localNewPrice.push({id: idCurrentQuotingOrder, price: price, discountPrice: 0});
                                    }
                                }

                                else if (this.quotingOrder.blinds[indexQuotingOrder].canvas.length > 0 && localVariant) {
                                    let price = 0;
                                    for (let index = 0; index < this.quotingOrder.blinds[indexQuotingOrder].canvas.length; index++) {
                                        if (this.quotingOrder.blinds[indexQuotingOrder].canvas[index].width > 1 && this.quotingOrder.blinds[indexQuotingOrder].canvas[index].height > 1) {
                                          price += parseFloat(localVariant.price * this.quotingOrder.blinds[indexQuotingOrder].canvas[index].width * this.quotingOrder.blinds[indexQuotingOrder].canvas[index].height);
                                        }
                                        else if (this.quotingOrder.blinds[indexQuotingOrder].canvas[index].width > 1) {
                                          price += parseFloat(localVariant.price * this.quotingOrder.blinds[indexQuotingOrder].canvas[index].width);
                                        }
                                        else if (this.quotingOrder.blinds[indexQuotingOrder].canvas[index].height > 1) {
                                          price += parseFloat(localVariant.price * this.quotingOrder.blinds[0].canvas[index].height);
                                        }
                                        else {
                                          price += parseFloat(localVariant.price);
                                        }
                                    }
                                    localNewPrice.push({id: idCurrentQuotingOrder, price: price, discountPrice: 0});
                                }
                                else if (localVariant) {
                                    localNewPrice.push({id: idCurrentQuotingOrder, price: localVariant.price, discountPrice: 0});
                                }
                                else {
                                    localNewPrice.push({id: idCurrentQuotingOrder, price: 0, discountPrice: 0});
                                }
                            }
                        }

                        if(this.user.discount_percent > 0){
                            localNewPrice.forEach(itemNewPrice=>{
                                itemNewPrice.discountPrice = itemNewPrice.price - ((this.user.discount_percent/100)*itemNewPrice.price);
                            });
                        }
                        axios.post('/api/revalidate-item-quotation/'+localItemQuotation.id, localNewPrice).then((response)=>{
                            if(response.status == 200){
                                this.$store.dispatch('getQuotingOrders');
                            }
                        });
                        // console.log("MODIFICADO", localNewPrice, this.quotingOrder.blinds)
                    }
                });
            }
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
        emitClickCloseFromOrdersAndQuotationsDialog(){
            this.isOrdersAndQuotationsDialogActivated = false;
        }
    },

    props: {
        option: {
            type: String,
            required: true,
        }
    },

    components: {
        ItemOrder,
        ItemQuotation,
        DashboardOrdersAndQuotationsDialog
    }
}
</script>
