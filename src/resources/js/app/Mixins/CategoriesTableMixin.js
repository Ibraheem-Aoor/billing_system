import {CATEGORY_LIST} from "../Config/BillarApiUrl";
import {urlGenerator} from "../Helpers/AxiosHelper";

export default {
    data() {
        return {
            urlGenerator,
            tableId: 'categories-table',
            options: {
                url: CATEGORY_LIST,
                name: this.$t('categories_table'),
                filters: [
                    {
                        'title': this.$t('created'),
                        'type': 'range-picker',
                        'key': 'date',
                        'option': ['today', 'thisMonth', 'last7Days', 'nextYear']
                    }
                ],
                columns: [
                    {
                        title: this.$t('name'),
                        type: 'text',
                        key: 'name',
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
                        modifier: () => this.$can("update_categories"),
                    },
                    {
                        title: this.$t('delete'),
                        type: 'delete',
                        modifier: () => this.$can("delete_categories"),
                    }
                ],
                rowLimit: 10,
                orderBy: 'desc',
                responsive: true,
                showHeader: true,
                showFilter: true,
                showSearch: true,
                showAction: true,
                tableShadow: true,
                actionType: 'dropdown',
                datatableWrapper: true,
                paginationType: 'pagination'
            },
        }
    },
    methods: {
        getListAction(rowData, actionObj) {
            this.selectUrl = `${CATEGORY_LIST}/${rowData.id}`;
            if (actionObj.type === 'edit') {
                this.isModalActive = true;
            } else if (actionObj.type === 'delete') {
                this.confirmationModalActive = true;
            }
        },
    }
}