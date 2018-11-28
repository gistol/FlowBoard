<template>

  <div>

      <div
        v-for="(value, key) in project.columns"
        :key="key"
        class="column"
      >

        <div class="column-header">

          <p class="column-title">
            {{ value.status.name }}
          </p>

          <span class="column-count">
            {{ value.issues.length }}
          </span>

        </div>

        <draggable
          v-model="value.issues"
          :options="{group: project._id}"
          class="column-content"
        >
          <p v-if="value.issues.length === 0" class="issue-empty">
            This column doesn't have any issues 😭
          </p>
          <issue
            v-else
            v-for="(val, key) in value.issues"
            :key="key"
            :data="val"
          />
        </draggable>

      </div>

  </div>

</template>

<script>

    import draggable from 'vuedraggable';
    import issue from '../general/issue.vue';

    export default {
        components: {
            issue,
            draggable
        },
        props: {
            project: {
                type: Object,
                default() { return {} }
            }
        }
    }

</script>

<style lang="scss">

  .column {

    float:left;
    margin: 20px;
    width: 275px;
  }

  .column .column-header {

    border-bottom: 1px solid #e0e0e0;

  }

  .column .column-count {

    float: right;
    background-color: #008DEF;
    font-size: 14px;
    color: white;
    border-radius: 50px;
    height: 25px;
    width: 35px;
    text-align: center;
    margin-top: 15px;
    margin-right: 10px;
    padding: 4px;

  }

  .column .column-title {

    font-weight: 500;
    display: inline-block;

  }

  .column .issue-empty {

    padding: 20px;
    text-align: center;
    border: 1px dotted #008DEF;

  }

</style>