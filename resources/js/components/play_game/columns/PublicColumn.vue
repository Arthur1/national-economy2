<template>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <div class="gameStateDisplay border rounded border-dark">
                    <div><span class="mr-1rem font-weight-bold">ラウンド{{ game.round }}</span> (賃金${{ game.wage }})</div>
                    <div><span class="mr-1rem">家計: ${{ game.pool }}</span>山札: {{ game.pile_cards_number }}枚</div>
                </div>
                <div class="btn-group mt-3">
                    <button type="button" @click="fetchLogs" class="btn btn-outline-secondary" data-toggle="modal" data-target="#logsModal">ログ</button>
                    <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#summaryModal">サマリー</button>
                </div>
                <logs-modal ref="logsModal" />
                <summary-modal :game="game" />
            </div>
            <div class="col-md-9">
                <div class="buildingBox">
                    <building-card
                        v-for="building in game.public_buildings"
                        :key="building.id"
                        :building="building"
                        :currentWindow="currentWindow"
                        :isMyTurn="isMyTurn"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import BuildingCard from '../cards/BuildingCard.vue'
import SummaryModal from '../modals/SummaryModal.vue'
import LogsModal from '../modals/LogsModal.vue'
export default {
    props: ['game'],
    components: { BuildingCard, SummaryModal, LogsModal },
    data() {
        return {
            currentWindow: 'WindowHandCards',
        }
    },
    computed: {
        isMyTurn() {
            return false
        }
    },
    methods: {
        fetchLogs() {
            this.$refs.logsModal.fetchLogs()
        }
    }
}
</script>
<style scoped>
.buildingBox {
    display: flex;
    flex-wrap: wrap;
}
.gameStateDisplay {
    margin: 0.5rem 0;
    padding: 0.3rem;
    box-sizing: border-box;
}
.mr-1rem {
    margin-right: 1rem;
}
</style>
