<template>
	<modal :modal-id="modalId"
	       :preloader="preloader"
	       :title="selectedUrl ? $t('update_purpose') : $t('add_purpose')"
	       @closeModal="closeModal"
	       @submit="submit">
		<template slot="body">
			<app-overlay-loader v-if="preloader"/>
			<form ref="form"
			      :class="{'loading-opacity': preloader}"
			      :data-url="selectedUrl ? selectedUrl : 'purposes'"
			      class="mb-0">
				<div class="form-group">
					<label for="name">
						{{ $t('name') }}
						<sup class="text-size-20 top-1">*</sup>
					</label>
					<app-input
						id="name"
						v-model="formData.name"
						:error-message="$errorMessage(errors, 'name')"
						:placeholder="$t('name')"
						type="text"
					/>
				</div>
				<div class="form-group">
					<label for="description">{{ $t('description') }}</label>
					<app-input
						id="description"
						v-model="formData.description"
						:placeholder="$t('enter_description')"
						:text-area-rows="3"
						type="textarea"
					/>
				</div>
			
			</form>
		</template>
	</modal>
</template>

<script>

import {SubmitFormMixins} from "../../../Mixins/billar/SubmitFormMixins";

export default {
	name: 'PurposeAddEditModal',
	mixins: [SubmitFormMixins],
	data() {
		return {
			modalId: 'purpose-add-edit-modal',
			formData: {
				type: 'expense'
			},
		}
	},
	methods: {
		submit() {
			this.save(this.formData);
		},
		afterSuccessFromGetEditData(response) {
			this.formData = response.data;
		},
	},
	
}
</script>