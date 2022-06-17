<template>
    <div class="content-wrapper">
        <div class="d-flex align-items-center justify-content-between">
            <app-breadcrumb :page-title="$t('products')"/>
            <div class="mb-4">
                <button type="button" v-if="$can('view_categories')"
                        class="btn btn-primary btn-with-shadow"
                        @click="viewCategoryPage">
                    <app-icon name="list" class="size-20 mr-2"/>
                    {{ $t('categories') }}
                </button>
                <button type="button" v-if="$can('create_products')"
                        class="btn btn-success btn-with-shadow"
                        @click="openModal">
                    <app-icon name="plus" class="size-20 mr-2"/>
                    {{ $t('new_products') }}
                </button>
            </div>
        </div>

        <app-table :id="tableId" :options="options" @action="getListAction"/>

        <!-- Product Add/Edit Modal -->
        <product-add-edit-modal
            v-if="isModalActive"
            :table-id="tableId"
            :category-list="categoryList"
            :selected-url="selectUrl"
            @openCategoryAddEditModal="openCategoryAddEditModal"
            @closeModal="closeModal"
        />

        <!-- Category Add/Edit Modal -->
        <category-add-edit-modal
            v-if="isCategoryAddEditModalActive"
            :table-id="tableId"
            :selected-url="selectUrl"
            @closeModal="closeCategoryAddEditModal"
        />

        <!-- Product Delete Modal -->
        <app-delete-modal
            v-if="confirmationModalActive"
            modal-id="delete-confirm-modal"
            :message="$t('are_you_sure_to_delete_this_product')"
            @confirmed="confirmDelete"
            @cancelled="cancelledDelete"
        />
    </div>
</template>

<script>
import ProductsTableMixin from '../../../Mixins/ProductsTableMixin';
import {FormMixin} from '../../../../core/mixins/form/FormMixin';
import {DeleteMixins, ModalMixins} from "../../../Mixins/billar/DeleteMixins";

export default {
    name: 'Index',
    mixins: [ProductsTableMixin, FormMixin, DeleteMixins, ModalMixins]
}
</script>