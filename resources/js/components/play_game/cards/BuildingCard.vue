<template>
    <div
        class="buildingCard"
        :class="{[`bg-card-${building.card.type}`]: true, 'buildingCard-canUse': building.can_use}"
        :id="`buildingCard-${building.id}`"
        @click="openModal"
    >
        <div class="buildingCard_costs"><span v-if="building.card.type === 'building'">{{ building.card.costs }}</span></div>
        <div class="buildingCard_name">{{ building.card.name }}</div>
        <div class="buildingCard_vp"><span v-if="building.card.type === 'building'">{{ building.card.vp }}</span></div>
        <div class="workerBox">
            <div :class="'worker bg-playerOrder-' + player_order" v-for="player_order in building.occupying_players" :key="player_order"></div>
        </div>
        <div class="iconBox">
            <div v-if="building.card.is_agriculture" class="icon icon-agriculture"></div>
            <div v-if="building.card.is_industry" class="icon icon-industry"></div>
            <div v-if="building.card.is_facility" class="icon icon-facility"></div>
        </div>
    </div>
</template>
<script>
import Tooltip from 'bootstrap/js/dist/tooltip'

export default {
    props: ['building', 'isMyTurn', 'currentWindow'],
    mounted() {
        const options = {
            html: true,
            placement: 'top',
            boundary: 'viewport',
            title: this.iconReplacedText,
        }
        new Tooltip(this.$el, options)
    },
    computed: {
        iconReplacedText() {
            return this.building.card.text.replace(/農業アイコン/g, '<img src="/img/agriculture_icon.png" class="textIcon">')
                .replace(/工業アイコン/g, '<img src="/img/industry_icon.png" class="textIcon">')
                .replace(/施設アイコン/g, '<img src="/img/facility_icon.png" class="textIcon">')
        }
    },
    methods: {
        openModal() {
            if (this.currentWindow === 'WindowNone') return
            if (this.currentWindow !== 'WindowHandCards') {
                this.$toast.warning('下のウィンドウからアクションを実行してください')
                return
            }
            if (! this.isMyTurn) {
                this.$toast.warning('あなたの手番ではありません')
                return
            }
            if (! this.building.can_use) {
                this.$toast.warning('この職場は使用できません')
                return
            }
            this.$emit('push-open-use-building-modal-button', this.building)
        }
    }
}
</script>
<style scoped>
.buildingCard {
    width: 80px;
    height: 120px;
    position: relative;
    margin: 0.25rem;
    filter: drop-shadow(2px 2px 2px rgba(0,0,0,0.4));
    cursor: not-allowed;
    font-size: .9rem;
}
.buildingCard-canUse {
    cursor: pointer;
}
.buildingCard_costs {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    color: white;
}
.buildingCard_name {
    position: absolute;
    top: 2rem;
    left: 0;
    right: 0;
    color: white;
    text-align: center;
}
.buildingCard_vp {
    position: absolute;
    bottom: 0.5rem;
    left: 0;
    right: 0;
    color: white;
    text-align: center;
}
.workerBox {
    position: absolute;
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    left: 0;
    right: 0;
    top: 4rem;
    margin: auto;
}
.worker {
    border-radius: 50%;
    width: 1.5rem;
    height: 1.5rem;
    border: 1px solid #CCCCCC;
}
.iconBox {
    display: flex;
    flex-direction: column;
    position: absolute;
    right: 0.3rem;
    bottom: 0.5rem;
    width: 1.2rem;
}
.icon {
    width: 1.2rem;
    height: 1.2rem;
    background-size: contain;
}
.icon-industry {
    background-image: url('/img/industry_icon.png');
}
.icon-agriculture {
    background-image: url('/img/agriculture_icon.png');
}
.icon-facility {
    background-image: url('/img/facility_icon.png');
}
</style>
<style>
.textIcon {
    height: 1.4em;
}
</style>
