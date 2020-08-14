<template>
    <div class="main-tabel">
        <nav v-if="pagination.last_page > 1">
            <ul class="pagination justify-content-center">
                <li
                    class="page-item"
                    @click="fatchPaginate(pagination.prev_page_url)"
                    :disabled="!pagination.prev_page_url"
                >
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item"><span class="page-link-custom">{{pagination.current_page}}</span></li>
                <li class="page-item"><span class="page-link-custom">of</span></li>
                <li class="page-item"><span class="page-link-custom">{{pagination.last_page}}</span></li>
                <li
                    class="page-item"
                    @click="fatchPaginate(pagination.next_page_url)"
                    :disabled="!pagination.next_page_url"
                >
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Post Key</th>
                    <th scope="col">Result Url</th>
                    <th scope="col">Result Title</th>
                    <th scope="col">Loc Id</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="result in taskResults.data" v-bind:key="result.id">
                    <th scope="row">{{ result.id }}</th>
                    <td>{{ result.post_key }}</td>
                    <td>{{ result.result_url }}</td>
                    <td>{{ result.result_title }}</td>
                    <td>{{ result.loc_id }}</td>
                </tr>
            </tbody>
        </table>
        <button class="btn" @click="goBack()">&lt;&lt; Go Back</button>
    </div>
</template>

<script>
    export default {
        props: ['taskResults', 'pagination'],
        methods: {
            goBack() {
                this.$emit('goBack');
            },
            fatchPaginate(url) {
                this.$emit('fatchPaginate', url);
            }
        }
    }
</script>
