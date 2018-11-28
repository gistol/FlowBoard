<template>

    <div>

        <sidebar />

        <div class="bootstrap-wrapper" style="width: calc(100% - 250px);margin-left: 250px;">
          <router-view />
        </div>


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