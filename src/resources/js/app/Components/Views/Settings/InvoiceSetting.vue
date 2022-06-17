<template>
	<div>
		<app-note :notes="$t('invoice_setting_warning_note')" :title="$t('warning')"></app-note>
		<app-overlay-loader v-if="preloader"/>
		<form v-else ref="form" :class="{'loading-opacity': preloader}" class="mb-0 mt-3"
		      data-url="/invoice/settings"
		      enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group row">
						<label class="col-lg-3 mb-lg-0" for="invoiceLogo">
							{{ $t('invoice_logo') }} <br>
							<small class="text-muted font-italic">
								({{ $t('recommended_product_size') }})
							</small>
						</label>
						<div class="col-lg-8">
							<app-input
								id="invoiceLogo"
								v-model="formData.invoice_logo"
								:error-message="$errorMessage(errors, 'invoice_logo')"
								:generate-file-url="false"
								:label="$t('change_logo')"
								type="custom-file-upload"
								@change="companyLogo = true"
							/>
						</div>
					</div>
					<div class="form-group row align-items-center">
						<label class="col-lg-3 mb-lg-0" for="invoiceStartingNumber">
							{{ $t('invoice_starting_number') }}<br>
						</label>
						<div class="col-lg-8">
							<app-input
								id="invoiceStartingNumber"
								v-model="formData.invoice_starting_number"
								:error-message="$errorMessage(errors, 'invoice_starting_number')"
								type="number"
							/>
						</div>
					</div>
				</div>
			</div>
			
			<div v-if="$can('manage_invoice_setting')" class="mt-5 action-buttons">
				<button class="btn btn-primary mr-2" @click.prevent="submit">
					{{ $t('save') }}
				</button>
			</div>
		
		</form>
	</div>
</template>

<script>
import {FormMixin} from '../../../../core/mixins/form/FormMixin';
import {formDataAssigner} from "../../../Helpers/Helpers";
import {urlGenerator} from "../../../Helpers/AxiosHelper";

export default {
	name: 'InvoiceSetting',
	mixins: [FormMixin],
	data() {
		return {
			editorShow: false,
			preloader: false,
			isImageChange: false,
			errors: {},
			formData: {
				invoice_logo: '',
				invoice_starting_number: '',
			},
			companyLogo: false,
		}
	},
	methods: {
		afterError(response) {
			this.errors = response.data.errors;
		},
		submit() {
			if (this.companyLogo === false) {
				delete this.formData.invoice_logo;
			}
			let formData = formDataAssigner(new FormData, this.formData);
			
			this.save(formData)
		},
		afterSuccess(res) {
			this.$toastr.s(res.data.message);
		},
		getInvoiceData() {
			this.preloader = true;
			this.axiosGet(`get-basic-setting-data`).then(({data}) => {
				this.formData = data;
				this.formData.invoice_logo = urlGenerator(data.invoice_logo);
			}).finally(() => {
				this.preloader = false;
			})
		}
	},
	created() {
		this.getInvoiceData();
	}
}
</script>