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
    <modal-create-project
      v-if="show.modalCreateProject"
      :payload="payload"
      :update="updateFunc"
      :close="close"
    />
    <modal-create-org
      v-if="show.modalCreateOrg"
      :payload="payload"
      :update="updateFunc"
      :close="close"
    />
    <modal-create-user
      v-if="show.modalCreateUser"
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
    import ModalCreateProject from "./modalCreateProject.vue";
    import ModalCreateOrg from "./modalCreateOrg.vue";
    import ModalCreateUser from "./modalCreateUser.vue";

    export default {
        name: 'ModalLoader',
        components: {
            ModalCreateUser,
            ModalCreateOrg,
            ModalCreateProject,
            ModalUpdateIssue,
            ModalCreateColumn,
            ModalShowIssue,
            ModalCreateIssue
        },
        data() {
            return {
                show: {
                    modalCreateProject: false,
                    modalCreateColumn: false,
                    modalCreateIssue: false,
                    modalUpdateIssue: false,
                    modalCreateUser: false,
                    modalCreateOrg: false,
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
