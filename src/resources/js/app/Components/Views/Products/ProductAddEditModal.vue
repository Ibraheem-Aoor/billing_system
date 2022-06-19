<template>
    <modal :modal-id="modalId"
           :title="selectedUrl ? $t('edit_product') : $t('add_product')"
           :preloader="preloader"
           @submit="submit"
           @closeModal="closeModal">
        <template slot="body">
            <app-overlay-loader v-if="preloader"/>
            <form class="mb-0"
                  :class="{'loading-opacity': preloader}"
                  ref="form">
                <!-- <div class="form-group d-flex flex-column align-items-center">
                    <app-input
                        id="image"
                        :label="$t('choose_image')"
                        type="custom-file-upload"
                        :placeholder="''"
                        v-model="image"
                        @change="changeImage"
                        :error-message="$errorMessage(errors, 'image')"
                    />
                    <label for="image">
                        {{ $t('product_image') }}
                        <small class="text-muted">
                            ({{ $t('recommended_product_size') }})
                        </small>
                    </label>
                </div> -->
                <div class="form-group">
                    <label for="name">
                        {{ $t('name') }}<sup class="text-size-20 top-1">*</sup>
                    </label>
                    <app-input
                        id="name"
                        type="text"
                        :placeholder="$t('name')"
                        v-model="formData.name"
                        :error-message="$errorMessage(errors, 'name')"
                    />
                </div>
                <div class="form-group">
                    <label for="code">{{ $t('code') }}<sup class="text-size-20 top-1">*</sup></label>
                    <app-input
                        id="code"
                        type="text"
                        :placeholder="$t('code')"
                        v-model="formData.code"
                        :error-message="$errorMessage(errors, 'code')"
                    />
                </div>
                <div class="form-group">
                    <label for="category">
                        {{ $t('category') }}
                    </label>
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <app-input
                                class="mr-1"
                                id="category"
                                type="search-select"
                                :placeholder="$t('choose_a_category')"
                                v-model="formData.category_id"
                                list-value-field="value"
                                :list="categoryList"
                            />
                        </div>
                        <button type="button"
                                data-toggle="tooltip"
                                :title="$t('add_category')"
                                class="btn btn-primary"
                                @click="openCategoryAddEditModal">
                            <app-icon name="plus"/>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="unitPrice">
                        {{ $t('unit_price') }}<sup class="text-size-20 top-1">*</sup>
                    </label>
                    <app-input
                        id="unitPrice"
                        type="text"
                        :placeholder="$t('unit_price')"
                        v-model="formData.unit_price"
                        :error-message="$errorMessage(errors, 'unit_price')"
                    />
                </div>
                <div class="form-group">
                    <label for="description">
                        {{ $t('description') }}
                    </label>
                    <app-input
                        v-if="editorShow"
                        id="description"
                        type="text-editor"
                        :placeholder="$t('description')"
                        v-model="formData.description"
                    />
                </div>
            </form>
        </template>
    </modal>
</template>

<script>

import {formDataAssigner} from "../../../Helpers/Helpers";
import {SubmitFormMixins} from "../../../Mixins/billar/SubmitFormMixins";

export default {
    name: 'ProductAddEditModal',
    mixins: [SubmitFormMixins],
    props: {
        categoryList: {}
    },
    data() {
        return {
            modalId: 'product-add-edit-modal',
            formData: {category_id: ''},
            image: '',
            url: '',
            editorShow: false,
            isImageChange: false,
        }
    },
    methods: {
        changeImage() {
            this.isImageChange = true;
        },
        submit() {
            let formData = formDataAssigner(new FormData, this.formData);
            if (this.selectedUrl && !this.isImageChange) {
                this.image = ''
            }
            if (this.image) {
                formData.append('image', this.image);
            }
            if (this.selectedUrl) {
                formData.append('_method', 'patch');
                this.submitFromFixin('post', this.selectedUrl, formData)
            } else {
                this.submitFromFixin('post', 'products', formData)
            }

        },
        afterSuccessFromGetEditData(response) {
            this.formData = response.data;
            this.image = this.formData.file ? this.formData.file?.path : '';
            this.formData.category_id = this.formData.category ? this.formData.category_id : '';
            $("#note").summernote({
                callbacks: {
                    onChange: function () {
                        let code = $(this).summernote("code");
                        if (this.formData.description) {
                            this.formData.description = code;
                        }
                    },
                },
            });

            this.editorShow = false;
            setTimeout(() => {
                this.editorShow = true;
            });
        },
        openCategoryAddEditModal() {
            this.$emit('openCategoryAddEditModal');
        }
    },
    mounted() {
        if (!this.selectedUrl) {
            this.editorShow = true;
        }
        this.initializeTooltip();
    }
}
</script>