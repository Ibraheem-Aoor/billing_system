<template>
    <div>
        <app-table
            id="all-payment-methods-table"
            showFilter
            :options="options"
            @action="triggerActions"
        />

        <payment-method-create-edit-modal
            v-if="isModalActive"
            :modal-id="'payment-method-create-edit-modal'"
            :selected-url="selectedUrl"
            @closeModal="closePaymentMethodModal"
        />

        <app-confirmation-modal
            v-if="confirmationModalActive"
            :firstButtonName="$t('yes')"
            modal-class="warning"
            modal-id="app-confirmation-modal"
            @confirmed="confirmed('all-payment-methods-table')"
            @cancelled="cancelled"
        />
    </div>
</template>

<script>
import CoreLibrary from "../../../../../core/helpers/CoreLibrary";
import PaymentMethodMixin from "../Mixins/PaymentMethodMixin";
import {PAYMENT_METHOD} from "../../../../Config/ApiUrl";
import DatatableHelperMixin from "../../../../Mixins/global/DatatableHelperMixin";

export default {
    name: "PaymentMethod",
    extends: CoreLibrary,
    mixins: [PaymentMethodMixin, DatatableHelperMixin],
    props: {
        props: {
            default: ''
        },
        id: {
            type: String
        }
    },
    data() {
        return {
            selectedUrl: '',
            isModalActive: false,
            status: '',
            paymentSetting: '',
        }
    },
    mounted() {

        this.$hub.$on('headerButtonClicked-' + this.id, (component) => {
            this.isModalActive = true;
            this.selectedUrl = '';
        })
    },
    created() {

    },
    methods: {
        openModal() {
            this.selectedUrl = '';
            this.isModalActive = true;
        },
        closePaymentMethodModal(){
            this.isModalActive = false;
        },
        triggerActions(row, action, active) {
            if (action.type === 'edit') {
                this.selectedUrl = `${PAYMENT_METHOD}/${row.id}`;
                this.isModalActive = true;
            } else {
                this.getAction(row, action, active)
            }
        },
    },
    beforeDestroy() {
        this.$hub.$off('headerButtonClicked-' + this.id);
    }
}
</script>