<template>
    <div>
        <form method="POST" @submit.prevent="buyNow">
            <input type="hidden" name="stripeToken" v-model="stripeToken">
            <input type="hidden" name="stripeEmail" v-model="stripeEmail">
            <button type="submit" class="btn btn-block btn-primary" :disabled="disabled">
                {{ $t('complete_payment') }}
            </button>
        </form>
    </div>
</template>

<script>

import {axiosPost} from "../../../Helpers/AxiosHelper";

export default {
    name: "StripeCheckout",

    props: {
        invoiceInfo: {
            type: Object,
            required: true,
        },
        paymentType: {
            type: String,
        },
        disabled: {}
    },
    data() {
        return {
            stripeEmail: '',
            stripeToken: '',
        }
    },
    created() {

        this.stripe = StripeCheckout.configure({
            key: window.paymentConfig.stripePublicKey,
            image: "https://stripe.com/img/documentation/checkout/marketplace.png",
            locale: "auto",
            token: (token) => {
                this.$emit('paymentLoader', true)
                axiosPost('checkout', {
                    stripeToken: token.id,
                    stripeEmail: token.email,
                    amount: this.invoiceInfo.due_amount,
                    payment_type: this.paymentType,
                    invoice_id: this.invoiceInfo.id

                }).then((response) => {
                    if (response.data.status === 500) {
                        this.$toastr.e(response.data.message);
                    } else {
                        this.$toastr.s(response.data.message);
                        this.$emit('payment-success')
                        this.$emit('paymentLoader', false)
                    }
                }).catch((error) => {
                    console.log(error, "error");
                })
            }
        });
    },
    methods: {
        buyNow() {
            this.stripe.open({
                name: this.$t('stripe'),
                description: window.settings.company_name,
                zipCode: false,
                amount: this.invoiceInfo ? this.invoiceInfo.due_amount * 100 : 0

            });
        }
    }
}
</script>

