<template>

    <div class="sidebar">

        <img
          class="sidebar-logo"
          src="img/logo-light.svg"
        >

        <div class="top-menu menu">

            <p>DASHBOARD</p>

            <ul>

                <li
                  v-for="(value, key) in menu.top"
                  :key="key"
                  @click="goToScreen($event, value.link)"
                >

                    <a
                      href="#"
                    >

                        <i :class="'fas ' + value.icon" />

                        {{ value.name }}

                    </a>

                </li>

            </ul>

        </div>

        <div class="menu">

          <p>BOARDS</p>

          <ul>

            <li
              v-for="(value, key) in projects"
              :key="key"
              @click="goToProject($event, value)"
            >

              <a
                href="/"
                class="active"
              >

                <i class="fas fa-cube" />

                {{ value.name }}

              </a>

            </li>

          </ul>

        </div>

    </div>

</template>

<script>

    import * as types from '../../store/mutationConsts';

    export default {

        data () {
            return {
                menu: {
                    top: [
                        {
                            icon: 'fa-home',
                            name: 'Home',
                            link: 'home'
                        },
                        {
                            icon: 'fa-cog',
                            name: 'Settings',
                            link: 'settings'
                        }
                    ]
                }
            }
        },
        created () {

            this.$store.dispatch(types.GET_PROJECTS);

        },
        computed: {
            projects () {

                return this.$store.getters.getProjects;

            }
        },
        methods: {

            goToScreen (e, screen) {

                e.preventDefault();

                this.$router.push({
                    name: screen
                })

            },
            goToProject (e, val) {

                e.preventDefault();

                this.$router.push({
                    params: {
                        org: val.org,
                        project: val._id
                    },
                    name: 'project'
                })

            }

        }

    }

</script>