@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-5 border-right">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Lists</h3>
                                    <button class="btn btn-link" v-if="showListForm == false" @click="showListForm = true">+ Add List</button>
                                    <form class="form-inline" v-else
                                        @submit.prevent="saveList()">
                                        <div class="form-group mx-sm-3 mb-2">
                                            <input class="form-control" placeholder="List name"
                                            v-model="listForm.name"
                                            @keyup.esc="showListForm = false">
                                        </div>
                                        <button type="submit" class="btn btn-primary mb-2">Add</button>
                                        <button class="btn mb-2" @click="showListForm = false">Cancel</button>
                                        <span class="text-danger" v-if="listFormErrors.name">@{{ listFormErrors.name }}</span>
                                    </form>
                                </div>
                                <div class="col-md-12">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item" v-for="(list, index) in lists">
                                            <template v-if="listForm.id != list.id">
                                            @{{ list.name }}
                                            <button class="btn btn-sm float-right" @click.prevent="deleteList(list, index)"><i class="fas fa-trash"></i></button>
                                            <button class="btn btn-sm float-right" @click.prevent="editList(list)"><i class="fas fa-edit"></i></button>
                                            </template>
                                            <div class="form-inline" v-else>
                                                <div class="col-auto">
                                                    <input class="form-control" placeholder="List name"
                                                        v-model="listForm.name"
                                                        :class="{'is-invalid': listFormErrors.name}"
                                                        @keyup.enter="saveList(list)"
                                                        @keyup.esc="cancelEdit(list)">
                                                    <div class="invalid-feedback" v-if="listFormErrors.name">
                                                        @{{ listFormErrors.name }}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                <button class="btn mb-2" @click.prevent="cancelEdit(list)"><i class="fas fa-window-close"></i></button>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 border-right">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Todos</h3>
                                    <button class="btn btn-link"
                                        v-if="! showTodoForm"
                                        @click="showTodoForm = true">+ Add</button>
                                        <form class="form" @submit.prevent="saveTodo()" v-else>
                                                <div class="form-row">
                                                    <div class="col-auto mb-2">
                                                        <input class="form-control"
                                                            :class="{'is-invalid': todoFormErrors.description}"
                                                            placeholder="Todo description"
                                                            v-model="todoForm.description" @keyup.esc="showTodoForm = false">
                                                        <div class="invalid-feedback" v-if="todoFormErrors.description">
                                                            @{{ todoFormErrors.description }}
                                                        </div>
                                                    </div>
                                                    <div class="col-auto mb-2">
                                                        <select class="form-control"
                                                            v-model="todoForm.list_id"
                                                            :class="{'is-invalid': todoFormErrors.list_id}">
                                                            <option :value="list.id" v-for="list in lists">@{{ list.name }}</option>
                                                        </select>
                                                        <div class="invalid-feedback" v-if="todoFormErrors.description">
                                                            @{{ todoFormErrors.list_id }}
                                                        </div>
                                                    </div>
                                                    <div class="col-4 mb-2 input-group">
                                                        <flat-pickr
                                                            v-model="todoForm.due_at"
                                                            @keyup.esc="showTodoForm = false"
                                                            :config="datePickerConfig"></flat-pickr>
                                                        <div class="input-group-addon">
                                                            <div class="input-group-text">&nbsp;<i class="fas fa-calendar"></i></div>
                                                        </div>
                                                        <div class="invalid-feedback" v-if="todoFormErrors.description">
                                                            @{{ todoFormErrors.due_at }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-auto mb-2">
                                                    <button type="submit" class="btn btn-primary mb-2">Add</button>
                                                    <button class="btn mb-2" @click.prevent="showTodoForm = false">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                </div>
                                <div class="col-md-12">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item" v-for="todo in todos"
                                        :style="{textDecoration: todo.completed_at ? 'line-through' : ''}">
                                            @{{ todo.description }} <small> - @{{ todo.list }}</small><span class="float-right"><span class="text-muted">@{{ todo.due_at_formatted }}</span>
                                            <input type="checkbox" class="ml-3"
                                            :checked="todo.completed_at"
                                            @click="toggleComplete(todo)">
                                        </span>
                                        </li>
                                    </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
