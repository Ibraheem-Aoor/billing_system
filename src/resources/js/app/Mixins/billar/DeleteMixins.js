export const DeleteMixins = {
    data() {
        return {
            confirmationModalActive: false,
            selectUrl: ''
        }
    },
    methods: {
        cancelledDelete() {
            this.selectUrl = '';
            this.confirmationModalActive = false;
            $("#delete-confirm-modal").modal("hide");
        },
        confirmDelete() {
            this.axiosDelete(this.selectUrl).then((response) => {
                this.$toastr.s(response.data.message);
                this.$hub.$emit("reload-" + this.tableId);
                this.cancelledDelete();
            }).catch((error) => {
                this.$toastr.e(error.response.data.message);
                this.cancelledDelete();
            });
        }
    }
}

export const ModalMixins = {
    data() {
        return {
            isModalActive: false,
            selectUrl: ""
        }
    },
    methods: {
        openModal() {
            this.isModalActive = true;
        },
        closeModal() {
            this.selectUrl = "";
            this.isModalActive = false;
        }
    }
}