<template>
    <div class="maxHeight">
        <div class="text-center loginBox maxHeight">
            <div class="form-signin">
                <h1 class="h3 mb-3 font-weight-normal text-primary">登録</h1>
                <form @submit.prevent="register">
                    <input type="text" id="form_name" class="form-control" placeholder="ユーザ名" required autofocus v-model="name">
                    <input type="email" id="form_email" class="form-control" placeholder="メールアドレス" required v-model="email">
                    <input type="password" id="form_password" class="form-control" placeholder="パスワード" required v-model="password">
                    <input type="password" id="form_password_confirmation" class="form-control" placeholder="パスワード(確認)" required v-model="password_confirmation">
                    <button class="btn btn-lg btn-primary btn-block text-white" type="submit" :disabled="is_sending">登録</button>
                </form>
                <p class="mt-3">
                    <router-link to="/login">ログインはこちら</router-link>
                </p>
            </div>
        </div>
    </div>
</template>
<script>
import Utils from '../mixins/utils'
export default {
    mixins: [ Utils ],
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            is_sending: false
        }
    },
    methods: {
        register() {
            if (this.is_sending) {
                this.$toast.error('現在処理中です');
                return
            }
            this.is_sending = true
            axios.get('/sanctum/csrf-cookie').then(response => {
                let payload = {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                }
                axios.post('/api/register', payload).then(response => {
                    this.$store.dispatch('setUser').then(() => {
                        this.is_sending = false
                        this.$toast.success('ユーザ登録しました')
                        this.$router.push('/home')
                    })
                }).catch(err => {
                    this.is_sending = false
                    this.errorsToast(err)
                })
            }).catch(err => {
                this.is_sending = false
                this.csrfErrorToast(err)
            })
        }
    }
}
</script>
<style>
    html, body, #app, main, .maxHeight {
        height: 100vh;
    }
</style>
<style scoped>
    .loginBox {
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
    }
    .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }
    .form-control:focus {
        z-index: 2;
    }
    [id="form_name"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    [id="form_email"], [id="form_password"] {
        margin-bottom: -1px;
        border-radius: 0;
    }
    [id="form_password_confirmation"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>
