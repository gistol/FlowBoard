<template>

  <modal
    :close="close"
  >

    <div slot="header">

      <h2> {{ payload.title }} </h2>

    </div>

    <div slot="body" >

      <div class="issue-content">



        <div class="field-show">

          <div class="field-title">
            <p>Type</p>
          </div>

          <div class="field-value">
            <img
              :src="'/img/issue/type-' + payload.status.name + '.png'"
              :alt="payload.status.name"
            > {{ payload.status.name }}
          </div>

        </div>

        <div class="field-show">

          <div class="field-title">
            <p>Summary</p>
          </div>

          <div class="field-value">
            {{ payload.comment }}
          </div>

        </div>

        <div class="field-show">

          <div class="field-title">
            <p>Assignee</p>
          </div>

          <div class="field-value">
          <span v-if="payload.assignee !== null">
            {{ payload.assignee.firstName }} {{ payload.assignee.lastName }}
          </span>
            <span v-else>
            Not assigned
          </span>
          </div>

        </div>

        <div class="field-show">

          <div class="field-title">
            <p>Reporter</p>
          </div>

          <div class="field-value">
            {{ payload.reporter.firstName }} {{ payload.reporter.lastName }}
          </div>

        </div>

        <div class="field-show">

          <div class="field-title">
            <p>Created</p>
          </div>

          <div
            class="field-value"
            style="margin-bottom: 20px;"
          >
            {{ payload.created.date | moment("HH:mm D MMMM YYYY") }}
          </div>

        </div>

      </div>

      <button
        @click="updateIssue($event)"
      >
        Update issue
      </button>

      <button
        @click="deleteIssue($event)"
        class="delete-button"
      >
        Delete issue
      </button>

    </div>

  </modal>

</template>

<script>
    import api from '../../store/axios';
    import Modal from "../ui/modal.vue";
    import mutations from '../../consts/mutationConsts';
    import Eventbus from '../../event/Eventbus';
    import events from '../../consts/eventConsts';

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
        methods: {

            updateIssue(e) {

                e.preventDefault();

                Eventbus.$emit(events.MODAL_REQUEST, {
                    modal: 'modalUpdateIssue',
                    payload: this.payload,
                    callback() {

                    }
                })

            },

            deleteIssue(e) {

                e.preventDefault();

                api(this.$store.state.token)
                    .delete('/' + this.$store.state.org + '/' + this.payload.project + '/' + this.payload.projectId + '/issue/delete',
                        this.payload
                    )
                    .then(() => {
                        this.showDeleteSuccess();
                        this.$store.commit(mutations.SAVE_PROJECT, false);
                        this.$store.dispatch(mutations.GET_PROJECT, this.payload.project);
                        this.close();
                    }).catch((res) => {});

            }

        },
        notifications: {
            showDeleteSuccess: {
                title: 'Issue deleted',
                message: 'You\'re issue is deleted',
                type: 'success'
            }
        }
    }
</script>
<style lang="scss">

  .issue-content {

    position: relative;

  }

</style>