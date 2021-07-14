<template>
<div>
    <v-container fluid style="max-width: 1200px;" class="my-4">
        <v-row justify="space-between">
            <v-col md="3" sm="12" :style="(isMobile && $vuetify.breakpoint.width > 779) ? 'background-color: white; position: sticky; top: 84px; z-index: 2;' : (isMobile && $vuetify.breakpoint.width < 780) ? 'background-color: white; position: sticky; top: 56px; z-index: 2;' : '' ">
                <!-- MENU INICIA -->
                 <v-row :style="!isMobile ? 'position: sticky; top: 77px': ''">
                <v-col class="line" cols="12" md="12" sm="12">
                  <v-list dense flat subheader v-if="types && !isMobile">
                    <v-subheader>TOLDO</v-subheader>
                    <v-list-item-group
                        v-model="type"
                        mandatory>
                      <v-list-item
                      dense
                      v-for="type in types.types"
                      :key="type.id"
                      :value="type.slug"
                      style="min-height: 20px;height:20px"
                      >
                        <template v-slot:default="{ active }">
                          <v-list-item-action>
                            <v-checkbox
                            dense
                            :input-value="active"
                            color="#47a5ad"
                            ></v-checkbox>
                          </v-list-item-action>
                          <v-list-item-content class="pa-0">
                            <v-list-item-title>{{ type.name }}</v-list-item-title>
                          </v-list-item-content>
                        </template>
                        </v-list-item>
                      </v-list-item-group>
                    </v-list>

                    <v-menu offset-y v-if="types && isMobile">
                      <template v-slot:activator="{attrs, on}">
                        <v-btn v-bind="attrs" v-on="on" text color="#47a5ad" block>
                          TOLDO: {{selectedType }}
                          <v-icon right>mdi-chevron-down</v-icon>
                        </v-btn>
                      </template>
                       <v-list  dense flat>
                      <v-list-item-group
                      mandatory
                      v-model="type">
                        <v-list-item
                        :value="type.slug"
                        dense
                        v-for="type in types.types"
                        :key="type.id"
                        >
                          <template v-slot:default="{ active }">
                            <v-list-item-action>
                              <v-checkbox
                              dense
                              :input-value="active"
                              color="#47a5ad"
                              ></v-checkbox>
                            </v-list-item-action>
                            <v-list-item-content>
                              <v-list-item-title>{{ type.name }}</v-list-item-title>
                            </v-list-item-content>
                          </template>
                        </v-list-item>
                      </v-list-item-group>
                    </v-list>
                    </v-menu>
                    <v-divider></v-divider>

                    <v-list dense flat subheader v-if="getType && !isMobile" color="transparent">
                      <v-subheader>LÍNEA</v-subheader>
                      <v-list-item-group
                      mandatory
                      v-model="line">
                        <v-list-item
                        :value="line.slug"
                        dense
                        v-for="line in getType.lines"
                        :key="line.id"
                        style="min-height: 20px;height:20px">
                          <template v-slot:default="{ active }">
                            <v-list-item-action>
                              <v-checkbox
                              dense
                              :input-value="active"
                              color="#47a5ad"
                              ></v-checkbox>
                            </v-list-item-action>
                            <v-list-item-content class="pa-0">
                              <v-list-item-title>{{ line.name }}</v-list-item-title>
                            </v-list-item-content>
                          </template>
                        </v-list-item>
                      </v-list-item-group>
                    </v-list>
                    <v-menu offset-y v-if="getType && isMobile">
                      <template v-slot:activator="{attrs, on}">
                        <v-btn v-bind="attrs" v-on="on" text color="#47a5ad" block>
                          LINEA: {{ selectedLine }}
                          <v-icon right>mdi-chevron-down</v-icon>
                        </v-btn>
                      </template>
                       <v-list  dense flat>
                      <v-list-item-group
                      mandatory
                      v-model="line">
                        <v-list-item
                        :value="line.slug"
                        dense
                        v-for="line in getType.lines"
                        :key="line.id"
                        >
                          <template v-slot:default="{ active }">
                            <v-list-item-action>
                              <v-checkbox
                              dense
                              :input-value="active"
                              color="#47a5ad"
                              ></v-checkbox>
                            </v-list-item-action>
                            <v-list-item-content>
                              <v-list-item-title>{{ line.name }}</v-list-item-title>
                            </v-list-item-content>
                          </template>
                        </v-list-item>
                      </v-list-item-group>
                    </v-list>
                    </v-menu>
                    <v-divider></v-divider>

                    <v-list  dense flat subheader v-if="subweaves && !isMobile" color="transparent">
                        <v-subheader>MODELO</v-subheader>
                        <v-list-item-group
                        mandatory
                        v-model="subweave">
                          <v-list-item
                          :value="subweave.slug"
                          dense
                          v-for="subweave in subweaves"
                          :key="subweave.id"
                          style="min-height: 20px;height:20px">
                            <template v-slot:default="{ active }">
                                <v-list-item-action>
                                    <v-checkbox
                                    dense
                                    :input-value="active"
                                    color="#47a5ad"
                                    ></v-checkbox>
                                </v-list-item-action>
                                <v-list-item-content class="pa-0" >
                                    <v-list-item-title>{{ subweave.name }}</v-list-item-title>
                                </v-list-item-content>
                            </template>
                          </v-list-item>
                        </v-list-item-group>
                    </v-list>
                    <v-menu offset-y v-if="subweaves && isMobile">
                      <template v-slot:activator="{attrs, on}">
                        <v-btn v-bind="attrs" v-on="on" text color="#47a5ad" block>
                          MODELO: {{ selectedSubweave }}
                          <v-icon right>mdi-chevron-down</v-icon>
                        </v-btn>
                      </template>
                       <v-list  dense flat>
                      <v-list-item-group
                      mandatory
                      v-model="subweave">
                        <v-list-item
                        :value="subweave.slug"
                        dense
                        v-for="subweave in subweaves"
                        :key="subweave.id"
                        >
                          <template v-slot:default="{ active }">
                            <v-list-item-action>
                              <v-checkbox
                              dense
                              :input-value="active"
                              color="#47a5ad"
                              ></v-checkbox>
                            </v-list-item-action>
                            <v-list-item-content>
                              <v-list-item-title>{{ subweave.name }}</v-list-item-title>
                            </v-list-item-content>
                          </template>
                        </v-list-item>
                      </v-list-item-group>
                    </v-list>
                    </v-menu>
                    <v-divider></v-divider>

                    <v-list  dense flat subheader v-if="weaves && !isMobile" color="transparent">
                        <v-subheader>TEJIDO</v-subheader>
                        <v-list-item-group
                        mandatory
                        v-model="weave">
                          <v-list-item
                          :value="weave.slug"
                          dense
                          v-for="weave in weaves.weaves"
                          :key="weave.id"
                          style="min-height: 20px;height:20px">
                            <template v-slot:default="{ active }">
                                <v-list-item-action>
                                    <v-checkbox
                                    dense
                                    :input-value="active"
                                    color="#47a5ad"
                                    ></v-checkbox>
                                </v-list-item-action>
                                <v-list-item-content class="pa-0" >
                                    <v-list-item-title>{{ weave.name }}</v-list-item-title>
                                </v-list-item-content>
                            </template>
                          </v-list-item>
                        </v-list-item-group>
                    </v-list>

                    <v-menu offset-y v-if="weaves && isMobile" >
                      <template v-slot:activator="{attrs, on}">
                        <v-btn
                        v-bind="attrs"
                        v-on="on"
                        text
                        color="#47a5ad"
                        block>
                          TEJIDO: {{ selectedWeave }}
                          <v-icon right>mdi-chevron-down</v-icon>
                        </v-btn>
                      </template>
                       <v-list  dense flat>
                      <v-list-item-group
                      mandatory
                      v-model="weave">
                        <v-list-item
                        :value="weave.slug"
                        dense
                        v-for="weave in weaves.weaves"
                        :key="weave.id"
                        >
                          <template v-slot:default="{ active }">
                            <v-list-item-action>
                              <v-checkbox
                              dense
                              :input-value="active"
                              color="#47a5ad"
                              ></v-checkbox>
                            </v-list-item-action>
                            <v-list-item-content class="pa-0">
                              <v-list-item-title>{{ weave.name }}</v-list-item-title>
                            </v-list-item-content>
                          </template>
                        </v-list-item>
                      </v-list-item-group>
                    </v-list>
                    </v-menu>
                    <v-divider></v-divider>


                </v-col>
                 </v-row>
                 <!-- MENU TERMINA -->
            </v-col>
            <v-col cols="12" md="9" sm="12" >
                <v-data-iterator
                :items="products"
                :items-per-page="18"
                :page="parseInt(page)"
                :search="search"
                hide-default-footer
                no-data-text="No hay toldos disponibles">
                    <template v-slot:header>
                      <v-row class="mt-2" justify="space-between">
                          <v-btn class="ml-8" fab dark depressed color="white" small @click="formerPage()">
                              <v-icon color="black">mdi-chevron-left</v-icon>
                          </v-btn>
                          <v-spacer></v-spacer>
                          <span class="mt-2 grey--text"> Página {{page}} de {{numberOfPages}}</span>
                          <v-spacer></v-spacer>
                          <v-btn class="mr-8" depressed fab dark color="white" small @click="nextPage()">
                              <v-icon color="black">mdi-chevron-right</v-icon>
                          </v-btn>

                      </v-row>

                    </template>
                    <template v-slot:default="props">
                        <v-row>
                            <v-col style="justify-content: center; display: flex;" v-for="item in props.items" :key="item.name" cols="12" md="4" sm="6">
                                <v-hover v-slot="{ hover }" v-if="item">
                            <v-card width="240"  color="grey lighten-4"  flat :to="{name: 'Details', params: {slugWeave:item.weave.slug, slugDetail: item.id.toString()}}">
                              <v-img
                              class="white--text align-end"
                              :class="{'escalada':hover}"
                              width="240" height="270"
                              :aspect-ratio="16/9"
                              :src="`/img/modelos/medium/${item.type.slug}/${item.line.slug}/${item.image}.jpg`"
                              :gradient="hover?'rgba(71, 165, 173, 0.7) 100%, transparent 72px':''"  >
                                <template v-slot:placeholder>
                                  <v-img src="/img/modelos/generic-sunwave.png"></v-img>
                                </template>
                                <!-- <v-slide-y-reverse-transition>

                                </v-slide-y-reverse-transition> -->
                                <v-slide-x-transition>
                                  <div
                                  v-if="hover"
                                  class="d-flex transition-fast-in-fast-out  v-card--reveal white--text "
                                  style="height: 40%;">
                                    <v-hover v-slot="{ hover }">
                                      <v-btn :to="{name: 'Details', params: {slugWeave:item.weave.slug, slugDetail: item.id.toString()}}" depressed :outlined="!hover" tile color="white"  small>Detalles del producto</v-btn>
                                    </v-hover>
                                  </div>
                                </v-slide-x-transition>
                              </v-img>
                              <v-card-title  class="title-weave d-flex justify-center ">
                                    <b class="text-center" style="font-size: 12px; line-height: 20px; color: #47a5ad" >
                                      {{ item.name}}
                                    </b>
                              </v-card-title>
                              <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                target="_blank"
                                :href="`https://api.whatsapp.com/send?phone=5215548948279?&amp;text=Hola+quiero+saber+el+precio+del+toldo+${item.name}`"
                                color="#47a5ad"
                                tile
                                depressed
                                outlined
                                small>
                                  PREGUNTAR POR PRECIO
                                </v-btn>
                                <v-spacer></v-spacer>
                              </v-card-actions>
                            </v-card>
                          </v-hover>
                            </v-col>
                        </v-row>
                    </template>
                    <template v-slot:footer="pagination">
                      <div style="display: none">
                          {{pagination.options.page = page }}
                      </div>
                      <v-row
                      class="my-4"
                      align="center"
                      justify="center">
                       <v-btn
                       small
                        fab
                        dark
                        depressed
                        color="white"
                        class="ml-8"
                        @click="formerPage()">
                          <v-icon color="black">mdi-chevron-left</v-icon>
                        </v-btn>
                        <v-spacer></v-spacer>
                        <span class="mr-4 grey--text"> Página {{page}} de {{numberOfPages}}</span>
                        <v-spacer></v-spacer>
                         <v-btn
                         small
                        depressed
                        fab
                        dark
                        color="white"
                        class="mr-8"
                        @click="nextPage()">
                          <v-icon color="black">mdi-chevron-right</v-icon>
                        </v-btn>
                      </v-row>
                    </template>
                </v-data-iterator>
                <!-- <v-btn fab small icon bottom absolute color="white">
                    <v-icon>mdi-arrow-down</v-icon>
                  </v-btn> -->
            </v-col>
        </v-row>
    </v-container>
</div>
</template>

<script>
export default {
    data(){
        return{
            selectedWeave: this.slugWeave,
            selectedSubweave: this.slugSubweave,
            selectedLine: this.slugLine,
            selectedType: this.slugType,
            isMobile: false,
            productName: null,
            selectedIndex: 1,
            isMobile:false,
            dialog: false,
            model: null,
            search: '',
            filter: {},
            sortDesc: false,
            page: this.$route.query.page || 1,
            itemsPerPage: 18,
            sortBy: 'price',
            keys: [
              {name: 'Nombre', attribute: 'name'},
              {name: 'Precio', attribute: 'price'},
              {name: 'Rotable', attribute: 'rotate'}
            ],
            orderKeys: [
              {name: 'Ascendente', attribute: false},
              {name: 'Descendente', attribute: true}
            ],
        }
    },
    mounted(){
        this.onResize()
        window.addEventListener('resize', this.onResize, { passive: true })
    },

    methods: {
        nextPage(){
            this.page = parseInt(this.page)
            if(this.page + 1 <= this.numberOfPages){
                this.page += 1
                this.$router.push({query: {...this.$route.query, page: this.page}})
            }
        },
        formerPage(){
            this.page = parseInt(this.page)
            if(this.page - 1 >= 1){
                this.page -= 1
                this.$router.push({query: {...this.$route.query, page: this.page}})
            }
        },

        updateItemsPerPage(number){
            this.itemsPerPage = number
        },

        onResize(){
            this.isMobile = window.innerWidth < 958
        },
    },

    computed:{
        numberOfPages(){
            return Math.ceil(this.products.length / this.itemsPerPage)
        },
        weave: {
	        get: function() {
                return this.slugWeave
            },
	        set: function(newValue) {
                this.selectedWeave = newValue
	        }
	    },

        subweave: {
	        get: function() {
                return this.slugSubweave
            },
	        set: function(newValue) {
                this.selectedSubweave = newValue
	        }
	    },

        line: {
	        get: function() {
                return this.slugLine
            },
	        set: function(newValue) {
                this.selectedLine = newValue
	        }
	    },
        type: {
            get: function () {
                return this.slugType
            },
            set: function(newValue) {
                this.selectedType = newValue
	        }
        },

        weaves(){
            return this.$store.state.productsModule.subweaves.find(sw => sw.line.slug === this.selectedLine && sw.type.slug === this.selectedType && sw.slug === this.selectedSubweave)
        },
        subweaves(){
            return this.$store.state.productsModule.subweaves.filter(sw => sw.line.slug === this.selectedLine && sw.type.slug === this.selectedType && sw.slug)
        },

        getType(){
            if(this.$store.getters.getTypes(this.slugProduct)){
                return this.$store.getters.getTypes(this.slugProduct).types.find(type => type.slug === this.selectedType)
            }
        },

        types(){
            return  this.$store.getters.getTypes(this.slugProduct)
        },

        products(){
          return this.$store.state.productsModule.variants.filter((variant) => variant.type.slug === this.selectedType && variant.line.slug === this.selectedLine && variant.weave.slug === this.selectedWeave && variant.subweave.slug === this.selectedSubweave)
        },

    },

    props:{
        slugLine: {
            type: String,
            required: false,
        },
        slugType: {
            type: String,
            required: true,
        },
        slugProduct: {
            type: String,
            required: true,
        },
        slugWeave:{
            type: String,
            required: false,
        },
        slugSubweave:{
            type: String,
            required: false,
        }
    },

}
</script>

<style>
.hide-scroll::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.hide-scroll {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
.v-card--reveal {
align-items: center;
bottom: 0;
justify-content: center;
position: absolute;
width: 100%;

}

.title-weave{
  text-align: center;
  padding: 5px;
  word-break: break-word !important;
  line-height: 12px;
  font-size: 12px !important;
}

.escalada{
   transform: scale(1.02);
    -moz-transform: scale(1.02);
    -webkit-transform: scale(1.02);
    -o-transform: scale(1.02);
    -ms-transform: scale(1.02);
    transition-duration: 0.5s;
}
</style>
