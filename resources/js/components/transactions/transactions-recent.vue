<template>
	<div>
		<div class="card">
			<div class="card-header"><slot></slot></div>
	        <div class="card-body">

	        	<span v-if="transactions && transactions.length == 0">No recent transactions.</span>

	            <div class="table-responsive ps">
				    <table class="table tablesorter">
				        <thead v-if="transactions && transactions.length > 0" class=" text-primary">
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
				            <tr v-if="transactions && transactions.length > 0" v-for="transaction in transactions">
				                <td>
				                    {{transaction.date | date_format_mdy}}
				                </td>
				                <td>
				                    {{transaction.user_transaction_category.title}}
				                </td>
				                <td>
				                    {{transaction.short_description}}
				                </td>
				                <td>
				                	<span :class="{'text-success':transaction.type_id == 1, 'text-danger':transaction.type_id == -1}">
				                		<span v-if="transaction.type_id == -1">-</span>
				                		<span v-else>+</span>
				                    	${{transaction.amount}}
				                    </span>
				                </td>
				            </tr>
				            <tr v-show="!transactions" v-for="x in [0,1,2,3,4]">
				            	<td colspan="99">
				                	<div class="ph-item" style="margin:0px;padding:14px"></div>
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
    			transactions: null,
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

    			//console.log('refresh!');

    			axios.get(Vue.prototype.$apiRoutes.getRecentTransactions.url + '/' + this.widgetType).then( response => {
    				this.transactions = response.data;
    			}).catch( error => {
    				Vue.prototype.$flashMessage(error.response.data.message, 'error');
    			});

    		}

    	},

        mounted() {
            this.getRecentTransactions();
        }
    }
</script>
