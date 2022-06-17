<template>
    <modal :modal-id="modalId"
           :title="generateModalTitle('payment_method')"
           :preloader="preloader"
           @submit="submit"
           @closeModal="closeModal">

        <template slot="body">
            <app-overlay-loader v-if="preloader"/>

            <form ref="form"
                  :data-url="selectedUrl ? selectedUrl : url"
                  class="mb-0"
                  :class="{'loading-opacity': preloader}">
                <div class="form-group">
                    <label>{{ $t('name') }}</label>
                    <app-input type="text"
                               v-model="formData.name"
                               :placeholder="$t('name')"
                               :error-message="$errorMessage(errors, 'name')"/>
                </div>

                <div class="form-group">
                    <label>{{ $t('type') }}</label>
                    <app-input type="select"
                               v-model="formData.type"
                               :list="paymentType"
                               :error-message="$errorMessage(errors, 'type')"
                    />
                </div>

                <div v-if="selectedUrl" class="form-group">
                    <label>{{ $t('payment_method_status') }}</label>
                    <app-input type="radio"
                               :radio-checkbox-name="'for-status'"
                               list-value-field="translated_name"
                               v-model="formData.status_id"
                               :list="statusList"/>
                </div>

                <template v-if="selectedType">
                    <div v-if="formData.type === 'stripe'" class="form-group">
                        <label>{{ $t('public_key') }}</label>
                        <app-input type="text"
                                   :placeholder="$t('public_key')"
                                   v-model="formData.public_key"
                                   :error-message="$errorMessage(errors, 'public_key')"/>
                    </div>

                    <div v-else class="form-group">
                        <label>{{ $t('client_id') }}</label>
                        <app-input type="text"
                                   :placeholder="$t('client_id')"
                                   v-model="formData.client_id"
                                   :error-message="$errorMessage(errors, 'client_id')"/>
                    </div>

                    <div class="form-group">
                        <label>{{ $t('secret_key') }}</label>
                        <app-input type="password"
                                   :placeholder="$t('secret_key')"
                                   v-model="formData.secret_key"
                                   :error-message="$errorMessage(errors, 'secret_key')"/>
                    </div>

                    <div v-if="formData.type === 'paypal'" class="form-group">
                        <label>{{ $t('mode') }}</label>
                        <app-input type="radio"
                                   :list="modeList"
                                   v-model="formData.mode"
                                   :error-message="$errorMessage(errors, 'mode')"/>
                    </div>

<!--                    <div class="form-group">-->
<!--                        <app-input type="single-checkbox"-->
<!--                                   v-model="formData.is_default"-->
<!--                                   :list-value-field="$t('mark_as_default')"/>-->
<!--                    </div>-->

                </template>

            </form>

        </template>

    </modal>
</template>

<script>
import {FormMixin} from "../../../../../core/mixins/form/FormMixin";
import {GET_PAYMENT_METHOD_STATUS, PAYMENT_METHOD} from "../../../../Config/ApiUrl";
import HelperMixin from "../../../../Mixins/global/HelperMixin";


export default {
    name: "PaymentMethodCreateEditModal",
    mixins: [FormMixin, HelperMixin],
    props: {
        modalId: {
            type: String,
        }
    },

    data() {
        return {
            url: PAYMENT_METHOD,
            statusList: [],
            paymentType: [
                {id: '', value: 'Choose One', disabled: true},
                {id: 'cash', value: this.$t('cash')},
                {id: 'stripe', value: this.$t('stripe')},
                {id: 'paypal', value: this.$t('paypal')}
            ],
            modeList: [
                {id: 'production', value: this.$t('live')},
                {id: 'sandbox', value: this.$t('sandbox')}
            ],
            formData: {
                is_default: false,
                public_key: '',
                secret_key: '',
                client_id: '',
                mode: '',
            },
            preloader: false,
            showError: false,
            errors: {}

        }
    },
    computed: {
        selectedType() {
            if (this.formData.type === 'stripe' || this.formData.type === 'paypal') {
                if (this.formData.type === 'stripe') {
                    this.formData.client_id = '';
                } else {
                    this.formData.public_key = '';
                }
                return true;
            }
            this.formData.secret_key = '';
            this.formData.public_key = '';
            this.formData.client_id = '';
            this.formData.mode = '';
            return false;
        }
    },
    created() {
        this.getStatusList();
    },
    methods: {
        getStatusList() {
            this.axiosGet(GET_PAYMENT_METHOD_STATUS).then(response => {
                this.statusList = response.data
            });
        },
        beforeSubmit() {
            this.preloader = true;
        },
        submit() {
            this.save(this.formData);
        },
        afterFinalResponse() {
            this.preloader = false;
        },
        afterSuccess({data}) {
            this.formData = {};
            $('#payment-method-create-edit-modal').modal('hide');
            this.$emit('payment-method-created');
            this.toastAndReload(data.message, 'all-payment-methods-table');
        },
        afterError(response) {
            this.message = '';
            this.loading = false;
            this.errors = response.data.errors || {};
            if (response.status != 422)
                this.$toastr.e(response.data.message || response.statusText)
        },
        afterSuccessFromGetEditData(response) {
            this.preloader = false;
            this.formData = response.data;
            this.formData.type = this.formData.alias;
            if (this.formData.type == 'stripe') {
                this.formData.public_key = this.formData.client_key;
            } else if (this.formData.type == 'paypal') {
                this.formData.client_id = this.formData.client_key;
            }
        },
        hideModal() {
            $('#' + this.modalId).modal('hide');
        },
        closeModal() {
            this.hideModal();
            this.$emit('closeModal')
        }
    },
}
</script>
