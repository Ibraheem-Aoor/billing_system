<template>
    <div class="content-wrapper">
        <div class="d-flex align-items-center justify-content-between">
            <app-breadcrumb :page-title="$t('expenses')"/>
            <div class="mb-4">
                <button type="button" v-if="$can('view_purposes')"
                        class="btn btn-primary btn-with-shadow"
                        @click="viewPurposePage">
                    <app-icon name="list" class="size-20 mr-2"/>
                    {{ $t('purposes') }}
                </button>
                <button type="button" v-if="$can('create_expenses')"
                        class="btn btn-success btn-with-shadow"
                        @click="openModal">
                    <app-icon name="plus" class="size-20 mr-2"/>
                    {{ $t('add_expense') }}
                </button>
            </div>
        </div>

        <div class="d-flex justify-content-between" :class="{'loading-opacity': preloader}">
            <div class="w-100 mb-primary">
                <div class="text-white bg-primary shadow rounded d-flex align-items-center p-4">
                    <div class="ml-3">
                        <h5 class="mb-0">{{ numberWithCurrencySymbol(expenseSummery.totalExpense) }}</h5>

                        <div class="flex-shrink-0">
                            {{ $t('overall') }}
                        </div>

                    </div>
                </div>
            </div>
            <div class="w-100 mb-primary mx-2">
                <div class="text-white bg-success shadow rounded d-flex align-items-center p-4">
                    <div class="ml-3">
                        <h5 class="mb-0">{{ numberWithCurrencySymbol(expenseSummery.monthExpense) }}</h5>

                        <div class="flex-shrink-0">
                            {{ $t('this_month') }}
                        </div>

                    </div>
                </div>
            </div>
            <div class="w-100 mb-primary mx-2">
                <div class="text-white bg-secondary shadow rounded d-flex align-items-center p-4">
                    <div class="ml-3">
                        <h5 class="mb-0">{{ numberWithCurrencySymbol(expenseSummery.weekExpense) }}</h5>
                        <div class="flex-shrink-0">
                            {{ $t('this_week') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-100 mb-primary">
                <div class="text-white bg-warning shadow rounded d-flex align-items-center p-4">
                    <div class="ml-3">
                        <h5 class="mb-0"> {{ numberWithCurrencySymbol(expenseSummery.todayExpense) }}</h5>
                        <div class="flex-shrink-0">
                            {{ $t('today') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <app-table
            v-if="$can('view_expenses')"
            :id="tableId"
            :options="options"
            @action="getListAction"/>


        <app-expense-create-edit-modal
            v-if="isModalActive"
            :table-id="tableId"
            :selected-url="selectUrl"
            @openPurposeAddEditModal="openPurposeAddEditModal"
            @closeModal="closeModal"
        />

        <!-- Client Delete Modal -->
        <app-delete-modal
            v-if="confirmationModalActive"
            modal-id="delete-confirm-modal"
            :message="$t('are_you_sure_to_delete_this_category')"
            @confirmed="confirmDelete"
            @cancelled="cancelledDelete"
        />

        <!-- Purpose Add/Edit Modal -->
        <app-purpose-add-edit-modal
            v-if="isPurposeModalActive"
            purposeType="expense"
            @success="afterPurposeAdded"
            @closeModal="closePurposeAddEditModal"
        />
    </div>
</template>

<script>
import ExpenseTableMixin from "../../../Mixins/ExpenseTableMixin";
import AppFunction from "../../../../core/helpers/app/AppFunction";
import {axiosGet} from "../../../Helpers/AxiosHelper";

export default {
    name: "Expense",
    mixins: [ExpenseTableMixin],
    methods: {
        viewPurposePage() {
            location.replace(AppFunction.getAppUrl('/purposes/list/view'));
        },
        getExpenseSummery() {
            this.preloader = true;
            axiosGet('expense-summation').then(({data}) => {
                this.expenseSummery = data;
            }).finally(() => {
                this.preloader = false;
            })
        },
        openPurposeAddEditModal() {
            this.isPurposeModalActive = true;
            setTimeout(() => {
                $('#expense-create-edit-modal').css({
                    opacity: '0.5',
                });
            });
        },
        closePurposeAddEditModal() {
            this.isPurposeModalActive = false;
            setTimeout(() => {
                $('#expense-create-edit-modal').css({
                    opacity: '1',
                });
            });
            $("#purpose-add-edit-modal").modal("hide");
        },
        afterPurposeAdded() {
            this.$hub.$emit('new-purpose-added')
        },
        closeModal() {
            this.selectUrl = "";
            this.isModalActive = false;
            this.getExpenseSummery()
        },
        cancelledDelete() {
            this.selectUrl = '';
            this.confirmationModalActive = false;
            $("#delete-confirm-modal").modal("hide");
            this.getExpenseSummery();
        },
    },
    created() {
        this.getExpenseSummery();
    }
}
</script>

<style scoped>

</style>