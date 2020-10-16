<template>
    <div class="container">
        <h1 class="text-primary mt-5">ホーム</h1>
        <router-link :to="{ name: 'create_game' }" class="btn btn-info btn-block text-white mt-4"><font-awesome-icon icon="plus" />ゲーム作成</router-link>
        <h2 class="text-secondary mt-4">プレイ中のゲーム</h2>
        <div class="list-group">
            <router-link
                v-for="game in gamesListInProgess"
                :key="game.game.id"
                :to="{ name: 'play_game', params: { id: game.game.id } }"
                class="list-group-item list-group-item-action"
                :class="{'list-group-item-info': game.player_order === game.game.current_log.player_order}"
            >
                <span class="mr-1rem">{{ game.game.players_number }}人ゲーム({{ game.game.type | gameTypeToJa }}) / {{ game.player_order }}番手</span><br>
                <font-awesome-icon icon="users" />{{ game.game.players.map(player => player.user.name) | implode }}<br>
                <font-awesome-icon :icon="['far', 'clock']" />{{ game.game.created_at }}
            </router-link>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            gamesList: []
        }
    },
    created() {
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
    computed: {
        gamesListInProgess() {
            return this.gamesList.filter(game => ! game.game.is_finished).reverse()
        },
        gamesListDone() {
            return this.gamesList.filter(game => game.game.is_finished).reverse()
        }
    },
    filters: {
        gameTypeToJa(type) {
            switch (type) {
                case 'normal':
                    return '無印'
                case 'mecenat':
                    return 'メセナ'
                case 'glory':
                    return 'グローリー'
                case 'mix':
                    return 'ミックス'
                default:
                    return ''
            }
        },
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
</style>
