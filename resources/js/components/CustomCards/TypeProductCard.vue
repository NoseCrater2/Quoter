<template>
    <v-hover v-slot="{ hover }">
        <v-card :width="$vuetify.breakpoint.mobile?'330':'420'" height="300" color="grey lighten-4"  flat :to=" type.lines > 0?{name: 'Lines', params: {slugType: type.slug }}:{name: 'Products', params: {slugType: type.slug}}" >
            <v-img class="white--text align-end"  :class="{'escalada':hover}" width="420" height="300" :aspect-ratio="16/9"  :src="`/img/tipos/${type.slug}.jpg`" :gradient="hover?'rgba(71, 165, 173, 0.7) 100%, transparent 72px':''"  >
                <v-slide-y-reverse-transition>
                    <div v-if="!hover" class="title d-flex transition-fast-in-fast-out justify-center"  > 
                        <h4 class="text-center">{{ type.name}}</h4> 
                    </div> 
                </v-slide-y-reverse-transition>
                <v-slide-x-transition>
                    <div
                    v-if="hover"
                    class="d-flex transition-fast-in-fast-out  v-card--reveal white--text"
                    style="height: 100%;"
                    >
                        <v-hover v-slot="{ hover }">
                            <v-btn :to="type.lines > 0?{name: 'Lines', params: {slugType: type.slug}}:{name: 'Products', params: {slugType: type.slug}}" depressed :outlined="!hover" tile color="white" >
                                {{type.name}}
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
        type: {
            type: Object,
            required: true,
        }
    }
}
</script>