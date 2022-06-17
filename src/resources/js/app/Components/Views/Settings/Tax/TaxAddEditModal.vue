<template>
    <modal :modal-id="modalId"
           :title="selectedUrl ? $t('edit_tax') : $t('add_tax')"
           :preloader="preloader"
           @submit="submit"
           @closeModal="closeModal">
        <template slot="body">
            <app-overlay-loader v-if="preloader"/>

            <form ref="form"
                  :data-url="selectedUrl ? selectedUrl : 'taxes'"
                  class="mb-0"
                  :class="{'loading-opacity': preloader}">
                <div class="form-group">
                    <label>{{ $t('tax_name') }}</label>
                    <app-input
                        type="text"
                        v-model="formData.name"
                        :placeholder="$t('name')"
                        :error-message="$errorMessage(errors, 'name')"
                    />
                </div>
                <div class="form-group">
                    <label>{{ $t('tax_value') }} (%)</label>
                    <app-input
                        type="number"
                        v-model="formData.value"
                        :placeholder="$t('value')"
                        :error-message="$errorMessage(errors, 'value')"
                    />
                </div>
                <div class="form-group">
                    <label>
                        {{ $t("is_default") }}</label>
                    <app-input
                        v-model="formData.is_default"
                        :list="[{id:1, value: 'Yes'}, {id:0, value: 'No'}]"
                        type="radio"
                        :error-message="$errorMessage(errors, 'is_default')"/>
                </div>
            </form>
        </template>
    </modal>
</template>

<script>
    import {SubmitFormMixins} from "../../../../Mixins/billar/SubmitFormMixins";

    export default {
        name: 'TaxAddEditModal',
        mixins: [SubmitFormMixins],
        data() {
            return {
                modalId: 'tax-add-edit-modal',
                formData: {}
            }
        },
        methods: {
            submit() {
                this.save(this.formData);
            },
            afterSuccessFromGetEditData(response) {
                this.formData = response.data;
            },
        }
    }
</script>
