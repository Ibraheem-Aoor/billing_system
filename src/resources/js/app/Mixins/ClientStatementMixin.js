import {CLIENT_STATEMENT_REPORT} from "../Config/ApiUrl";
import {formatDateToLocal, numberWithCurrencySymbol} from "../Helpers/Helpers";

export default {
	data() {
		return {
			tableId: 'client-statement-table',
			selectedUrl: '',
			rowData: {},
			options: {
				url: CLIENT_STATEMENT_REPORT,
				name: this.$t('client_statement_table'),
				filters: [
					{
						'title': this.$t('date'),
						'type': 'range-picker',
						'key': 'date',
						'option': ['today', 'thisMonth', 'last7Days', 'nextYear']
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
						title: this.$t('date'),
						type: 'custom-html',
						key: 'date',
						modifier: (value) => {
							return value ? formatDateToLocal(value) : '-'
						}
					},
					{
						title: this.$t('activity'),
						type: 'custom-html',
						key: 'received_amount',
						modifier: (value, row) => {
							return value ?
								`<span class="badge badge-success badge-pill mr-2">${this.$t('payment_received')}</span>` :
								`<span class="badge badge-danger badge-pill mr-2">${this.$t('invoice_generated')}</span>`
						}
					},
					{
						title: this.$t('invoices'),
						type: 'text',
						key: 'invoice_number',
					},
					{
						title: this.$t('client'),
						type: 'object',
						key: 'client',
						modifier: (client => client ? client.full_name : '')
					},
					{
						title: this.$t('payments'),
						type: 'custom-html',
						key: 'received_amount',
						modifier: (value => numberWithCurrencySymbol(value))
					},
					{
						title: this.$t('balance'),
						type: 'custom-html',
						key: 'due_amount',
						modifier: (value => numberWithCurrencySymbol(value))
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