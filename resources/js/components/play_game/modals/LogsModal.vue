<template>
    <div class="modal fade" id="logsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ログ</h5>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div v-for="round of 9" :key="round">
                        <div v-if="logs[round]">
                            <h6 class="font-weight-bold mt-2">ラウンド{{ round }}</h6>
                            <div class="logs">
                                <div v-for="log in logs[round]" :key="log.id" :class="`text-playerOrder-${log.player_order}`">{{ log.text }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Modal from '../../../mixins/modal'

export default {
    props: ['logs'],
    mixins: [Modal]
}
</script>
<style scoped>
/*
.logs {
    display: flex;
    flex-direction: column-reverse;
}
*/
</style>
