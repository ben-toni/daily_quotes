<template>
    <div>
        <div v-if="showModal" class="custom-modal">
            <div class="custom-modal-content">
                <div class="custom-modal-header pb-3">
                    <span class="close" @click="close">&times;</span>
                    <h5>{{subscriberData.email}}</h5>
                </div>
                <div class="custom-modal-body text-center py-3 font-16">
                    <p class="font-weight-bold green-font">Pay {{$constants.PRICE_STRING}}&#8364; to use application and
                        receive quotes!</p>
                    <div id="paypal-button-container"></div>
                </div>
                <div class="custom-modal-footer text-right pt-3">
                    <button type="button" class="btn btn-secondary" @click="close">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                showModal: false,
                constants: this.$constants,
                subscriberData: {},
                paypal: process.env.MIX_PAYPAL_CLIENT_ID,
            }
        },
        mounted() {
            let recaptchaScript = document.createElement('script');
            recaptchaScript.setAttribute('src', 'https://www.paypal.com/sdk/js?client-id=' + this.paypal + '&currency=EUR');
            document.head.appendChild(recaptchaScript);
        },
        methods: {
            renderPayPalElement() {
                paypal.Buttons({
                    createOrder: (data, actions) => {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: this.$constants.PRICE,
                                },
                                currency: 'EUR'
                            }]
                        });
                    },
                    onApprove: (data, actions) => {
                        return actions.order.capture().then( (details) => {
                            axios.get(this.$constants.STATUS_TO_ACTIVE_ROUTE + this.subscriberData.id).then((response) => {
                                this.close();
                                window.toastr.success(this.translate('general.'+response.data.message));
                            }).catch((error) => {
                                this.close();
                                window.toastr.error(this.translate('general.'+response.data.message));
                            });
                        });
                    }
                }).render('#paypal-button-container');
            },

            open(data) {
                this.subscriberData = data;
                this.showModal = true;
                this.$nextTick(() => {
                    this.renderPayPalElement();
                });
            },

            close() {
                this.showModal = false;
            },
        }
    }
</script>
