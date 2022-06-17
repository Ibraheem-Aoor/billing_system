<template>
    <div class="content-wrapper" v-if="dataLoaded">
        <app-breadcrumb :page-title="$t('dashboard')"/>

        <div class="row">
            <div class="col-md-6 col-xl-3 mb-primary" v-if="$can('show_all_data')">
                <div class="primary-card-color shadow rounded d-flex align-items-center p-4">
                    <div
                        class="width-58 height-58 text-white bg-brand-color rounded d-inline-flex flex-shrink-0 align-items-center justify-content-center">
                        <app-icon name="users" class="size-24 text-white"/>
                    </div>
                    <div class="ml-2">
                        <h6 class="mb-0">{{ formData.totalClient }}</h6>
                        <p class="text-muted mb-0">{{ $t('clients') }}</p>
                    </div>
                </div>
            </div>
            <template v-if="$can('dashboard_card')">
                <div class="col-md-6 col-xl-3 mb-primary">
                    <div class="primary-card-color shadow rounded d-flex align-items-center p-4">
                        <div
                            class="width-58 height-58 text-white bg-brand-color rounded d-inline-flex flex-shrink-0 align-items-center justify-content-center">
                            <app-icon name="file-text" class="size-24 text-white"/>
                        </div>
                        <div class="ml-2">
                            <h6 class="mb-0">{{ formData.totalInvoice }}</h6>
                            <p class="text-muted mb-0">{{ $t('invoices') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3 mb-primary">
                    <div class="primary-card-color shadow rounded d-flex align-items-center p-4">
                        <div
                            class="width-58 height-58 text-white bg-brand-color rounded d-inline-flex flex-shrink-0 align-items-center justify-content-center">
                            <app-icon name="credit-card" class="size-24 text-white"/>
                        </div>
                        <div class="ml-2">
                            <h6 class="mb-0">{{ formData.totalPayment }}</h6>
                            <p class="text-muted mb-0">{{ $t('payments') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3 mb-primary" v-if="$can('show_all_data')">
                    <div class="primary-card-color shadow rounded d-flex align-items-center p-4">
                        <div
                            class="width-58 height-58 text-white bg-brand-color rounded d-inline-flex flex-shrink-0 align-items-center justify-content-center">
                            <app-icon name="box" class="size-24 text-white"/>
                        </div>
                        <div class="ml-2">
                            <h6 class="mb-0">{{ formData.totalProduct }}</h6>
                            <p class="text-muted mb-0">{{ $t('products') }}</p>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="row" v-if="$can('dashboard_card')">
            <div class="col-md-6 col-xl-3 mb-primary">
                <div class="text-white bg-success shadow rounded d-flex align-items-center p-4">
                    <div class="flex-shrink-0">
                        <app-icon name="check-circle" class="size-42"/>
                    </div>
                    <div class="ml-3">
                        <h5 class="mb-0">{{ formData.totalPaidInvoice }}</h5>
                        <p class="mb-0">{{ $t('paid_invoices') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-primary">
                <div class="text-white bg-warning shadow rounded d-flex align-items-center p-4">
                    <div class="flex-shrink-0">
                        <app-icon name="alert-triangle" class="size-42"/>
                    </div>
                    <div class="ml-3">
                        <h5 class="mb-0">{{ formData.unpaidInvoices }}</h5>
                        <p class="mb-0">{{ $t('unpaid_invoices') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-primary">
                <div class="text-white bg-brand-color shadow rounded d-flex align-items-center p-4">
                    <div class="flex-shrink-0">
                        <app-icon name="credit-card" class="size-42"/>
                    </div>
                    <div class="ml-3">
                        <h5 class="mb-0">{{ formData.partiallyPaidInvoices }}</h5>
                        <p class="mb-0">{{ $t('partially_paid') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-primary">
                <div class="text-white bg-danger shadow rounded d-flex align-items-center p-4">
                    <div class="flex-shrink-0">
                        <app-icon name="file-minus" class="size-42"/>
                    </div>
                    <div class="ml-3">
                        <h5 class="mb-0">{{ formData.overdueInvoices }}</h5>
                        <p class="mb-0">{{ $t('overdue_invoices') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-9 mb-primary" v-if="$can('yearly_overview')">
                <div class="card card-with-shadow border-0 h-100">
                    <div class="bg-transparent card-header d-flex align-items-center justify-content-between p-primary">
                        <h5 class="mb-0">{{ $t('yearly_income_overview') }}</h5>
                        <!--                        <div class="d-flex">-->
                        <!--                            <div class="d-flex align-items-center mr-4">-->
                        <!--                                <span class="bg-brand-color width-18 height-18 rounded d-inline-block mr-2"/> {{ $t('income') }}-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                    </div>
                    <app-overlay-loader v-if="yearlyLoaded"/>
                    <div class="card-body" v-else>
                        <app-chart
                            type="custom-line-chart"
                            :height="250"
                            :labels="yearlyOverviewChart.labels"
                            :data-sets="yearlyOverviewChart.dataSet"
                        />
                    </div>
                </div>
            </div>
            <div class="col-xl-3 mb-primary" v-if="$can('payment_overview')">
                <div class="card card-with-shadow border-0 h-100">
                    <div class="bg-transparent card-header p-primary">
                        <h5 class="mb-0">{{ $t('payment_overview') }}</h5>
                    </div>
                    <app-overlay-loader v-if="loaded"/>
                    <div class="card-body" v-else>
                        <app-chart
                            class="mb-primary"
                            type="pie-chart"
                            :height="200"
                            :labels="paymentOverviewChart.labels"
                            :data-sets="paymentOverviewChart.dataSet"
                        />
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <span class="width-18 height-18 rounded d-inline-block mr-2"
                                      style="background: rgb(70, 195, 95);"/>
                                {{ $t('received_amount') }} ({{ receivedAmount }})
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="width-18 height-18 rounded d-inline-block mr-2"
                                      style="background: rgb(252, 44, 16);"/> {{ $t('due_amount') }}
                                ({{ dueAmount }})
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <app-overlay-loader v-else/>
</template>

<script>

import {FormMixin} from "../../../../core/mixins/form/FormMixin";
import {numberWithCurrencySymbol} from "../../../Helpers/Helpers";

export default {
    name: 'Index',
    mixins: [FormMixin],
    data() {
        return {
            formData: {},
            dataLoaded: false,
            loaded: false,
            yearlyLoaded: false,
            paymentOverview: {},
            yearlyOverviewChart: {
                labels: [],
                dataSet: [
                    {
                        backgroundColor: 'rgb(70, 195, 95)',
                        borderColor: 'rgb(70, 195, 95)',
                        data: [10, 30, 50],
                        fill: false,
                    },
                ]
            },
            paymentOverviewChart: {
                labels: [this.$t('received_amount'), this.$t('due_amount')],
                dataSet: [{
                    borderWidth: 0,
                    data: [],
                    backgroundColor: [
                        'rgb(70, 195, 95)',
                        'rgb(252, 44, 16)',
                    ]
                }]
            }
        }
    },
    computed: {
        receivedAmount() {
            return numberWithCurrencySymbol(this.paymentOverviewChart.dataSet[0].data[0])
        },
        dueAmount() {
            return numberWithCurrencySymbol(this.paymentOverviewChart.dataSet[0].data[1])
        }
    },
    methods: {
        getDashboardCardData() {
            this.axiosGet('dashboard-card').then((response) => {
                this.formData = response.data;
            }).catch(({error}) => {
            }).finally(() => {
                this.dataLoaded = true
            });
        },
        getPaymentOverview() {
            this.loaded = true;
            this.axiosGet('payment-overview').then(({data}) => {
                this.paymentOverviewChart.labels = Object.keys(data.payment_overview)
                this.paymentOverviewChart.dataSet[0].data = Object.values(data.payment_overview)
            }).catch(({error}) => {
            }).finally(() => {
                this.loaded = false
            });
        },
        getYearlyOverview() {
            this.yearlyLoaded = true;
            this.axiosGet('yearly-overview').then(({data}) => {
                this.yearlyOverviewChart.labels = Object.keys(data).map(item => item)
                this.yearlyOverviewChart.dataSet[0].data = Object.values(data).map(item => item.income || 0);
            }).catch(({error}) => {
            }).finally(() => {
                this.yearlyLoaded = false
            });
        }
    },
    created() {
        this.getDashboardCardData();
        if (this.$can('payment_overview')) {
            this.getPaymentOverview();
        }
        if (this.$can('yearly_overview')) {
            this.getYearlyOverview();
        }


    }
}
</script>