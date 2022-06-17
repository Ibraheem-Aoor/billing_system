import * as actions from '../Config/ApiUrl';

export default {
    data() {
        return {
            tableId: 'expense-report-table',
            selectedUrl: '',
            rowData: {},
            options: {
                url: actions.DATATABLE_DATA,
                name: this.$t('expense_report_table'),
                filters: [
                    {
                        'title': this.$t('date'),
                        'type': 'range-picker',
                        'key': 'date',
                        'option': ['today', 'thisMonth', 'last7Days', 'nextYear']
                    },
                    {
                        'title': this.$t('category'),
                        'type': 'drop-down-filter',
                        'key': 'search select',
                        'option': [
                            {id: 1, name: 'Grocery'},
                            {id: 2, name: 'Fruits'},
                            {id: 3, name: 'Stationery'},
                            {id: 4, name: 'Fuel'},
                            {id: 5, name: 'Machinery'}
                        ],
                        'listValueField': 'name',
                    }
                ],
                columns: [
                    {
                        title: this.$t('name'),
                        type: 'custom-html',
                        key: 'name',
                        modifier: (value) => {
                            if (value) {
                                return '-'
                            }
                        }
                    },
                    {
                        title: this.$t('date'),
                        type: 'custom-html',
                        key: 'name',
                        modifier: (value) => {
                            if (value) {
                                return '-'
                            }
                        }
                    },
                    {
                        title: this.$t('category'),
                        type: 'custom-html',
                        key: 'name',
                        modifier: (value) => {
                            if (value) {
                                return '-'
                            }
                        }
                    },
                    {
                        title: this.$t('amount'),
                        type: 'custom-html',
                        key: 'name',
                        modifier: (value) => {
                            if (value) {
                                return '-'
                            }
                        }
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
    methods: {

    }
}