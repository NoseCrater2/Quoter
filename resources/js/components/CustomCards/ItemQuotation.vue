<template>
    <v-hover v-slot="{ hover }">
        <v-card min-width="240" max-width="303" :flat="hover?false:true"  :outlined="hover?false:true" :class="hover?'grow':''">
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
                            <v-list-item dense link>
                                <v-list-item-icon>
                                    <v-icon >mdi-clipboard-list</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Ver detalles</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item dense link>
                                <v-list-item-icon>
                                    <v-icon >mdi-cart</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Agregar al carrito</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item dense link>
                                <v-list-item-icon>
                                    <v-icon >mdi-pencil</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>Ver en cotizador</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item dense link>
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
                <h3 style="color: #3ba2a9">R140821/100</h3>
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
                        <span style="font-size: 1.5rem" class="font-weight-bold">
                           {{mxCurrencyFormat.format(item.total)}}
                        </span>
                        <span class="text-center">MXN</span>
                    </v-col>
                </v-list-item-content>
            </v-list-item>
            <v-card-actions >
                <v-btn small outlined rounded text @click="openDetailsDialog(item.id)">Ver Detalles</v-btn>
                <v-spacer></v-spacer>
                <v-btn small rounded color="#f99404" class="white--text">
                    <v-icon left>mdi-cart</v-icon>
                    Comprar
                </v-btn>
            </v-card-actions>
            <v-card-text class="pa-2 text-center" >
                <v-chip small label style="width: 100%" class="d-flex justify-center">
                    VIGENCIA 22/08/2021
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
        </v-card>
    </v-hover>
</template>

<script>
export default {
    data(){
        return {
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
        }
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
        z-index: 160 !important;
        transform: translateY(-2px) !important;
    }
</style>