<template>
	<div>
		<div class="card">
			<div class="card-header"><slot></slot></div>
	        <div class="card-body">
	            <div class="table-responsive ps">
				    <table class="table tablesorter">
				        <thead class=" text-primary">
				            <tr>
				                <th>
				                    Date
				                </th>
				                <th>
				                    Category
				                </th>
				                <th>
				                    Short Description
				                </th>
				                <th>
				                	Amount
				                </th>
				            </tr>
				        </thead>
				        <tbody>
				            <tr v-for="transaction in transactions">
				                <td>
				                    {{transaction.date | date_format_mdy}}
				                </td>
				                <td>
				                    {{transaction.user_transaction_category.title}}
				                </td>
				                <td>
				                    {{transaction.short_description}}
				                </td>
				                <td class="text-center">
				                    ${{transaction.amount}}
				                </td>
				            </tr>
				        </tbody>
				    </table>
				</div>
	        </div>
        </div>
	</div>     
</template>

<script>
    export default {

    	data() { 
    		return {
    			transactions: [],
    		}
    	},

    	props: {
    		widgetType: {
    			type: String,
    			required: true,
    			default: 'in'
    		}
    	},

    	methods: {

    		getRecentTransactions() {

    			console.log('refresh!');

    			axios.get(Vue.prototype.$apiRoutes.getRecentTransactions.url + '/' + this.widgetType).then( response => {
    				this.transactions = response.data;
    			}).catch( error => {
    				Vue.prototype.$flashMessage(error.response.data.message, 'error');
    			});

    		}

    	},

        mounted() {
            console.log('Component mounted.')
            this.getRecentTransactions();
        }
    }
</script>
