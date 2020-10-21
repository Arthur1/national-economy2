<template>
    <div :class="`buildingCard bg-card-${building.card.type}`" :id="`sellBuildingCard-${building.id}`">
        <div class="buildingCard_costs"><span v-if="building.card.type === 'building'">{{ building.card.costs }}</span></div>
        <div class="buildingCard_name">{{ building.card.name }}</div>
        <div class="buildingCard_vp"><span v-if="building.card.type === 'building'">{{ building.card.vp }}</span></div>
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
    props: ['building'],
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
    font-size: .9rem;
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
