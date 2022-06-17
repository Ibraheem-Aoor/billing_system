<template>
    <div class="content-wrapper">
        <div class="d-flex align-items-center justify-content-between">
            <app-breadcrumb :page-title="$t('payments')"/>
            <button type="button" v-if="$can('create_payment_histories')"
                    class="btn btn-success btn-with-shadow mb-4"
                    @click="openModal">
                <app-icon name="plus" class="size-20 mr-2"/>
                {{ $t('add_payment') }}
            </button>
        </div>

        <div class="row">
            <div class="col-md-6 col-xl-3 mb-primary">
                <div class="text-white bg-primary shadow rounded d-flex align-items-center p-4">
                    <div class="ml-3">
                        <h5 class="mb-0">{{ $t('total_amount') }}</h5>

                        <div class="flex-shrink-0">
                            {{ numberWithCurrencySymbol(paymentSummation) }}
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <app-table :id="tableId" :options="options" @action="getListAction"/>

        <!-- Payment Add/Edit Modal -->
        <payment-add-edit-modal
            v-if="isModalActive"
            :table-id="tableId"
            :selected-url="selectUrl"
            @closeModal="closeModal"
        />

        <!-- Payment Delete Modal -->
        <app-delete-modal
            v-if="confirmationModalActive"
            modal-id="delete-confirm-modal"
            :message="$t('are_you_sure_to_delete_this_payment')"
            @confirmed="confirmDelete"
            @cancelled="cancelledDelete"

        />
    </div>
</template>

<script>
import PaymentsTableMixin from '../../../Mixins/PaymentsTableMixin';

export default {
    name: 'Index',
    mixins: [PaymentsTableMixin]
}
</script>