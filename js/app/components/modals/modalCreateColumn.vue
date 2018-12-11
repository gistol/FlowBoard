<template>

  <modal
    :close="close"
  >

    <div slot="header">

      <h3>Create column</h3>

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
            <p>Status</p>
          </div>

          <div class="field-value">
            <select v-model="project.status">
              <option value="1">Backlog</option>
              <option value="3">In Progress</option>
              <option value="2">Done</option>
            </select>
          </div>

        </div>

        <div class="field-set">

          <div class="field-title">
            <p>Order</p>
          </div>

          <div class="field-value">
            <custom-select
                v-model="project.order"
                :options="order"
                :show-img="false"
                class="dropdown-less-height"
            />
          </div>

        </div>

        <button
          @click="createColumn($event)"
        >
          Create column
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

            let columns = this.$store.getters.getProject.project.columns;

            let i = 0;

            for (i = 0; i < columns.length; i++) {

                this.order.push({
                    value: i + 1
                });

            }

        },
        data () {
            return {
                order: [{
                    value: 0
                }],
                loading: false,
                error: null,
                project: {
                    status: 1,
                    order: 0
                }
            }
        },
        methods: {

            createColumn (e) {
                e.preventDefault();

                this.error = null;
                this.loading = true;

                this.project.status = parseInt(this.project.status);
                this.project.order = parseInt(this.project.order);

                api(this.$store.state.token)
                    .post('/' + this.$store.state.org + '/' + this.payload.project + '/column/create',
                        this.project
                    )
                    .then((res) => {
                        this.loading = false;
                        this.showColumnCreateSuccess();
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
            showColumnCreateSuccess: {
                title: 'Column created',
                message: 'You\'re column is created',
                type: 'success'
            }
        }
    }
</script>

<style lang="scss">

  .dropdown-less-height {

    height: 32px!important;

    ul {

      top: 15px!important;
      height: 59px!important;

    }

  }

</style>