<template>
    <div class="d-flex align-items-center">
        <div class="avatars-w-50">
            <app-avatar
                :title="rowData.name"
                :img="rowData.file ? rowData.file.full_url : urlGenerator('images/default-image.jpg')"
                :alt-text="rowData.name"
                :shadow="true"
            />
        </div>
    </div>
</template>

<script>
import {urlGenerator} from "../../Helpers/AxiosHelper";

export default {
    name: 'MediaColumn',
    props: {
        rowData: {
            type: Object,
            required: true
        },
        data: {
            type: String,
        }
    },
    data() {
        return {
            urlGenerator
        }
    },
    methods: {
        passEvent() {
            this.$hub.$emit('getTableMediaAction', this.rowData)
        }
    }
}
</script>