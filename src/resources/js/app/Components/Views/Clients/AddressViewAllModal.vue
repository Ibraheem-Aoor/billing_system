<template>
    <app-modal modal-alignment="top" modal-id="address-view-all-modal" modal-size="default" @close-modal="closeModal">
        <template slot="header">
            <h5 class="modal-title">{{ $t('view_all_address') }}</h5>
            <button aria-label="Close" class="close outline-none" data-dismiss="modal" type="button">
                <span>
                    <app-icon :name="'x'"></app-icon>
                </span>
            </button>
        </template>
        <template slot="body">
            <div v-for="(item, index) in rowData">
                <div class="d-flex align-items-center">
                    <span style="font-size: 14px !important;" class="mb-1 badge badge-round badge-light">{{ item.address }}</span>
                </div>
            </div>
        </template>
        <template slot="footer">
            <button
                class="btn btn-secondary mr-2"
                data-dismiss="modal"
                type="button"
                @click.prevent="closeModal">
                {{ $t('close') }}
            </button>
        </template>
    </app-modal>
</template>

<script>
export default {
    name: "AddressViewAllModal",
    props: ['rowData'],
    data(){
        return{

        }
    },
    methods:{
        closeModal(value) {
            this.$emit('close-modal', value);
        },
    }
}
</script>