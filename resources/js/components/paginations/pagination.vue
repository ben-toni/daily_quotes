<template>
    <div v-show="data.last_page > 1" class="custom-pagination d-flex justify-content-center">
        <ul class="pagination" v-if="data.last_page > 1">

            <li v-if="data.prev_page_url" class="page-item">
                <a @click="fetchData(data.current_page - 1)" class="page-link a-green" href="javascript:void(0)">{{translate('pagination.previous')}}</a>
            </li>

            <li v-for="page in lowerVisiblePages" class="page-item">
                <a @click="fetchData(page)" class="page-link a-green" href="javascript:void(0)">{{page}}</a>
            </li>

            <li class="page-item">
                <a class="active-page-link page-link green-bg white-color" v-if="data.current_page !== 0" href="javascript:void(0)">{{data.current_page}}</a>
            </li>

            <li v-for="page in higherVisiblePages" class="page-item">
                <a class="page-link a-green" href="javascript:void(0)" @click="fetchData(page)">{{page}}</a>
            </li>

            <li v-if="data.next_page_url" class="page-item">
                <a class="page-link a-green" href="javascript:void(0)" @click="fetchData(data.current_page + 1)">{{translate('pagination.next')}}</a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "pagination",
        data() {
            return {
                data: {
                    current_page: 0,
                    last_page: 0
                },
                url: this.dataUrl,
                filters: this.filtersProp
            }
        },
        props: {
            formData: {
                type: Object,
                default: () => {return {}}
            },
            maxSideButtons: {
                type: Number,
                required: false,
                default: 2
            },
            dataUrl: {
                type: String,
                required: true,
            },
            searchKeyword: {
                type: String,
                required: false,
                default: ''
            },
            method: {
                type: String,
                required: false,
                default: 'post'
            },
            filtersProp: {
                type: Object,
                required: false,
                default: null
            },
        },
        watch: {
            searchKeyword: function (value) {

                this.fetchData(null, value);
            },
        },
        computed: {
            higherVisiblePages() {
                const higherVisiblePages = [];
                for (let i = this.data.current_page + 1; i <= Math.min(this.data.current_page + this.maxSideButtons, this.data.last_page); i++) {
                    higherVisiblePages.push(i);
                }

                return higherVisiblePages;
            },
            lowerVisiblePages() {
                const lowerVisiblePages = [];
                for (let i = Math.min(this.data.current_page - this.maxSideButtons, this.data.current_page); i < this.data.current_page; i++) {
                    if (i > 0) {
                        lowerVisiblePages.push(i);
                    }
                }

                return lowerVisiblePages;
            },
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData(pageNumber = '', keyword = '', filters = null) {
                if (pageNumber === '') {
                    pageNumber = this.data.current_page;
                }
                let page = (pageNumber ? ('?page=' + pageNumber) : '');
                this.formData['searchKeyword'] = keyword;
                this.formData['filters'] = filters;

                axios.post(this.url + page, this.formData)
                    .then((response) => {
                        if (!(response.data.entity === undefined)) {
                            this.data = response.data.entity;
                        }
                    }).then(() => {
                    this.$emit('pagechanged', this.data);
                    this.$emit('pagination', this.data);
                })
            },
        }
    }
</script>
