<template>
    <div>
        <div class="container">
            <div class="text-center my-5">
                <h1 class="font-weight-bold green-font">{{translate('general.users')}}</h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card-shadow card">
                        <div class="card-header text-center font-weight-bold py-4">
                            <ul class="nav nav-pills custom-pills d-flex justify-content-center" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-subscribers-tab" data-toggle="pill" href="#pills-subscribers" role="tab" aria-controls="pills-subscribers" aria-selected="true">{{translate('general.subscribers')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a @click="getUsers" class="nav-link" id="pills-admins-tab" data-toggle="pill" href="#pills-admins" role="tab" aria-controls="pills-admins" aria-selected="false">{{translate('users-page.admins')}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-subscribers" role="tabpanel" aria-labelledby="pills-subscribers-tab">
                                <div class="pt-4 px-4">
                                    <div class="row d-flex justify-content-center">
                                        <div class="input-group col-12 col-md-4">
                                            <input type="text" v-model="searchKeyword" class="form-control input-lg" :placeholder="translate('general.search')"/>
                                        </div>
                                        <div class="form-group col-12 col-md-4 mt-2 mt-md-0">
                                            <select @change="$refs.customPagination.fetchData(1, searchKeyword, filters)" class="form-control" v-model="filters.status">
                                                <option :value="null" disabled selected hidden>{{translate('general.status')}}</option>
                                                <option :value="$constants.ACTIVE_STATUS">{{$constants.ACTIVE_STATUS}}</option>
                                                <option :value="$constants.INACTIVE_STATUS">{{$constants.INACTIVE_STATUS}}</option>
                                                <option :value="$constants.UNPAID_STATUS">{{$constants.UNPAID_STATUS}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pb-4 px-4">
                                    <div class="table-responsive-sm">
                                        <table class="table table-bordered table-striped text-center">
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th class="text-center text-uppercase">{{translate('general.email')}}</th>
                                                <th class="text-center text-uppercase">{{translate('general.status')}}</th>
                                            </tr>
                                            <tr v-for="subscriber in subscribersData">
                                                <td class="pt-3-half">{{subscriber.id}}</td>
                                                <td class="pt-3-half">{{subscriber.email}}</td>
                                                <td class="pt-3-half">
                                                    <h5>
                                                        <span v-if="subscriber.status == 'UNPAID'" class="badge badge-secondary p-2">{{translate('general.'+subscriber.status)}}</span>
                                                        <span v-else-if="subscriber.status == 'ACTIVE'" class="badge badge-success cursor-pointer p-2" @click="updateStatus(subscriber)">{{translate('general.'+subscriber.status)}}</span>
                                                        <span v-else class="badge badge-danger cursor-pointer p-2" @click="updateStatus(subscriber)">{{translate('general.'+subscriber.status)}}</span>
                                                    </h5>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <custom-pagination ref="customPagination" :data-url="this.$constants.ADMIN_ROUTE_PREFIX + this.$constants.SUBSCRIBERS_DATA_ROUTE" v-on:pagination="pageChanged($event)" :filters-prop="filters" :search-keyword="searchKeyword"></custom-pagination>
                                <change-subscriber-status ref="changeSubscriberStatusModal" v-on:updated="updateData()"></change-subscriber-status>
                            </div>
                            <div class="tab-pane fade" id="pills-admins" role="tabpanel" aria-labelledby="pills-admins-tab">
                                <div class="card-body pb-4 px-4">
                                    <div class="table-responsive-md">
                                        <table class="table table-bordered table-striped text-center">
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th class="text-center text-uppercase">{{translate('general.name')}}</th>
                                                <th class="text-center text-uppercase">{{translate('general.email')}}</th>
                                            </tr>
                                            <tr v-for="user in usersData">
                                                <td class="pt-3-half">{{user.id}}</td>
                                                <td class="pt-3-half">{{user.name}}</td>
                                                <td class="pt-3-half">{{user.email}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                subscribersData: [],
                usersData: [],
                searchKeyword: '',
                filters: {
                    status: null,
                },
                constants: window.constants
            }
        },
        methods: {
            getUsers() {
                axios.get(this.$constants.ADMIN_ROUTE_PREFIX + this.$constants.USERS_DATA_ROUTE).then((response) => {
                    this.usersData = response.data.entity;
                });
            },

            pageChanged(data) {
                this.subscribersData = data.data;
            },

            updateStatus(data) {
                this.$refs.changeSubscriberStatusModal.open(data);
            },

            updateData() {
                this.$refs.customPagination.fetchData();
            },
        }
    }
</script>
