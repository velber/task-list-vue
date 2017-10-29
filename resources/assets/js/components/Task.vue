<template>
    <draggable v-model="tasks" :taskd="tasks" :options="{handle:'.handle'}" class="mdl-list"
               @start="drag=true" @end="drag=false" @update="onMove">
        <li class="mdl-list__item" v-for="(task, index) in tasks" :key="task.id">
            <span class="mdl-list__item-primary-content">
                <button class="mdl-button mdl-js-button mdl-button--icon handle">
                    <i class="material-icons">blur_on</i>
                </button>
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" :for="getCheckboxId(task.id)">
                    <input type="checkbox" :id="getCheckboxId(task.id)" class="mdl-checkbox__input" checked/>
                </label>
                <span contenteditable="true" class="editable" @blur="update(task.id, $event)">
                    {{ task.name }}
                </span>
            </span>
            <span class="mdl-list__item-secondary-action">
                <button class="mdl-button mdl-js-button mdl-button--icon" @click="remove(index, task.id)">
                    <i class="material-icons">cancel</i>
                </button>
            </span>
        </li>
    </draggable>
</template>

<script>
    var Draggable = require('vuedraggable');

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
            },
            onMove(e) {
                console.log(e.item.dataset.id);
                console.log(e.item.dataset.order);
            },
            update(id, e) {
                this.$http.patch('/task/' + id, {
                    name: e.target.textContent
                }).then(response => console.log(response));
            },
            remove(i, id) {
                this.$http.delete('/task/' + id, {}).then(response => {
                    this.tasks.splice(i, 1);
                }, response => {
                    // error callback
                });
            }
        },
        created() {
            axios.get('/tasks').then(response => this.tasks = response.data);
        }
    };
</script>

<style>
    .mdl-list {
        padding: 0;
    }
    .mdl-list__item {
        margin-bottom: 15px;
        background-color: #fbfffc;
        box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 1px 5px 0 rgba(0,0,0,0.12), 0 3px 1px -2px rgba(0,0,0,0.2);
    }
    .mdl-checkbox {
        width: 24px;
    }
    .handle {
        margin-right: 15px;
    }
    .editable {
        outline: none;
    }
    .sortable-ghost {
        background-color: #97b498;
    }
    .sortable-drag {
        background-color: #fbfffc;
    }
</style>
