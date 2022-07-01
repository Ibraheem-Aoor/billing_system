import AppFunction from "../../core/helpers/app/AppFunction";
import {CLIENT_LIST} from "../Config/BillarApiUrl";
import {FormMixin} from "../../core/mixins/form/FormMixin";
import {DeleteMixins, ModalMixins} from "./billar/DeleteMixins";
import {countries} from "./billar/FilterMixins";
import {mapGetters} from "vuex";
import * as actions from '../Config/ApiUrl';

export default {
    mixins: [FormMixin, DeleteMixins, ModalMixins, countries],
    data() {
        return {
            tableId: 'clients-table',
            rowData: {},
            options: {
                url: CLIENT_LIST,
                name: this.$t('clients_table'),
                filters: [
                    {
                        'title': this.$t('created'),
                        'type': 'range-picker',
                        'key': 'date',
                        'option': ['today', 'thisMonth', 'last7Days', 'nextYear']
                    },
                    {
                        title: this.$t('country'),
                        type: 'drop-down-filter',
                        key: 'countries',
                        option: [],
                    }
                ],
                columns: [
                    {
                        title: this.$t('name'),
                        type: 'component',
                        key: 'name',
                        componentName: 'app-table-media',
                    },
                    {
                        title: this.$t('client_number'),
                        type: 'text',
                        key: 'client_number',
                    },
                    {
                        title: this.$t('email'),
                        type: 'object',
                        key: 'user',
                        modifier: (user) => {
                            return user ? user.email : '-';
                        }
                    },
                    {
                        title: this.$t('status'),
                        type: 'custom-html',
                        key: 'user',
                        modifier: (user) => {
                            return `<span class="badge badge-${user?.status?.class} badge-pill mr-2">${user?.status?.translated_name}</span>`
                        }
                    },
                    {
                        title: this.$t('phone'),
                        type: 'object',
                        key: 'user',
                        modifier: (user => user ? user.trn?.trn : '-')
                    },
                    {
                        title: "TRN",
                        type: 'object',
                        key: 'user',
                        modifier: (user => user ? user.profile?.trn : '-')
                    },
                    {
                        title: this.$t('city'),
                        type: 'text',
                        key: 'city',
                    },
                    {
                        title: this.$t('state'),
                        type: 'text',
                        key: 'state',
                    },
                    {
                        title: this.$t('postal_code'),
                        type: 'text',
                        key: 'postal_code',
                    },
                    {
                        title: this.$t('country'),
                        type: 'object',
                        key: 'country',
                        modifier: (value) => {
                            return value ? value.name : '-';
                        }
                    },
                    {
                        title: this.$t('address'),
                        type: 'object',
                        key: 'user',
                        modifier: (user => user ? user.profile?.address : '-')
                    },
                    {
                        title: this.$t('website'),
                        type: 'text',
                        key: 'website_url',
                    },
                    {
                        title: this.$t('notes'),
                        type: 'text',
                        key: 'notes',
                    },
                    {
                        title: this.$t('actions'),
                        type: 'action'
                    }
                ],
                actions: [
                    {
                        title: this.$t('view'),
                        type: 'view',
                        modifier: () => this.$can("client_invoice_details"),
                    },
                    {
                        title: this.$t('active'),
                        type: 'active',
                        modifier: (rowData) => {

                            if (rowData.user && this.$can('show_all_data')) {
                                return rowData.user?.status?.name === 'status_active' ? false : true
                            } else {
                                return false;
                            }
                        },
                    },
                    {
                        title: this.$t('de_activate'),
                        type: 'de_activate',
                        modifier: (rowData) => {
                            if (rowData.user && this.$can('show_all_data')) {
                                return rowData.user?.status?.name === 'status_inactive' ? false : true
                            } else {
                                return false;
                            }
                        },
                    },
                    {
                        title: this.$t('edit'),
                        type: 'edit',
                        modifier: () => this.$can("update_clients"),
                    },
                    {
                        title: this.$t('delete'),
                        type: 'delete',
                        modifier: () => this.$can("delete_clients"),
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
    computed: {
        ...mapGetters(["checkEmailDelivery"]),
    },
    methods: {
        getListAction(rowData, actionObj) {
            this.selectUrl = `${CLIENT_LIST}/${rowData.id}`;
            if (actionObj.type === 'view') {
                location.replace(AppFunction.getAppUrl(`/${CLIENT_LIST}/${rowData.id}/details`));
            } else if (actionObj.type === 'active') {
                this.changeUserStatus(1, rowData.user);
            } else if (actionObj.type === 'de_activate') {
                this.changeUserStatus(2, rowData.user);
            } else if (actionObj.type === 'edit') {
                this.isModalActive = true;
            } else if (actionObj.type === 'delete') {
                this.confirmationModalActive = true;
            }
        },
        viewClientDetails() {
            location.replace(AppFunction.getAppUrl('/client-details'));
        },
        getTableMediaAction() {
            this.$hub.$on('getTableMediaAction', (data) => {
                this.viewClientDetails();
            })
        },
        openModal() {
            if (this.checkEmailDelivery != 1) {
                this.$toastr.e(this.$t('you_need_to_setup_an_email_first'));
            } else {
                this.isModalActive = true;
            }
        },
        changeUserStatus(status, userInfo) {
            let url = `${actions.USERS_LIST}/${userInfo.id}`,
                reqData = userInfo;
            reqData.status_id = status;
            this.axiosPatch({
                url: url,
                data: reqData
            }).then(res => {
                this.$toastr.s(res.data.message);
            }).catch(error => {
                let {message} = error.response.data;
                this.$toastr.e(message);
            }).finally(() => {
                this.$hub.$emit('reload-' + this.tableId);
            });
        }
    },
    mounted() {
        this.getTableMediaAction();
        this.$store.dispatch("checkEmailDelivery");
    }
}