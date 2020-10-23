<template>
    <div class="modal fade" id="deleteGameModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">確認</h5>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>
                        この操作はやり直しできません。本当にプレイ中のゲームを削除しますか？
                    </p>
                    <div class="list-group">
                        <div class="list-group-item" v-if="deleting_game">
                            <span class="mr-1rem">{{ deleting_game.players_number }}人ゲーム（{{ deleting_game.type_description }}）{{ deleting_game.my_player_order }}番手</span><br>
                            <font-awesome-icon icon="users" />{{ deleting_game.players.map(player => player.user.name) | implode }}<br>
                            <font-awesome-icon :icon="['far', 'clock']" />{{ deleting_game.created_at }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">考え直す</button>
                    <button type="button" class="btn btn-danger text-white" @click="$emit('push-delete-game-button')">削除する</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Modal from '../../mixins/modal'

export default {
    props: ['deleting_game'],
    mixins: [Modal],
    filters: {
        implode(array) {
            return array.join('・')
        }
    }
}
</script>
<style scoped>
.list-group-item svg {
    margin-right: 0.5em;
}
</style>