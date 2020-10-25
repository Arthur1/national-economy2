<template>
    <div class="modal fade" id="sellModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">確認</h5>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    本当に{{ cardNames }}を売却しますか？
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">考え直す</button>
                    <button type="button" class="btn btn-primary text-white" @click="$emit('push-sell-button')" :disabled="isLoading">売却する</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Modal from '../../../mixins/modal'

export default {
    props: ['sellBuildings', 'isLoading'],
    mixins: [Modal],
    computed: {
        cardNames() {
            if (! this.sellBuildings) return '';
            return this.sellBuildings.map(hand_card => hand_card.card.name).join('・')
        }
    }
}
</script>
