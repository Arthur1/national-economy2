<template>
    <div>
        <button class="btn btn-secondary btn-sm toggleButton" v-if="game.my_player_order" @click="toggle">切り替え</button>
        <div class="designOfficeCardsWrapper row" v-if="isMain">
            <div class="col-md-12">
                <p v-if="isMyTurn" class="mt-3 text-danger">獲得するカードを選択してください。</p>
                <p v-else class="mt-3 text-danger">5枚のカードが公開されました。</p>
                <form @submit.prevent="$emit('push-open-pick-modal-button', pickDesignOfficeCard)">
                    <div class="designOfficeCardsBox">
                        <div class="designOfficeCardDummy text-center">
                            <button v-if="isMyTurn" type="submit" class="btn btn-primary btn-sm text-white" :disabled="! pick_id">決定</button>
                        </div>
                        <label
                            v-for="design_office_card in game.design_office_cards"
                            :key="design_office_card.id"
                            :for="`form_pick_id-${design_office_card.id}`"
                            :class="{'cardLabel': isMyTurn, 'is-selected': pick_id === design_office_card.id }"
                        >
                            <design-office-card :design_office_card="design_office_card" />
                        </label>
                    </div>
                    <div class="pickRadioBox" v-if="isMyTurn">
                        <div class="pickRadio">選択</div>
                        <div v-for="design_office_card in game.design_office_cards" :key="design_office_card.id" class="pickRadio">
                            <input type="radio" required name="pick_id" v-model="pick_id" :id="`form_pick_id-${design_office_card.id}`" :value="design_office_card.id">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <window-hand-cards v-else :game="game" />
    </div>
</template>
<script>
import DesignOfficeCard from '../cards/DesignOfficeCard.vue'
import WindowHandCards from './WindowHandCards.vue'

export default {
    components: { DesignOfficeCard, WindowHandCards },
    props: ['game', 'isMyTurn'],
    data() {
        return {
            pick_id: null,
            isMain: true,
        }
    },
    computed: {
        pickDesignOfficeCard() {
            return this.game.design_office_cards.find(design_office_card => design_office_card.id === this.pick_id, this)
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
    filter: drop-shadow(0 0 3px #3490dc);
}
.designOfficeCardsWrapper {
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
.designOfficeCardsBox, .pickRadioBox {
    display: flex;
    flex-wrap: nowrap;
}
.pickRadio {
    width: 80px;
    margin: 0.25rem;
    text-align: center;
    flex: 0 0 80px;
    min-width: 80px;
}
.designOfficeCardDummy {
    width: 80px;
    height: 120px;
    position: relative;
    margin: 0.25rem;
    flex: 0 0 80px;
    min-width: 80px;
}
/*
design-office-card {
    cursor: pointer;
}
*/
</style>
