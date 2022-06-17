// Countries Filter
export const countries = {
    computed: {
        countryList() {
            return this.$store.getters.getCountry.map(country => {
                return {
                    id: country.id,
                    value: country.name
                }
            })
        }
    },
    watch: {
        'countryList.length': {
            handler: function (length) {
                this.options.filters.find(({key, option}) => {
                    if (key === 'countries') option.push(...this.countryList)
                })
            },
            immediate: true
        }
    },
    mounted() {
        this.$store.dispatch("getCountry");
    }
}