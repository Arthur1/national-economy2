<template>
    <div class="modal fade" id="ruralModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">確認</h5>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body" v-if="rural_action_id === 1">
                    本当に「消費財を2枚引く」でよろしいですか？
                </div>
                 <div class="modal-body" v-else-if="rural_action_id === 2">
                    本当に「消費財を2枚捨てて建物を3枚引く」でよろしいですか？
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">考え直す</button>
                    <button type="button" class="btn btn-primary text-white" @click="$emit('push-rural-action-button')">実行する</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Modal from '../../../mixins/modal'

export default {
    props: ['rural_action_id'],
    mixins: [Modal]
}
</script>
