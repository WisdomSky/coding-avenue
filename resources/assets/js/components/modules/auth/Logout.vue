<template>
   <div>

   </div>
</template>

<script>
    import { Loading } from 'element-ui';
    import { AuthService } from '@services';

    export default {
        mounted() {
            let loadingInstance = Loading.service({ fullscreen: true, text: this.$t('message.loggingOut') });
            AuthService.logout()
                .subscribe(() => {},
                 () => {
                    this.$router.back();
                    loadingInstance.close();
                });
        }
    }
</script>
