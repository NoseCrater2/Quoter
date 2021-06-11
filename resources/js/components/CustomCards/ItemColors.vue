<template>
     <v-item-group v-model="selected" @change="onClickItem(selected)">
        <v-row >
            <v-col
            cols="2"
            v-for="n in colors.length" :key="n">
                <v-item v-slot="{ active, toggle}" >
                    <v-card
                    outlined
                    tile
                    class="d-flex"
                    height="20"
                    width="20"
                    @click="toggle"
                    >
                       <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs}">
                                <div :class="{'selected':active}" v-bind="attrs" v-on="on">
                                    <v-img  :aspect-ratio="16/9" height="20"  width="20" :src="`/img/modelos/tumb/${type}/${manufacturer}/${colors[n-1].code}.jpg`">
                                         <template v-slot:placeholder>
                                             <v-img src="/img/modelos/thumb-unavailable.jpg"></v-img>
                                         </template>
                                    </v-img>
                                </div>
                            </template>
                            <span>{{ colors[n-1].color }}</span>
                        </v-tooltip>   
                    </v-card>
                </v-item>
            </v-col>
        </v-row>
    </v-item-group>
</template>

<script>
export default {
    data(){
        return {
            selected: 0,
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
        }
    },

    mounted(){
        console.log(this.type)
    },

    methods:{
        onClickItem(event){
            this.$emit('changeIndex', event)
        },
    }
}
</script>