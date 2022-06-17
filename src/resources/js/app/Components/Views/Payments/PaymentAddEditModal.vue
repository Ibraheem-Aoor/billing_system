<template>
  <modal :modal-id="modalId"
         :title="$t('add_payment')"
         :preloader="preloader"
         @submit="submit"
         @closeModal="closeModal">
    <template slot="body">
      <app-overlay-loader v-if="preloader"/>
      <form class="mb-0"
            :class="{'loading-opacity': preloader}"
            ref="form"
            :data-url="selectedUrl ? selectedUrl : PAYMENTHISTORY">
        <div class="form-group">
          <label for="invoice">
            {{ $t('invoice') }}<sup class="text-size-20 top-1">*</sup>
          </label>
          <app-input
              id="invoice"
              type="search-select"
              :placeholder="$t('choose_an_invoice')"
              v-model="formData.invoice_id"
              list-value-field="invoice_number"
              :list="invoiceList"
              :error-message="$errorMessage(errors, 'invoice_id')"
          />
        </div>
        <div class="form-group">
          <label for="receivedOn">{{ $t('received_on') }}</label>
          <app-input
              id="receivedOn"
              type="date"
              v-model="formData.received_on"
              :error-message="$errorMessage(errors, 'received_on')"
          />
        </div>
        <div class="form-group">
          <label for="paymentMethod">
            {{ $t('payment_method') }}<sup class="text-size-20 top-1">*</sup>
          </label>
          <app-input
              id="paymentMethod"
              type="search-select"
              :placeholder="$t('choose_a_payment_method')"
              v-model="formData.payment_method_id"
              list-value-field="name"
              :list="paymentMethodList"
              :error-message="$errorMessage(errors, 'payment_method_id')"
          />
        </div>
        <div class="form-group">
          <label for="amount">
            {{ $t('amount') }}<sup class="text-size-20 top-1">*</sup>
          </label>
          <app-input
              id="amount"
              type="text"
              :placeholder="$t('amount')"
              v-model="formData.amount"
              :error-message="$errorMessage(errors, 'amount')"
          />
        </div>
        <div class="form-group">
          <label for="note">
            {{ $t('notes') }}<sup class="text-size-20 top-1">*</sup>
          </label>
          <app-input
              v-if="editorShow"
              id="note"
              type="text-editor"
              :placeholder="''"
              v-model="formData.note"
              :error-message="$errorMessage(errors, 'note')"
          />
        </div>
      </form>
    </template>
  </modal>
</template>

<script>
import moment from 'moment';
import {SubmitFormMixins} from "../../../Mixins/billar/SubmitFormMixins";
import {mapGetters} from 'vuex'
import {PAYMENTHISTORY} from "../../../Config/BillarApiUrl";

export default {
  name: 'PaymentAddEditModal',
  mixins: [SubmitFormMixins],
  props: ['invoiceId'],
  data() {
    return {
      PAYMENTHISTORY,
      modalId: 'payment-add-edit-modal',
      editorShow: false,
      formData: {
        received_on: moment(new Date()).format('YYYY-MM-DD'),
        invoice_id: this.invoiceId ? Number(this.invoiceId) : null,
        old_amount: null
      },
    }
  },
  computed: {
    ...mapGetters({
      invoiceList: 'getInvoice',
      paymentMethodList: 'getPaymentMethod'
    })
  },
  methods: {

    submit() {
      this.save(this.formData);
    },

    afterSuccessFromGetEditData(response) {
      this.formData = response.data;
      this.formData.old_amount = this.formData.amount;
      $("#note").summernote({
        callbacks: {
          onChange: function () {
            let code = $(this).summernote("code");
            if (this.formData.note) {
              this.formData.note = code;
            }
          },
        },
      });

      this.editorShow = false;
      setTimeout(() => {
        this.editorShow = true;
      });
    },
  },
  mounted() {
    if (!this.selectedUrl) {
      this.editorShow = true;
    }
  },
}
</script>