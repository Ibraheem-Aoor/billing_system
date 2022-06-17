import {FormMixin} from "../../../core/mixins/form/FormMixin";

export const SubmitFormMixins = {
    mixins: [FormMixin],
    props: {
        tableId: {
            type: String,
        }
    },
    data() {
        return {
            preloader: false,
            errors: {},
        }
    },
    methods: {
        beforeSubmit() {
            this.preloader = true;
        },
        afterError({data}) {
            this.errors = data.errors;
        },
        afterSuccess({data}) {
            this.$toastr.s(data.message);
            this.$hub.$emit('reload-' + this.tableId);
            this.$emit('success')
            this.closeModal()
        },
        afterFinalResponse() {
            this.preloader = false;
        },
        hideModal() {
            $('#' + this.modalId).modal('hide');
        },
        closeModal() {
            this.hideModal();
            this.$emit('closeModal')
        }
    }
}