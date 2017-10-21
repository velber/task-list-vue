@extends('layouts.app')
@section('main-content')
    <div id="app">
        <h1 class="text-center">To Do List</h1>
        <ul>
            <task v-for="(task, key, index) in tasks" :key="task.id" :task="task"></task>
        </ul>
    </div>
@endsection
