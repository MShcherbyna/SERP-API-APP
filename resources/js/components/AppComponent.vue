<template>
    <main role="main" class="container">
        <div class="alert alert-danger" role="alert" v-show="showErros">
            <p
                v-for="(error, index) in errors"
                v-bind:key="index"
            >{{ error }}</p>
        </div>
        <div class="alert alert-success" role="alert" v-show="success">
            Request processed successfully
        </div>
        <div class="jumbotron">
            <h1>SERP API</h1>
            <form>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="phrase">Search phrase:</label>
                        <input type="text" class="form-control" id="phrase" v-model="searchPhrase">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="location">Location</label>
                        <select id="location" class="form-control" v-model="location" @change="getSearchEngin">
                            <option value="" selected>Choose location</option>
                            <option value="UA">Ukraine</option>
                            <option value="US">USA</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3" v-if="isReadonly">
                        <label for="searchSystem">Search Engine</label>
                        <input type="text" class="form-control" v-bind:readonly="isReadonly" value="Choose search engine">
                    </div>
                    <div class="form-group col-md-3" v-else>
                        <label for="searchSystem">Search Engine</label>
                        <select id="searchSystem" class="form-control" v-model="searchEngin">
                            <option value="" selected>Choose search engin</option>
                            <option
                                v-for="engin in searchEngins"
                                v-bind:key="engin.se_id"
                                v-bind:value="engin.se_id"
                            > {{engin.se_name}} </option>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" @click="onSearch()">Search</button>
            </form>
        </div>
    </main>
</template>

<script>
    export default {
        data() {
            return {
                searchPhrase: "",
                location: "",
                searchEngin: null,
                isReadonly: true,
                searchEngins: [],
                errors: [],
                showErros: false,
                success: false,
            };
        },
        methods: {
            onSearch: function() {
                if (this.validator() === false) {
                    this.showErros = true;

                    return false;
                }

                this.showErros = false;

                this.axios.post('/api/task', {
                    searchPhrase: this.searchPhrase,
                    location: this.getLocationCanonicalName(this.location),
                    searchEngin: this.searchEngin
                })
                .then(response => {
                    this.showErros = false;
                    this.success = true;
                    this.clear();
                })
                .catch(error => {
                    this.success = false;
                    this.showErros = true;
                    this.errors.push(error);
                })

            },
            getSearchEngin() {
                if (this.location == "") {
                    this.isReadonly = true;
                    this.searchEngins = [];

                    return false;
                }

                this.isReadonly = false;

                let url = '/api/get-engines/' + this.location;

                this.axios.get(url).then((response) => {
                    this.searchEngins = response.data
                }).catch(error => {
                    console.error(error);
                    return false;
                }).finally(() => (this.isReadonly = false));
            },
            validator() {
                let errorCount = 0;

                this.errors = [];

                if(this.searchPhrase.trim() == "") {
                    errorCount++;
                    this.errors.push("Field Search phrase is empty");
                }
                if(this.location.trim() == "") {
                    errorCount++;
                    this.errors.push("Field location is empty");
                }

                if(this.searchEngin == null) {
                    errorCount++;
                    this.errors.push("Field Search Engine is empty");
                }

                if (errorCount > 0) return false;

                return true;
            },
            clear() {
                this.searchPhrase = "",
                this.location = "",
                this.searchEngin = "",
                this.isReadonly = true,
                this.searchEngins = [],
                this.errors = [],
                this.showErros = false
            },
            getLocationCanonicalName(key) {
                let names = {
                    'UA': 'Ukrain',
                    'US': 'United States'
                }

                return names[key];
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
        }
    }
</script>
