<template>
    <div class="modal fade" id="pickModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">確認</h5>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body" v-if="pickPileCard">
                    本当に{{ pickPileCard.card.name }}を手札に加えますか？
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">考え直す</button>
                    <button type="button" class="btn btn-primary text-white" @click="$emit('push-pick-button')">手札に加える</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Modal from '../../../mixins/modal'

export default {
    props: ['pickPileCard'],
    mixins: [Modal]
}
</script>
