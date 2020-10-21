<template>
    <div class="handCardsWrapper row">
        <div class="col-md-12">
            <p class="mt-3 text-danger">捨て札にするカードを選択してください。</p>
            <form @submit.prevent="$emit('push-open-round-end-discard-modal-button', discardHandCards)">
                <div class="handCardsBox">
                    <div class="handCardDummy text-center">
                        <button type="submit" class="btn btn-primary btn-sm text-white" :disabled="! discard_ids.length">決定</button><br><br>
                    </div>
                    <label v-for="hand_card in game.my_hand_cards" :key="hand_card.id" :for="'form_discard_ids-' + hand_card.id" class="cardLabel" :class="{ 'is-selected': discard_ids.includes(hand_card.id) }">
                        <hand-card :hand_card="hand_card"/>
                    </label>
                </div>
                <div class="discardCheckBox">
                    <div class="discardCheck">捨て札</div>
                    <div v-for="hand_card in game.my_hand_cards" :key="hand_card.id" class="discardCheck">
                        <input type="checkbox" v-model="discard_ids" :id="'form_discard_ids-' + hand_card.id" :value="hand_card.id">
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import HandCard from '../cards/HandCard.vue'
export default {
    components: { HandCard },
    props: ['game'],
    data() {
        return {
            discard_ids: [],
        }
    },
    computed: {
        discardHandCards() {
            if (! this.game) return []
            return this.game.my_hand_cards.filter(hand_card => this.discard_ids.includes(hand_card.id), this)
        },
        isDisabled() {
            if (! this.game) return true
            const my_player = this.game.players.find(player => player.player_order == this.my_player_order, this)
            if (! my_player) return true
            const discard_number = this.game.my_hand_cards.length - my_player.max_hand_cards_number
            return discard_number !== this.discard_ids.length
        }
    }
}
</script>
<style scoped>
.cardLabel {
    cursor: pointer;
}
.cardLabel.is-selected {
    filter: drop-shadow(0 0 2px red);
}
.handCardsWrapper {
    position: fixed;
    z-index: 100;
    height: 250px;
    width: 100%;
    bottom: 0;
    background: rgba(249, 251, 231, 0.9);
    overflow-x: auto;
}
.handCardsBox, .discardCheckBox {
    display: flex;
    flex-wrap: nowrap;
}
.discardCheck {
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
hand-card {
    cursor: pointer;
}
</style>
