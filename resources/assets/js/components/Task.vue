<template>
    <draggable class="mdl-list"
               v-model="tasks"
               :taskd="tasks"
               :options="{handle:'.handle'}"
               @update="move">
        <div class="mdl-list__item" v-for="(task, index) in tasks"
             :key="task.id"
             :data-order="task.order"
             :data-id="task.id">
            <span class="mdl-list__item-primary-content">
                <button class="mdl-button mdl-js-button mdl-button--icon handle">
                    <i class="material-icons">blur_on</i>
                </button>
                <div class="toggle" :class="{checked: task.status}" @click="toggle(task, $event)"></div>
                <input type="text" class="mdl-list__input"
                       :value="task.name" maxlength="60"
                       :id="getInputId(task.id)"
                       :disabled="task.status == 1"
                       :class="{through:task.status}"
                       @focusout="update(task.id, $event)"
                       @keyup.enter="update(task.id, $event)"/>
            </span>
            <span class="mdl-list__item-secondary-action">
                <button class="mdl-button mdl-js-button mdl-button--icon" @click="remove(index, task.id)">
                    <i class="material-icons">cancel</i>
                </button>
            </span>
        </div>
        <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" slot="footer"
                @click="addTask">
            <i class="material-icons">add</i>
        </button>
    </draggable>
</template>

<script>
    import draggable from 'vuedraggable';
    export default {
        data() {
            return {
                tasks: [],
                newItemId: null
            }
        },
        components: {
            draggable: draggable
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
            toggle(task, e) {
                task.status = ! task.status;
                e.target.closest('.mdl-list__item-primary-content')
                    .querySelector('.mdl-list__input')
                    .disabled = task.status;

                this.$http.patch('/task/' + task.id, {
                    status: task.status
                });
            },
            update: _.debounce(function(id, e) {
                let task = _.find(this.tasks, ['id', id]);
                task.name = e.target.value;
                this.$http.patch('/task/' + id, {
                    name: task.name
                }).then(response => {
                    this.showSnackBar('Task saved!');
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

                let bottomOrder = e.item.nextSibling.nodeName === '#text'
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
        padding: 0;
        margin-bottom: 15px;
        background-color: #fff;
        box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 1px 5px 0 rgba(0,0,0,0.12), 0 3px 1px -2px rgba(0,0,0,0.2);
    }
    .handle {
        margin-left: 5px;
    }
    .toggle {
        cursor: pointer;
        margin-right: 5px;
        -webkit-appearance: none;
        appearance: none;
    }
    .toggle:after {
        content: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="-10 -18 100 135"><circle cx="50" cy="50" r="50" fill="none" stroke="#ededed" stroke-width="3"/></svg>');
    }
    .toggle.checked:after {
        content: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="-10 -18 100 135"><circle cx="50" cy="50" r="50" fill="none" stroke="#bddad5" stroke-width="3"/><path fill="#5dc2af" d="M72 25L42 71 27 56l-4 4 20 20 34-52z"/></svg>');
    }
    .mdl-list__input {
        font-size: 22px;
        outline: none;
        border: none;
        width: 100%;
        transition: color 0.4s, font-size 0.2s;
    }
    .through {
        text-decoration: line-through;
        color: #a9a5a5;
        background: #fff;
        font-size: 18px;
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
    .mdl-list__item-secondary-action {
        display: none;
    }
    .mdl-list__item-secondary-action i {
        color: #97b498;
    }
    .mdl-list__item:hover .mdl-list__item-secondary-action {
        display: block;
    }
</style>
