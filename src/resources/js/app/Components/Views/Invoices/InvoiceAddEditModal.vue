<template>
	<modal :modal-id="modalId"
	       :preloader="preloader"
	       :title="selectedUrl ? $t('edit_invoice') : $t('add_invoice')"
	       modal-size="extra-large"
	       @closeModal="closeModal"
	       @submit="submit">
		<template slot="body">
			<app-overlay-loader v-if="preloader"/>
			<form ref="form"
			      :class="{'loading-opacity': preloader}"
			      :data-url="selectedUrl ? selectedUrl : INVOICES"
			      class="mb-0">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="client">{{ $t('client') }}</label>
							<app-input
								id="client"
								v-model="formData.client_id"
								:error-message="$errorMessage(errors, 'client_id')"
								:list="clientList"
								:placeholder="$t('choose_a_client')"
								list-value-field="value"
								type="search-select"
							/>
						</div>
						<div class="form-group">
							<label for="invoiceNumber">{{ $t('invoice_number') }}</label>
							<app-input
								id="invoiceNumber"
								v-model="formData.invoice_number"
								:disabled="true"
								:error-message="$errorMessage(errors, 'invoice_number')"
								:placeholder="$t('invoice_number')"
								type="text"
							/>
						</div>
						<div class="form-group">
							<label for="recurring">{{ $t('recurring') }}</label>
							<app-input
								id="recurring"
								v-model="formData.recurring"
								:error-message="$errorMessage(errors, 'recurring')"
								:list="recurringList"
								:placeholder="''"
								list-value-field="name"
								type="radio-buttons"
							/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="date">{{ $t('date') }}</label>
							<app-input
								id="date"
								v-model="formData.date"
								:error-message="$errorMessage(errors, 'date')"
								type="date"
							/>
						</div>
						<div class="form-group">
							<label for="dueDate">{{ $t('due_date') }}</label>
							<app-input
								id="dueDate"
								:min-date="formData.due_date"
								v-model="formData.due_date"
								:error-message="$errorMessage(errors, 'due_date')"
								type="date"
							/>
						</div>
						<div class="form-group">
							<label for="status">{{ $t('status') }}</label>
							<app-input
								id="status"
								v-model="formData.status_id"
								:error-message="$errorMessage(errors, 'status_id')"
								:list="statusList"
								:placeholder="$t('choose_a_status')"
								list-value-field="value"
								type="search-select"
							/>
						</div>
					</div>
					<div class="col-md-6">
						<div v-if="formData.recurring == 1" class="form-group">
							<label for="recurringCycle">{{ $t('recurring_cycle') }}</label>
							<app-input
								id="recurringCycle"
								v-model="formData.recurring_cycle_id"
								:error-message="$errorMessage(errors, 'recurring_cycle_id')"
								:list="recurringCycleList"
								:placeholder="$t('choose_a_recurring_cycle')"
								list-value-field="name"
								type="search-select"
							/>
						</div>
					</div>
				</div>
				<div>
					<div class="text-white bg-dark px-3 py-2 rounded-top">
						<div class="row">
							<div class="col-md-4">{{ $t('product') }}</div>
							<div class="col-md-2 text-md-right">{{ $t('quantity') }}</div>
							<div class="col-md-2 text-md-right">{{ $t('unit_price') }}</div>
							<div class="col-md-2 text-md-right">{{ $t('tax') }}</div>
							<div class="col-md-2 text-md-right">{{ $t('amount') }}</div>
						</div>
					</div>
					<div v-for="(product, index) in invoice_details" class="default-base-color p-3">
						<div class="row">
							<div class="col-lg-4 mb-2 mb-md-0">
								<app-input
									v-model="product.product_id"
									:list="productList"
									:placeholder="$t('choose_a_product')"
									list-value-field="name"
									type="search-select"
									@input="changeProduct($event, product)"
								/>
								<template v-if="Object.keys(errors).length">
									<small v-if="errors[`products.${index}.product_id`]" class="text-danger">
										{{ errors[`products.${index}.product_id`][0] }}
									</small>
								</template>
							
							</div>
							<div class="col-6 col-lg-2 mb-2 mb-md-0">
								<app-input
									v-model="product.quantity"
									:placeholder="$t('add_quantity')"
									type="number"
									@input="changeQty(product)"
								/>
								<template v-if="Object.keys(errors).length">
									<small v-if="errors[`products.${index}.quantity`]" class="text-danger">
										{{ errors[`products.${index}.quantity`][0] }}
									</small>
								</template>
							</div>
							<div class="col-6 col-lg-2 mb-2 mb-md-0">
								<app-input
									v-model="product.price"
									:placeholder="$t('add_price')"
									type="text"
								/>
								<template v-if="Object.keys(errors).length">
									<small v-if="errors[`products.${index}.price`]" class="text-danger">
										{{ errors[`products.${index}.price`][0] }}
									</small>
								</template>
							</div>
							<div class="col-6 col-lg-2">
								<app-input
									v-model="product.tax_id"
									:list="taxList"
									:placeholder="taxList && taxList.length > 1 ? $t('choose_tax') : $t('n_a_tax')"
									list-value-field="name"
									type="select"
									@input="changeTax(product)"
								/>
							</div>
							<div class="col-6 col-lg-2">
								<div class="d-flex align-items-center">
									<app-input
										v-model="product.amount"
										:disabled="true"
										:placeholder="''"
										type="text"
									/>
									<template v-if="Object.keys(errors).length">
										<small v-if="errors[`products.${index}.amount`]" class="text-danger">
											{{ errors[`products.${index}.amount`][0] }}
										</small>
									</template>
									<button v-if="invoice_details.length > 1"
									        class="btn pr-0"
									        type="button"
									        @click="removeProductRow(index, product.id)">
										<app-icon class="size-15 text-danger" name="trash-2"/>
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="text-right">
						<button class="btn btn-sm btn-primary my-2" type="button" @click="addMoreProduct">
							<app-icon class="size-13 mr-2" name="plus"/>
							{{ $t('add_more') }}
						</button>
					</div>
					<div class="row justify-content-end mb-primary">
						<div class="col-lg-6 col-xl-5">
							<div class="text-size-16 border-bottom mb-2">
								<div class="d-flex align-items-center justify-content-between py-2">
									<p class="text-muted mb-0">{{ $t('sub_total') }}</p>
									<p class="mb-0">{{ numberWithCurrencySymbol(totalSummation.subTotal) }}</p>
								</div>
								<div class="d-flex align-items-center justify-content-between py-2">
									<p class="text-muted mb-0">{{ $t('tax') }}</p>
									<p class="mb-0">{{ numberWithCurrencySymbol(totalSummation.tax) }}</p>
								</div>
								<div class="row align-items-center justify-content-between py-2">
									<div class="col-7">
										<app-input
											id="discount_type"
											v-model="formData.discount_type"
											:list="discountTypeList"
											list-value-field="name"
											type="select"
										/>
									</div>
									<div class="col-5">
										<app-input
											v-model="formData.discount"
											:disabled="formData.discount_type === 'none'"
											type="number"
										/>
									</div>
								</div>
							</div>
							<div class="d-flex align-items-center justify-content-between">
								<h4 class="text-muted mb-0">{{ $t('total') }}</h4>
								<h4 class="mb-0">{{ numberWithCurrencySymbol(grandTotal) }}</h4>
							</div>
							
							<div class="row d-flex align-items-center justify-content-between py-2">
								<div class="col-7">
									<p class="text-muted mb-0">{{ $t('received_amount') }} </p>
								</div>
								<div class="col-5">
									<app-input
										v-model="formData.received_amount"
										:error-message="$errorMessage(errors, 'received_amount')"
										type="number"
									/>
								</div>
							</div>
							
							<div class="d-flex align-items-center justify-content-between py-2">
								<p class="text-muted mb-0">{{ $t('return_amount') }}</p>
								<h4 class="mb-0">{{ numberWithCurrencySymbol(returnAmount) }}</h4>
							</div>
							
							<div class="d-flex align-items-center justify-content-between py-2">
								<p class="text-muted mb-0">{{ $t('due_amount') }}</p>
								<h4 class="mb-0">{{ numberWithCurrencySymbol(deuAmount) }}</h4>
							</div>
						
						</div>
					</div>
					<button v-if="!addNoteAndTerms"
					        :key="`plus`"
					        class="btn btn-primary"
					        type="button"
					        @click.prevent="addNoteAndTerms = true">
						<app-icon name="plus"/>
						{{ $t('add_note_terms') }}
					</button>
					<button v-else
					        :key="`minus`"
					        class="btn btn-warning"
					        type="button"
					        @click.prevent="removeNoteAndTerms">
						<app-icon name="minus"/>
						{{ $t('remove_note_terms') }}
					</button>
					<template v-if="addNoteAndTerms">
						<div class="form-group mt-primary">
							<label for="notes">{{ $t('notes') }}</label>
							<app-input v-if="editorShow"
							           id="notes"
							           v-model="formData.notes"
							           :minimal="true"
							           type="text-editor"
							/>
						</div>
						<div class="form-group">
							<label for="terms">{{ $t('terms') }}</label>
							<app-input v-if="editorShow"
							           id="terms"
							           v-model="formData.terms"
							           :minimal="true"
							           type="text-editor"/>
						</div>
					</template>
				</div>
			</form>
		</template>
	</modal>
</template>

<script>
import moment from 'moment';
import {FormMixin} from '../../../../core/mixins/form/FormMixin';
import {numberWithCurrencySymbol} from "../../../Helpers/Helpers";
import {SubmitFormMixins} from "../../../Mixins/billar/SubmitFormMixins";
import {INVOICES} from "../../../Config/BillarApiUrl";
import DateFunction from "../../../../core/helpers/date/DateFunction";

export default {
	name: 'InvoiceAddEditModal',
	mixins: [SubmitFormMixins, FormMixin],
	props: {
		productList: {
			type: Array,
		},
		statusList: {
			type: Array
		},
		recurringCycleList: {
			type: Array
		},
		taxList: {
			type: Array
		},
		clientList: {
			type: Array
		},
		
	},
	data() {
		return {
			numberWithCurrencySymbol,
			INVOICES,
			modalId: 'invoice-add-edit-modal',
			editorShow: false,
			addNoteAndTerms: false,
			formData: {
				client_id: '',
				invoice_number: null,
				recurring: '2',
				date: DateFunction.getDateFormat(new Date(), 'YYYY-MM-DD'),
				due_date: DateFunction.getDateFormat(new Date(), 'YYYY-MM-DD'),
				status_id: '',
				recurring_cycle_id: '',
				discount_type: 'none',
				discount: '',
				received_amount: null,
				notes: '',
				terms: ''
			},
			invoice_details: [
				{product_id: '', quantity: null, price: '', tax_id: null, amount: ''}
			],
			recurringList: [
				{id: '1', name: 'Yes'},
				{id: '2', name: 'No'}
			],
			discountTypeList: [
				{id: 'none', name: this.$t('discount_type')},
				{id: 'fixed', name: this.$t('fixed')},
				{id: 'percentage', name: this.$t('percentage')}
			]
		}
	},
	computed: {
		totalSummation() {
			let tax = 0;
			let subTotal = 0;
			this.invoice_details.forEach((item) => {
				let productPrice = parseFloat((item.quantity * item.price));
				let taxObj = this.taxList ? this.taxList.find(i => i.id == item.tax_id) : {};
				let productTax = typeof taxObj === 'undefined' ? 0 : taxObj.value;
				tax += (productPrice * (productTax / 100));
				subTotal += item.amount ? parseFloat((item.amount)) : 0;
			})
			return {tax, subTotal};
		},
		grandTotal() {
			if (this.formData.discount_type === 'none') {
				return this.totalSummation.subTotal;
			} else if (this.formData.discount_type === 'fixed') {
				return this.formData.discount ?
					(this.totalSummation.subTotal - this.formData.discount) : this.totalSummation.subTotal;
			} else if (this.formData.discount_type === 'percentage') {
				let par = (this.totalSummation.subTotal * this.formData.discount / 100);
				let result = this.totalSummation.subTotal - par;
				return this.formData.discount ? result : this.totalSummation.subTotal;
			}
		},
		deuAmount() {
			if (this.grandTotal < this.formData.received_amount) {
				return 0;
			}
			return (this.grandTotal - this.formData.received_amount);
		},
		
		returnAmount() {
			if (this.grandTotal > this.formData.received_amount) {
				return 0;
			}
			return (this.formData.received_amount - this.grandTotal);
		},
	},
	
	methods: {
		changeProduct(id, product) {
			let objPro = this.productList.find(item => item.id === id);
			product.quantity = 1;
			product.price = objPro.unit_price;
			product.tax_id = objPro.tax_id ? objPro.tax_id : null
			product.amount = objPro.unit_price * product.quantity
		},
		changeQty(product) {
			product.amount = parseFloat((product.quantity * product.price));
		},
		changeTax(product) {
			if (product.tax_id) {
				let taxObj = this.taxList.find(item => item.id == product.tax_id);
				let par = ((product.quantity * product.price) * (taxObj.value / 100));
				product.amount = ((product.quantity * product.price) + par);
			} else {
				product.amount = (product.price * product.quantity);
			}
		},
		addMoreProduct() {
			this.invoice_details.push({
				product_id: '',
				quantity: '',
				price: '',
				tax_id: null,
				amount: ''
			})
		},
		removeProductRow(index, id) {
			let formData = {};
			formData.sub_total = this.totalSummation.subTotal;
			formData.total = this.grandTotal;
			formData.due_amount = this.deuAmount;
			formData.received_amount = this.formData.received_amount;
			formData.invoice_detail_id = id;
			formData.id = this.formData.id;
			if (this.selectedUrl) {
				if (id !== undefined) {
					let deleteContext = {
						payload: {
							'url': 'invoice-details-delete',
							'data': formData
						},
						callBack: () => {
							this.invoice_details.splice(index, 1);
						}
					}
					this.$emit('invoiceProductDelete', deleteContext)
				} else this.invoice_details.splice(index, 1);
			} else this.invoice_details.splice(index, 1);
		},
		submit() {
			let formData = this.formData;
			formData.date = moment(this.formData.date).format('YYYY-MM-DD');
			formData.due_date = moment(this.formData.due_date).format('YYYY-MM-DD');
			formData.products = this.invoice_details;
			formData.discount = this.formData.discount ? this.formData.discount : 0;
			formData.sub_total = this.totalSummation.subTotal;
			formData.total = this.grandTotal;
			formData.received_amount = this.formData.received_amount ? this.formData.received_amount : 0;
			formData.due_amount = this.deuAmount;
			this.save(this.formData)
		},
		
		removeNoteAndTerms() {
			this.addNoteAndTerms = false;
			this.formData.notes = '';
			this.formData.terms = '';
		},
		
		afterSuccessFromGetEditData(response) {
			this.formData = response.data;
			this.invoice_details = this.formData.invoice_details;
			for (let i = 0; i < this.invoice_details.length; i++) {
				this.changeQty(this.invoice_details[i]);
				this.changeTax(this.invoice_details[i]);
			}
			if (this.formData.notes || this.formData.terms) this.addNoteAndTerms = true;
			$("#notes").summernote({
				callbacks: {
					onChange: function () {
						let code = $(this).summernote("code");
						if (this.formData.notes) {
							this.formData.notes = code;
						}
					},
				},
			});
			
			$("#terms").summernote({
				callbacks: {
					onChange: function () {
						let code = $(this).summernote("code");
						if (this.formData.terms) {
							this.formData.terms = code;
						}
					},
				},
			});
			
			this.editorShow = false;
			setTimeout(() => {
				this.editorShow = true;
			});
		},
		getInvoiceCount() {
			this.axiosGet(`invoice-number`).then((response) => {
				let invoice = response.data.id != undefined ? response.data.id : 0
				this.formData.invoice_number = Number(invoice) + Number(window.settings.invoice_starting_number)
			})
		}
	},
	
	mounted() {
		if (!this.selectedUrl) {
			this.editorShow = true;
			this.getInvoiceCount();
		}
	}
}
</script>