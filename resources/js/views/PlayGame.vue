<template>
    <div class="container-fluid">
        <component :is="currentWindow" :game="game" />
        <public-column :game="game" v-if="game" />
    </div>
</template>
<script>
import PublicColumn from '../components/play_game/columns/PublicColumn.vue'
import WindowNone from '../components/play_game/windows/WindowNone.vue'
import WindowHandCards from '../components/play_game/windows/WindowHandCards.vue'
export default {
    components: {
        PublicColumn,
        WindowNone,
        WindowHandCards
    },
    data() {
        return {
            game: null,
            isLoading: true,
            currentWindow: 'WindowNone'
        }
    },
    created() {
        this.fetchGame()
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
                if (this.game.my_player_order === this.game.current_log.player_order) {
                    this.$toast.info('あなたの手番です')
                }
                this.fetchLogs()
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
        fetchLogs() {
            axios.get(`/api/games/${this.$route.params.id}/logs`).then(res => {
                this.logs = res.data
                console.log(res.data)
            }).catch(err => {
                console.error(err)
            })
        }
    }
}
</script>
