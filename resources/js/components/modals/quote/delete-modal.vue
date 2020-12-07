<template>
    <div>
        <div v-if="showModal" class="custom-modal">
            <div class="custom-modal-content">
                <div class="custom-modal-header pb-3">
                    <span class="close" @click="close">&times;</span>
                    <h3>{{translate('quotes-page.deleteQuote')}}</h3>
                </div>
                <div class="custom-modal-body text-center py-3 font-16">
                    <p>{{translate('quotes-page.deleteQuoteDesc')}}</p>
                </div>
                <div class="custom-modal-footer text-right pt-3">
                    <form v-on:submit.prevent="submit">
                        <button type="button" class="btn btn-secondary" @click="close">{{translate('general.close')}}</button>
                        <button type="submit" class="btn btn-green">{{translate('general.delete')}}</button>
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
                quoteData: [],
            }
        },
        methods: {
            open(data) {
                this.quoteData = data;
                this.showModal = true;
            },

            close() {
                this.showModal = false;
            },

            submit() {
                axios.delete(this.$constants.ADMIN_ROUTE_PREFIX + this.$constants.QUOTES_SLASH_ROUTE + this.quoteData.id).then((response) => {
                    this.$emit('updated', true);
                    this.showModal = false;
                }).catch((error) => {
                    this.showModal = false;
                });
            },
        }
    }
</script>
