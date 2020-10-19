<template>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <div class="gameStateDisplay border rounded border-dark">
                    <div><span class="mr-1rem font-weight-bold">ラウンド{{ game.round }}</span>（賃金${{ game.wage }}）</div>
                    <div><span class="mr-1rem">家計: ${{ game.pool }}</span>山札: {{ game.pile_cards_number }}枚</div>
                </div>
                <div class="btn-group">
                    <button type="button" @click="$emit('push-open-logs-modal-button')" class="btn btn-outline-dark">ログ</button>
                    <button type="button" @click="$emit('push-open-summary-modal-button')" class="btn btn-outline-dark">サマリー</button>
                </div>
            </div>
            <div class="col-md-9">
                <div class="buildingBox">
                    <building-card
                        v-for="building in game.public_buildings"
                        :key="building.id"
                        :building="building"
                        :currentWindow="currentWindow"
                        :isMyTurn="isMyTurn"
                        @push-open-use-building-modal-button="emitPushOpenUseBuildingModal"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import BuildingCard from '../cards/BuildingCard.vue'
export default {
    props: ['game', 'currentWindow', 'isMyTurn'],
    components: { BuildingCard },
    methods: {
        emitPushOpenUseBuildingModal(building) {
            this.$emit('push-open-use-building-modal-button', building)
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
