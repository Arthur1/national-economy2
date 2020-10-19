import Modal from 'bootstrap/js/dist/modal'

export default {
    data() {
        return {
            modal: null
        }
    },
    mounted() {
        this.modal = new Modal(this.$el)
    },
    beforeDestroy() {
        this.modal.dispose()
    },
    methods: {
        openModal() {
            this.modal.show()
        },
        closeModal() {
            this.modal.hide()
        }
    }
}
