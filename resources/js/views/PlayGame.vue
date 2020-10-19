<template>
    <div class="container-fluid">
        <component
            v-if="game"
            :is="currentWindow"
            :game="game"
            :isMyTurn="isMyTurn"
        />
        <player-column
            v-if="myPlayer"
            :player="myPlayer"
            :currentWindow="currentWindow"
            :isMyTurn="isMyTurn"
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
            @push-open-use-building-modal-button="openUseBuildingModal"
        />
        <logs-modal ref="logsModal" :logs="logs" />
        <summary-modal v-if="game" ref="summaryModal" :game="game" />
        <use-building-modal
            ref="useBuildingModal"
            :building="usingBuilding"
            @push-use-building-button="useBuilding"
        />
    </div>
</template>
<script>
import PublicColumn from '../components/play_game/columns/PublicColumn.vue'
import PlayerColumn from '../components/play_game/columns/PlayerColumn.vue'
import LogsModal from '../components/play_game/modals/LogsModal.vue'
import SummaryModal from '../components/play_game/modals/SummaryModal.vue'
import UseBuildingModal from '../components/play_game/modals/UseBuildingModal.vue'
import WindowNone from '../components/play_game/windows/WindowNone.vue'
import WindowHandCards from '../components/play_game/windows/WindowHandCards.vue'
export default {
    components: {
        PublicColumn,
        PlayerColumn,
        LogsModal,
        SummaryModal,
        UseBuildingModal,
        WindowNone,
        WindowHandCards
    },
    data() {
        return {
            game: null,
            isLoading: true,
            currentWindow: 'WindowNone',
            usingBuilding: null,
            logs: {},
            isLastestLogs: false
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
            if (! this.game.my_player_order || ! this.game.current_log.player_order) return false
            return this.game.my_player_order === this.game.current_log.player_order
        }
    },
    methods: {
        fetchGame() {
            axios.get(`/api/games/${this.$route.params.id}`).then(res => {
                this.game = res.data
                console.log(res.data)
                this.isLoading = false
                for (let log of this.game.last_logs) {
                    this.$toast.success(log.text)
                }
                if (this.isMyTurn) {
                }
                this.currentWindow = 'WindowHandCards'
            }).catch(err => {
                switch (err.response.status) {
                    case 401:
                        this.$toast.warning('再度ログインしてください')
                        this.$router.push({ name: 'login', query: { redirect: this.$route.fullPath }})
                        break
                    case 404:
                        this.$toast.error('このゲームは存在しません')
                        this.$router.push({ name: 'home' })
                        break
                }
            })
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
                console.log(res.data)
            }).catch(err => {
                console.error(err)
            })
        },
        openSummaryModal() {
            this.$refs.summaryModal.openModal()
        },
        openUseBuildingModal(building) {
            this.usingBuilding = building
            this.$refs.useBuildingModal.openModal()
        },
        useBuilding() {
            const payload = {
                id: this.usingBuilding.id
            }
            this.isLoading = true
            axios.post(`/api/games/${this.$route.params.id}/use_building`, payload).then(res => {
                this.game = res.data
                this.isLoading = false
                this.isLastestLogs = false
                this.$refs.useBuildingModal.closeModal()
                for (let log of this.game.last_logs) {
                    this.$toast.success(log.text)
                }
            }).catch(err => {
                this.$toast.error(err.response.data.message)
            })
        }
    }
}
</script>
