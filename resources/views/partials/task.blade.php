<tr data-id="{!! $task->id !!}" data-order="{!! $task->order !!}">
    <td class="mdl-data-table__cell--non-numeric task-edit" contenteditable="true"
    >{{ $task->name }}</td>
    <td class="save-task">
        <button class="mdl-button mdl-js-button mdl-button--icon" data-action="name" title="Save">
            <i class="material-icons">save</i>
        </button>
    </td>
    <td class="mdl-data-table__cell--non-numeric">
        <select name="status_id" id="status_id" class="form-control" data-action="status_id">
            @foreach ($statuses as $status)
                <option value="{!! $status->id !!}" @if ($task->status_id == $status->id) selected @endif>{{ $status->name }}</option>
            @endforeach
        </select>
    <td class="mdl-data-table__cell--non-numeric">
        <i class="material-icons material-icons__move" title="Change order">open_with</i>
    </td>
    <td class="mdl-data-table__cell--non-numeric">
        <button class="mdl-button mdl-button__delete mdl-js-button mdl-button--icon mdl-button--colored
        mdl-button--accent mdl-js-ripple-effect" title="Delete task">
            <i class="material-icons">delete</i>
        </button>
    </td>
</tr>