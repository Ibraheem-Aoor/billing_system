<template>
    <div class="content-wrapper">
        <div class="d-flex align-items-center justify-content-between">
            <app-breadcrumb :page-title="$t('invoices')"/>
            <button type="button" v-if="$can('create_invoices')"
                    class="btn btn-success btn-with-shadow mb-4"
                    @click="isInvoiceAddEditModalActive = true">
                <app-icon name="plus" class="size-20 mr-2"/>
                {{ $t('new_invoice') }}
            </button>
        </div>
        <div class="d-flex justify-content-between">
            <div class="w-100 mb-primary">
                <div class="text-white bg-primary shadow rounded d-flex align-items-center p-4">
                    <div class="ml-3">
                        <h5 class="mb-0">{{ $t('total_amount') }}</h5>

                        <div class="flex-shrink-0">
                            {{ numberWithCurrencySymbol(invoiceSummation.total_amount) }}
                        </div>

                    </div>
                </div>
            </div>

            <div class="w-100 mb-primary mx-2">
                <div class="text-white bg-success shadow rounded d-flex align-items-center p-4">
                    <div class="ml-3">
                        <h5 class="mb-0">{{ $t('total_paid') }}</h5>
                        <div class="flex-shrink-0">
                            {{ numberWithCurrencySymbol(invoiceSummation.paid_amount) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-100 mb-primary">
                <div class="text-white bg-warning shadow rounded d-flex align-items-center p-4">
                    <div class="ml-3">
                        <h5 class="mb-0">{{ $t('total_due') }}</h5>
                        <div class="flex-shrink-0">
                            {{ numberWithCurrencySymbol(invoiceSummation.due_amount) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <app-table :id="tableId" :options="options" @action="getListAction"/>

        <!-- Client Add/Edit Modal -->
        <invoice-add-edit-modal
            v-if="isInvoiceAddEditModalActive"
            :table-id="tableId"
            :selected-url="selectUrl"
            :productList="productList"
            :status-list="statuses"
            :tax-list="taxList"
            :recurring-cycle-list="recurringCycleList"
            :clientList="clients"
            @invoiceProductDelete="deleteProductFromInvoice"
            @closeModal="closeInvoiceModal"
        />

        <!-- Payment Add/Edit Modal -->
        <payment-add-edit-modal
            v-if="isPaymentAddEditModalActive"
            :table-id="tableId"
            :invoice-id="invoiceId"
            @closeModal="closePaymentAddEditModal"
        />

        <invoice-payment-modal
            v-if="isInvoicePaymentModalActive"
            :table-id="tableId"
            :invoice-id="invoiceId"
            :selected-url="selectUrl"
            @closeModal="closeInvoicePaymentModal"
        />

        <!-- Client Delete Modal -->
        <app-delete-modal
            v-if="confirmationModalActive"
            modal-id="delete-confirm-modal"
            :message="$t('are_you_sure_to_delete_this_invoice')"
            @confirmed="confirmDelete"
            @cancelled="cancelledDelete"
        />

        <!-- Client Delete Modal -->
        <app-delete-modal
            v-if="invoiceProductDeleteModal"
            modal-id="invoice-product-delete-confirm-modal"
            :message="$t('are_you_sure_to_delete_this_product')"
            @confirmed="confirmDeleteInvoiceProduct"
            @cancelled="closeInvoiceDeleteModal"
        />
    </div>
</template>

<script>
import InvoiceTableMixin from '../../../Mixins/InvoiceTableMixin';

export default {
    name: 'Index',
    mixins: [InvoiceTableMixin],
}
</script>