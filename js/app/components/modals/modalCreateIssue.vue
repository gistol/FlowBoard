<template>

  <modal
    :close="close"
  >

    <div slot="header">

      <h3>Create issue</h3>

    </div>

    <div slot="body" >

      <div class="issue-content" v-if="!loading">

        <p v-if="error !== null">
          {{ error }}
        </p>

        <div class="field-set">

          <div class="field-title">
            <p>Title</p>
          </div>

          <div class="field-value">
            <input
              v-model="issue.title"
              placeholder="title"
            />
          </div>

        </div>


        <div class="field-set">

          <div class="field-title">
            <p>Type</p>
          </div>

          <div class="field-value">

            <custom-select
              v-model="issue.status"
              :options="options"
            />
          </div>

        </div>

        <div class="field-set">

          <div class="field-title">
            <p>Summary</p>
          </div>

          <div class="field-value">
            <textarea
              v-model="issue.comment"
              placeholder="issue discription"
            />
          </div>

        </div>

        <div class="field-set">

          <div class="field-title">
            <p>Assignee</p>
          </div>

          <div class="field-value">
            <select v-model="issue.assigned" v-if="projectUsers !== false">
              <option value="">None</option>
              <option
                v-for="(value, key) in projectUsers"
                :key="key"
                :value="value.email"
              >
                {{ value.firstName }} {{ value.lastName }}
              </option>
            </select>
            <p v-else>
              Loading users...
            </p>
          </div>

        </div>

        <button
          @click="createIssue($event)"
        >
          Create issue
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
    import CustomSelect from "../ui/customSelect.vue";

    export default {
        components: {
            CustomSelect,
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
        created () {

            if (this.projectUsers === false) {
                this.$store.dispatch(mutations.GET_PROJECT_USERS, this.payload.project);
            }

        },
        computed: {

            projectUsers() {
                return this.$store.getters.getProjectUsers;
            }

        },
        data () {
            return {
                loading: false,
                error: null,
                issue: {
                  status: 'task',
                  title: '',
                  comment: null,
                  assigned: ''
                },
                options: [
                    {
                        value: 'task'
                    },
                    {
                        value: 'bug'
                    },
                    {
                        value: 'epic'
                    }
                ]
            }
        },
        methods: {

            createIssue (e) {
                e.preventDefault();

                this.error = null;
                this.loading = true;

                if (this.issue.assigned === "") this.issue.assigned = null;
                if (this.issue.comment === "") this.issue.comment = null;

                api(this.$store.state.token)
                    .post('/' + this.$store.state.org + '/' + this.payload.project + '/issue/create',
                        this.issue
                    )
                    .then((res) => {
                        this.loading = false;
                        this.showIssueCreateSuccess();
                        this.update(res.data.data);
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
            showIssueCreateSuccess: {
                title: 'Issue created',
                message: 'You\'re issue is created',
                type: 'success'
            }
        }
    }
</script>