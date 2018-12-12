<template>

  <div class="welcome-screen">

    <h1>

      Welcome to organisation {{ selectedOrganisation }}

    </h1>

    <p>
      You can change your organisation settings in the settings page.
    </p>
    <p>

      To choose a different project click <a href="#" @click="clearLocal">here</a>

    </p>


  </div>


</template>

<script>
    export default {
        computed: {

            selectedOrganisation() {
                return this.$store.getters.getSelectedOrganisation;
            }

        },
        methods: {

            clearLocal(e) {

                e.preventDefault();


                localStorage.removeItem('selected-org');

                window.location.reload();


            }

        }
    }

</script>

<style lang="scss">

  .welcome-screen {

      text-align: center;

  }

</style>