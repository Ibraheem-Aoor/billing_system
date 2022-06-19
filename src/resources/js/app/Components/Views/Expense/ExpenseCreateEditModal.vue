<template>
    <modal :modal-id="modalId"
           modal-size="large"
           :title="selectedUrl ? $t('edit_expense') : $t('add_expense')"
           :preloader="preloader"
           @submit="submitData"
           @closeModal="closeModal">
        <template slot="body">
            <app-overlay-loader v-if="preloader"/>
            <form class="mb-0"
                  :class="{'loading-opacity': preloader}"
                  ref="form"
                  :data-url="selectedUrl ? selectedUrl : 'expenses'">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">
                                {{ $t('name') }}
                            </label>
                            <app-input
                                id="name"
                                type="text"
                                :placeholder="$t('enter_name')"
                                v-model="formData.name"
                                :error-message="$errorMessage(errors, 'name')"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount">
                                {{ $t('amount') }}<sup class="text-size-20 top-1">*</sup>
                            </label>
                            <app-input
                                id="amount"
                                type="number"
                                :placeholder="$t('enter_amount')"
                                v-model="formData.amount"
                                :error-message="$errorMessage(errors, 'amount')"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reference">
                                {{ $t('reference') }}<sup class="text-size-20 top-1">*</sup>
                            </label>
                            <app-input
                                id="reference"
                                type="text"
                                :placeholder="$t('enter_reference')"
                                v-model="formData.reference"
                                :error-message="$errorMessage(errors, 'reference')"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">
                                {{ $t('date') }}<sup class="text-size-20 top-1">*</sup>
                            </label>
                            <app-input
                                id="date"
                                type="date"
                                :placeholder="$t('enter_date')"
                                v-model="formData.date"
                                :max-date="new Date()"
                                :error-message="$errorMessage(errors, 'date')"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="expense_purpose">
                                {{ $t('expense_purpose') }}
                            </label>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <app-input
                                        id="expense_purpose"
                                        type="search-select"
                                        :placeholder="$t('select_expense_purpose')"
                                        :list="expensePurposeList"
                                        list-value-field="name"
                                        v-model="formData.purpose_id"
                                        :error-message="$errorMessage(errors, 'purpose_id')"
                                    />
                                </div>
                                <button type="button"
                                        data-toggle="tooltip"
                                        :title="$t('add_purpose')"
                                        class="btn btn-primary ml-1"
                                        @click="openPurposeAddEditModal">
                                    <app-icon name="plus"/>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="note">{{ $t('note') }}</label>
                            <app-input
                                id="note"
                                type="textarea"
                                :text-area-rows="3"
                                :placeholder="$t('enter_note')"
                                v-model="formData.note"
                            />
                        </div>
                    </div>
                </div>
            </form>
        </template>
    </modal>
</template>

<script>
import {SubmitFormMixins} from "../../../Mixins/billar/SubmitFormMixins";
import {axiosGet} from "../../../Helpers/AxiosHelper";
import {formDataAssigner} from "../../../Helpers/Helpers";
import {formatDateForServer} from "../../../Helpers/DateTimeHelper";

export default {
    name: "ExpenseCreateEditModal",
    mixins: [SubmitFormMixins],
    data() {
        return {
            formData: {},
            expensePurposeList: [],
            files: [],
            maxFileWarning: false,
            modalId: 'expense-create-edit-modal',
        }
    },
    methods: {
        submitData() {
            if (this.files.length > 1) {
                this.maxFileWarning = true;
                return;
            }
            this.maxFileWarning = false;
            this.formData.date = formatDateForServer(this.formData?.date);
            let formData = formDataAssigner(new FormData(), this.formData);
            if (this.files.length) {
                formData.append("attachment", this.files[0]);
            }
            if (this.selectedUrl) {
                formData.append('_method', 'patch');
                this.submitFromFixin('post', this.selectedUrl, formData)
            } else {
                this.submitFromFixin('post', 'expenses', formData)
            }
        },
        afterSuccessFromGetEditData(response) {
            this.formData = response.data;
        },
        getExpensePurposeList() {
            axiosGet('purpose-list?type=expense').then(({data}) => {
                this.expensePurposeList = data;
            })
        },
        openPurposeAddEditModal(){
            this.$emit('openPurposeAddEditModal');
        }
    },
    mounted() {
        this.getExpensePurposeList();
        this.$hub.$on('new-purpose-added', () => {
            this.getExpensePurposeList();
        });
    }
}
</script>

<style scoped>

</style>