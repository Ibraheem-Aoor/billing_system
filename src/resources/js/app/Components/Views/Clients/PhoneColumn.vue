<template>
    <div>
        <template v-for="(item, index) in phoneData" v-if="index < 2">
            <div class="d-flex align-items-center">
                <span class="mb-1 badge badge-round badge-light">{{ item.value }}</span>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    name: "PhoneColumn",
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

        }
    },
    methods:{

    },
    computed: {
        phoneData() {
            return this.value;
        }
    }
}
</script>
