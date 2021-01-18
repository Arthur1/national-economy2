<template>
    <div class="container-fluid">
        <component
            v-if="game"
            :is="currentWindow"
            :game="game"
            :isMyTurn="isMyTurn"
            :isLoading="isLoading"
            @push-rollback-use-building-button="rollbackUseBuilding"
            @push-open-build-modal-button="openBuildModal"
            @push-open-build-double-modal-button="openBuildDoubleModal"
            @push-open-build-free-modal-button="openBuildFreeModal"
            @push-open-action-discard-modal-button="openActionDiscardModal"
            @push-open-round-end-discard-modal-button="openRoundEndDiscardModal"
            @push-open-sell-modal-button="openSellModal"
            @push-open-pick-modal-button="openPickModal"
            @push-open-rural-modal-button="openRuralModal"
        />
        <div v-if="isMyTurn" class="alert alert-warning mt-3" role="alert">
            あなたの手番です
        </div>
        <player-column
            v-if="myPlayer"
            :player="myPlayer"
            :currentWindow="currentWindow"
            :isMyTurn="isMyTurn"
            :isSelfTurn="isMyTurn"
            @push-open-use-building-modal-button="openUseBuildingModal"
        />
        <public-column
            v-if="game"
            :game="game"
            :currentWindow="currentWindow"
            :isMyTurn="isMyTurn"
            @push-open-logs-modal-button="openLogsModal"
            @push-open-summary-modal-button="openSummaryModal"
            @push-open-use-building-modal-button="openUseBuildingModal"
        />
        <player-column
            v-for="player in otherPlayers"
            :key="player.id"
            :player="player"
            :currentWindow="currentWindow"
            :isMyTurn="isMyTurn"
            :isSelfTurn="isSelfTurn(player)"
            @push-open-use-building-modal-button="openUseBuildingModal"
        />
        <logs-modal ref="logsModal" :logs="logs" />
        <summary-modal v-if="game" ref="summaryModal" :game="game" />
        <use-building-modal
            ref="useBuildingModal"
            :building="usingBuilding"
            :isLoading="isLoading"
            @push-use-building-button="useBuilding"
        />
        <build-modal
            ref="buildModal"
            :buildHandCard="buildHandCard"
            :isLoading="isLoading"
            @push-build-button="build"
        />
        <build-double-modal
            ref="buildDoubleModal"
            :buildHandCards="buildHandCards"
            :isLoading="isLoading"
            @push-build-double-button="buildDouble"
        />
        <build-free-modal
            ref="buildFreeModal"
            :buildHandCard="buildHandCard"
            :isLoading="isLoading"
            @push-build-free-button="buildFree"
        />
        <action-discard-modal
            ref="actionDiscardModal"
            :discardHandCards="discardHandCards"
            :isLoading="isLoading"
            @push-action-discard-button="actionDiscard"
        />
        <round-end-discard-modal
            ref="roundEndDiscardModal"
            :discardHandCards="discardHandCards"
            :isLoading="isLoading"
            @push-round-end-discard-button="roundEndDiscard"
        />
        <sell-modal
            ref="sellModal"
            :sellBuildings="sellBuildings"
            :isLoading="isLoading"
            @push-sell-button="sell"
        />
        <pick-modal
            ref="pickModal"
            :pickDesignOfficeCard="pickDesignOfficeCard"
            :isLoading="isLoading"
            @push-pick-button="pick"
        />
        <rural-modal
            ref="ruralModal"
            :rural_action_id="rural_action_id"
            :isLoading="isLoading"
            @push-rural-action-button="ruralAction"
        />
    </div>
</template>
<script>
import PublicColumn from '../components/play_game/columns/PublicColumn.vue'
import PlayerColumn from '../components/play_game/columns/PlayerColumn.vue'

import LogsModal from '../components/play_game/modals/LogsModal.vue'
import SummaryModal from '../components/play_game/modals/SummaryModal.vue'
import UseBuildingModal from '../components/play_game/modals/UseBuildingModal.vue'
import BuildModal from '../components/play_game/modals/BuildModal.vue'
import BuildDoubleModal from '../components/play_game/modals/BuildDoubleModal.vue'
import BuildFreeModal from '../components/play_game/modals/BuildFreeModal.vue'
import ActionDiscardModal from '../components/play_game/modals/ActionDiscardModal.vue'
import RoundEndDiscardModal from '../components/play_game/modals/RoundEndDiscardModal.vue'
import SellModal from '../components/play_game/modals/SellModal.vue'
import PickModal from '../components/play_game/modals/PickModal.vue'
import RuralModal from '../components/play_game/modals/RuralModal.vue'

import WindowNone from '../components/play_game/windows/WindowNone.vue'
import WindowHandCards from '../components/play_game/windows/WindowHandCards.vue'
import WindowBuild from '../components/play_game/windows/WindowBuild.vue'
import WindowBuildDouble from '../components/play_game/windows/WindowBuildDouble.vue'
import WindowBuildFree from '../components/play_game/windows/WindowBuildFree.vue'
import WindowActionDiscard from '../components/play_game/windows/WindowActionDiscard.vue'
import WindowRoundEndDiscard from '../components/play_game/windows/WindowRoundEndDiscard.vue'
import WindowSell from '../components/play_game/windows/WindowSell.vue'
import WindowDesignOffice from '../components/play_game/windows/WindowDesignOffice.vue'
import WindowRural from '../components/play_game/windows/WindowRural.vue'

export default {
    components: {
        PublicColumn,
        PlayerColumn,

        LogsModal,
        SummaryModal,
        UseBuildingModal,
        BuildModal,
        BuildDoubleModal,
        BuildFreeModal,
        ActionDiscardModal,
        RoundEndDiscardModal,
        SellModal,
        PickModal,
        RuralModal,

        WindowNone,
        WindowHandCards,
        WindowBuild,
        WindowBuildDouble,
        WindowBuildFree,
        WindowActionDiscard,
        WindowRoundEndDiscard,
        WindowSell,
        WindowDesignOffice,
        WindowRural
    },
    data() {
        return {
            game: null,
            isLoading: true,
            currentWindow: 'WindowNone',
            usingBuilding: null,
            logs: {},
            isLastestLogs: false,
            buildHandCard: null,
            buildHandCards: [],
            costIds: null,
            discardHandCards: [],
            sellBuildings: [],
            pickDesignOfficeCard: null,
            rural_action_id: null
        }
    },
    created() {
        axios.get(`/api/games/${this.$route.params.id}`).then(res => {
            this.handleFetchedGame(res)
            Echo.channel(`game.${this.game.id}`).listen('GameUpdateEvent', e => {
                this.fetchGame()
            })
        }).catch(err => {
            this.handleFetchedGameError(err)
        })
    },
    beforeDestroy() {
        Echo.leaveChannel(`game.${this.game.id}`)
    },
    computed: {
        myPlayer() {
            if (! this.game) return null
            return this.game.players.find(player => player.player_order === this.game.my_player_order)
        },
        otherPlayers() {
            if (! this.game) return []
            return this.game.players
                .filter(player => player.player_order !== this.game.my_player_order)
                .sort((a, b) => {
                    let player_order_a = a.player_order
                    if (a.player_order < this.game.my_player_order) player_order_a += this.game.players_number
                    let player_order_b = b.player_order
                    if (b.player_order < this.game.my_player_order) player_order_b += this.game.players_number
                    return player_order_a - player_order_b
                })
        },
        isMyTurn() {
            if (! this.game || ! this.game.my_player_order || this.game.is_finished || ! this.game.current_log.player_order) return false
            return this.game.my_player_order === this.game.current_log.player_order
        },
        isSelfTurn() {
            if (! this.game || this.game.is_finished) return () => false
            return (player) => player.player_order === this.game.current_log.player_order
        }
    },
    methods: {
        fetchGame() {
            this.isLoading = true
            axios.get(`/api/games/${this.$route.params.id}`).then(res => {
                this.handleFetchedGame(res)
            }).catch(err => {
                this.handleFetchedGameError(err)
            })
        },
        handleFetchedGame(res) {
            this.game = res.data
            this.isLoading = false
            this.isLastestLogs = false
            for (let log of this.game.last_logs) {
                this.$toast.success(log.text)
            }
            if (this.isMyTurn) this.myTurnAlert()

            // toggle window
            if (this.game.is_finished)
                return this.currentWindow = 'WindowNone'
            if (this.game.current_log.action_type === 'design_office')
                return this.currentWindow = 'WindowDesignOffice'
            if (! this.game.my_player_order)
                return this.currentWindow = 'WindowNone'
            if (! this.isMyTurn)
                return this.currentWindow = 'WindowHandCards'
            switch (this.game.current_log.type) {
                case 'discard':
                    return this.currentWindow = 'WindowRoundEndDiscard'
                case 'wage':
                    return this.currentWindow = 'WindowSell'
            }
            switch (this.game.current_log.action_type) {
                case 'build':
                    return this.currentWindow = 'WindowBuild'
                case 'build_double':
                    return this.currentWindow = 'WindowBuildDouble'
                case 'build_free':
                    return this.currentWindow = 'WindowBuildFree'
                case 'discard':
                    return this.currentWindow = 'WindowActionDiscard'
                case 'rural':
                    return this.currentWindow = 'WindowRural'
                default:
                    return this.currentWindow = 'WindowHandCards'
            }
        },
        handleFetchedGameError(err) {
            this.isLoading = false
            if (! err.response) {
                console.error(err)
                return
            }
            switch (err.response.status) {
                case 401:
                    this.$toast.warning('再度ログインしてください')
                    this.$router.push({ name: 'login', query: { redirect: this.$route.fullPath }})
                    break
                case 404:
                    this.$toast.error('このゲームは存在しません')
                    this.$router.push({ name: 'home' })
                    break
                default:
                    this.$toast.error(err.response.data.message)
            }
        },
        myTurnAlert() {
            const audio = new Audio('/audio/my_turn.mp3')
            audio.volume = 0.7
            try {
                audio.play()
            } catch (err) {}
        },
        openLogsModal() {
            if (this.isLastestLogs) {
                this.$refs.logsModal.openModal()
                return
            }
            axios.get(`/api/games/${this.$route.params.id}/logs`).then(res => {
                this.logs = res.data
                this.isLastestLogs = true
                this.$refs.logsModal.openModal()
            }).catch(err => {
                this.handleFetchedGameError(err)
            })
        },
        openSummaryModal() {
            this.$refs.summaryModal.openModal()
        },
        openUseBuildingModal(building) {
            this.usingBuilding = building
            this.$refs.useBuildingModal.openModal()
        },
        openBuildModal(buildHandCard, costIds) {
            this.buildHandCard = buildHandCard
            this.costIds = costIds
            this.$refs.buildModal.openModal()
        },
        openBuildDoubleModal(buildHandCards, costIds) {
            this.buildHandCards = buildHandCards
            this.costIds = costIds
            this.$refs.buildDoubleModal.openModal()
        },
        openBuildFreeModal(buildHandCard) {
            this.buildHandCard = buildHandCard
            this.$refs.buildFreeModal.openModal()
        },
        openActionDiscardModal(discardHandCards) {
            this.discardHandCards = discardHandCards
            this.$refs.actionDiscardModal.openModal()
        },
        openRoundEndDiscardModal(discardHandCards) {
            this.discardHandCards = discardHandCards
            this.$refs.roundEndDiscardModal.openModal()
        },
        openSellModal(sellBuildings) {
            this.sellBuildings = sellBuildings
            this.$refs.sellModal.openModal()
        },
        openPickModal(pickDesignOfficeCard) {
            this.pickDesignOfficeCard = pickDesignOfficeCard
            this.$refs.pickModal.openModal()
        },
        openRuralModal(rural_action_id) {
            this.rural_action_id = rural_action_id
            this.$refs.ruralModal.openModal()
        },
        useBuilding() {
            if (this.isLoading) {
                this.$toast.error('現在ロード中です。時間をおいてください')
                return
            }
            const payload = {
                id: this.usingBuilding.id
            }
            this.isLoading = true
            axios.post(`/api/games/${this.$route.params.id}/use_building`, payload).then(res => {
                this.handleFetchedGame(res)
                this.$refs.useBuildingModal.closeModal()
            }).catch(err => {
                this.handleFetchedGameError(err)
                this.$refs.useBuildingModal.closeModal()
            })
        },
        rollbackUseBuilding() {
            if (this.isLoading) {
                this.$toast.error('現在ロード中です。時間をおいてください')
                return
            }
            this.isLoading = true
            axios.post(`/api/games/${this.$route.params.id}/rollback_use_building`, {}).then(res => {
                this.handleFetchedGame(res)
            }).catch(err => {
                this.handleFetchedGameError(err)
            })
        },
        build() {
            if (this.isLoading) {
                this.$toast.error('現在ロード中です。時間をおいてください')
                return
            }
            const payload = {
                build_id: this.buildHandCard.id,
                cost_ids: this.costIds
            }
            this.isLoading = true
            axios.post(`/api/games/${this.$route.params.id}/action`, payload).then(res => {
                this.handleFetchedGame(res)
                this.$refs.buildModal.closeModal()
            }).catch(err => {
                this.handleFetchedGameError(err)
                this.$refs.buildModal.closeModal()
            })
        },
        buildFree() {
            if (this.isLoading) {
                this.$toast.error('現在ロード中です。時間をおいてください')
                return
            }
            const payload = {
                build_id: this.buildHandCard.id
            }
            this.isLoading = true
            axios.post(`/api/games/${this.game.id}/action`, payload).then(res => {
                this.handleFetchedGame(res)
                this.$refs.buildFreeModal.closeModal()
            }).catch(err => {
                this.handleFetchedGameError(err)
                this.$refs.buildFreeModal.closeModal()
            })
        },
        buildDouble() {
            if (this.isLoading) {
                this.$toast.error('現在ロード中です。時間をおいてください')
                return
            }
            const payload = {
                build_ids: this.buildHandCards.map(hand_card => hand_card.id),
                cost_ids: this.costIds
            }
            this.isLoading = true
            axios.post(`/api/games/${this.game.id}/action`, payload).then(res => {
                this.handleFetchedGame(res)
                this.$refs.buildDoubleModal.closeModal()
            }).catch(err => {
                this.handleFetchedGameError(err)
                this.$refs.buildDoubleModal.closeModal()
            })
        },
        actionDiscard() {
            if (this.isLoading) {
                this.$toast.error('現在ロード中です。時間をおいてください')
                return
            }
            const payload = {
                discard_ids: this.discardHandCards.map(hand_card => hand_card.id)
            }
            this.isLoading = true
            axios.post(`/api/games/${this.$route.params.id}/action`, payload).then(res => {
                this.handleFetchedGame(res)
                this.$refs.actionDiscardModal.closeModal()
            }).catch(err => {
                this.handleFetchedGameError(err)
                this.$refs.actionDiscardModal.closeModal()
            })
        },
        roundEndDiscard() {
            if (this.isLoading) {
                this.$toast.error('現在ロード中です。時間をおいてください')
                return
            }
            const payload = {
                discard_ids: this.discardHandCards.map(hand_card => hand_card.id)
            }
            this.isLoading = true
            axios.post(`/api/games/${this.$route.params.id}/discard`, payload).then(res => {
                this.handleFetchedGame(res)
                this.$refs.roundEndDiscardModal.closeModal()
            }).catch(err => {
                this.handleFetchedGameError(err)
                this.$refs.roundEndDiscardModal.closeModal()
            })
        },
        sell() {
            if (this.isLoading) {
                this.$toast.error('現在ロード中です。時間をおいてください')
                return
            }
            const payload = {
                sell_ids: this.sellBuildings.map(building => building.id)
            }
            this.isLoading = true
            axios.post(`/api/games/${this.$route.params.id}/sell`, payload).then(res => {
                this.handleFetchedGame(res)
                this.$refs.sellModal.closeModal()
            }).catch(err => {
                this.handleFetchedGameError(err)
                this.$refs.sellModal.closeModal()
            })
        },
        pick() {
            if (this.isLoading) {
                this.$toast.error('現在ロード中です。時間をおいてください')
                return
            }
            const payload = {
                pick_id: this.pickDesignOfficeCard.id,
            }
            this.isLoading = true
            axios.post(`/api/games/${this.$route.params.id}/action`, payload).then(res => {
                this.handleFetchedGame(res)
                this.$refs.pickModal.closeModal()
            }).catch(err => {
                this.handleFetchedGameError(err)
                this.$refs.pickModal.closeModal()
            })
        },
        ruralAction() {
            if (this.isLoading) {
                this.$toast.error('現在ロード中です。時間をおいてください')
                return
            }
            const payload = {
                action_id: this.rural_action_id
            }
            this.isLoading = true
            axios.post(`/api/games/${this.$route.params.id}/action`, payload).then(res => {
                this.handleFetchedGame(res)
                this.$refs.ruralModal.closeModal()
            }).catch(err => {
                this.handleFetchedGameError(err)
                this.$refs.ruralModal.closeModal()
            })
        }
    }
}
</script>
<style scoped>
.container-fluid {
    padding-bottom: 270px;
}
</style>
