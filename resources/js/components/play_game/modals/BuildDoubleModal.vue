<template>
    <div class="modal fade" id="buildDoubleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">確認</h5>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body" v-if="cardNames">
                    本当に{{ cardNames }}を建設しますか？
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">考え直す</button>
                    <button type="button" class="btn btn-primary text-white" @click="$emit('push-build-double-button')" :disabled="isLoading">建設する</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Modal from '../../../mixins/modal'

export default {
    props: ['buildHandCards', 'isLoading'],
    mixins: [Modal],
    computed: {
        cardNames() {
            return this.buildHandCards.map(hand_card => hand_card.card.name).join('・')
        }
    }
}
</script>
