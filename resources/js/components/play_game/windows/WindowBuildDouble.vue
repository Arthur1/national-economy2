<template>
    <div class="handCardsWrapper row">
        <div class="col-md-12">
            <p class="mt-3 text-danger">建設するカード2つと、コストとして捨て札にするカードを選択してください。</p>
            <form @submit.prevent="$emit('push-open-build-double-modal-button', buildHandCards, cost_ids)">
                <div class="handCardsBox">
                    <div class="handCardDummy text-center">
                        <button type="submit" class="btn btn-primary btn-sm text-white" :disabled="isDisabled">決定</button><br><br>
                        <button type="button" class="btn btn-secondary btn-sm" @click="$emit('push-rollback-use-building-button')">戻る</button>
                    </div>
                    <label
                        v-for="hand_card in game.my_hand_cards"
                        :key="hand_card.id"
                        :for="`form_build_ids-${hand_card.id}`"
                        @click.right.prevent="toggleDiscard(hand_card.id)"
                        :class="{'cardLabel': hand_card.card.type !== 'goods', 'is-selected': build_ids.includes(hand_card.id), 'is-dis-selected': cost_ids.includes(hand_card.id)}"
                    >
                        <hand-card :hand_card="hand_card" />
                    </label>
                </div>
                <div class="buildRadioBox">
                    <div class="buildRadio">建設</div>
                    <div v-for="hand_card in game.my_hand_cards" :key="hand_card.id" class="buildRadio">
                        <input type="checkbox" v-model="build_ids" :disabled="hand_card.card.type === 'goods'" :value="hand_card.id" :id="`form_build_ids-${hand_card.id}`">
                    </div>
                </div>
                <div class="costCheckBox">
                    <div class="buildRadio">コスト</div>
                    <div v-for="hand_card in game.my_hand_cards" :key="hand_card.id" class="costCheck">
                        <input type="checkbox" v-model="cost_ids" :value="hand_card.id" :id="'form_cost_ids-' + hand_card.id">
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
            build_ids: [],
            cost_ids: [],
        }
    },
    computed: {
        buildHandCards() {
            return this.game.my_hand_cards.filter(hand_card => this.build_ids.includes(hand_card.id), this)
        },
        isDisabled() {
            if (this.build_ids.length !== 2) return true
            if (this.cost_ids.includes(this.build_ids[0])) return true
            if (this.cost_ids.includes(this.build_ids[1])) return true
            return false
        }
    },
    methods: {
        toggleDiscard(id) {
            if (this.cost_ids.includes(id)) {
                this.cost_ids = this.cost_ids.filter(cost_id => cost_id !== id)
            } else {
                this.cost_ids.push(id)
            }
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
