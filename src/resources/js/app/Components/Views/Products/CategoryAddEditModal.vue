<template>
    <modal :modal-id="modalId"
           :title="selectedUrl ? $t('update_category') : $t('add_category')"
           :preloader="preloader"
           @submit="submit"
           @closeModal="closeModal">
        <template slot="body">
            <app-overlay-loader v-if="preloader"/>
            <form class="mb-0"
                  :class="{'loading-opacity': preloader}"
                  ref="form"
                  :data-url="selectedUrl ? selectedUrl : 'categories'">
                <div class="form-group">
                    <label for="name">
                        {{ $t('name') }}
                        <sup class="text-size-20 top-1">*</sup>
                    </label>
                    <app-input
                        id="name"
                        type="text"
                        :placeholder="$t('name')"
                        v-model="formData.name"
                        :error-message="$errorMessage(errors, 'name')"
                    />
                </div>
            </form>
        </template>
    </modal>
</template>

<script>

import {SubmitFormMixins} from "../../../Mixins/billar/SubmitFormMixins";

export default {
    name: 'CategoryAddEditModal',
    mixins: [SubmitFormMixins],
    data() {
        return {
            modalId: 'category-add-edit-modal',
            formData: {},
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