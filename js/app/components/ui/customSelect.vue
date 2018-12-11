<template>

  <div class="dropdown">
    <a
      href="#"
      class="selected"
      @click="openSelect"
    >
      <img
        :src="'/img/issue/type-' + value + '.png'"
        :alt="'type-' + value"
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
        :selected="option.value === value"
        :key="index"
        @click="select($event, option.value)"
      >
        <a href="#">
          <img
            :src="'/img/issue/type-' + option.value + '.png'"
            :alt="'type-' + option.value"
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
              type: String,
              default: ""
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

    .selected {

      position: absolute;
      top: 0;
      left: 0;
      width: 100%;

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
      top: 29px;
      padding: 0;
      left: 0;
      background: #F5F9FB;
      border-top: 2px solid #036FE8;
      list-style: none;
      width: 100%;
      height: 90px;
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