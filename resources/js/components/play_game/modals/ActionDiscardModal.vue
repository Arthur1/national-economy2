<template>
    <div class="modal fade" id="actionDiscardModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">確認</h5>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    本当に{{ cardNames }}を捨てますか？
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">考え直す</button>
                    <button type="button" class="btn btn-primary text-white" @click="$emit('push-action-discard-button')">捨てる</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Modal from '../../../mixins/modal'

export default {
    props: ['discardHandCards'],
    mixins: [Modal],
    computed: {
        cardNames() {
            if (! this.discardHandCards) return '';
            return this.discardHandCards.map(hand_card => hand_card.card.name).join('・')
        }
    }
}
</script>
