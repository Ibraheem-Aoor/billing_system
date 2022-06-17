<template>
    <div class="content-wrapper">
        <div class="d-flex align-items-center justify-content-between">
            <app-breadcrumb :page-title="$t('purposes')"/>
            <div class="mb-4">
                <a :href="urlGenerator('expenses/list/view')" v-if="$can('view_expenses')"
                   class="btn btn-primary btn-with-shadow">
                    <app-icon name="list" class="size-20 mr-2"/>
                    {{ $t('back_to_expense') }}
                </a>
                <button type="button" v-if="$can('create_purposes')"
                        class="btn btn-success btn-with-shadow"
                        @click="openModal">
                    <app-icon name="plus" class="size-20 mr-2"/>
                    {{ $t('new_purpose') }}
                </button>
            </div>

        </div>

        <app-table  v-if="$can('view_purposes')"
                    :id="tableId"
                    :options="options"
                    @action="getListAction"/>

        <!-- Purpose Add/Edit Modal -->
        <app-purpose-add-edit-modal
            v-if="isModalActive"
            :table-id="tableId"
            :selected-url="selectUrl"
            @closeModal="closeModal"
        />

        <!-- Purpose Delete Modal -->
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
import PurposeTableMixin from "../../../Mixins/PurposeTableMixin";
import {FormMixin} from "../../../../core/mixins/form/FormMixin";
import {DeleteMixins, ModalMixins} from "../../../Mixins/billar/DeleteMixins";

export default {
    name: "Purpose.vue",
    mixins: [PurposeTableMixin, FormMixin, DeleteMixins, ModalMixins]
}
</script>

<style scoped>

</style>