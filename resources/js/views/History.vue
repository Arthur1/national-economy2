<template>
    <div class="container">
        <h1 class="text-primary mt-5">ゲーム履歴</h1>
        <div class="list-group">
            <router-link
                v-for="game in gamesList"
                :key="game.id"
                :to="{ name: 'play_game', params: { id: game.id } }"
                class="list-group-item list-group-item-action"
            >
                <span class="mr-1rem">{{ game.players_number }}人ゲーム（{{ game.type_description }}）{{ game.my_player_order }}番手</span><br>
                <font-awesome-icon icon="users" />{{ game.players.map(player => `${player.user.name}［${player.vp}点 ${player.rank}位］`) | implode }}<br>
                <font-awesome-icon :icon="['far', 'clock']" />{{ game.created_at }}
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
        axios.get('/api/games/finished').then(res => {
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
    filters: {
        implode(array) {
            return array.join('・')
        }
    }
}
</script>
<style scoped>
.btn svg, .list-group-item svg {
    margin-right: 0.5em;
}
.mr-1rem {
    margin-right: 1rem;
}
</style>
