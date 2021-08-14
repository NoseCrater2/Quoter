<template>
    <div class="v-btn--fixed v-btn--right contenedor">
        <div class="d-flex justify-center"  >
            <v-btn @click="onClickButton"  tile icon color="white" min-width="20" width="20" >
                <v-icon dark size="30">
                    mdi-email
                </v-icon>
            </v-btn>
        </div>

        <div class="d-flex justify-center">
            <v-btn  tile dark  color="#26d367" icon min-width="20" width="20" href="https://api.whatsapp.com/send?phone=5215548948279" target="_blank">
                <v-img src="/img/whatsapp.png" width="30"></v-img>
            </v-btn>
        </div>

        <!-- <div  class="d-flex justify-center">
            <v-btn tile dark color="#0084ff" icon min-width="20" width="20" >
                <v-img src="/img/facebook-messenger.png" width="30"></v-img>
            </v-btn>
        </div> -->
    </div>
</template>

<script>
export default {
   methods: {
     onClickButton (event) {
        this.$emit('clicked', true)
     }
   }
}
</script>

<style scoped>

.contenedor{
    margin-top: 300px;
    margin-right: -20px;
    z-index:5;
    border-radius: 15px 0px 0px 15px;
    min-width: 24px;
    width: 50px;
    height: 72px;
    background-color:#47a5ad;
}

</style>
