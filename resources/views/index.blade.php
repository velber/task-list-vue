@extends('app')
@section('main-content')
    <h1 class="text-center">To Do List</h1>
        <div class="form-group__task" data-token="{!! csrf_token() !!}">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" name="name" id="name">
                <label class="mdl-textfield__label" for="name">New task ...</label>
            </div>
            <select name="status_id" id="status_id" class="form-control">
                <option value="" selected disabled>   -- Select status -- </option>
                @foreach ($statuses as $status)
                    <option value="{!! $status->id !!}">{{ $status->name }}</option>
                @endforeach
            </select>
            <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-js-ripple-effect"
                type="button" id="submit-task">
                <i class="material-icons">check</i>
            </button>
            <span class="mdl-tooltip" for="submit-task">Add task</span>
        </div>
    @if ($tasks->count())
        <h4 class="text-center">Tasks</h4>
        <table class="mdl-data-table mdl-js-data-table">
            <thead>
            <tr>
                <th class="mdl-data-table__cell--non-numeric">Task</th>
                <td></td>
                <th class="mdl-data-table__cell--non-numeric">Status</th>
                <th class="mdl-data-table__cell--non-numeric">Order</th>
                <th class="mdl-data-table__cell--non-numeric">Delete</th>
            </tr>
            </thead>
            <tbody id="sortable">
            @foreach ($tasks as $task)
                @include('partials.task', ['task' => $task, 'statuses' => $statuses])
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
