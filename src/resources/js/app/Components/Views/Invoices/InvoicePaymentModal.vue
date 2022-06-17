<template>
    <app-modal modal-alignment="top" modal-id="invoice-payment-modal"
               modal-size="default"
               :modal-backdrop="preloader"
               @close-modal="closeModal">
        <template slot="header">
            <h5 class="modal-title">{{ $t('pay_invoice') }}</h5>
            <button aria-label="Close" class="close outline-none" data-dismiss="modal" type="button">
                <span>
                    <app-icon :name="'x'"></app-icon>
                </span>
            </button>
        </template>
        <template slot="body">
            <div v-if="paymentMethodList.length > 0 && paymentTypeList.length > 0"
                 class="form-group row align-items-center">
                <app-overlay-loader v-if="preloader"/>
                <template v-else>
                    <div class="col-12 col-lg-4">
                        <label for="paymentType" class="mb-0 text-size-16 text-capitalize">
                            {{ $t('payment_method') }}
                        </label>
                    </div>
                    <div class="col-12 col-lg-8">
                        <app-input
                            id="paymentType"
                            type="radio-buttons"
                            v-model="paymentType"
                            @input="afterSelectedPayMethod"
                            :list="paymentTypeList"/>
                    </div>
                </template>
            </div>
            <div v-else class="note note-warning p-4">
                {{ $t('no_payment_type_notice') }}
            </div>
        </template>
        <template slot="footer">
            <button class="btn btn-secondary mr-2" data-dismiss="modal" type="button" @click.prevent="closeModal">
                {{ $t('cancel') }}
            </button>
            <template v-if="paymentType==='stripe'">
                <stripe-checkout-modal
                    :invoice-info="formData"
                    payment-type="stripe"
                    @payment-success="paymentSuccess"
                    @paymentLoader="paymentLoader"
                    :disabled="preloader"
                />
            </template>
            <template v-else-if="paymentType==='paypal'">
                <button type="button"
                        class="btn btn-primary"
                        :disabled="!paypalButton"
                        @click.prevent="submit(formData)">{{ $t('complete_payment') }}
                </button>
                <div id="paypal-button" v-if="!preloader"></div>
            </template>

        </template>
    </app-modal>
</template>

<script>
import {PAYMENTHISTORY} from "../../../Config/BillarApiUrl";
import {FormMixin} from "../../../../core/mixins/form/FormMixin";
import AppFunction from "../../../../core/helpers/app/AppFunction";
import {axiosPost} from "../../../Helpers/AxiosHelper";
import {mapGetters} from 'vuex'

export default {
    name: 'InvoicePaymentModal',
    mixins: [FormMixin],
    props: {
        invoiceId: {},
        tableId: {}
    },
    data() {
        return {
            PAYMENTHISTORY,
            formData: {},
            paymentTypeData: {},
            paymentType: '',
            paypalButton: true,
            preloader: false,
            AppFunction
        }
    },
    methods: {
        afterSelectedPayMethod() {
            this.paypalButton = true;
        },
        submit(formData) {
            this.paypalButton = false;
            paypal.Button.render({
                env: window.paymentConfig.paypalPaymentMode ?? 'sandbox', // change for production if app is live,
                client: {
                    sandbox: window.paymentConfig.paypalPaymentMode == 'sandbox' ? window.paymentConfig.paypalClientId : '',
                    production: window.paymentConfig.paypalPaymentMode == 'production' ? window.paymentConfig.paypalClientId : ''
                },

                commit: true, // Show a 'Pay Now' button

                style: {
                    color: 'gold',
                    size: 'small'
                },

                payment: function (data, actions) {
                    return actions.payment.create({
                        payment: {
                            transactions: [
                                {
                                    amount: {
                                        total: formData.due_amount,
                                        currency: 'USD'
                                    }
                                }
                            ]
                        }
                    });
                },

                onAuthorize: (data, actions) => {
                    return actions.payment.execute().then((payment) => {
                        if (payment.payer.status === 'VERIFIED' && payment.state === 'approved')
                            this.preloader = true;
                        axiosPost('checkout', {
                            amount: formData.due_amount,
                            payment_type: 'paypal',
                            invoice_id: formData.id
                        }).then((response) => {
                            this.preloader = false;
                            this.$toastr.s(response.data.message);
                            this.paymentSuccess();
                        });

                    });
                },
                onCancel: function (data, actions) {
                    actions.redirect();
                },
                onError: function (err) {
                    console.log(err)
                }

            }, '#paypal-button');


        },
        paymentLoader(event) {
            this.preloader = event;
        },
        paymentSuccess() {
            this.paymentType = '';
            this.$hub.$emit('reload-' + this.tableId);
            this.closeModal();
        },
        afterSuccessFromGetEditData(response) {
            this.formData = response.data;
        },
        hideModal() {
            $('#invoice-payment-modal').modal('hide');
        },
        closeModal() {
            this.hideModal();
            this.$emit('closeModal')
        },
    },
    computed: {
        ...mapGetters({
            paymentMethodList: 'getPaymentMethod'
        }),
        paymentTypeList() {
            let list = [],
                configList = window.paymentConfig;

            this.paymentMethodList.filter((item) => {
                if (item.alias === 'paypal' && configList?.paypalClientId) {
                    list.push({id: 'paypal', value: this.$t('paypal')})
                }
                if (item.alias === 'stripe' && configList?.stripePublicKey) {
                    list.push({id: 'stripe', value: this.$t('stripe')})
                }
            })
            return list;

        }
    }


}
</script>

<style lang="scss">
#invoice-payment-modal {
    @media (min-width: 576px) {
        &.modal {
            .modal-dialog {
                .modal-content {
                    min-height: 280px !important;
                }
            }
        }
    }
}

</style>