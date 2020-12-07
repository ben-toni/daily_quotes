<template>
    <div>
        <div v-if="showModal" class="custom-modal">
            <div class="custom-modal-content">
                <div class="custom-modal-header pb-3">
                    <span class="close" @click="close">&times;</span>
                    <h3>{{translate('quotes-page.singleQuote')}}</h3>
                </div>
                <div class="custom-modal-body text-center py-3 font-16">
                    <p>{{quoteData.description}}</p>
                </div>
                <div class="custom-modal-footer text-right pt-3">
                    <button type="button" class="btn btn-secondary" @click="close">{{translate('general.close')}}</button>
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
        }
    }
</script>
