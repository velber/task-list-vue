<template>
    <ul class="demo-list-control mdl-list">
        <vddl-list class="panel__body--list" :list="tasks" :horizontal="false">
            <vddl-draggable v-for="(task, key, index) in tasks"
                            :draggable="task"
                            :index="index"
                            :wrapper="tasks"
                            effect-allowed="move"
                            :key="task.id">
                <vddl-nodrag class="nodrag">
                    <vddl-handle
                            :handle-left="20"
                            :handle-top="20"
                            class="handle">
                        <button class="mdl-button mdl-js-button mdl-button--icon">
                            <i class="material-icons">blur_on</i>
                        </button>
                    </vddl-handle>
                    <li class="mdl-list__item">
                        <span class="mdl-list__item-check">
                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect"
                                   :for="getCheckboxId(task.id)"
                                   style="width: 30px;">
                               <input type="checkbox" :id="getCheckboxId(task.id)" class="mdl-checkbox__input" checked/>
                            </label>
                        </span>
                        <span class="mdl-list__item-primary-content">
                            {{ task.name }}
                        </span>
                        <span class="mdl-list__item-secondary-action">
                            <button class="mdl-button mdl-js-button mdl-button--icon">
                                <i class="material-icons">cancel</i>
                            </button>
                        </span>
                    </li>
                </vddl-nodrag>
            </vddl-draggable>
        </vddl-list>
    </ul>
</template>

<script>
    export default {
        data() {
            return {
                tasks: []
            }
        },
        components: {

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
    .vddl-nodrag {
        display: flex;
    }
    .vddl-handle {
        display: flex;
        align-items: center;
    }
    .mdl-list__item {
        flex-grow: 2;
    }
    .mdl-list__item-check {
        padding-left: 5px;
    }
</style>
