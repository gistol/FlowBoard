<template>

  <modal
    :close="close"
  >

    <div slot="header">

      <h3>Invite User</h3>

    </div>

    <div slot="body" >

      <div class="issue-content" v-if="!loading">

        <p
          v-if="error !== null"
          class="error-box"
        >
          {{ error }}
        </p>

        <div
          class="field-set"
        >
          <div class="field-title">
            <p>email</p>
          </div>

          <div class="field-value">
            <input
              v-model="email"
            >
          </div>
        </div>

        <div
          class="field-set"
        >
          <div class="field-title">
            <p>access</p>
          </div>

          <div class="field-value">
            <custom-select
              v-model="access"
              :options="options"
              class="dropdown-less-height"
            />
          </div>
        </div>

        <button
          @click="createUser($event)"
        >
          Invite user
        </button>

      </div>

      <div
        v-else
        class="loading"
      >
        <p class="loading-text">

          <i class="fas fa-spinner fa-spin" /> Loading...

        </p>
      </div>

    </div>

  </modal>

</template>
<script>
    import api from '../../store/axios';
    import Modal from "../ui/modal.vue";
    import CustomSelect from "../ui/customSelect.vue";

    export default {
        components: {
            Modal,
            CustomSelect
        },
        props: {
            update: {
                type: Function,
                default: () => {
                    return 0;
                }
            },
            payload: {
                type: Object,
                default() {}
            },
            close: {
                type: Function,
                default: () => {
                    return 0;
                }
            }
        },
        data () {
            return {
                loading: false,
                error: null,
                email: '',
                access: 10,
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
        methods: {

            createUser (e) {
                e.preventDefault();

                this.error = null;
                this.loading = true;

                api(this.$store.state.token)
                    .post('/' + this.$store.state.org + '/user/invite',
                        {
                            email: this.email,
                            access: this.access
                        }
                    )
                    .then(() => {
                        this.loading = false;
                        this.showUserInvited();
                        this.close();
                    }).catch((res) => {
                        this.loading = false;
                        if (res.response.status === 400) {
                            this.error = res.response.data.data.message;
                        } else {
                            this.error = 'Unknown error'
                        }
                    }
                );

            }

        },
        notifications: {
            showUserInvited: {
                title: 'User invited',
                message: 'User is invited',
                type: 'success'
            }
        }
    }
</script>