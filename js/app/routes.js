import home from './components/pages/home/home.vue';
import project from './components/pages/project/project.vue';
import settings from './components/pages/settings/settings.vue';
import notFound from './components/pages/general/notFound.vue';

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
    },
    {
        path: '*',
        component: notFound
    }
];