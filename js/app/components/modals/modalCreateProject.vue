<template>

  <modal
    :close="close"
  >

    <div slot="header">

      <h3>Create Project</h3>

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
            <p>Project name</p>
          </div>

          <div class="field-value">
            <input
              v-model="project.name"
              placeholder="Project name"
            />
          </div>

        </div>

        <button
          @click="createProject($event)"
        >
          Create project
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
                    .post('/' + this.$store.state.org + '/project/create',
                        this.project
                    )
                    .then(() => {
                        this.loading = false;
                        this.showProjectSuccess();
                        this.update();
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
            showProjectSuccess: {
                title: 'Project created',
                message: 'You\'re project is created',
                type: 'success'
            }
        }
    }
</script>