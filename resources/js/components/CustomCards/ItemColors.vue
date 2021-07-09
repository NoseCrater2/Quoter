<template>
     <v-item-group v-model="selected" @change="onClickItem(selected)">
                <v-item v-for="n in colors.length" :key="n" v-slot="{ active, toggle}" class="ma-2">
                    <v-avatar
                    :color="active?'#EEEEEE':'white'"
                    size="60" :style="active?'box-shadow: 0px 0px 5px 2px gray;':''"
                    >
                       <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs}">
                                <v-avatar size="50" @click="toggle" v-bind="attrs" v-on="on"  style="box-shadow: 0px 0px 2px 1px gray" >
                                    <v-img  :src="`/img/modelos/tumb/${type}/${manufacturer}/${colors[n-1].code}.jpg`">
                                         <template v-slot:placeholder>
                                             <v-img src="/img/modelos/tumb-unavailable.jpg"></v-img>
                                         </template>
                                    </v-img>
                                </v-avatar>
                            </template>
                            <span>{{ colors[n-1].color }}</span>
                        </v-tooltip>   
                    </v-avatar>
                </v-item>

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

    methods:{
        onClickItem(event){
            this.$emit('changeIndex', event)
        },
    }
}
</script>