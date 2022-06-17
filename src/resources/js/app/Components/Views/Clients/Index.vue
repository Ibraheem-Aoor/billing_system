<template>
    <div class="content-wrapper">
        <div class="d-flex align-items-center justify-content-between">
            <app-breadcrumb :page-title="$t('clients')"/>
            <button type="button" v-if="$can('create_clients')"
                    class="btn btn-success btn-with-shadow mb-4"
                    @click="openModal">
                <app-icon name="plus" class="size-20 mr-2"/>
                {{ $t('add_client') }}
            </button>
        </div>

        <app-table :id="tableId" :options="options" @action="getListAction"/>

        <!-- Client Add/Edit Modal -->
        <client-add-edit-modal
            v-if="isModalActive"
            :table-id="tableId"
            :country-list="countryList"
            :selected-url="selectUrl"
            @closeModal="closeModal"
        />

        <!-- Client Delete Modal -->
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
import ClientsTableMixin from '../../../Mixins/ClientsTableMixin';

export default {
    name: 'Index',
    mixins: [ClientsTableMixin]
}
</script>