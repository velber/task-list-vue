@extends('layouts.app')
@section('main-content')

    <div id="app">
        <h1 class="text-center">To Do List</h1>
        <ul class="demo-list-control mdl-list">
            <vddl-list class="panel__body--list" :list="tasks" :horizontal="false">
                <vddl-draggable v-for="(task, key, index) in tasks"
                                :draggable="task"
                                :index="index"
                                :wrapper="tasks"
                                effect-allowed="move">
                    <vddl-nodrag class="nodrag">
                        <vddl-handle
                                :handle-left="20"
                                :handle-top="20"
                                class="handle">
                            <button class="mdl-button mdl-js-button mdl-button--icon">
                                <i class="material-icons">blur_on</i>
                            </button>
                        </vddl-handle>
                        <task :task="task"></task>
                    </vddl-nodrag>
                </vddl-draggable>
            </vddl-list>
        </ul>
    </div>

@endsection
