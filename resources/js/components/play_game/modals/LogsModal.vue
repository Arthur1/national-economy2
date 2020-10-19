<template>
    <div class="modal fade" id="logsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ログ</h5>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div v-for="log in filteredLogs" :key="log.id" class="alert alert-dark">
                        {{ log.text }}
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
    mixins: [Modal],
    computed: {
        filteredLogs() {
            return this.logs.filter(log => log.text).reverse()
        }
    }
}
</script>
