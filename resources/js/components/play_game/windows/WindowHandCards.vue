<template>
    <div>
        <div class="alert alert-info mt-3" role="alert">
            あなたの手番です
        </div>
        <div class="handCardsWrapper row">
            <div class="col-md-12">
                <h2 :class="['mt-3', 'text-playerOrder-' + game.my_player_order]">あなたの手札</h2>
                <div class="handCardsBox">
                    <hand-card class="handCard" v-for="hand_card in game.my_hand_cards" :hand_card="hand_card" :key="hand_card.id" />
                </div>
            </div>
        </div>
    </div>    
</template>
<script>
import HandCard from '../cards/HandCard.vue'
export default {
    components: { HandCard },
    props: ['game'],
}
</script>
<style scoped>
.handCardsWrapper {
    position: fixed;
    z-index: 100;
    height: 250px;
    width: 100%;
    bottom: 0;
    background: rgba(220, 220, 220, 0.9);
    overflow-x: auto;
}
.handCardsBox {
    display: flex;
    flex-wrap: no-wrap;
}
.handCard {
    flex: 0 0 80px;
    min-width: 80px;
}
</style>
