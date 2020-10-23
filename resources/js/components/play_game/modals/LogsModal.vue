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
                                <div v-for="log in logs[round]" :key="log.id">
                                    <div v-if="log.type === 'use_building'" class="log">
                                        <font-awesome-icon icon="circle" :class="`text-playerOrder-${log.player_order}`" />{{ log.text }}
                                    </div>
                                    <div v-else-if="log.type === 'action'" class="log log-indented text-muted">
                                        <font-awesome-icon icon="caret-right" />{{ log.text }}
                                    </div>
                                    <div v-else-if="log.type === 'discard'" class="log">
                                        <font-awesome-icon icon="trash" :class="`text-playerOrder-${log.player_order}`" />{{ log.text }}
                                    </div>
                                    <div v-else-if="log.type === 'wage'" class="log">
                                        <font-awesome-icon icon="dollar-sign" :class="`text-playerOrder-${log.player_order}`" />{{ log.text }}
                                    </div>
                                    <div v-else-if="log.type === 'sell_buildings'" class="log log-indented text-muted">
                                        <font-awesome-icon icon="caret-right" />{{ log.text }}
                                    </div>
                                    <div v-else-if="log.type === 'reshuffle'" class="log">
                                        <font-awesome-icon icon="random" />{{ log.text }}
                                    </div>
                                    <div v-else-if="log.type === 'reserve'" class="log">
                                        <font-awesome-icon icon="info-circle" :class="`text-playerOrder-${log.player_order}`" />{{ log.text }}
                                    </div>
                                </div>
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
.log {
    margin: 0.2rem 0;
}
.log-indented {
    padding-left: 1rem;
}
.log svg {
    margin-right: 0.7em;
}
/*
.logs {
    display: flex;
    flex-direction: column-reverse;
}
*/
</style>
