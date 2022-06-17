<template>
    <div class="content-wrapper">
        <app-breadcrumb :page-title="$t('expense_report')"/>

        <app-table :id="tableId" :options="options"/>
    </div>
</template>

<script>
    import ExpenseReportMixin from '../../../Mixins/ExpenseReportMixin';

    export default {
        name: 'ExpenseReport',
        mixins: [ExpenseReportMixin]
    }
</script>