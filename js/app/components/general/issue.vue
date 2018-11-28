<template>

  <div
    class="issue"
  >


    <div class="issue-img">
      <img
        :src="'/img/issue/type-' + data.status.name + '.png'"
      >
    </div>


    <div class="issue-content">

      <p class="issue-description">
        <span>FB-{{ data._id }}</span> {{ data.title }}
      </p>

      <p class="issue-assignee">
        {{ data.assignee.firstName }} {{ data.assignee.lastName }}
      </p>

    </div>

  </div>

</template>

<script>

    export default {

        name: 'issue',
        props: {
            data: {
                type: Object,
                default () {
                    return {}
                }
            }
        }


    }

</script>

<style lang="scss">

  .column .column-content .issue {

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

          .issue-description {

              font-size: 18px;

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