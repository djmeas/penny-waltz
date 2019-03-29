<template>
	<div>
		<!-- All Transactions -->
		<div class="card">
			<div class="card-header">
				All Transactions 
				<span v-if="paginatedData">
					<span class="card-header-subheader">Displaying {{paginatedData.from}} - {{paginatedData.to}} of {{paginatedData.total}}</span> 
					<span class="card-header-subheader">Page {{paginatedData.current_page}}</span>

				</span>
			</div>
	        <div class="card-body">

	            <div id="table-transactions-all" class="table-responsive ps">
				    <table class="table tablesorter">
				        <thead v-if="transactions.length > 0" class=" text-primary">
				            <tr>
				                <th class="date">
				                    Date
				                </th>
				                <th class="category">
				                    Category
				                </th>
				                <th class="short-description">
				                    Short Description
				                </th>
				                <th class="additional-notes">
				                	Additional Notes
				                </th>
				                <th class="amount">
				                	Amount
				                </th>
				                <th class="action text-center">
				                	Actions
				                </th>
				            </tr>
				        </thead>
				        <tbody>
				            <tr v-if="transactions.length > 0" v-for="transaction in transactions">
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
				                    {{transaction.additional_notes}}
				                </td>
				                <td>
				                    ${{transaction.amount}}
				                </td>
				                <td class="text-center" title="edit">
				                	<i class="tim-icons icon-pencil"></i>
				                </td>
				            </tr>
				            <tr v-show="transactions.length == 0" v-for="x in [0,1,2,3,4,5,6,7,8]">
				            	<td colspan="99">
				                	<div class="ph-item" style="margin:0px;padding:14px"></div>
				                </td>
				            </tr>
				        </tbody>
				    </table>
				</div>

				<div class="text-center">

					<button @click="paginationChange(paginatedData.prev_page_url)" 
					class="btn btn-default" :class="{'faded':paginatedData.current_page == 1}">
						<i class="tim-icons icon-minimal-left"></i>
					</button>
					&nbsp;&nbsp;&nbsp;
					<button @click="paginationChange(paginatedData.next_page_url)" 
					class="btn btn-default" :class="{'faded':paginatedData.last_page == paginatedData.current_page}">
						<i class="tim-icons icon-minimal-right"></i>
					</button>
				</div>

	        </div>
        </div>
	</div>     
</template>

<script>
    export default {

    	data() { 
    		return {
    			paginatedData: null,
    			transactions: [],
    		}
    	},

    	props: {

    	},

    	methods: {

    		getAllTransactions() {

    			axios.post(Vue.prototype.$apiRoutes.getAllTransactions.url).then( response => {
    				this.paginatedData = response.data;
    				this.transactions = response.data.data;
    			}).catch( error => {
    				Vue.prototype.$flashMessage(error.response.data.message, 'error');
    			}); 

    		},

    		paginationChange(url) {

    			axios.post(url).then( response => {
    				this.paginatedData = response.data;
    				this.transactions = response.data.data;
    			}).catch( error => {
    				Vue.prototype.$flashMessage(error.response.data.message, 'error');
    			}); 

    		}

    	},

        mounted() {
            console.log('transactions-all.vue loaded.');
            this.getAllTransactions();
        }
    }
</script>
