<template>
    <v-hover  v-slot="{ hover }">
        <v-btn rounded :outlined="hover?false:true" :style="hover?'color: white':''"  style="font-size:0.70em; font-weight: bolder;" block color="#47a5ad"
        @click="chooseRoute(line)">
            {{line.name}}
        </v-btn>
    </v-hover>
    <!-- <v-hover v-slot="{ hover }">
        <v-card height="340" width="380" class="ma-4" @click="chooseRoute(line)">
            <v-img class="white--text align-end"  :class="{'escalada':hover}" width="390" height="340" :aspect-ratio="16/9"  :src="image(line.slug)"  :gradient="hover?'rgba(71, 165, 173, 0.7) 100%, transparent 72px':''"  >
            <template v-slot:placeholder>
                <v-img src="/img/modelos/medium-unavailable.jpg"></v-img>
            </template>
                <v-slide-y-reverse-transition>
                    <div v-if="!hover" class="title d-flex transition-fast-in-fast-out justify-center"  >
                        <h3 class="text-center">{{ line.name}}</h3>
                    </div>
                </v-slide-y-reverse-transition>
                <v-slide-x-transition>
                    <div
                    v-if="hover"
                    class="d-flex transition-fast-in-fast-out  v-card--reveal white--text"
                    style="height: 100%;"
                    >
                        <v-hover v-slot="{ hover }">

                            <v-btn @click="chooseRoute(line)" :outlined="!hover" depressed  tile color="white" >
                                {{ line.name }}
                            </v-btn>
                          </v-hover>
                    </div>
                </v-slide-x-transition>
                <v-expand-transition>
                    <div
                   v-if="hover"
                    class="d-flex transition-fast-in-fast-out  v-card--reveal white--text"
                    style="height: 20%;"
                    >
                        <v-btn   title dark color="transparent" depressed>
                            <v-icon size="35" class="mr-4" left>mdi-plus-circle-outline</v-icon>Ver más
                        </v-btn>
                    </div>
                </v-expand-transition>
            </v-img>
        </v-card>
    </v-hover> -->
</template>

<script>
export default {
    props: {
        line: Object,
        type: Object,

    },

    mounted(){

    },

    methods: {

    },

    computed: {

    },

    methods:{
        image(slug){
            try {
                return "/img/lineas/"+this.type.slug+'-'+slug+".jpg"
            } catch (error) {
                return "/img/modelos/medium/unavailable.jpg"
            }
        },

        chooseRoute(line){
            if(this.type.product_id === 3 || this.type.product_id === "3"){
                this.$router.replace({name: 'Modelos', params: {slugType:  this.type.slug, slugLine: line.slug}})
            }else if(this.type.weaves.length > 0){
                 this.$router.replace({name: 'Tejidos', params: {slugLine: line.slug}})
            }else{
                this.$router.replace({name: 'Products', params: {slugLine: line.slug}})
            }
        }
    }
}
</script>
