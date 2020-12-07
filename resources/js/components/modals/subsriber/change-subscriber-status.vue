<template>
    <div>
        <div v-if="showModal" class="custom-modal">
            <div class="custom-modal-content">
                <div class="custom-modal-header pb-3">
                    <span class="close" @click="close">&times;</span>
                    <h5>{{subscriberData.email}}</h5>
                </div>
                <div class="custom-modal-body text-center py-3 font-16">
                    <p>{{translate('users-page.changeSubscriberStatus')}}</p>
                </div>
                <div class="custom-modal-footer text-right pt-3">
                    <form v-on:submit.prevent="submit">
                        <button type="button" class="btn btn-secondary" @click="close">{{translate('general.close')}}</button>
                        <button type="submit" class="btn btn-green">{{translate('users-page.changeStatus')}}</button>
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
                subscriberData: [],
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
                if (this.subscriberData.status == this.$constants.ACTIVE_STATUS) {
                    this.subscriberData.status = this.$constants.INACTIVE_STATUS
                } else {
                    this.subscriberData.status = this.$constants.ACTIVE_STATUS
                }
                axios.put(this.$constants.ADMIN_ROUTE_PREFIX + this.$constants.SUBSCRIBERS_SLASH_ROUTE + this.subscriberData.id, this.subscriberData).then((response) => {
                    this.$emit('updated', true);
                    this.showModal = false;
                }).catch((error) => {
                    this.showModal = false;
                });
            },
        }
    }
</script>
