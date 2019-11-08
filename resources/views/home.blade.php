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
                                            v-model="listForm.name">
                                        </div>
                                        <button type="submit" class="btn btn-primary mb-2">Add</button>
                                        <button class="btn mb-2" @click="showListForm = false">Cancel</button>
                                        <span class="text-danger" v-if="listFormErrors.name">@{{ listFormErrors.name }}</span>
                                    </form>
                                </div>
                                <div class="col-md-12">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item" v-for="(list, index) in lists">
                                            @{{ list.name }}
                                            <button class="btn btn-sm float-right" @click.prevent="deleteList(list, index)"><i class="fas fa-trash"></i></button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 border-right">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Todos</h3>
                                </div>
                                <div class="col-md-12">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                                Bring milk <small> - Work</small><span class="float-right"><span class="text-muted">4th Nov, 2019 5:30 pm</span><input type="checkbox" class="ml-3"></span>

                                            </li>
                                            <li class="list-group-item">
                                                Bring milk <small> - Personal</small><span class="float-right"><span class="text-muted">4th Nov, 2019 5:30 pm</span><input type="checkbox" class="ml-3"></span>

                                            </li>
                                            <li class="list-group-item">
                                                Bring milk <small> - Work</small><span class="float-right"><span class="text-muted">4th Nov, 2019 5:30 pm</span><input type="checkbox" class="ml-3"></span>

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
