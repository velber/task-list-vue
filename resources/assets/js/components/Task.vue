<template>
    <draggable v-model="tasks" :options="{handle:'.handle'}" @start="drag=true" @end="drag=false" clas="mdl-list">
        <li class="mdl-list__item" v-for="task in tasks">
            <span class="mdl-list__item-primary-content">
                <button class="mdl-button mdl-js-button mdl-button--icon handle">
                    <i class="material-icons">blur_on</i>
                </button>
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" :for="getCheckboxId(task.id)">
                    <input type="checkbox" :id="getCheckboxId(task.id)" class="mdl-checkbox__input" checked/>
                </label>
                <span contenteditable="true" class="editable">{{ task.name }}</span>
            </span>
            <span class="mdl-list__item-secondary-action">
                <button class="mdl-button mdl-js-button mdl-button--icon">
                    <i class="material-icons">cancel</i>
                </button>
            </span>
        </li>
    </draggable>
</template>

<script>
    var Draggable = require('vuedraggable')
    export default {
        data() {
            return {
                tasks: []
            }
        },
        components: {
            draggable: Draggable
        },
        methods: {
            getCheckboxId(id) {
                return `list-checkbox-${id}`;
            }
        },
        created() {
            axios.get('/tasks').then(response => this.tasks = response.data);
        }
    };
</script>

<style>
    .mdl-checkbox {
        width: 24px;
    }

    .handle {
        margin-right: 15px;
    }

    .editable {
        padding: 8px 4px;
    }
</style>
