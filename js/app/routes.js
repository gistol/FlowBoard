import home from './components/pages/home.vue';
import settings from './components/pages/settings.vue';
import project from './components/pages/project.vue';

export default [
    {
        path: '/',
        name: 'home',
        component: home
    },
    {
        path: '/settings',
        name: 'settings',
        component: settings
    },
    {
        path: '/:org/:project',
        name: 'project',
        component: project
    }
];