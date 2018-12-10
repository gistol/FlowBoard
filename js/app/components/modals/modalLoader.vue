<template>
  <div>
    <modal-create-issue
      v-if="show.modalCreateIssue"
      :payload="payload"
      :update="updateFunc"
      :close="close"
    />
    <modal-show-issue
      v-if="show.modalShowIssue"
      :payload="payload"
      :update="updateFunc"
      :close="close"
    />
    <modal-create-column
      v-if="show.modalCreateColumn"
      :payload="payload"
      :update="updateFunc"
      :close="close"
    />
    <modal-update-issue
      v-if="show.modalUpdateIssue"
      :payload="payload"
      :update="updateFunc"
      :close="close"
    />
  </div>
</template>

<script>
    import _ from 'lodash';
    import Eventbus from '../../event/Eventbus';
    import events from '../../consts/eventConsts';
    import ModalCreateIssue from "./modalCreateIssue.vue";
    import ModalShowIssue from "./modalShowIssue.vue";
    import ModalCreateColumn from "./modalCreateColumn.vue";
    import ModalUpdateIssue from "./modalUpdateIssue.vue";

    export default {
        name: 'ModalLoader',
        components: {
            ModalUpdateIssue,
            ModalCreateColumn,
            ModalShowIssue,
            ModalCreateIssue
        },
        data() {
            return {
                show: {
                    modalCreateColumn: false,
                    modalCreateIssue: false,
                    modalUpdateIssue: false,
                    modalShowIssue: false
                },
                payload: {},
                updateFunc() {
                    return 0;
                }
            }
        },
        created() {
            Eventbus.$on(events.MODAL_REQUEST, value => {
                this.close();
                this.show[value.modal] = true;
                this.payload = value.payload;
                this.updateFunc = value.callBack;
            });
        },
        methods: {
            close() {
                _.forEach(this.show, (value, key) => {
                    this.show[key] = false;
                });
            }
        }
    }
</script>
