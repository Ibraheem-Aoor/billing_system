<template>
    <div class="d-flex align-items-center">
        <template v-if="rowData.user">
            <div class="avatars-w-40">
                <app-avatar
                    :title="rowData.user.full_name"
                    :img="rowData.user.profile_picture ? rowData.user.profile_picture.full_url : ''"
                    :alt-text="rowData.user.full_name"
                    :shadow="true"
                />

            </div>
            <div class="ml-3">
                <a href="" @click.prevent="passEvent">
                    {{ rowData.user.full_name }}
                </a>
            </div>
        </template>
    </div>
</template>

<script>
import {urlGenerator} from "../../Helpers/AxiosHelper";
import {CLIENT_LIST} from "../../Config/BillarApiUrl";

export default {
    name: 'TableMedia',
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
            window.location = (urlGenerator(`/${CLIENT_LIST}/${this.rowData.id}/details`));
            // this.$hub.$emit('getTableMediaAction', this.rowData)
        }
    }
}
</script>