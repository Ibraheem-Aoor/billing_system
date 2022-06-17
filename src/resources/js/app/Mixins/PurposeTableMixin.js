import {urlGenerator} from "../Helpers/AxiosHelper";
import {PURPOSE_LIST} from "../Config/BillarApiUrl";

export default {
    data() {
        return {
            urlGenerator,
            tableId: 'purpose-table',
            options: {
                url: PURPOSE_LIST,
                name: this.$t('purpose_table'),
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
                        title: this.$t('type'),
                        type: 'text',
                        key: 'type',
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
                        modifier: () => this.$can("update_purposes"),
                    },
                    {
                        title: this.$t('delete'),
                        type: 'delete',
                        modifier: () => this.$can("delete_purposes"),
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
            this.selectUrl = `${PURPOSE_LIST}/${rowData.id}`;
            if (actionObj.type === 'edit') {
                this.isModalActive = true;
            } else if (actionObj.type === 'delete') {
                this.confirmationModalActive = true;
            }
        },
    }
}