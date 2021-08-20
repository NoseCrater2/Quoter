<template>
    <v-slide-group v-model="indexPositionColor"   show-arrows >
        <v-slide-item v-for="n in colors.length" :key="n" v-slot="{ }">
            <v-hover   v-slot="{ hover }">
                <v-card
                :class="{'selected':hover}"
                outlined
                tile
                @click="onClickItem(n-1)"
                @mouseenter="onMouseEnter(n-1)"
                class="ma-3"
                height="80"
                width="60">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs}">
                            <div>
                                <v-img  v-bind="attrs" v-on="on"   :aspect-ratio="16/9" height="80"  :src="`/img/modelos/medium/${type}/${manufacturer}/${colors[n-1].code}.jpg`">
                                    <template v-slot:placeholder>
                                        <v-img src="/img/modelos/medium-unavailable.jpg">
                                        </v-img>
                                    </template>
                                        <div
                                          v-if="hover"
                                          class="d-flex transition-fast-in-fast-out grey lighten-1 v-card--reveal"
                                          style="height: 100%; opacity: 0.6;"
                                        >
                                          <v-icon>mdi-magnify</v-icon>
                                        </div>
                                </v-img>
                            </div>
                        </template>
                        <span>{{ colors[n-1].color }}</span>
                    </v-tooltip>
                </v-card>
            </v-hover>
        </v-slide-item>
    </v-slide-group>
</template>

<script>
export default {
    data(){
        return{

        }
    },

    props: {
        colors:{
            type: Array,
        },
        type: {
            type: String,
        },
        manufacturer: {
            type: String,
        },
        indexPositionColor:{
            type: Number,
        }
    },

    methods:{
        onClickItem(event){
            this.$emit('openDialog', event)
            this.$emit('changeIndex', event)
        },
        onMouseEnter(event){
            this.$emit('changeIndex', event)
        },
    },
}
</script>
