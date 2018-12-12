<template>

    <div>

        <div
          v-if="selectedOrganisation === null"
          class="onboarding"
        >

          <img
            class="logo"
            src="/img/logo-light.svg"
            alt="logo-light"
          >

          <p>Select a project to continue</p>

          <div class="organisations-container">

            <div
              v-for="(value, key) in organisations"
              :key="key"
              class="organisation-tile"
              @click="selectOrg($event, value.name)"
            >
              <b>{{ value.name }}</b> <br><br>{{ value['user_count'] }} users
            </div>

            <div
              class="organisation-tile"
              @click="createOrg"
            >
              <i class="fa fa-plus-circle" /> New organisation
            </div>

          </div>

        </div>

        <sidebar
          v-if="selectedOrganisation !== null"
        />

        <div
          v-if="selectedOrganisation !== null"
          class="bootstrap-wrapper"
        >
          <router-view />
        </div>


        <modal-loader />

    </div>

</template>

<script>


    import Eventbus from './event/Eventbus';
    import events from './consts/eventConsts';
    import mutations from './consts/mutationConsts';
    import sidebar from './components/general/sidebar.vue';
    import ModalLoader from "./components/modals/modalLoader.vue";

    export default {
        components: {
            sidebar,
            ModalLoader
        },
        computed: {

            selectedOrganisation() {
                return this.$store.getters.getSelectedOrganisation;
            },

            organisations() {
                return this.$store.getters.getOrganisations;
            }

        },
        created () {

            if (localStorage.getItem('selected-org')) {
                this.$store.commit(mutations.SET_ORGANISATION, localStorage.getItem('selected-org'));
            } else {
                this.$store.dispatch(mutations.GET_ORGANISATIONS);
            }

        },
        methods: {

            selectOrg (e, org) {

                e.preventDefault();

                this.$store.commit(mutations.SET_ORGANISATION, org);

                localStorage.setItem('selected-org', org);

            },

            createOrg (e) {

                e.preventDefault();

                Eventbus.$emit(events.MODAL_REQUEST, {
                    modal: 'modalCreateOrg',
                    payload: {},
                    callback() {}
                });

            }

        }
    }

</script>

<style lang="scss">

  .bootstrap-wrapper {

      width: calc(100% - 250px);margin-left: 250px;

  }

  .onboarding {


      position: absolute;

      top: 0;
      left: 0;

      width: 100%;
      height: 100%;

      background-color: #1C2158;
      color: #ffffff;

      text-align: center;

      .logo {

          display: block;
          margin: 50px auto;
          max-width: 300px;

      }

      .organisations-container {

          display: block;
          margin: 0 auto;
          max-width: 250px;

          .organisation-tile {

            cursor: pointer;
            background-color: #ffffff;
            color: black;
            padding: 25px;
            width: 240px;
            border-radius: 4px;
            margin: 5px;

            &:hover {

                background-color: #005FEA;
                color: #ffffff;

            }

          }

      }

  }

</style>