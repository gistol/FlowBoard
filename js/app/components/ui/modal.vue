<template>
  <div class="modal">

    <div
      :style="styleObject"
      class="modal-content"
    >

      <div class="modal-header">

        <span
          class="close"
          @click="close"
        >
          <i class="fa fa-times"/>
        </span>

        <h2 class="title">
          <slot name="header"/>
        </h2>

      </div>

      <div class="modal-body">
        <slot name="body"/>
      </div>

    </div>

  </div>
</template>

<script>
    export default {
        name: "modal",
        props: {
            close: {
                type: Function,
                default() {
                    return 0;
                }
            },
            styleObject: {
                type: Object,
                default() {
                    return {};
                }
            }
        }
    }
</script>

<style lang="scss">

  .modal {

    background-color: rgba(0, 0, 0, 0.5);
    position: fixed;
    z-index: 100;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;

    .modal-content {

      position: fixed;
      background: #fff;
      top: 50%;
      left: 50%;
      width: 450px;
      height: 400px;
      transform: translate(-50%, -50%);
      border-radius: 4px;
      overflow: hidden;

      .modal-header {

        padding: 25px;

        .close {

          position: absolute;
          text-align: center;
          top: 0;
          right: 0;
          width: 50px;
          height: 35px;
          color: #ffffff;
          background: #036EE9;
          border-radius: 0 0 0 4px;
          cursor: pointer;
          line-height: 35px;
          font-size: 20px;

          &:hover {

            color: #f4f4f4;

          }

        }

      }

      .modal-body {

        position: absolute;
        top: 80px;
        width: 100%;
        overflow-y: scroll;
        height: 320px;
        padding: 0 25px;

      }

    }

  }

</style>