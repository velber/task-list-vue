<template>
    <li class="mdl-list__item">
        <span class="mdl-list__item-check">
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" :for="getCheckboxId(task.id)"
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
</template>

<script>
    export default {
        props: ['task'],
        components: [''],
        methods: {
            getCheckboxId(id) {
                return `list-checkbox-${id}`;
            }
        },
        mounted() {
            //console.log(this.task);
        }
    }
</script>

<style>
    .mdl-list__item-check {
        padding-left: 5px;
    }
</style>
