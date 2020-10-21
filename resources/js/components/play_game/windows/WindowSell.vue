<template>
    <div>
        <button class="btn btn-secondary btn-sm toggleButton" @click="toggle">切り替え</button>
        <div class="buildingsWrapper row" v-if="isMain">
            <div class="col-md-12">
                <p class="mt-3 text-danger">売却する建物を選択してください。</p>
                <form @submit.prevent="$emit('push-open-sell-modal-button', sellBuildings)">
                    <div class="handCardsBox">
                        <div class="handCardDummy text-center">
                            <button type="submit" class="btn btn-primary btn-sm text-white" :disabled="! sell_ids.length">決定</button>
                        </div>
                        <label v-for="building in buildings" :key="building.id" :for="'form_sell_ids-' + building.id" :class="{ 'cardLabel': building.card.is_sellable, 'is-selected': sell_ids.includes(building.id) }">
                            <sell-building-card :building="building" />
                        </label>
                    </div>
                    <div class="sellCheckBox">
                        <div class="sellCheck">売却</div>
                        <div v-for="building in buildings" :key="building.id" class="sellCheck">
                            <input type="checkbox" v-model="sell_ids" :value="building.id" :id="'form_sell_ids-' + building.id" :disabled="! building.card.is_sellable">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <window-hand-cards v-else :game="game" />
    </div>
</template>
<script>
import SellBuildingCard from '../cards/SellBuildingCard.vue'
import WindowHandCards from './WindowHandCards.vue'
export default {
    components: {
        SellBuildingCard,
        WindowHandCards
    },
    props: ['game'],
    data() {
        return {
            sell_ids: [],
            isMain: true,
        }
    },
    computed: {
        buildings() {
            if (! this.game) return []
            const my_player = this.game.players.find(player => player.player_order === this.game.my_player_order, this)
            return my_player.buildings
        },
        sellBuildings() {
            return this.buildings.filter(building => this.sell_ids.includes(building.id), this)
        }
    },
    methods: {
        toggle() {
            this.isMain = ! this.isMain
        }
    }
}
</script>
<style scoped>
.cardLabel {
    cursor: pointer;
}
.cardLabel.is-selected {
    filter: drop-shadow(0 0 3px #ffc107 );
}
.buildingsWrapper {
    position: fixed;
    z-index: 100;
    height: 250px;
    width: 100%;
    bottom: 0;
    background: rgba(249, 251, 231, 0.9);
    overflow-x: auto;
}
.toggleButton {
    position: fixed;
    z-index: 100;
    bottom: 260px;
    left: 30px;
}
.handCardsBox, .sellCheckBox {
    display: flex;
    flex-wrap: nowrap;
}
.sellCheck {
    width: 80px;
    margin: 0.25rem;
    text-align: center;
    flex: 0 0 80px;
    min-width: 80px;
}
.handCardDummy {
    width: 80px;
    height: 120px;
    position: relative;
    margin: 0.25rem;
    flex: 0 0 80px;
    min-width: 80px;
}
</style>
