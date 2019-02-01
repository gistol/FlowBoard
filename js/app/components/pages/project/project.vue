<template>

  <div class="project">

    <div v-if="project !== false">

      <div v-if="project.access > ACCESS_READ">

        <button
          v-if="project.project.columns.length !== 0"
          @click="createIssue($event)"
        >
          Create issue
        </button>

        <button
          @click="createColumn($event)"
        >
          Create column
        </button>
      </div>

      <column
        class="columns"
        :project="project.project"
      />

    </div>

    <div
      v-else
      class="full-screen-loading"
    >

      <p class="loading-text">

        <i class="fas fa-spinner fa-spin" /> Loading your board

      </p>

    </div>

  </div>

</template>

<script>

    import Column from "./column.vue";
    import accessMixin from '../../../mixins/accessMixin';
    import mutations from '../../../consts/mutationConsts';
    import events from '../../../consts/eventConsts';
    import Eventbus from '../../../event/Eventbus';

    export default {
        components: {
            Column
        },
        mixins: [accessMixin],
        data () {
            return {}
        },
        created() {
            this.$store.dispatch(mutations.GET_PROJECT, this.$route.params.project);
        },
        beforeRouteUpdate (to, from, next) {
            this.$store.dispatch(mutations.GET_PROJECT, to.params.project);
            this.$store.dispatch(mutations.SAVE_PROJECT_USERS, false);

            next();
        },
        computed: {
            project () {

                if (typeof this.$store.getters.getProject.project === 'undefined') return false;

                return (
                    this.$store.getters.getProject.project.name === this.$route.params.project ?
                        this.$store.getters.getProject : false
                )
            },
        },
        methods: {
            createIssue (e) {

                e.preventDefault();

                Eventbus.$emit(events.MODAL_REQUEST, {
                   modal: 'modalCreateIssue',
                   payload: {
                       project: this.project.project.name
                   },
                   callBack(issue) {
                       this.$store.commit(mutations.SAVE_CREATED_ISSUE, issue);
                   }
                });

            },
            createColumn (e) {

                e.preventDefault();

                Eventbus.$emit(events.MODAL_REQUEST, {
                    modal: 'modalCreateColumn',
                    payload: {
                        project: this.project.project.name
                    },
                    callBack () {
                        this.$store.commit(mutations.SAVE_PROJECT, false);
                        this.$store.dispatch(mutations.GET_PROJECT, this.$route.params.project);
                    }
                })

            }
        }
    }

</script>

<style lang="scss">

  .full-screen-loading {

    display: flex;
    width: 80vw;
    height: 90vh;

  }

  .loading-text {

    margin: auto;


    i {

      margin-right: 15px;

    }

  }

  .project {

      .columns {

        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;

      }

  }

</style>
