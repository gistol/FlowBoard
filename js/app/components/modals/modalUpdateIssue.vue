<template>

  <modal
    :close="close"
  >

    <div slot="header">

      <p>Update issue</p>

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
            <select v-model="issue.status">
              <option>task</option>
              <option>bug</option>
              <option>epic</option>
            </select>
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
          @click="updateIssue($event)"
        >
          Update issue
        </button>

      </div>

      <div v-else>
        <p>Loading ....</p>
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
        created () {

            this.issue = JSON.parse(JSON.stringify(this.payload));

            this.issue.status = this.issue.status.name;
            this.issue.assigned = (this.issue.assignee === null ? "" : this.issue.assignee.email);

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
                }
            }
        },
        methods: {

            updateIssue (e) {
                e.preventDefault();

                this.error = null;
                this.loading = true;

                api(this.$store.state.token)
                    .put('/' + this.$store.state.org + '/' + this.payload.project + '/issue/update',
                        this.issue
                    )
                    .then((res) => {
                        this.loading = false;
                        this.showIssueCreateSuccess();
                        this.$store.commit(mutations.SAVE_PROJECT, false);
                        this.$store.dispatch(mutations.GET_PROJECT, this.payload.project);
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
                title: 'Issue updated',
                message: 'You\'re issue is updated',
                type: 'success'
            }
        }
    }
</script>