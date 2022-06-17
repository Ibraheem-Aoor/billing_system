import {INVOICE_REPORT} from "../Config/ApiUrl";
import {formatDateToLocal, numberWithCurrencySymbol} from "../Helpers/Helpers";

export default {
    data() {
        return {
            formatDateToLocal,
            tableId: 'invoice-report-table',
            selectedUrl: '',
            rowData: {},
            options: {
                url: INVOICE_REPORT,
                name: this.$t('invoice_report_table'),
                filters: [
                    {
                        'title': this.$t('date'),
                        'type': 'range-picker',
                        'key': 'date',
                        'option': ['today', 'thisMonth', 'last7Days', 'nextYear']
                    },
                    {
                        title: this.$t("status"),
                        type: "checkbox",
                        key: "status",
                        option: [],
                        permission: this.$can('show_all_data') ? true : false
                    },
                    {
                        'title': this.$t('clients'),
                        'type': 'drop-down-filter',
                        'key': 'clients',
                        'option': [],
                        permission: this.$can('show_all_data') ? true : false
                    }
                ],
                columns: [
                    {
                        title: this.$t('status'),
                        type: 'custom-html',
                        key: 'status',
                        modifier: (value) => {
                            return `<span class="badge badge-${value.class} badge-pill mr-2">${value.translated_name}</span>`
                        }
                    },
                    {
                        title: this.$t('invoice_number'),
                        type: 'text',
                        key: 'invoice_number',
                    },
                    {
                        title: this.$t('date'),
                        type: 'custom-html',
                        key: 'date',
                        modifier: (value) => {
                            return value ? formatDateToLocal(value) : '-'
                        }
                    },
                    {
                        title: this.$t('client'),
                        type: 'object',
                        key: 'client',
                        modifier: (value) => {
                            return value ? value.full_name : '-'
                        }
                    },
                    {
                        title: this.$t('amount'),
                        type: 'object',
                        key: 'total',
                        modifier: (total => numberWithCurrencySymbol(total))
                    },
                    {
                        title: this.$t('paid'),
                        type: 'object',
                        key: 'received_amount',
                        modifier: (received_amount => numberWithCurrencySymbol(received_amount))
                    },
                    {
                        title: this.$t('amount_due'),
                        type: 'object',
                        key: 'due_amount',
                        modifier: (due_amount => numberWithCurrencySymbol(due_amount))
                    }
                ],
                actions: [],
                rowLimit: 10,
                orderBy: 'desc',
                responsive: true,
                showHeader: true,
                showFilter: true,
                showSearch: true,
                showAction: false,
                tableShadow: true,
                actionType: 'dropdown',
                datatableWrapper: true,
                paginationType: 'pagination'
            },
            isCategoryAddEditModalActive: false,
            isCategoryDeleteModalActive: false,
        }
    },
    methods: {}
}