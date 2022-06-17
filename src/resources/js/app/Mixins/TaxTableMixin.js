import * as actions from '../Config/ApiUrl';
import {CATEGORY_LIST, TAX_LIST} from "../Config/BillarApiUrl";

export default {
    props: ['id', 'props'],
    data() {
        return {
            tableId: 'tax-table',
            rowData: {},
            options: {
                url: TAX_LIST,
                name: this.$t('tax_table'),
                filters: [],
                columns: [
                    {
                        title: this.$t('name'),
                        type: 'text',
                        key: 'name',
                    },
                    {
                        title: this.$t('value'),
                        type: 'custom-html',
                        key: 'value',
                        modifier: (value) => {
                            if (value) {
                                return value + '%';
                            }
                        }
                    },
                    {
                        title: this.$t('default'),
                        type: 'custom-html',
                        key: 'is_default',
                        modifier: (value) => {
                            return value == 0 ? 'No' : 'Yes'
                        }
                    },
                    {
                        title: this.$t('actions'),
                        type: 'action'
                    }
                ],
                actions: [
                    {
                        title: this.$t('edit'),
                        type: 'edit',
                        modifier: () => this.$can("update_taxes"),
                    },
                    {
                        title: this.$t('delete'),
                        type: 'delete',
                        modifier: () => this.$can("delete_taxes"),
                    }
                ],
                rowLimit: 10,
                orderBy: 'desc',
                responsive: true,
                showHeader: true,
                showFilter: true,
                showSearch: true,
                showAction: true,
                tableShadow: false,
                actionType: 'dropdown',
                datatableWrapper: true,
                paginationType: 'pagination'
            },
            isTaxAddEditModalActive: false,
            isTaxDeleteModalActive: false,
        }
    },
    methods: {
        getListAction(rowData, actionObj) {
            this.selectUrl = `${TAX_LIST}/${rowData.id}`;
            if (actionObj.type === 'edit') {
                this.openTaxAddEditModal();
            } else if (actionObj.type === 'delete') {
                this.confirmationModalActive = true;
            }
        },
        addTax() {
            this.$hub.$on(`headerButtonClicked-${this.id}`, () => {
                this.openTaxAddEditModal();
            })
        },
        openTaxAddEditModal() {
            this.isTaxAddEditModalActive = true;
        },
        closeTaxAddEditModal() {
            this.isTaxAddEditModalActive = false;
            $("#tax-add-edit-modal").modal("hide");
        },
    },
    mounted() {
        this.addTax();
    }
}