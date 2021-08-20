<template>
    <v-hover v-slot="{ hover }">
        <v-card width="303" :color="hover?'#3ba2a9':'white'"  :dark="hover?true:false" >
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-subtitle>
                        {{item.blinds}} PERSIANA(S)
                    </v-list-item-subtitle>
                    <v-list-item-title style="font-size: 1.15rem; font-weight: bold">
                        Orden recibida
                    </v-list-item-title>
                </v-list-item-content>
                <v-list-item-avatar tile size="67">
                    <v-icon size="67" :color="hover?'white':'#3ba2a9'" >
                       mdi-clipboard-check
                    </v-icon>
                    <!-- <v-icon size="67" :color="hover?'white':'#CDDC39'"  v-else-if="item.state=='Orden en proceso'">
                       mdi-progress-wrench
                    </v-icon>
                    <v-icon size="67" :color="hover?'white':'#8BC34A'"  v-else-if="item.state=='Orden en envío'">
                       mdi-truck-fast
                    </v-icon>
                    <v-icon size="67" :color="hover?'white':'#4CAF50'"  v-else-if="item.state=='Orden entregada'">
                       mdi-truck-check
                    </v-icon> -->
                </v-list-item-avatar>
            </v-list-item>

            <v-list-item>
                <v-list-item-content class="mx-n3">
                        <v-col cols="3">
                            <div>
                                <v-badge
                                  class="mb-n2 font-weight-bold isHoverBadge"
                                  :content="item.blinds"
                                  :value="item.blinds"
                                  :color="hover?'white':'#3ba2a9'"
                                  overlap
                                  :offset-x="item.blinds > 9 ? '39' : '37'"
                                  offset-y="28"
                                >
                                  <v-icon :color="hover?'white':'#3ba2a9'" size="55">
                                    mdi-blinds
                                  </v-icon>
                                </v-badge>
                            </div>
                        </v-col>
                        <v-col cols="9" class="text-right">
                            <span style="font-size: 2rem" class="font-weight-bold">
                               {{mxCurrencyFormat.format(item.total)}}
                            </span>
                            <span class="text-center">MXN</span>
                        </v-col>
                </v-list-item-content>
            </v-list-item>
            <v-card-actions class="ml-n2">
                <v-btn outlined rounded text @click="openDetailsDialog(item.id)">Ver Detalles</v-btn>
                <v-spacer></v-spacer>
                <v-chip color="white" text-color="black">
                    <v-avatar left class="green" >
                      
                    </v-avatar>
                        Entregada
                </v-chip>
            </v-card-actions>
            <!-- <v-col v-if="item.user" cols="12" class="text-end mt-n9">
                <v-icon size="17">mdi-account</v-icon><span class="mb-4 caption">{{item.user}}</span>
            </v-col> -->
            <!-- <v-list-item class="mb-n4">
                <v-list-item-content class="mx-n4">
                    <v-col cols="6">
                        <v-row>
                            <v-col cols="3">
                                <v-icon>mdi-calendar-check</v-icon>
                            </v-col>
                            <v-col cols="9">
                                <span class="subtitle-2">Fecha de pedido</span>
                                <div class="caption">
                                    {{item.created_at}}
                                </div>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-divider vertical></v-divider>
                    <v-col cols="6">
                        
                    </v-col>
                </v-list-item-content>
            </v-list-item> -->
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