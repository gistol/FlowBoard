<template>

    <div>

        <sidebar />

        <router-view style="margin-left: 250px;" />

    </div>

</template>

<script>

    import sidebar from './components/general/sidebar.vue';

    export default {

        components: {

            sidebar

        }

    }

</script>