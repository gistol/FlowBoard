<template>

  <div
    class="issue"
    @click="makeIssueActive"
  >

    <div class="issue-img">
      <img
        :src="'/img/issue/type-' + data.status.name + '.png'"
      >
    </div>


    <div class="issue-content">

      <p class="issue-description">
        <span>{{ data.key }}</span> {{ data.title }}
      </p>

      <p class="issue-assignee">
        <span v-if="data.assignee !== null">
          {{ data.assignee.firstName }} {{ data.assignee.lastName }}
        </span>
      </p>

    </div>

  </div>

</template>

<script>

    import Eventbus from '../../../event/Eventbus';
    import events from "../../../consts/eventConsts";

    export default {

        name: 'issue',
        props: {
            issueKey: {
                type: String,
                default: ""
            },
            data: {
                type: Object,
                default () {
                    return {}
                }
            }
        },
        methods: {
            makeIssueActive () {

                Eventbus.$emit(events.MODAL_REQUEST, {
                    modal: 'modalShowIssue',
                    payload: this.data
                });

            }
        }
    }

</script>

<style lang="scss">

  .column .column-content .issue {

      &:hover,
      .active {

        background-color: #048DEF;

      }


    border-radius: 5px;

      padding: 10px;
      cursor: pointer;

      p {
        margin: 0;
        padding: 0;
      }

      margin: 10px;
      display: flex;

      .issue-img {

          padding: 2px 5px 0 0;

          img {

              width: 20px;

          }

      }

      .issue-content {

          padding: 0 5px;
          max-width: 95%;

          .issue-description {

              font-size: 18px;
              overflow-wrap: break-word;
              word-wrap: break-word;

              span {

                  font-size: 16px;
                  font-weight: 400;

              }

              font-weight: 500;

          }

          .issue-assignee {

              font-size: 14px;

          }

      }

  }

</style>