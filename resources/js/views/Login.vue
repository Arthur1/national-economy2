<template>
    <div class="maxHeight">
        <div class="text-center loginBox maxHeight">
            <div class="form-signin">
                <h1 class="h3 mb-3 font-weight-normal text-primary">ログイン</h1>
                <form @submit.prevent="login">
                    <input type="text" id="form_name" class="form-control" placeholder="ユーザ名" required autofocus v-model="name">
                    <input type="password" id="form_password" class="form-control" placeholder="パスワード" required v-model="password">
                    <button class="btn btn-lg btn-primary btn-block text-white" type="submit">ログイン</button>
                </form>
                <p class="mt-3">
                    <router-link to="/register">ユーザ登録はこちら</router-link>
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
            password: ''
        }
    },
    methods: {
        login() {
            axios.get('/sanctum/csrf-cookie').then(res=> {
                let payload = {
                    name: this.name,
                    password: this.password
                }
                axios.post('/api/login', payload).then(res => {
                    this.$store.dispatch('setUser').then(() => {
                        this.$toast.success('ログインしました')
                        this.$router.push(this.$route.query.redirect || '/home')
                    })
                }).catch(this.errorsToast)
            }).catch(this.csrfErrorToast)
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
    input[type="text"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>
