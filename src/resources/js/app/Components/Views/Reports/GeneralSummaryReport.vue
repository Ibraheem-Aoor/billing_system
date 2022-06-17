<template>
    <div class="content-wrapper">
        <app-breadcrumb :page-title="$t('general_summary')"/>

        <div class="row">
            <div class="col-xl-9 mb-primary">
                <div class="card card-with-shadow border-0 h-100">
                    <div class="bg-transparent card-header d-flex align-items-center justify-content-between p-primary">
                        <h5 class="mb-0">{{ $t('yearly_overview') }}</h5>
                        <div class="d-flex">
                            <div class="d-flex align-items-center mr-4">
                                <span class="bg-brand-color width-18 height-18 rounded d-inline-block mr-2"/> {{ $t('income') }}
                            </div>
                        </div>
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
            <div class="col-xl-3 mb-primary">
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
                                      style="background: rgb(252, 44, 16);"/> {{ $t('received_amount') }}
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="width-18 height-18 rounded d-inline-block mr-2"
                                      style="background: rgb(70, 195, 95);"/> {{ $t('outstanding_amount') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {FormMixin} from "../../../../core/mixins/form/FormMixin";

export default {
    name: 'GeneralSummaryReport',
    mixins: [FormMixin],
    data() {
        return {
            loaded: false,
            yearlyLoaded: false,
            yearlyOverviewChart: {
                labels: [],
                dataSet: [
                    {
                        backgroundColor: 'rgb(70, 195, 95)',
                        borderColor: 'rgb(70, 195, 95)',
                        data: [],
                        fill: false,
                    },
                    // {
                    //     fill: false,
                    //     backgroundColor: 'rgb(252, 101, 16)',
                    //     borderColor: 'rgb(252, 101, 16)',
                    //     data: [10, 120, 30, 190, 5, 240, 50, 30, 70, 50, 90, 120],
                    // }
                ]
            },
            paymentOverviewChart: {
                labels: [],
                dataSet: [{
                    borderWidth: 0,
                    data: [],
                    backgroundColor: [
                        'rgb(252, 44, 16)',
                        'rgb(70, 195, 95)'
                    ]
                }]
            }
        }
    },
    methods: {

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
        this.getPaymentOverview();
        this.getYearlyOverview();
    }
}
</script>