export default {
    methods: {
        errorsToast(err) {
            let errors = err.response.data.errors
            if (errors) {
                for (let key of Object.keys(errors)) {
                    for (let message of errors[key]) {
                        this.$toast.error(message)
                    }
                }
            } else {
                this.$toast.error(err.response.data.message)
            }
        },
        csrfErrorToast() {
            this.$toast.error('お手数ですが再度送信してください')
        }
    }
}
