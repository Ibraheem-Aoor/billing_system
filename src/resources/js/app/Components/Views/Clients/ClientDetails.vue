<template>
    <div class="content-wrapper">
        <app-breadcrumb :page-title="$t('client_details')"/>

        <div class="row">
            <div class="col-xl-4 mb-4 mb-xl-0">
                <div class="card card-with-shadow border-0 h-100">
                    <div class="card-body" v-if="dataLoaded">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <div
                                class="width-150 height-150 rounded-circle default-base-color d-inline-flex flex-shrink-0 align-items-center justify-content-center">
                                <template v-if="formData.user">
                                    <app-avatar :alt-text="formData.user.full_name"
                                                :img="formData.user.profile_picture ? formData.user.profile_picture.full_url :''"
                                                :title="formData.user.full_name"/>
                                </template>
                            </div>
                            <div class="text-center mt-3">
                                <h6>{{ formData.name }}</h6>
                                <template v-if="formData.user">
                                    <div class="text-muted d-flex align-items-center justify-content-center">
                                        <app-icon name="mail" class="size-14 mr-2"/>
                                        {{ formData.user.email }}
                                    </div>
                                    <div class="text-muted d-flex align-items-center justify-content-center"
                                         v-if="formData.user.profile">
                                        <app-icon name="phone" class="size-14 mr-2"/>
                                        {{
                                            formData.user.profile.contact ? formData.user.profile.contact : $t('not_added_yet')
                                        }}
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="table-responsive custom-scrollbar mt-primary">
                            <table class="table text-size-14 mb-0">
                                <tbody>
                                <tr>
                                    <th class="border-0 default-font-color">{{ $t('address') }}</th>
                                    <td class="border-0 text-muted">
                                        {{
                                            formData.user ? formData.user.profile ? formData.user.profile.address : $t('not_added_yet') : ''
                                        }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="border-0 default-font-color">{{ $t('city') }}</th>
                                    <td class="border-0 text-muted">{{ formData.city }}</td>
                                </tr>
                                <tr>
                                    <th class="border-0 default-font-color">{{ $t('state') }}</th>
                                    <td class="border-0 text-muted">{{ formData.state }}</td>
                                </tr>
                                <tr>
                                    <th class="border-0 default-font-color">{{ $t('postal_code') }}</th>
                                    <td class="border-0 text-muted">{{ formData.postal_code }}</td>
                                </tr>
                                <tr>
                                    <th class="border-0 default-font-color">{{ $t('country') }}</th>
                                    <td class="border-0 text-muted">{{
                                            formData.country ? formData.country.name : ''
                                        }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="border-0 default-font-color">{{ $t('website') }}</th>
                                    <td class="border-0 text-muted">{{ formData.website_url }}</td>
                                </tr>
                                <tr>
                                    <th class="border-0 default-font-color">{{ $t('notes') }}</th>
                                    <td class="border-0 text-muted">{{ formData.notes }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <app-overlay-loader v-else/>
                </div>
            </div>
            <div class="col-xl-8">
                <app-table :id="modalId" :options="options" @action="getListAction"/>
            </div>
        </div>
    </div>
</template>

<script>
import CoreLibrary from '../../../../core/helpers/CoreLibrary';
import * as actions from "../../../Config/ApiUrl";
import AppFunction from "../../../../core/helpers/app/AppFunction";
import {SubmitFormMixins} from "../../../Mixins/billar/SubmitFormMixins";

export default {
    name: 'ClientDetails',
    extends: CoreLibrary,
    mixins: [SubmitFormMixins],
    props: ['clientId'],
    data() {
        return {
            AppFunction,
            formData: {},
            dataLoaded: false,
            selectUrl: '',
            modalId: 'client-invoice-table',
            options: {
                url: '/clients-invoice/' + this.clientId,
                name: this.$t('clients_table'),
                filters: [],
                columns: [
                    {
                        title: this.$t('invoice_number'),
                        type: 'text',
                        key: 'invoice_number',
                    },
                    {
                        title: this.$t('status'),
                        type: 'custom-html',
                        key: 'status',
                        modifier: (value) => {
                            return `<span class="badge badge-${value.class} badge-pill mr-2">${value.translated_name}</span>`
                        }
                    },
                    {
                        title: this.$t('date'),
                        type: 'text',
                        key: 'date',
                    },
                    {
                        title: this.$t('due_date'),
                        type: 'text',
                        key: 'due_date',
                    },
                    {
                        title: this.$t('amount'),
                        type: 'text',
                        key: 'sub_total',
                    },
                    {
                        title: this.$t('actions'),
                        type: 'action'
                    }
                ],
                actions: [
                    {
                        title: this.$t('view'),
                        icon: 'eye',
                        type: 'view',
                        url: AppFunction.getAppUrl('/invoice-details')
                    }
                ],
                rowLimit: 10,
                orderBy: 'desc',
                responsive: true,
                showHeader: true,
                showFilter: false,
                showSearch: false,
                showAction: true,
                tableShadow: true,
                actionType: 'default',
                datatableWrapper: true,
                paginationType: 'pagination'
            },
        }
    },
    methods: {
        afterSuccessFromGetEditData(response) {
            this.formData = response.data;
            this.dataLoaded = true;
        },
        getListAction(rowData, actionObj) {
            this.selectUrl = `/invoices/${rowData.id}/details`;
            if (actionObj.type === 'view') {
                location.replace(this.selectUrl);
            }
        },
    }
}
</script>