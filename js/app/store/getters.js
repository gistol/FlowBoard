export default {

    getOrganisations (state) {

        return state.organisations;

    },

    getSelectedOrganisation (state) {

        return state.org;

    },

    getProjects (state) {

        return state.projects;

    },

    getProject (state) {

        return state.project;

    },

    getIssue (state) {

        return state.issue;

    },

    getProjectUsers (state) {

        return state.projectUsers;

    }

}