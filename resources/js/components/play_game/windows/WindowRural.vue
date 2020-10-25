<template>
    <div class="handCardsWrapper row">
        <div class="col-md-12">
            <p class="mt-3 text-danger">2つの行動のうちいずれかを選択してください。</p>
            <div class="handCardsBox">
                <div class="handCardDummy text-center">
                    <button type="button" class="btn btn-outline-dark btn-sm" @click="$emit('push-open-rural-modal-button', 1)">+<span class="text-card-goods">■</span>2</button><br><br>
                    <button type="button" class="btn btn-outline-dark btn-sm" @click="$emit('push-open-rural-modal-button', 2)" :disabled="! has2goods">-<span class="text-card-goods">■</span>2 +<span class="text-card-building">■</span>3</button><br><br>
                    <button type="button" class="btn btn-secondary btn-sm" @click="$emit('push-rollback-use-building-button')" :disabled="isLoading">戻る</button>
                </div>
                <hand-card v-for="hand_card in game.my_hand_cards" :hand_card="hand_card" :key="hand_card.id" />
            </div>
        </div>
    </div>
</template>
<script>
import HandCard from '../cards/HandCard.vue'
export default {
    components: { HandCard },
    props: ['game', 'isLoading'],
    computed: {
        has2goods() {
            let goods = this.game.my_hand_cards.filter(card => card.card.type === 'goods')
            return goods.length >= 2
        }
    }
}
</script>
<style scoped>
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
</style>
