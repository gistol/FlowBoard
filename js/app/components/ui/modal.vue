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
      background: #f5f9ff;
      top: 50%;
      left: 50%;
      width: 750px;
      height: 500px;
      transform: translate(-50%, -50%);
      border-radius: 7px;
      overflow: hidden;

      .modal-header {

        position: absolute;
        background: #fff;
        top: 0;
        left: 0;
        width: 100%;
        height: 80px;
        padding: 25px;
        z-index: 1;
        text-align: center;

        .title {

          display: block;
          font-size: 24px;

        }

        .close {

          position: absolute;
          top: 0;
          right: 0;
          width: 50px;
          height: 35px;
          color: #bec4cc;
          background: #f6faff;
          border-radius: 0 0 0 7px;
          cursor: pointer;
          line-height: 35px;
          font-size: 20px;

          &:hover {

            color: #8c98a9;

          }

        }

      }

      .modal-body {

        position: absolute;
        top: 80px;
        left: 0;
        width: 100%;
        height: calc(100% - 80px);
        overflow-y: scroll;
        padding: 25px;
        z-index: 1;
        text-align: center;

        .modal-info {

          display: block;
          width: 80%;
          margin: 10px auto;
          font-size: 16px;

        }

        .loader {

          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          z-index: 1;

          h1 {

            font-size: 18px;
            font-weight: 100;
            color: #4c4c4c;
            margin-top: 25px;

          }

          img {

            height: 52px;

          }

        }

        .page-form {

          width: 100%;
          padding: 25px 50px;

          .field {

            width: 100%;
            margin: 15px 0;

            .field-title {

              display: block;
              text-align: left;
              margin-bottom: 10px;
              font-weight: 300;

            }

            &.field-options {

              .field-title {

                margin-left: 35px;
                padding: 2px 0;

              }

            }

            .field-half {

              margin: 5px 25px;
              display: inline-block;

            }

            input[type="text"] {

              display: block;
              width: 100%;
              border-radius: 5px;
              padding: 10px 15px;
              border: 2px solid #e4eaf3;

              &:hover,
              &:active,
              &:focus {

                border: 2px solid #c8e6ff;

              }

            }

          }

        }

        .options {

          position: relative;
          list-style: none;
          background: #ffffff;
          margin: -25px -25px 0 -25px;

          li {

            display: inline-block;
            padding: 0 25px 10px;
            cursor: pointer;
            border-bottom: 2px solid transparent;

            &.active {

              border-bottom: 2px solid #81c5ff;

            }

            span {

              color: #738696;

            }

          }

        }

      }

    }

  }

</style>