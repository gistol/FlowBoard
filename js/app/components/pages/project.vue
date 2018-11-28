<template>

  <div>

    <div
      v-if="project !== false"
      class="columns"
    >

      <div v-if="project.columns.length === 0">

        Awwwh snap no columns...

      </div>

      <column
        :project="project"
      />

    </div>

    <div v-else>

      Loading..

    </div>

  </div>

</template>

<script>

    import * as types from '../../store/mutationConsts';
    import Column from "../general/column.vue";

    export default {

        components: {
            Column
        },

        data () {
            return {}
        },

        created() {

            this.$store.dispatch(types.GET_PROJECT, this.$route.params.project);

        },
        beforeRouteUpdate (to, from, next) {

            this.$store.dispatch(types.GET_PROJECT, to.params.project);

            next();

        },
        computed: {

            project () {

                return (
                    this.$store.getters.getProject.name === this.$route.params.project ?
                        this.$store.getters.getProject : false
                )

            }

        }

    }

</script>