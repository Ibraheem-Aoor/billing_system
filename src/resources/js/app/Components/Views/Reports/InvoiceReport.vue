<template>
    <div class="content-wrapper">
        <app-breadcrumb :page-title="$t('invoice_report')"/>

        <app-table :id="tableId" :options="options"/>
    </div>
</template>

<script>
import InvoiceReportMixin from '../../../Mixins/InvoiceReportMixin';
import {clientUser, status} from "../../../Mixins/FilterMixin";

export default {
    name: 'InvoiceReport',
    mixins: [InvoiceReportMixin, clientUser, status]
}
</script>