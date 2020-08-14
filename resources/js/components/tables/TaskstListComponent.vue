<template>
    <div class="main-tabel">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Task ID</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created at</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="task in tasksList" v-bind:key="task.id">
                    <th scope="row">{{ task.id }}</th>
                    <td>{{ task.task_id }}</td>
                    <td>{{ task.status == 1 ? 'complete' : task.status == 0 ? 'pending' : 'error' }}</td>
                    <td>{{ task.created_at | moment("YYYY-MM-DD") }}</td>
                    <th scope="col"><span class="btn btn-link" @click="showTaskResult(task.task_id)">show</span></th>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['tasksList'],
        methods: {
            showTaskResult(taskId) {
                this.$emit('showResults', taskId);

                return false;
            }
        }
    }
</script>
