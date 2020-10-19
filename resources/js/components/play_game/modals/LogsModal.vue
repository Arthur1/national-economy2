<template>
    <div class="modal fade" id="logsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ログ</h5>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div v-for="round of 9" :key="round" class="rounds">
                        <div v-if="logs[round]">
                            <h6 class="font-weight-bold">ラウンド{{ round }}</h6>
                            <div class="logs">
                                <div v-for="log in logs[round]" :key="log.id">{{ log.text }}</div>
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
.rounds {
    display: flex;
    flex-direction: column-reverse;
}
.logs {
    display: flex;
    flex-direction: column-reverse;
}
</style>
