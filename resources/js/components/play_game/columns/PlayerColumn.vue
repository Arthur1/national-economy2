<template>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <div class="playerStateDisplay border rounded" :class="[`border-playerOrder-${player.player_order}`]">
                    <div>
                        <span class="mr-1rem font-weight-bold" :class="`text-playerOrder-${player.player_order}`"><font-awesome-icon v-if="isSelfTurn" icon="angle-double-right" />{{ player.user.name }}</span>
                        <span v-if="player.is_sp" class="text-danger">[SP]</span>
                    </div>
                    <div>
                        <span class="mr-1rem">
                            <span v-for="n of player.active_workers_number" :key="`active_${n}`" :class="[`text-playerOrder-${player.player_order}`]">●</span><span v-for="n of inactiveWorkersNumber" :key="`inactive_${n}`" :class="[`text-playerOrder-${player.player_order}`]">◯</span>
                        </span>
                        （<span :class="`text-playerOrder-${player.player_order}`">{{ player.workers_number }}</span><span v-if="player.dolls_number">+{{ player.dolls_number }}</span>人）
                    </div>
                    <div>
                        <span class="mr-1rem">所持金: ${{ player.money }}</span>
                        手札: <span class="text-card-building">{{ player.hand_buildings_number }}</span>+<span class="text-card-goods">{{ player.hand_goods_number }}</span>枚
                    </div>
                    <div>
                        <span class="mr-1rem">勝利点: {{ player.vp_token }}枚</span>
                        未払い賃金: {{ player.debt }}枚
                    </div>
                    <div class="font-weight-bold text-danger" v-if="player.rank">
                        <span class="mr-1rem">{{ player.vp }}点</span>{{ player.rank }}位
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="buildingBox">
                    <building-card
                        v-for="building in player.buildings"
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
    props: ['player', 'currentWindow', 'isMyTurn', 'isSelfTurn'],
    components: { BuildingCard },
    data() {
        return {}
    },
    computed: {
        inactiveWorkersNumber() {
            return this.player.workers_number + this.player.dolls_number - this.player.active_workers_number
        }
    },
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
.playerStateDisplay {
    margin: 0.5rem 0;
    padding: 0.3rem;
    box-sizing: border-box;
}
.mr-1rem {
    margin-right: 1rem;
}
.playerStateDisplay svg {
    margin-right: 0.5em;
}
</style>
