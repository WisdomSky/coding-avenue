<template>
    <img ref="avatar" :src="user.avatar_url" alt="">
</template>

<script>

    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },
    }
</script>