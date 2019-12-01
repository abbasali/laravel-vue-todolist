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
// import this component
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

const app = new Vue({
    el: '#app',

    components: {
        flatPickr
    },

    data() {
        return {
            showListForm: false,

            listForm: {
                id: '',
                name: ''
            },

            listFormErrors: {},

            lists: [],

            showTodoForm: false,

            todoForm: {
                id: '',
                description: '',
                list_id: '',
                due_at: '',
                completed_at: ''
            },

            todoFormErrors: {},

            todos: [],

            datePickerConfig: {
                altInput: true,
                altInputClass: 'form-control',
                enableTime: true,
                dateFormat: 'Y-m-d H:G:S'
            }
        }
    },

    mounted() {
        this.fetchLists();
        this.fetchTodos();
    },

    methods: {
        fetchLists () {
            axios.get('/api/todoLists')
                .then(response => {
                    this.lists = response.data.data;
                });
        },

        fetchTodos () {
            axios.get('/api/todos')
                .then(response => {
                    this.todos = response.data.data;
                });
        },

        saveList (list) {
            this.listFormErrors = {};

            let saveRequest;
            if (_.isUndefined(list)) {
                saveRequest = axios.post('/api/todoLists', this.listForm);
            } else {
                saveRequest = axios.put(`/api/todoLists/${list.id}`, this.listForm);
            }

            saveRequest.then((response) => {
                if (list) {
                    list.name = response.data.data.name;
                } else {
                    this.lists.push(response.data.data);
                }
                this.listForm.id = '';
                this.listForm.name = '';
            })
            .catch((error) => {
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
        },

        editList (list) {
            // Set the list name and id in the list form
            this.listForm.id = list.id;
            this.listForm.name = list.name;
        },

        cancelEdit (list) {
            this.listForm.id = '';
            this.listForm.name = '';
        },

        saveTodo (todo) {
            this.todoFormErrors = {};

            let saveRequest;
            if (_.isUndefined(todo)) {
                saveRequest = axios.post('/api/todos', this.todoForm);
            } else {
                saveRequest = axios.put(`/api/todos/${list.id}`, this.todoForm);
            }

            saveRequest.then((response) => {
                if (todo) {
                    todo.description = response.data.data.description;
                    todo.list_id = response.data.data.list_id;
                    todo.due_at = response.data.data.due_at;
                    todo.completed_at = response.data.data.completed_at;
                } else {
                    this.todos.push(response.data.data);
                }
                this.todoForm.id = '';
                this.todoForm.description = '';
                this.todoForm.list_id = '';
                this.todoForm.due_at = '';
                this.todoForm.completed_at = '';
            })
            .catch((error) => {
                let errors = error.response.data.errors;
                _.forEach(errors, (messages, field) => {
                    Vue.set(this.todoFormErrors, field, messages[0]);
                });
            });
        },

        deleteTodo(id) {
            let del = confirm("Are you sure you want to remove this Todo");
            if (del == true) {
                axios.delete(`/api/todos/${id}`)
                .then(response => {
                    this.fetchTodos();
                }).catch((error) => {
                    console.log(error);
                })
            }
        },

        toggleComplete(todo) {
            axios.put(`/api/todos/${todo.id}/toggle-complete`)
                .then(response => {
                    todo.completed_at = response.data.data.completed_at;
                    this.fetchTodos();
                })
        },
    },
});
