<template>

  <div>
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
            v-if="projects === false"
          >

            <a
              href="#"
            >

              <i class="fas fa-spinner fa-spin" />

              Loading projects

            </a>

          </li>

          <li
            v-else
            @click="createProject($event)"
          >
            <a
              href="#"
            >

              <i class="fas fa-plus-circle" />

              Create project

            </a>
          </li>

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

    <div
      class="sidebar-mobile"
      @click="showMenuBarMobile = !showMenuBarMobile"
    >

      <img
        class="sidebar-logo"
        src="img/logo-light.svg"
      >

    </div>

    <div
      v-if="showMenuBarMobile"
      class="sidebar-mobile-content"
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
            v-if="projects === false"
          >

            <a
              href="#"
            >

              <i class="fas fa-spinner fa-spin" />

              Loading projects

            </a>

          </li>

          <li
            v-else
            @click="createProject($event)"
          >
            <a
              href="#"
            >

              <i class="fas fa-plus-circle" />

              Create project

            </a>
          </li>

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
  </div>


</template>

<script>

    import Eventbus from '../../event/Eventbus';
    import events from '../../consts/eventConsts';
    import mutations from '../../consts/mutationConsts';

    export default {

        data () {
            return {
                showMenuBarMobile: false,
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
                        },
                        {
                            icon: 'fa-sign-out-alt',
                            name: 'Logout',
                            link: 'settings'
                        }
                    ]
                }
            }
        },
        created () {

            this.$store.dispatch(mutations.GET_PROJECTS);

        },
        computed: {

            projects () {

                if (this.$store.getters.getProjects === false) return false;

                return this.$store.getters.getProjects.projects;

            }

        },
        methods: {

            goToScreen (e, screen) {

                e.preventDefault();

                this.showMenuBarMobile = false;

                this.$router.push({
                    name: screen
                })

            },
            goToProject (e, val) {

                e.preventDefault();

                this.showMenuBarMobile = false;

                this.$router.push({
                    params: {
                        org: val.org,
                        project: val._id
                    },
                    name: 'project'
                })

            },
            createProject (e) {

                e.preventDefault();

                this.showMenuBarMobile = false;

                Eventbus.$emit(events.MODAL_REQUEST, {
                    modal: 'modalCreateProject',
                    payload: {},
                    callBack() {
                        this.$store.dispatch(mutations.GET_PROJECTS);
                    }
                });

            }

        }

    }

</script>

<style>

  @media screen and (max-width: 800px) {
    .bootstrap-wrapper {

      margin: 0;
      width: 100%;

    }
  }

</style>
