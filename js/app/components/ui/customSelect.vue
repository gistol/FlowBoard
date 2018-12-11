<template>

  <div class="dropdown">
    <a
      href="#"
      class="selected"
      @click="openSelect"
    >
      <img
        v-if="showImg"
        :src="'/img/issue/type-' + value + '.png'"
        :alt="value"
      >
      {{ value }}
    </a>
    <ul
      v-if="open"
      class="editor-scrollbar"
    >
      <li
        v-for="(option, index) in options"
        :value="option.value"
        :key="index"
        @click="select($event, option.value)"
      >
        <a href="#">
          <img
            v-if="showImg"
            :src="option.img"
            :alt="option.value"
          >
          {{ option.value }}
        </a>
      </li>
    </ul>
  </div>

</template>


<script>

  export default {

      props: {
          options: {
              type: Array,
              default() {
                  return []
              }
          },
          value: {
              type: [String, Number],
              default: ""
          },
          showImg: {
              type: Boolean,
              default: false
          }
      },
      data () {
          return {
              open: false
          }
      },
      methods: {

          select (e, val) {

              e.preventDefault();

              this.$emit('input', val);

              this.open = false;

          },

          openSelect (e) {

              e.preventDefault();

              this.open = !this.open;

          },

      }

  }

</script>


<style lang="scss">

  .dropdown {

    position: relative;
    background: #F5F9FB;
    height: 45px;
    width: 100%;
    float: right;
    cursor: pointer;
    margin-bottom: 25px;

    .selected {

      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      border-bottom: 2px solid #036FE8;

    }

    a {


      display: flex;
      align-items: center;
      padding: 5px 15px;

      img {

        width: 20px;
        margin: 7px 20px 7px 7px;

      }

      color: black;
      text-decoration: none;

    }

    ul {

      position: absolute;
      top: 30px;
      padding: 0;
      left: 0;
      background: #F5F9FB;
      list-style: none;
      width: 100%;
      height: 88px;
      overflow-y: scroll;

      li {

        display: block;

        a {

          background: transparent;

          &:hover {

            color: white;
            background: #036FE8;

          }

        }

      }

    }

  }

</style>