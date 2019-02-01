<template>

  <modal
    :close="close"
  >

    <div slot="header">

      <h3>Create Organisation</h3>

    </div>

    <div slot="body" >

      <div class="issue-content" v-if="!loading">

        <p
          v-if="error !== null"
          class="error-box"
        >
          {{ error }}
        </p>

        <div class="field-set">

          <div class="field-title">
            <p>Organisation name</p>
          </div>

          <div class="field-value">
            <input
              v-model="project.name"
              placeholder="Organisation name"
            />
          </div>

        </div>

        <button
          @click="createProject($event)"
        >
          Create organisation
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
    import mutations from '../../consts/mutationConsts';

    export default {
        components: {
            Modal
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
                project: {
                    name: '',
                }
            }
        },
        methods: {

            createProject (e) {
                e.preventDefault();

                this.error = null;
                this.loading = true;

                api(this.$store.state.token)
                    .post('/organisation/create',
                        this.project
                    )
                    .then((res) => {
                        this.loading = false;
                        this.showOrgSuccess();
                        localStorage.setItem('selected-org', res.data.data.name);
                        this.$store.commit(mutations.SET_ORGANISATION, res.data.data.name);
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
            showOrgSuccess: {
                title: 'Organisation created',
                message: 'You\'re organisation is created',
                type: 'success'
            }
        }
    }
</script>