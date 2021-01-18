<template>
    <div class="container">
        <h1 class="text-primary mt-5">ホーム</h1>
        <router-link :to="{ name: 'create_game' }" class="btn btn-info btn-block text-white mt-4"><font-awesome-icon icon="plus" />ゲーム作成</router-link>
        <h2 class="text-secondary mt-4">お知らせ</h2>
        <p>
            National Economy Onlineをご利用いただいている皆さまは、<router-link :to="{ name: 'announcement_v3' }">「バージョン3.0の開発予告とお詫び」</router-link>をご一読ください。
        </p>
        <h2 class="text-secondary mt-4">プレイ中のゲーム</h2>
        <div class="list-group">
            <router-link
                v-for="game in gamesList"
                :key="game.id"
                :to="{ name: 'play_game', params: { id: game.id } }"
                class="list-group-item list-group-item-action"
                :class="{'list-group-item-info': game.my_player_order === game.current_log.player_order }"
            >
                <span class="mr-1rem">{{ game.players_number }}人ゲーム（{{ game.type_description }}）{{ game.my_player_order }}番手</span><br>
                <font-awesome-icon icon="users" />{{ game.players.map(player => player.user.name) | implode }}<br>
                <font-awesome-icon :icon="['far', 'clock']" />{{ game.created_at }}
                <button
                    v-if="game.organizer_id === $store.state.userID"
                    class="btn deleteButton btn-outline-danger btn-sm"
                    @click.prevent="openDeleteGameModal(game)"
                >
                    <font-awesome-icon icon="trash" />削除する
                </button>
            </router-link>
        </div>
        <delete-game-modal ref="deleteGameModal" :deleting_game="deleting_game" @push-delete-game-button="deleteGame" />
    </div>
</template>
<script>
import DeleteGameModal from '../components/home/DeleteGameModal.vue'
import Utils from '../mixins/utils'

export default {
    mixins: [
        Utils
    ],
    components: {
        DeleteGameModal
    },
    data() {
        return {
            gamesList: [],
            deleting_game: null
        }
    },
    created() {
        this.fetchGames()
    },
    methods: {
        fetchGames() {
            axios.get('/api/games/in_progress').then(res => {
                this.gamesList = res.data
            }).catch(err => {
                switch (err.response.status) {
                    case 401:
                        this.$toast.warning('再度ログインしてください')
                        this.$router.push({ name: 'login' })
                        break
                }
            })
        },
        openDeleteGameModal(deleting_game) {
            this.deleting_game = deleting_game
            this.$refs.deleteGameModal.openModal()
        },
        deleteGame() {
            axios.delete(`/api/games/${this.deleting_game.id}`).then(res => {
                this.$toast.warning('ゲームを削除しました')
                this.fetchGames()
            }).catch(err => {
                this.errorsToast(err)
            }).finally(() => {
                this.$refs.deleteGameModal.closeModal()
            })
        }
    },
    filters: {
        implode(array) {
            return array.join('・')
        }
    }
}
</script>>
<style scoped>
.btn svg, .list-group-item svg {
    margin-right: 0.5em;
}
.mr-1rem {
    margin-right: 1rem;
}
.deleteButton {
    position: absolute;
    right: 1rem;
    bottom: 0.5rem;
}
</style>
