<template>
    <div>
        <div class="container-fluid">
            <div class="row d-flex align-items-center">
                <div class="col-12 col-md-6 mt-5 mt-md-0">
                    <div class="w-75 text-center m-auto">
                        <div class="logo mb-5">
                            <i class="fas fa-quote-right"></i>
                        </div>
                        <h1 class="green-font font-weight-bold">Quotes App</h1>
                        <p class="grey-font mt-5">
                            {{translate('landing-page.landingDesc')}}
                        </p>
                        <form v-on:submit.prevent="submit">
                            <div class="z-index-0 custom-group-input input-group input-group-lg mt-5">
                                <input v-model="subscriberData.email" style="z-index:0" type="email" class="form-control" :placeholder="translate('general.yourEmail')" required>
                                <div class="input-group-append">
                                    <button type="submit" class="input-group-text green-bg cursor-pointer white-color">{{translate('general.subscribe')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <img class="w-100" :src="'/img/background.jpg'">
                </div>
            </div>
        </div>
        <!-- Components -->
        <change-status-mail ref="changeStatusModal"></change-status-mail>
        <payment-modal ref="paymentModal"></payment-modal>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                subscriberData: {},
            }
        },
        methods: {
            submit() {
                axios.post(this.$constants.SUBSCRIBERS_ROUTE, this.subscriberData).then((response) => {
                    this.subscriberData = response.data.entity;
                    if (this.subscriberData.status == this.$constants.UNPAID_STATUS) {
                        this.$refs.paymentModal.open(response.data.entity);
                    } else if (this.subscriberData.status == this.$constants.ACTIVE_STATUS){
                        this.$refs.changeStatusModal.open(response.data.entity);
                    } else if (this.subscriberData.status == this.$constants.INACTIVE_STATUS){
                        this.$refs.changeStatusModal.open(response.data.entity);
                    } else {
                        this.$refs.paymentModal.open(response.data.entity);
                    }

                    this.subscriberData = {};
                });
            },
        }
    }
</script>
