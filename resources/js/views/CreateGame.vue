<template>
    <div class="container">
        <h1 class="mt-4 text-primary">ゲーム作成</h1>
        <form @submit.prevent="create">
            <div class="mb-3">
                <label class="form-label" for="form_type">ゲームタイプ</label>
                <select class="form-select" id="form_type" v-model="type">
                    <option value="normal">無印</option>
                    <option value="mecenat">メセナ</option>
                    <option value="glory">グローリー</option>
                    <option value="mix">ミックス</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="form_players_number">プレイ人数</label>
                <select class="form-select" id="form_players_number" v-model="players_number" @change="flushUsers">
                    <!--<option value="1">1人</option>-->
                    <option value="2">2人</option>
                    <option value="3">3人</option>
                    <option value="4">4人</option>
                </select>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="form_needs_shuffle" v-model="needs_shuffle" checked>
                    <label class="form-check-label" for="form_needs_shuffle">
                        番手をシャッフルする
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="form_user_1">ユーザ名(1人目)</label>
                <input type="text" id="form_user_1" v-model="users[0]" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label" for="form_user_2">ユーザ名(2人目)</label>
                <input type="text" id="form_user_2" v-model="users[1]" class="form-control" :disabled="players_number < 2">
            </div>
            <div class="mb-3">
                <label class="form-label" for="form_user_3">ユーザ名(3人目)</label>
                <input type="text" id="form_user_3" v-model="users[2]" class="form-control" :disabled="players_number < 3">
            </div>
            <div class="mb-3">
                <label class="form-label" for="form_user_4">ユーザ名(4人目)</label>
                <input type="text" id="form_user_4" v-model="users[3]" class="form-control" :disabled="players_number < 4">
            </div>
            <button type="submit" class="btn btn-primary text-white" :disabled="is_processing">作成する</button>
        </form>
    </div>
</template>
<script>
import Utils from '../mixins/utils'
export default {
    mixins: [Utils],
    data() {
        return {
            type: 'normal',
            players_number: 2,
            users: [],
            needs_shuffle: true,
            is_processing: false
        }
    },
    mounted() {
        this.users = [this.$store.state.name]
    },
    methods: {
        create() {
            this.is_processing = true
            let payload = {
                type: this.type,
                players_number: this.players_number,
                users: this.users,
                needs_shuffle: this.needs_shuffle,
            }
            axios.post('/api/games', payload).then(res => {
                this.$toast.success('ゲームを作成しました')
                this.$router.push({ name: 'home' })
            }).catch((err) => {
                this.is_processing = false
                this.errorsToast(err)
            })
        },
        flushUsers() {
            this.users = this.users.filter(user => user)
                .filter((user, key) => key < this.players_number, this)
        }
    }
}
</script>
