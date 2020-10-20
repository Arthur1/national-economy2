<template>
    <div class="container-fluid">
        <component
            v-if="game"
            :is="currentWindow"
            :game="game"
            :isMyTurn="isMyTurn"
            @push-rollback-use-building-button="rollbackUseBuilding"
            @push-open-build-modal-button="openBuildModal"
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
            @push-use-building-button="useBuilding"
        />
        <build-modal
            ref="buildModal"
            :buildHandCard="buildHandCard"
            @push-build-button="build"
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
import WindowNone from '../components/play_game/windows/WindowNone.vue'
import WindowHandCards from '../components/play_game/windows/WindowHandCards.vue'
import WindowBuild from '../components/play_game/windows/WindowBuild.vue'
export default {
    components: {
        PublicColumn,
        PlayerColumn,
        LogsModal,
        SummaryModal,
        UseBuildingModal,
        BuildModal,
        WindowNone,
        WindowHandCards,
        WindowBuild
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
            costIds: null
        }
    },
    created() {
        this.fetchGame()
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
            if (! this.game || ! this.game.my_player_order || ! this.game.current_log.player_order) return false
            return this.game.my_player_order === this.game.current_log.player_order
        },
        isSelfTurn() {
            return (player) => player.player_order === this.game.current_log.player_order
        }
    },
    methods: {
        fetchGame() {
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
            if (this.isMyTurn) {
            }

            // toggle window
            if (this.game.current_log.action_type === 'design_office') return this.currentWindow = 'WindowDesignOffice'
            if (! this.game.my_player_order || this.game.is_finished) return this.currentWindow = 'WindowNone'
            if (! this.isMyTurn) return this.currentWindow = 'WindowHandCards'
            switch (this.game.current_log.type) {
                case 'discard':
                    return this.currentWindow = 'WindowEndDiscard'
                case 'paying':
                    return this.currentWindow = 'WindowPaying'
            }
            switch (this.game.current_log.action_type) {
                case 'build':
                    return this.currentWindow = 'WindowBuild'
                case 'build_double':
                    return this.currentWindow = 'WindowBuildDouble'
                case 'build_free':
                    return this.currentWindow = 'WindowBuildFree'
                case 'discard':
                    return this.currentWindow = 'WindowDiscard'
                case 'design_office':
                    return this.currentWindow = 'WindowDesignOffice'
                case 'rural':
                    return this.currentWindow = 'WindowRural'
                default:
                    return this.currentWindow = 'WindowHandCards'
            }
        },
        handleFetchedGameError(err) {
            if (! err.response.status) {
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
        useBuilding() {
            const payload = {
                id: this.usingBuilding.id
            }
            this.isLoading = true
            axios.post(`/api/games/${this.$route.params.id}/use_building`, payload).then(res => {
                this.handleFetchedGame(res)
                this.$refs.useBuildingModal.closeModal()
            }).catch(err => {
                this.handleFetchedGameError(err)
            })
        },
        rollbackUseBuilding() {
            this.isLoading = true
            axios.post(`/api/games/${this.$route.params.id}/rollback_use_building`, {}).then(res => {
                this.handleFetchedGame(res)
            }).catch(err => {
                this.handleFetchedGameError(err)
            })
        },
        build() {
            const payload = {
                build_id: this.buildHandCard.id,
                cost_ids: this.costIds,
            }
            this.isLoading = true
            axios.post(`/api/games/${this.$route.params.id}/action`, payload).then(res => {
                this.handleFetchedGame(res)
                this.$refs.buildModal.closeModal()
            }).catch(err => {
                this.handleFetchedGameError(err)
            })
        }
    }
}
</script>
