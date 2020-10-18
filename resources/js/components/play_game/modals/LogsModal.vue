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
export default {
    data() {
        return {
            logs: [],
            isLatest: false
        }
    },
    computed: {
        filteredLogs() {
            return this.logs.filter(log => log.text).reverse()
        }
    },
    methods: {
        fetchLogs() {
            if (this.isLatest) return
            axios.get(`/api/games/${this.$route.params.id}/logs`).then(res => {
                this.logs = res.data
                this.isLatest = true
                console.log(res.data)
            }).catch(err => {
                console.error(err)
            })
        }
    }
}
</script>
