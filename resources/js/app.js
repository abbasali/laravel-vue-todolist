/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',

    data() {
        return {
            showListForm: false,

            listForm: {
                id: '',
                name: ''
            },

            listFormErrors: {},

            lists: [],
        }
    },

    mounted() {
        this.fetchLists();
    },

    methods: {
        fetchLists () {
            axios.get('/api/todoLists')
                .then(response => {
                    this.lists = response.data.data;
                });
        },

        saveList() {

            this.listFormErrors = {};

            axios.post('/api/todoLists', this.listForm)
                .then(response => {
                    this.showListForm = false;
                    this.lists.push(response.data.data);
                })
                .catch(error => {
                    let errors = error.response.data.errors;
                    _.forEach(errors, (messages, field) => {
                        Vue.set(this.listFormErrors, field, messages[0]);
                    });
                });
        },

        deleteList (list, index) {
            if (confirm('Are you sure you want to delete this list?')) {
                axios.delete(`/api/todoLists/${list.id}`)
                    .then(response => {
                        this.lists.splice(index, 1);
                    });
            }
        }
    },
});
