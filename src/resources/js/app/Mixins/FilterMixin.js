// Client Filter
export const clientUser = {
	computed: {
		clients() {
			return this.$store.getters.getClientUser.map(client => {
				return {
					id: client.id,
					value: client.full_name
				}
			})
		}
	},

	watch: {
		'clients.length': {
			handler: function (length) {
				this.options?.filters.find(({key, option}) => {
					if (key === 'clients') option.push(...this.clients)
				})
			},
			immediate: true
		}
	},

	mounted() {

		setTimeout(() => {
			this.$store.dispatch('getClientUser')
		}, 1000)
	}
}

// Status Filter

export const status = {
	computed: {
		statuses() {
			return this.$store.getters.getInvoiceStatus.map(status => {
				return {
					id: status.id,
					value: status.translated_name
				}
			})
		}
	},

	watch: {
		'statuses.length': {
			handler: function (length) {
				this.options?.filters.find(({key, option}) => {
					if (key === 'status') option.push(...this.statuses)
				})
			},
			immediate: true
		}
	},

	mounted() {
		setTimeout(() => {
			this.$store.dispatch('getInvoiceStatus')
		}, 1000)
	}
}

// Payment methods

export const paymentMethods = {
	computed: {
		paymentMethods() {
			return this.$store.getters.getPaymentMethod.map(payment => {
				return {
					id: payment.id,
					value: payment.name
				}
			})
		}
	},

	watch: {
		'paymentMethods.length': {
			handler: function (length) {
				this.options?.filters.find(({key, option}) => {
					if (key === 'payment_methods') option.push(...this.paymentMethods)
				})
			},
			immediate: true
		}
	},

	mounted() {
		setTimeout(() => {
			this.$store.dispatch('getPaymentMethod')
		}, 1000)
	}
}

//Category

export const Category = {
	computed: {
		categoryList() {
			return this.$store.getters.getCategory.map(category => {
				return {
					id: category.id,
					value: category.name
				}
			})
		}
	},

	watch: {
		'categoryList.length': {
			handler: function (length) {
				this.options?.filters.find(({key, option}) => {
					if (key === 'categories') option.push(...this.categoryList)
				})
			},
			immediate: true
		}
	},

	mounted() {
		setTimeout(() => {
			this.$store.dispatch("getCategory");
		}, 1000)
	}
}

export const Purpose = {
	computed: {
		purposeList() {
			return this.$store.getters.getPurpose.map(purpose => {
				return {
					id: purpose.id,
					value: purpose.name
				}
			})
		}
	},

	watch: {
		'purposeList.length': {
			handler: function (length) {
				this.options?.filters.find(({key, option}) => {
					if (key === 'expense_purpose') option.push(...this.purposeList)
				})
			},
			immediate: true
		}
	},

	mounted() {
		this.$store.dispatch("getPurpose", 'expense');
	}
}
