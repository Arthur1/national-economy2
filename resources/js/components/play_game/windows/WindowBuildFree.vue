<template>
    <div class="handCardsWrapper row">
        <div class="col-md-12">
            <p class="mt-3 text-danger">建設するカードを選択してください。</p>
            <form @submit.prevent="$emit('push-open-build-free-modal-button', buildHandCard)">
                <div class="handCardsBox">
                    <div class="handCardDummy text-center">
                        <button type="submit" class="btn btn-primary btn-sm text-white" :disabled="isDisabled">決定</button><br><br>
                        <button type="button" class="btn btn-secondary btn-sm" @click="$emit('push-rollback-use-building-button')">戻る</button>
                    </div>
                    <label
                        v-for="hand_card in game.my_hand_cards"
                        :key="hand_card.id" :for="`form_buildId-${card.id}`"
                        :class="{'cardLabel': hand_card.card.type !== 'goods', 'is-selected': hand_card.id === buildId}"
                    >
                        <hand-card :hand_card="hand_card" />
                    </label>
                </div>
                <div class="buildRadioBox">
                    <div class="buildRadio">建設</div>
                    <div v-for="hand_card in game.my_hand_cards" :key="hand_card.id" class="buildRadio">
                        <input type="radio" required :disabled="hand_card.cardtype === 'goods'" v-model="buildId" :value="hand_card.id" :id="`form_buildId-${hand_card.id}`" name="buildId">
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
            buildId: null,
        }
    },
    computed: {
        buildHandCard() {
            if (! this.buildId) return null
            return this.game.my_hand_cards.find(card => card.id === this.buildId, this)
        },
        isDisabled() {
            if (! this.buildId) return true
            if (this.costIds.includes(this.buildId)) return true
            return false
        }
    }
}
</script>
<style scoped>
.cardLabel {
    cursor: pointer;
}
.is-selected {
    filter: drop-shadow(0 0 2px green);
}
.is-dis-selected {
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
.handCardsBox, .buildRadioBox, .costCheckBox {
    display: flex;
    flex-wrap: nowrap;
}
.buildRadioBox {
    border-bottom: 1px solid grey;
}
.buildRadio, .costCheck {
    width: 80px;
    margin: 0.25rem;
    flex: 0 0 80px;
    min-width: 80px;
    text-align: center;
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
