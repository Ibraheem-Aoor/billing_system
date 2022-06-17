import {EXPENSE_LIST} from "../Config/BillarApiUrl";
import {FormMixin} from "../../core/mixins/form/FormMixin";
import {DeleteMixins, ModalMixins} from "./billar/DeleteMixins";
import * as actions from '../Config/ApiUrl';
import {numberWithCurrencySymbol} from "../Helpers/Helpers";
import {urlGenerator} from "../Helpers/AxiosHelper"
import {Purpose} from "./FilterMixin";

export default {
    mixins: [FormMixin, Purpose, DeleteMixins, ModalMixins],
    data() {
        return {
            tableId: 'expense-table',
            rowData: {},
            expenseSummery: {},
            preloader: false,
            isPurposeModalActive: false,
            numberWithCurrencySymbol,
            options: {
                url: EXPENSE_LIST,
                name: this.$t('expenses'),
                filters: [
                    {
                        'title': this.$t('created'),
                        'type': 'range-picker',
                        'key': 'date',
                        'option': ['today', 'thisMonth', 'last7Days', 'nextYear']
                    },
                    {
                        title: this.$t('purpose'),
                        type: 'drop-down-filter',
                        key: 'expense_purpose',
                        option: [],
                    }
                ],
                columns: [
                    {
                        title: this.$t('name'),
                        type: 'text',
                        key: 'name',
                    },
                    {
                        title: this.$t('purpose'),
                        type: 'object',
                        key: 'purpose',
                        modifier: (purpose) => purpose ? purpose.name : '-'
                    },
                    {
                        title: this.$t('reference'),
                        type: 'text',
                        key: 'reference',
                    },
                    {
                        title: this.$t('amount'),
                        type: 'object',
                        key: 'amount',
                        modifier: (amount) => numberWithCurrencySymbol(amount)
                    },
                    // {
                    //     title: this.$t('note'),
                    //     type: 'text',
                    //     key: 'note',
                    // },
                    {
                        title: this.$t('attachment'),
                        type: 'custom-html',
                        key: 'attachment',
                        modifier: (file) => {
                            return file ? `<a href="${urlGenerator(file.path)}" target="_blank">
                                                <i data-feather="external-link"/>
                                           </a>` : '-';
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
                        modifier: () => this.$can("update_expenses"),
                    },
                    {
                        title: this.$t('delete'),
                        type: 'delete',
                        modifier: () => this.$can("delete_expenses"),
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
    methods:{
        getListAction(rowData, actionObj) {
            this.selectUrl = `${EXPENSE_LIST}/${rowData.id}`;
            if (actionObj.type === 'edit') {
                this.isModalActive = true;
            } else if (actionObj.type === 'delete') {
                this.confirmationModalActive = true;
            }
        },
    }
}