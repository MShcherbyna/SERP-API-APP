<template>
    <main role="main" class="container">
        <div class="alert alert-success" role="alert" v-show="success">
            Task status updated!
        </div>
        <div class="jumbotron">
            <div class="task-results" v-if="showResults">
                <tasks-results
                    v-bind:task-results="taskResults"
                    v-bind:pagination="pagination"
                    @goBack="goBack"
                    @fatchPaginate="paginate"
                ></tasks-results>
            </div>
            <div class="main-tabel" v-else>
                <button class="btn" @click="updateStatus()">&lt;&lt; Update status &gt;&gt;</button>
                <tasks-list
                    v-bind:tasks-list="tasksList"
                    @showResults="showTaskResults"
                ></tasks-list>
            </div>
        </div>
    </main>
</template>

<script>
    export default {
        created(){
            this.axios.get('/api/task').then((response) => {
                this.tasksList = response.data;
            }).catch(error => {
                console.error(error);
                return false;
            });
        },
        data() {
            return {
                tasksList: [],
                taskResults: [],
                pagination: [],
                showResults: false,
                success: false
            };
        },
        methods: {
            showTaskResults(taskId, nextStepUrl = '') {
                let url = (nextStepUrl === '') ? ('/api/task/' + taskId) : nextStepUrl;

                this.axios.get(url).then((response) => {
                    this.taskResults = response.data;
                    this.makePagination(response.data);
                    this.showResults = true;
                }).catch(error => {
                    console.error(error);
                    return false;
                });
            },
            goBack() {
                this.taskResults = [];
                this.showResults = false;
            },
            paginate(url) {
                this.showTaskResults(null, url);
            },
            makePagination(data) {
                let pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url,
                    total: data.total
                }

                this.pagination = pagination;
            },
            updateStatus() {
                this.axios.get('/api/task').then((response) => {
                    this.tasksList = response.data;
                    this.success = true;
                    setTimeout(() => this.success = false, 2000)
                }).catch(error => {
                    console.error(error);
                    return false;
                });
            }
        }
    }
</script>
