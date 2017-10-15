<template></template>
<script>
    import CryptoJS from 'crypto-js';
    import { CryptoJSAesJson } from '@helpers';
    export default {
        props: ['data'],
        created() {
           try {
               var decrypted = JSON.parse(CryptoJS.AES.decrypt(this.data, document.head.querySelector('meta[name="csrf-token"]').content, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
               this.$store.commit('login', decrypted);
           } catch (e) {
               console.log(e);
           }

        }
    }
</script>