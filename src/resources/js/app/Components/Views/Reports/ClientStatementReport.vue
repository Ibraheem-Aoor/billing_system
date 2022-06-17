<template>
    <div class="content-wrapper">
        <app-breadcrumb :page-title="$t('client_statement')"/>

        <app-table :id="tableId" :options="options"/>
    </div>
</template>

<script>
    import ClientStatementMixin from '../../../Mixins/ClientStatementMixin';
    import {clientUser} from "../../../Mixins/FilterMixin";

    export default {
        name: 'ClientStatementReport',
        mixins: [ClientStatementMixin, clientUser]
    }
</script>