<template>
    <v-dialog :value="true" fullscreen>
        <iframe height="100%" width="100%" :src="urlPayment"></iframe>
    </v-dialog>
</template>

<script>
export default {
    props: ['urlPayment']
}
</script>

<style>

</style>
