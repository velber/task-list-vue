<template>
    <draggable v-model="tasks" :taskd="tasks" :options="{handle:'.handle'}" class="mdl-list"
               @start="drag=true" @end="drag=false" @update="move">
        <div class="mdl-list__item" v-for="(task, index) in tasks" :key="task.id" :data-order="task.order" :data-id="task.id">
            <span class="mdl-list__item-primary-content">
                <button class="mdl-button mdl-js-button mdl-button--icon handle">
                    <i class="material-icons">blur_on</i>
                </button>
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" :for="getCheckboxId(task.id)">
                    <input type="checkbox" @change="check(task.id, $event)" :checked="task.status"
                           :id="getCheckboxId(task.id)" class="mdl-checkbox__input"/>
                </label>
                <input type="text" class="mdl-list__input" @keyup="update(task.id, $event)" :value="task.name"
                   :id="getInputId(task.id)">
                </input>
            </span>
            <span class="mdl-list__item-secondary-action">
                <button class="mdl-button mdl-js-button mdl-button--icon" @click="remove(index, task.id)">
                    <i class="material-icons">cancel</i>
                </button>
            </span>
        </div>
        <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored"
                slot="footer" @click="addTask">
            <i class="material-icons">add</i>
        </button>
    </draggable>
</template>

<script>
    var Draggable = require('vuedraggable');

    export default {
        data() {
            return {
                tasks: [],
                newItemId: null
            }
        },
        components: {
            draggable: Draggable
        },
        methods: {
            move(e) {
                let order = this.getOrder(e);
                let id = e.item.dataset.id;

                e.item.dataset.order = order;

                this.$http.patch('/task/' + id, {
                    order: order
                });
            },
            check(id, e) {
                let status = e.target.checked;
                this.$http.patch('/task/' + id, {
                    status: status
                }).then(response => {
                    //TODO cross annd move to down
                });
            },
            update: _.debounce(function(id, e) {
                let task = _.find(this.tasks, ['id', id]);
                task.name = e.target.value;
                this.$http.patch('/task/' + id, {
                    name: task.name
                }).then(response => {
                    this.showSnackBar('Task updated!');
                }, response => {
                    this.showSnackBar('Error!');
                });
            }, 500),
            remove(i, id) {
                this.$http.delete('/task/' + id, {}).then(response => {
                    this.tasks.splice(i, 1);
                this.showSnackBar('Task deleted!');
                }, response => {
                    this.showSnackBar('Error!');
                });
            },
            addTask() {
                this.$http.post('/task', {}).then(response => {
                    let task = response.data.task;
                    this.tasks.push(task);
                    this.newItemId = task.id;
            }, response => {
                    this.showSnackBar('Error!');
                });
            },
            getCheckboxId(id) {
                return `list-checkbox-${id}`;
            },
            getInputId(id) {
                return `list-input-${id}`;
            },
            getOrder(e) {
                let newOrder;
                let topOrder = _.isNull(e.item.previousSibling)
                        ? null
                        : _.toNumber(e.item.previousSibling.dataset.order);
                let bottomOrder = _.isNull(e.item.nextSibling)
                        ? null
                        : _.toNumber(e.item.nextSibling.dataset.order);

                if (_.isNull(topOrder)) {
                    newOrder = bottomOrder + 1;
                } else if (_.isNull(bottomOrder)) {
                    newOrder = topOrder - 1;
                } else {
                    newOrder = _.divide(_.add(bottomOrder, topOrder), 2);
                }

                return newOrder;
            },
            focusNewTask() {
                let $input = document.querySelector('#' + this.getInputId(this.newItemId));
                if (! _.isNull($input)) {
                    $input.focus();
                }
            },
            showSnackBar(message) {
                document.querySelector('#demo-toast-example')
                        .MaterialSnackbar
                        .showSnackbar({
                            message: message,
                            timeout: 1500
                        });
            }
        },
        created() {
            this.$http.get('/tasks').then(response => this.tasks = response.data);
        },
        updated() {
            this.focusNewTask();
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
    .mdl-list__input {
        outline: none;
        border: none;
        width: 100%;
    }
    .sortable-ghost {
        background-color: #97b498;
    }
    .sortable-ghost input {
        background-color: #97b498;
    }
    .sortable-drag {
        background-color: #fbfffc;
    }
    .mdl-button--fab {
        float: right;
    }
</style>
