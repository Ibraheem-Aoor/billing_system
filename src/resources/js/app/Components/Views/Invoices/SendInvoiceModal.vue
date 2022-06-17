<template>
	<modal :modal-id="modalId"
	       :preloader="preloader"
	       :submit-button="$t('send')"
	       :title="$t('send_invoice')"
	       modal-size="extra-large"
	       @closeModal="closeModal"
	       @submit="submit">
		<template slot="body">
			<app-overlay-loader v-if="preloader"/>
			<form ref="form"
			      :class="{'loading-opacity': preloader}"
			      :data-url="INVOICES_SEND+'/'+invoiceInformation.id"
			      class="mb-0">
				<div class="row">
					<div class="col-lg-8">
						<div class="form-group">
							<label for="email">
								{{ $t('email') }}<sup class="text-size-20 top-1">*</sup>
							</label>
							<app-input
								id="email"
								v-model="formData.email"
								:error-message="$errorMessage(errors, 'email')"
								:placeholder="$t('enter_email_address')"
								type="email"
							/>
						</div>
						<div class="form-group">
							<label for="subject">
								{{ $t('subject') }}<sup class="text-size-20 top-1">*</sup>
							</label>
							<app-input
								id="subject"
								v-model="formData.subject"
								:error-message="$errorMessage(errors, 'subject')"
								:placeholder="$t('enter_subject')"
								type="text"
							/>
						</div>
						<div class="form-group">
							<label for="text-editor-id">
								{{ $t('message') }}<sup class="text-size-20 top-1">*</sup>
							</label>
							<app-input
								id="text-editor-id"
								v-model="formData.message"
								:error-message="$errorMessage(errors, 'message')"
								:placeholder="$t('type_your_message')"
								type="text-editor"
							/>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="mb-4">
							<h6>{{ $t('invoice_tags') }}</h6>
							<div class="default-base-color rounded p-3">
                                <span v-for="invoiceTag in tags.invoice"
                                      class="badge badge-secondary badge-pill cursor-pointer mr-2 mb-1"
                                      @click="addTag(invoiceTag.name)">
                                    {{ invoiceTag.name }}
                                </span>
							</div>
						</div>
						<div class="mb-4">
							<h6>{{ $t('client_tags') }}</h6>
							<div class="default-base-color rounded p-3">
                                <span v-for="clientTag in tags.client"
                                      class="badge badge-secondary badge-pill cursor-pointer mr-2 mb-1"
                                      @click="addTag(clientTag.name)">
                                    {{ clientTag.name }}
                                </span>
							</div>
						</div>
						<div class="mb-4">
							<h6>{{ $t('company_tags') }}</h6>
							<div class="default-base-color rounded p-3">
                                <span v-for="companyTag in tags.company"
                                      class="badge badge-secondary badge-pill cursor-pointer mr-2 mb-1"
                                      @click="addTag(companyTag.name)">
                                    {{ companyTag.name }}
                                </span>
							</div>
						</div>
						<div class="mb-4">
							<h6>{{ $t('user_tags') }}</h6>
							<div class="default-base-color rounded p-3">
                                <span v-for="userTag in tags.users"
                                      class="badge badge-secondary badge-pill cursor-pointer mr-2 mb-1"
                                      @click="addTag(userTag.name)">
                                    {{ userTag.name }}
                                </span>
							</div>
						</div>
					</div>
				</div>
			</form>
		</template>
	</modal>
</template>

<script>
import {SubmitFormMixins} from "../../../Mixins/billar/SubmitFormMixins";
import {INVOICES_SEND} from "../../../Config/BillarApiUrl";

export default {
	name: 'SendInvoiceModal',
	mixins: [SubmitFormMixins],
	props: {
		invoiceInformation: {},
		email: {}
	},
	data() {
		return {
			INVOICES_SEND,
			modalId: 'send-invoice-modal',
			formData: {
				email: this.email,
			},
			tags: {
				invoice: [
					{id: 1, name: '{invoice_number}'},
					{id: 2, name: '{invoice_amount}'},
					{id: 3, name: '{invoice_logo}'},
				],
				client: [
					{id: 1, name: '{client_name}'},
					{id: 2, name: '{client_email}'},
					// {id: 3, name: '{client_number}'},
				],
				company: [
					{id: 1, name: '{company_name}'},
					// {id: 2, name: 'company_email'},
					// {id: 3, name: 'company_website'},
					// {id: 4, name: 'contact_person'},
				],
				users: [
					// {id: 1, name: '{username}'},
					// {id: 1, name: '{password}'},
					{id: 1, name: '{login_link}'}
				]
			}
		}
	},
	methods: {
		submit() {
			let formData = this.formData;
			this.save(formData);
		},
		afterSuccess(response) {
			this.$toastr.s(response.data.message);
			this.$emit('closeModal')
		},
		afterError(response) {
			this.errors = response.data.errors;
			this.$toastr.e(response.data.message);
		},
		addTag(tag_name = '{name}') {
			$("#text-editor-id").summernote('editor.saveRange');
			$("#text-editor-id").summernote('editor.restoreRange');
			$("#text-editor-id").summernote('editor.focus');
			$("#text-editor-id").summernote('editor.insertText', tag_name);
		},
	}
}
</script>