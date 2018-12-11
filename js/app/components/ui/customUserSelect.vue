<template>

  <div class="dropdown">
    <a
      href="#"
      class="selected"
      @click="openSelect"
    >
      <img
        v-if="showImg"
        :src="'/img/user/' + getUserProps(value).email"
        :alt="getUserProps(value).email"
      >
      {{ getUserProps(value).firstName }} {{ getUserProps(value).lastName }}
    </a>
    <ul
      v-if="open"
      class="editor-scrollbar"
    >
      <li
        v-for="(option, index) in options"
        :value="option.email"
        :key="index"
        @click="select($event, option.email)"
      >
        <a href="#">
          <img
            v-if="showImg"
            :src="'/img/user/' + option.email"
            :alt="option.email"
          >
          {{ option.firstName }} {{ option.lastName }}
        </a>
      </li>
    </ul>
  </div>

</template>


<script>

    import _ from 'lodash';

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

            getUserProps (val) {

                let key = _.findIndex(this.options, {
                    email: val
                });

                if (key === -1) {
                    return {
                        email: 'test@test.com',
                        firstName: 'not',
                        lastName: 'assigned'
                    }
                }

                return this.options[key];

            },

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