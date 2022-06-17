<template>
    <div>
        <template v-for="(item, index) in addressData" v-if="index < 2">
            <div class="d-flex align-items-center">
                <span class="mb-1 badge badge-round badge-light">{{ textTruncate(item.address, 28, '...') }}</span>
            </div>
            <small class="cursor-pointer" v-if="addressData.length > 2 && index == 1">
                <b>+{{ addressData.length - 2 }} more</b>
            </small>
        </template>
    </div>
</template>

<script>
import {textTruncate} from "../../../Helpers/Helpers";
export default {
    name: "AddressColumn",
    props: {
        rowData: {
            type: Object,
            required: true
        },
        value: {
            type: Array,
        }
    },
    data() {
        return {
            textTruncate,
        }
    },
    methods:{

    },
    computed: {
        addressData() {
            return this.value;
        }
    }
}
</script>