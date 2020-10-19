<template>
    <div class="handCard" :class="[`bg-card-${hand_card.card.type}`]" :id="`handCard-${hand_card.id}`">
        <div class="handCard_costs" :class="{ 'text-warning': isChangeCosts }"><span v-if="hand_card.card.type === 'building'">{{ hand_card.real_costs || hand_card.card.costs }}</span></div>
        <div class="handCard_name">{{ hand_card.card.name }}</div>
        <div class="handCard_vp"><span v-if="hand_card.card.type === 'building'">{{ hand_card.card.vp }}</span></div>
        <div class="worker"></div>
        <div class="iconBox">
            <div v-if="hand_card.card.is_agriculture" class="icon icon-agriculture"></div>
            <div v-if="hand_card.card.is_industry" class="icon icon-industry"></div>
            <div v-if="hand_card.card.is_facility" class="icon icon-facility"></div>
        </div>
    </div>
</template>
<script>
import Tooltip from 'bootstrap/js/dist/tooltip'

export default {
    props: ['hand_card'],
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
        isChangeCosts() {
            if (! this.hand_card.real_costs) return false
            return this.hand_card.real_costs < this.hand_card.card.costs
        },
        iconReplacedText() {
            return this.hand_card.card.text.replace(/農業アイコン/g, '<img src="/img/agriculture_icon.png" class="textIcon">')
                .replace(/工業アイコン/g, '<img src="/img/industry_icon.png" class="textIcon">')
                .replace(/施設アイコン/g, '<img src="/img/facility_icon.png" class="textIcon">')
        }
    }
}
</script>
<style scoped>
.handCard {
    width: 80px;
    height: 120px;
    position: relative;
    margin: 0.25rem;
    filter: drop-shadow(2px 2px 2px rgba(0,0,0,0.4));
    flex: 0 0 80px;
    min-width: 80px;
    font-size: .9rem;
}
.handCard_costs {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    color: white;
}
.handCard_name {
    position: absolute;
    top: 2rem;
    left: 0;
    right: 0;
    color: white;
    text-align: center;
}
.handCard_vp {
    position: absolute;
    bottom: 0.5rem;
    left: 0;
    right: 0;
    color: white;
    text-align: center;
}
.worker {
    display: none;
    position: absolute;
    left: 0;
    right: 0;
    top: 4rem;
    margin: auto;
    background: #4B8F9F;
    border-radius: 50%;
    width: 1.5rem;
    height: 1.5rem;
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
