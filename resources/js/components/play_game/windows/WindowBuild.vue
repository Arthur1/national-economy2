<template>
    <div class="handCardsWrapper row">
        <div class="col-md-12">
            <p class="mt-3 text-danger">建設するカードと、コストとして捨て札にするカードを選択してください。</p>
            <form @submit.prevent="$emit('push-open-build-modal-button', buildHandCard, costIds)">
                <div class="handCardsBox">
                    <div class="handCardDummy text-center">
                        <button type="submit" class="btn btn-primary btn-sm text-white" :disabled="isDisabled">決定</button><br><br>
                        <button type="button" class="btn btn-secondary btn-sm" @click="$emit('push-rollback-use-building-button')">戻る</button>
                    </div>
                    <label v-for="card in game.my_hand_cards" :key="card.id" :for="'form_buildId-' + card.id" @click.right.prevent="toggleDiscard(card.id)" :class="{'cardLabel': card.card.type !== 'goods', 'is-selected': card.id === buildId, 'is-dis-selected': costIds.includes(card.id)}">
                        <hand-card :hand_card="card" />
                    </label>
                </div>
                <div class="buildRadioBox">
                    <div class="buildRadio">建設</div>
                    <div v-for="card in game.my_hand_cards" :key="card.id" class="buildRadio">
                        <input type="radio" required :disabled="card.card.type === 'goods'" v-model="buildId" :value="card.id" :id="'form_buildId-' + card.id" name="buildId">
                    </div>
                </div>
                <div class="costCheckBox">
                    <div class="buildRadio">コスト</div>
                    <div v-for="card in game.my_hand_cards" :key="card.id" class="costCheck">
                        <input type="checkbox" v-model="costIds" :value="card.id">
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
            costIds: [],
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
    },
    methods: {
        build() {
            const payload = {
                buildId: this.buildId,
                costIds: this.costIds,
            }
            this.$emit('startLoading')
            axios.post(`/api/games/${this.game.id}/action`, payload).then(res => {
            }).catch(err => {
                this.$emit('endLoading')
                this.$toast.error(err.response.data.message)
            })
        },
        toggleDiscard(id) {
            if (this.costIds.includes(id)) {
                this.costIds = this.costIds.filter(costId => costId !== id)
            } else {
                this.costIds.push(id)
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
