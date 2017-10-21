<template>
    <div>
        {{ task.name }}
    </div>
</template>

<script>
    export default {
        props: ['task'],
        mounted() {
            console.log(this.task);
        }
    }
</script>
