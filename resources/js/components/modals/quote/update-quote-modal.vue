<template>
    <div>
        <div v-if="showModal" class="custom-modal">
            <div class="custom-modal-content">
                <div class="custom-modal-header pb-3">
                    <span class="close" @click="close">&times;</span>
                    <h3>{{translate('quotes-page.updateQuote')}}</h3>
                </div>
                <form v-on:submit.prevent="submit">
                    <div class="custom-modal-body py-3">
                        <div class="form-group">
                            <textarea v-model="quoteData.description" class="form-control" :placeholder="translate('general.quote')" rows="5" required>{{quoteData.description}}</textarea>
                        </div>
                    </div>
                    <div class="custom-modal-footer text-right pt-3">
                        <button type="button" class="btn btn-secondary" @click="close">{{translate('general.close')}}</button>
                        <button type="submit" class="btn btn-green">{{translate('general.update')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                showModal: false,
                quoteData: {},
            }
        },
        methods: {
            open(data) {
                this.quoteData = Object.assign({}, data);
                this.showModal = true;
            },

            close() {
                this.showModal = false;
            },

            submit() {
                axios.put(this.$constants.ADMIN_ROUTE_PREFIX + this.$constants.QUOTES_SLASH_ROUTE + this.quoteData.id, this.quoteData).then((response) => {
                    this.$emit('updated', true);
                    this.showModal = false;
                }).catch((error) => {
                    this.showModal = false;
                });
            },
        }
    }
</script>
