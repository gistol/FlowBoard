<template>

    <div>

        <sidebar />

        <div class="bootstrap-wrapper" style="width: calc(100% - 250px);margin-left: 250px;">
          <router-view />
        </div>


        <modal-loader />

    </div>

</template>

<script>

    import sidebar from './components/general/sidebar.vue';
    import ModalLoader from "./components/modals/modalLoader.vue";

    export default {
        components: {
            ModalLoader,
            sidebar
        }
    }

</script>