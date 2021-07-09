<template>
    <v-hover v-slot="{ hover }">
        <v-card height="340" width="380" class="ma-4" > 
            <v-img class="white--text align-end"  :class="{'escalada':hover}" width="390" height="340" :aspect-ratio="16/9"  :src="image(model.slug)"  :gradient="hover?'rgba(71, 165, 173, 0.7) 100%, transparent 72px':''"  >
            <template v-slot:placeholder>
                <v-img src="/img/modelos/medium-unavailable.jpg"></v-img>
            </template>
                <v-slide-y-reverse-transition>
                    <div v-if="!hover" class="title d-flex transition-fast-in-fast-out justify-center"  > 
                        <h3 class="text-center">{{ model.name}}</h3> 
                    </div> 
                </v-slide-y-reverse-transition>
                <v-slide-x-transition>
                    <div
                    v-if="hover"
                    class="d-flex transition-fast-in-fast-out  v-card--reveal white--text"
                    style="height: 100%;"
                    >
                        <v-hover v-slot="{ hover }">
                            <v-btn
                            :to="{name: 'TejidosToldos'}"
                            :outlined="!hover" depressed  tile color="white" >
                                {{ model.name }}
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
    </v-hover>
</template>
<script>
export default {
    props: {
        model: Object,        
    },

    methods:{
        image(slug){
            try {
                return "/img/weaves/"+slug+".jpg"
            } catch (error) {
                return "/img/modelos/medium/unavailable.jpg"
            }
        }
    }
}
</script>