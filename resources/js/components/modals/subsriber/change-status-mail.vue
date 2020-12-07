<template>
    <div>
        <div v-if="showModal" class="custom-modal">
            <div class="custom-modal-content">
                <div class="custom-modal-header pb-3">
                    <span class="close" @click="close">&times;</span>
                    <h5>{{subscriberData.email}}</h5>
                </div>
                <div class="custom-modal-body text-center py-3 font-16">
                    <p>{{translate('landing-page.receiveMail')}}
                        <br>
                        {{translate('landing-page.yourStatus')}}<b class="green-font">{{subscriberData.status}}</b>
                    </p>
                </div>
                <div class="custom-modal-footer text-right pt-3">
                    <form v-on:submit.prevent="submit">
                        <button type="button" class="btn btn-secondary" @click="close">{{translate('general.close')}}</button>
                        <button type="submit" class="btn btn-green">{{translate('landing-page.sendMail')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                showModal: false,
                subscriberData: {},
            }
        },
        methods: {
            open(data) {
                this.subscriberData = data;
                this.showModal = true;
            },

            close() {
                this.showModal = false;
            },

            submit() {
                axios.get(this.$constants.SEND_MAIL_ROUTE + this.subscriberData.id).then((response) => {
                    this.$emit('updated', true);
                    this.showModal = false;
                }).catch((error) => {
                    this.showModal = false;
                });
            },
        }
    }
</script>
