<template>
    <div></div>
</template>
<script>
export default {
    data() {
        return {
            game: null,
            isLoading: true
        }
    },
    created() {
        this.fetchData()
    },
    methods: {
        fetchData() {
            axios.get(`/api/games/${this.$route.params.id}`).then(res => {
                this.game = res.data
                console.log(res.data)
                this.isLoading = false
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
        }
    }
}
</script>
