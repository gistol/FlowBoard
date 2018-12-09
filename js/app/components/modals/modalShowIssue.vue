<template>

  <modal
    :close="close"
  >

    <div slot="header">

      <h2> {{ payload.title }} </h2>

    </div>

    <div slot="body" >

      <div class="issue-content">



        <div class="field-set">

          <div class="field-title">
            <p>Type</p>
          </div>

          <div class="field-value">
            <img
              :src="'/img/issue/type-' + payload.status.name + '.png'"
            > {{ payload.status.name }}
          </div>

        </div>

        <div class="field-set">

          <div class="field-title">
            <p>Summary</p>
          </div>

          <div class="field-value">
            {{ payload.comment }}
          </div>

        </div>

        <div class="field-set">

          <div class="field-title">
            <p>Assignee</p>
          </div>

          <div class="field-value">
          <span v-if="payload.assignee !== null">
            {{ payload.assignee.firstName }} {{ payload.assignee.lastName }}
          </span>
            <span v-else>
            change to a person
          </span>
          </div>

        </div>

        <div class="field-set">

          <div class="field-title">
            <p>Reporter</p>
          </div>

          <div class="field-value">
            {{ payload.reporter.firstName }} {{ payload.reporter.lastName }}
          </div>

        </div>

        <div class="field-set">

          <div class="field-title">
            <p>Created</p>
          </div>

          <div class="field-value">
            {{ payload.created.date }}
          </div>

        </div>

      </div>

      <span>{{ payload.key }}</span>

    </div>

  </modal>

</template>
<script>
    import Modal from "../ui/modal.vue";

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
        }
    }
</script>

<style lang="scss">

  .issue-content {

    position: relative;

    .field-set {

      display: flex;

      .field-title {

        text-align: right;
        margin-right: 10px;
        flex-basis: 0;
        flex-grow: 2;

        p {

          margin: 0;
          padding: 0;

        }


      }

      .field-value {

        flex-basis: 0;
        flex-grow: 3;

        img {

          width: 20px;

        }

      }

    }

  }

</style>