<template>
    <div>
        <app-table
            id="all-payment-methods-table"
            showFilter
            :id="tableId"
            :options="options"
            @action="getListAction"
        />

        <tax-add-edit-modal
            v-if="isTaxAddEditModalActive"
            modal-id="tax-add-edit-modal"
            :selected-url="selectUrl"
            :table-id="tableId"
            @closeModal="isTaxAddEditModalActive = false"
        />

        <app-confirmation-modal
            v-if="confirmationModalActive"
            modal-id="delete-confirm-modal"
            :message="$t('are_you_sure_to_delete_this_tax')"
            @confirmed="confirmDelete"
            @cancelled="cancelledDelete"
        />
    </div>
</template>

<script>
    import TaxTableMixin from '../../../../Mixins/TaxTableMixin';
    import {DeleteMixins} from "../../../../Mixins/billar/DeleteMixins";
    import {FormMixin} from '../../../../../core/mixins/form/FormMixin';

    export default {
        name: 'TaxSetting',
        mixins: [TaxTableMixin, DeleteMixins, FormMixin]
    }
</script>