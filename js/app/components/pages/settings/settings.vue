<template>

  <div>

    <div v-if="loading === false">

      <h1 v-if="organisation.access !== 100">

        You are not allowed to view this page

      </h1>

      <div v-else>

        <h1>User management for {{ data.name }}</h1>


        <div
          v-for="(value, key) in data.users"
          :key="key"
          class="user-card"
        >
          <div class="field-set">
            <div class="field-title">
              <p>{{ value.user.firstName }} {{ value.user.lastName }}</p>
            </div>

            <div class="field-value">
              <custom-select
                v-model="value.access"
                :options="options"
                class="dropdown-less-height"
              />
            </div>
          </div>
          <button
            @click="updateUser($event, value.user.email, value.access)"
          >
            Update user
          </button>
        </div>

        <div
          class="user-card"
        >
          <button
            @click="createUser"
            style="display: block;margin: 10px auto;"
          >
            Invite user
          </button>

        </div>


      </div>

    </div>

    <div
      v-else
      class="full-screen-loading"
    >

      <p class="loading-text">

        <i class="fas fa-spinner fa-spin" /> Loading your settings

      </p>

    </div>




  </div>

</template>

<script>

  import api from '../../../store/axios';
  import events from '../../../consts/eventConsts';
  import Eventbus from '../../../event/Eventbus';
  import CustomSelect from "../../ui/customSelect.vue";

  export default {
      components: {CustomSelect},
      computed: {

          organisation () {

              return this.$store.getters.getProjects;

          }

      },

      data() {
          return {
              loading: true,
              data: [],
              options: [
                  {
                      value: 10
                  },
                  {
                      value: 50
                  },
                  {
                      value: 100
                  }
              ]
          }
      },
      created() {

          api(this.$store.state.token)
              .get('/' + this.$store.getters.getSelectedOrganisation + '/info')
              .then((res) => {
                  this.data = res.data.data;
                  this.loading = false;
              }).catch((res) => {
                  this.loading = false;
              });

      },
      methods: {

          createUser (e) {
              e.preventDefault();


              Eventbus.$emit(events.MODAL_REQUEST, {
                  modal: 'modalCreateUser',
                  payload: {},
                  callback() {}
              })

          },

          updateUser (e, email, access) {

              api(this.$store.state.token)
                  .put('/' + this.$store.getters.getSelectedOrganisation + '/user/update',{
                      email: email,
                      access: access
                  })
                  .then(() => {
                      this.showUpdateSuccess();
                  }).catch((res) => {

                      if (res.response.status === 400) {
                          this.showUpdateError({
                              title: res.response.data.data.property,
                              message: res.response.data.data.message
                          });
                      } else {
                          this.showUpdateError({
                              title: 'Unknown',
                              message: 'A unknown error occurred'
                          });
                      }
                  });

          }

      },

      notifications: {
          showUpdateSuccess: {
              title: 'Updated user',
              message: 'Access updated of user',
              type: 'success'
          },
          showUpdateError: {
              title: 'placeholder',
              message: 'placeholder-text',
              type: 'error'
          }
      }

  }

</script>

<style lang="scss">

  .user-card {
    width: 200px;
    padding: 5px;
    margin: 5px;
    background-color: #ffffff;
    border-radius: 5px;
    float: left
  }

</style>