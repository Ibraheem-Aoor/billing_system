<template>
    <div class="content-wrapper">
        <app-breadcrumb :page-title="$t('payments_summary')"/>

        <app-table :id="tableId" :options="options"/>
    </div>
</template>

<script>
    import PaymentSummaryMixin from '../../../Mixins/PaymentSummaryMixin';
    import {clientUser, paymentMethods} from "../../../Mixins/FilterMixin";

    export default {
        name: 'PaymentSummaryReport',
        mixins: [PaymentSummaryMixin, clientUser, paymentMethods]
    }
</script>