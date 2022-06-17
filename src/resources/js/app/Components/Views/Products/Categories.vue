<template>
    <div class="content-wrapper">
        <div class="d-flex align-items-center justify-content-between">
            <app-breadcrumb :page-title="$t('categories')"/>
            <div class="mb-4">
                <a :href="urlGenerator('products/list/view')" v-if="$can('view_products')"
                   class="btn btn-primary btn-with-shadow">
                    <app-icon name="list" class="size-20 mr-2"/>
                    {{ $t('back_to_products') }}
                </a>
                <button type="button" v-if="$can('create_categories')"
                        class="btn btn-success btn-with-shadow"
                        @click="openModal">
                    <app-icon name="plus" class="size-20 mr-2"/>
                    {{ $t('new_category') }}
                </button>
            </div>

        </div>

        <app-table :id="tableId" :options="options" @action="getListAction"/>

        <!-- Category Add/Edit Modal -->
        <category-add-edit-modal
            v-if="isModalActive"
            :table-id="tableId"
            :selected-url="selectUrl"
            @closeModal="closeModal"
        />

        <!-- Category Delete Modal -->
        <app-delete-modal
            v-if="confirmationModalActive"
            modal-id="delete-confirm-modal"
            :message="$t('are_you_sure_to_delete_this_category')"
            @confirmed="confirmDelete"
            @cancelled="cancelledDelete"
        />
    </div>
</template>

<script>
import CategoriesTableMixin from '../../../Mixins/CategoriesTableMixin';
import {FormMixin} from '../../../../core/mixins/form/FormMixin';
import {DeleteMixins, ModalMixins} from "../../../Mixins/billar/DeleteMixins";

export default {
    name: 'Categories',
    mixins: [CategoriesTableMixin, FormMixin, DeleteMixins, ModalMixins]
}
</script>