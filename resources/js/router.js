import {createRouter, createWebHistory} from 'vue-router'
import viewComponent from './components/viewComponent.vue'
import addComponent from './components/addComponent.vue'
import editComponent from './components/editComponent.vue'
import errorComponent from './components/errorComponent.vue'

const routes = [
    {path:'/', component: viewComponent},
    {path:'/Announcement', component: viewComponent},
    {path:'/Announcement/add', component: addComponent},
    {path:'/Announcement/edit/:id', component: editComponent},
    // {path: '/:catchAll(.*)', component: errorComponent, name: 'Error404'}
]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

export default router