<template>
    <div>
        <div class="content-wrapper">
            <div class="d-flex align-items-center justify-content-between">
                <app-breadcrumb :page-title="$t('invoice_details')"/>
                <div class="mb-4">
                    <button v-if="$can('update_invoices')" class="btn btn-warning btn-with-shadow mr-1"
                            type="button"
                            @click="editInvoice">
                        <app-icon class="size-20 mr-2" name="edit"/>
                        {{ $t('edit') }}
                    </button>
                    <button v-if="$can('invoice_download')" class="btn btn-primary btn-with-shadow mr-1"
                            type="button"
                            @click="downloadInvoice">
                        <app-icon class="size-20 mr-2" name="download"/>
                        {{ $t('action_invoice_download') }}
                    </button>
                    <button v-if="$can('invoice_send')" class="btn btn-success btn-with-shadow"
                            type="button"
                            @click="openSendInvoiceModal">
                        <app-icon class="size-20 mr-2" name="send"/>
                        {{ $t('send') }}
                    </button>
                </div>
            </div>

            <div class="row justify-content-center">
                <div v-if="dataLoaded" class="invoice_preview primary-card-color">
                    <div id="print-invoice" class="cus-invoice_container">
                        <div class="cus-invoice_container__item cus-px-5 cus-mt-5">
                            <div class="cus-w-25 cus-f-left cus-p-2">
                                <div>
                                    <img class="cus-logo" :src="AppFunction.getAppUrl(configData.invoice_logo)" alt="NF">
                                </div>
                            </div>
                            <div class="cus-w-50 cus-f-right cus-text-right">
                                <h1 class="cus-text-capital cus-bold">Invoice</h1>
                                <table class="cus-f-right cus-w-75 cus-font-xm cus-mt-3">
                                    <tr>
                                        <td class="cus-bold">{{ $t('invoice_no') }}</td>
                                        <td>:</td>
                                        <td class="cus-text-right">{{ formData.invoice_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="cus-bold">{{ $t('date') }}</td>
                                        <td>:</td>
                                        <td class="cus-text-right">{{ formatDateToLocal(formData.date) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="cus-bold">{{ $t('due_date') }}</td>
                                        <td>:</td>
                                        <td class="cus-text-right">{{ formatDateToLocal(formData.due_date) }}</td>
                                    </tr>
                                </table>
                                <div class="cus-f-clear"></div>
                            </div>
                            <div class="cus-f-clear"></div>
                        </div>

                        <div class="cus-invoice_container__item cus-p-5">
                            <div class="cus-w-50 cus-f-left cus-font-xm">
                                <p v-if="formData.created_by" class="cus-bold">{{ $t('from') }}</p>
                                <p>{{ formData.created_by.full_name }}</p>
                                <template v-if="formData.created_by.profile">
                                    <small v-if="formData.created_by.profile.contact">{{ $t('contact') }}: {{ formData.created_by.profile.contact }}</small>
                                    <br>
                                    <small v-if="formData.created_by.profile.address">{{ $t('address') }}: {{ formData.created_by.profile.address }}</small>
                                </template>
                            </div>
                            <div class="cus-w-50 cus-f-right cus-font-xm">
                                <div class="cus-w-75 cus-f-right">
                                    <p v-if="formData.client" class="cus-bold">{{ $t('to') }}</p>
                                        <p>{{ formData.client.full_name }}</p>
                                        <template v-if="formData.client.profile">
                                            <small v-if="formData.client.profile.contact">{{ $t('contact') }}: {{ formData.client.profile.contact }}</small>
                                            <br>
                                            <small v-if="formData.client.profile.address">{{ $t('address') }}: {{ formData.client.profile.address }}</small>
                                        </template>
                                </div>
                                <div class="cus-f-clear"></div>
                            </div>
                            <div class="cus-f-clear"></div>
                        </div>


                        <div class="cus-invoice_container__item cus-px-5">
                            <table class="cus-w-100 cus-font-xm cus-table-strip" border="0" cellspacing="0" cellpadding="0">
                                <thead>
                                <tr class="cus-bg-dark cus-text-light">
                                    <th class="cus-w-45 cus-p-1 cus-text-left">{{ $t('product') }}</th>
                                    <th class="cus-w-10 cus-p-1 cus-text-right">{{ $t('quantity') }}</th>
                                    <th class="cus-w-15 cus-p-1 cus-text-right">{{ $t('unit_price') }}</th>
                                    <th class="cus-w-15 cus-p-1 cus-text-right">{{ $t('tax') }}</th>
                                    <th class="cus-w-15 cus-p-1 cus-text-right">{{ $t('total') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(invoiceProduct, index) in formData.invoice_details" :key="`invoice-item-${index}`">
                                        <td class="cus-p-1">{{ invoiceProduct.product.name }}</td>
                                        <td class="cus-p-1 cus-text-right">{{ invoiceProduct.quantity }}</td>
                                        <td class="cus-p-1 cus-text-right">{{ numberWithCurrencySymbol(invoiceProduct.price) }}</td>
                                        <td class="cus-p-1 cus-text-right">{{ invoiceProduct.tax ? (invoiceProduct.tax.value) + ('%') : 'N/A' }}</td>
                                        <td class="cus-p-1 cus-text-right">
                                            {{ numberWithCurrencySymbol(
                                                calculateProductTax(
                                                    invoiceProduct.tax
                                                    ? invoiceProduct.tax.value
                                                    : 0, invoiceProduct.quantity * invoiceProduct.price) + (invoiceProduct.quantity * invoiceProduct.price))
                                            }}
                                        </td>
                                    </tr>
                                <tr class="cus-bg-transparent">
                                    <td colspan="5">
                                        <div class="cus-hr cus-mt-2"></div>
                                    </td>
                                </tr>
                                <tr class="cus-bg-transparent">
                                    <td colspan="2"></td>
                                    <td colspan="2" class="cus-bold cus-p-1">{{ $t('sub_total') }} :</td>
                                    <td class="cus-text-right cus-p-1">{{ numberWithCurrencySymbol(formData.sub_total) }}</td>
                                </tr>
                                <tr class="cus-bg-transparent">
                                    <td colspan="2"></td>
                                    <td colspan="2" class="cus-bold p-1">{{ $t('tax') }} :</td>
                                    <td class="cus-text-right cus-p-1">{{ numberWithCurrencySymbol(totalTax) }}</td>
                                </tr>
                                <tr class="cus-bg-transparent">
                                    <td colspan="2"></td>
                                    <td colspan="2" class="cus-bold cus-p-1">{{ $t('discount') }} :</td>
                                        <td v-if="formData.discount_type === 'percentage'" class="cus-text-right cus-p-1">{{ formData.discount }} %</td>
                                        <td v-else class="cus-text-right cus-p-1">{{ numberWithCurrencySymbol(formData.discount) }}</td>
                                </tr>
                                <tr class="cus-bg-transparent">
                                    <td colspan="2"></td>
                                    <td colspan="2" class="cus-bold p-1">{{ $t('total') }} :</td>
                                    <td class="cus-text-right cus-p-1">{{ numberWithCurrencySymbol(formData.total) }}</td>
                                </tr>
                                <tr class="cus-bg-transparent">
                                    <td colspan="2"></td>
                                    <td colspan="2" class="cus-bold p-1">{{ $t('paid') }} :</td>
                                    <td colspan="2" class="cus-text-right p-1">{{ numberWithCurrencySymbol(formData.received_amount) }}</td>
                                </tr>
                                <tr class="cus-bg-transparent">
                                    <td colspan="2" class="cus-bg-transparent"></td>
                                    <td colspan="3" class="cus-bg-transparent">
                                        <div class="cus-hr cus-mt-2"></div>
                                    </td>
                                </tr>
                                <tr class="cus-bg-transparent cus-bold">
                                    <td colspan="2"></td>
                                    <td colspan="2" class="cus-p-1">{{ $t('due_amount') }} :</td>
                                    <td class="cus-text-right cus-p-1">{{ numberWithCurrencySymbol(formData.due_amount) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="cus-invoice_container__item cus-p-5 cus-font-xm">
                            <div>
                                <template v-if="formData.notes">
                                    <div class="cus-bold">{{ $t('notes') }}</div>
                                    <p v-html="formData.notes"></p>
                                </template>
                                <template v-if="formData.terms">
                                    <div class="cus-bold cus-mt-3">{{ $t('terms') }}</div>
                                    <p v-html="formData.terms"></p>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <app-overlay-loader v-else/>
            </div>
            
            <send-invoice-modal
                v-if="isSendInvoiceModalActive"
                :email="formData.client.email"
                :invoice-information="formData"
                @closeModal="closeSendInvoiceModal"
            />
            
            <!-- Client Add/Edit Modal -->
            <invoice-add-edit-modal
                v-if="isInvoiceAddEditModalActive"
                :clientList="clients"
                :productList="productList"
                :recurring-cycle-list="recurringCycleList"
                :selected-url="selectUrl"
                :status-list="statuses"
                :table-id="tableId"
                :tax-list="taxList"
                @closeModal="closeInvoiceModal"
                @success="afterUpdate"
            />
        </div>
</div>
</template>

<script>
import AppFunction from '../../../../core/helpers/app/AppFunction';
import {SubmitFormMixins} from "../../../Mixins/billar/SubmitFormMixins";
import {formatDateToLocal, numberWithCurrencySymbol} from "../../../Helpers/Helpers";
import {mapGetters} from "vuex";
import {INVOICES} from "../../../Config/BillarApiUrl";
import {clientUser, status} from "../../../Mixins/FilterMixin";


export default {
	name: 'InvoiceDetails',
	mixins: [SubmitFormMixins, clientUser, status],
	props: {
		configData: {}
	},
	data() {
		return {
			numberWithCurrencySymbol,
			formatDateToLocal,
			dataLoaded: false,
			AppFunction,
			isSendInvoiceModalActive: false,
			isInvoiceAddEditModalActive: false,
			productList: [],
			selectUrl: '',
			formData: {},
		}
	},
	computed: {
		totalTax() {
			let totalTaxes = 0;
			this.formData.invoice_details.map((item) => {
				if (item.tax) {
					totalTaxes = totalTaxes + (((item.price * item.quantity) * item.tax.value) / 100)
				} else {
					totalTaxes = totalTaxes + 0;
				}
			});
			return totalTaxes;
		},
		...mapGetters({
			recurringCycleList: "getRecurringCycle",
			taxList: "getTax",
		}),
	},
	methods: {
		calculateProductTax(tax, totalPrice) {
			let taxes = 0;
			taxes = ((totalPrice * tax) / 100);
			return taxes;
		},
		afterSuccessFromGetEditData(response) {
			this.formData = response.data;
			this.dataLoaded = true;
		},
		editInvoice() {
			this.selectUrl = `${INVOICES}/${this.formData.id}`;
			this.isInvoiceAddEditModalActive = true;
		},
		downloadInvoice() {
			window.open(AppFunction.getAppUrl(`invoice-download/${this.formData.id}`))
		},
		openSendInvoiceModal() {
			this.isSendInvoiceModalActive = true;
		},
		closeSendInvoiceModal() {
			this.isSendInvoiceModalActive = false;
			$('#send-invoice-modal').modal('hide');
		},
		getAllProduct() {
			this.axiosGet(`products?all`).then(({data}) => {
				this.productList = data
			})
		},
		closeInvoiceModal() {
			this.selectUrl = "";
			this.isInvoiceAddEditModalActive = false;
		},
		afterUpdate() {
			window.location.reload();
		}
	},
	mounted() {
		this.getAllProduct();
		this.$store.dispatch("getRecurringCycle");
		this.$store.dispatch("getTax");
		
	}
}
</script>
<style scoped>
/* dev */
        .t {
            border: 1px solid red;
        }

        .invoice_preview {
            width: 100%;
            max-width: 800px;
            min-height: 700px;
        }

        .cus-bg-t {
            background-color: #00660050;
        }

        .cus-bg-dark {
            background-color: #333333 !important;
        }

        .cus-bg-secondary {
            background-color: #dddddd !important;
        }

        .cus-bg-transparent {
            background-color: transparent !important;
        }

        .invoice_preview * {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }

        /*common*/
        .cus-m-0 {
            margin: 0;
        }

        .cus-m-1 {
            margin: 5px;
        }

        .cus-m-2 {
            margin: 10px;
        }

        .cus-m-3 {
            margin: 15px;
        }

        .cus-m-4 {
            margin: 20px;
        }

        .cus-m-5 {
            margin: 25px;
        }

        .cus-mx-1 {
            margin: 0 5px;
        }

        .cus-mx-2 {
            margin: 0 10px;
        }

        .cus-mx-3 {
            margin: 0 15px;
        }

        .cus-mx-4 {
            margin: 0 20px;
        }

        .cus-mx-5 {
            margin: 0 25px;
        }

        .cus-my-1 {
            margin: 5px 0;
        }

        .cus-my-2 {
            margin: 10px 0;
        }

        .cus-my-3 {
            margin: 15px 0;
        }

        .cus-my-4 {
            margin: 20px 0;
        }

        .cus-my-5 {
            margin: 25px 0;
        }

        .cus-mt-1 {
            margin-top: 5px
        }

        .cus-mt-2 {
            margin-top: 10px
        }

        .cus-mt-3 {
            margin-top: 15px
        }

        .cus-mt-4 {
            margin-top: 20px
        }

        .cus-mt-5 {
            margin-top: 25px
        }

        .cus-mb-1 {
            margin-bottom: 5px
        }

        .cus-mb-2 {
            margin-bottom: 10px
        }

        .cus-mb-3 {
            margin-bottom: 15px
        }

        .cus-mb-4 {
            margin-bottom: 20px
        }

        .cus-mb-5 {
            margin-bottom: 25px
        }

        .cus-p-0 {
            padding: 0;
        }

        .cus-p-1 {
            padding: 5px;
        }

        .cus-p-2 {
            padding: 10px;
        }

        .cus-p-3 {
            padding: 15px;
        }

        .cus-p-4 {
            padding: 20px;
        }

        .cus-p-5 {
            padding: 25px;
        }

        .cus-px-1 {
            padding: 0 5px;
        }

        .cus-px-2 {
            padding: 0 10px;
        }

        .cus-px-3 {
            padding: 0 15px;
        }

        .cus-px-4 {
            padding: 0 20px;
        }

        .cus-px-5 {
            padding: 0 25px;
        }

        .cus-py-1 {
            padding: 5px 0;
        }

        .cus-py-2 {
            padding: 10px 0;
        }

        .cus-py-3 {
            padding: 15px 0;
        }

        .cus-py-4 {
            padding: 20px 0;
        }

        .cus-py-5 {
            padding: 25px 0;
        }

        .cus-w-10 {
            width: 10%;
        }

        .cus-w-15 {
            width: 15%;
        }

        .cus-w-45 {
            width: 45%;
        }

        .cus-w-25 {
            width: 25%;
        }

        .cus-w-50 {
            width: 50%;
        }

        .cus-w-75 {
            width: 75%;
        }

        .cus-w-100 {
            width: 100%;
        }

        .cus-h-100 {
            height: 100%;
        }

        .cus-f-left {
            float: left;
        }

        .cus-f-right {
            float: right;
        }

        .cus-f-clear {
            clear: both;
        }

        .cus-text-left {
            text-align: left;
        }

        .cus-text-right {
            text-align: right;
        }

        .cus-text-center {
            text-align: center;
        }

        .cus-text-secondary {
            color: #666666;
        }

        .cus-text-black {
            color: #000 !important;
        }

        .cus-text-light {
            color: #fff;
        }

        .cus-text-capital {
            text-transform: uppercase;
        }

        .cus-thin {
            font-weight: lighter;
        }

        .cus-bold {
            font-weight: bold;
        }

        .cus-font-xm {
            font-size: small;
        }

        .cus-font-md {
            font-size: medium;
        }

        .cus-font-lg {
            font-size: large;
        }

        .cus-table-strip {
        }

        .cus-table-strip tr:nth-child(even) {
            background-color: #66666610;
        }

        /*layout*/
        .cus-invoice_container {
        }

        .cus-invoice_container * {
            box-sizing: content-box;
        }

        .cus-invoice_container__item {

        }

        .cus-logo {
            width: 96px;
        }

        .cus-hr {
            background-color: #999999;
            border: none;
            height: 1px;
        }
</style>
