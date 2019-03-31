<template>
	<div class="row">
		<div class="col-lg-12">

            <!-- Add Transaction / Default -->
            <button v-show="componentState == null" @click="componentState = 'add_transaction'"
            id="action-add-transaction" class="btn btn-fill btn-primary" title="Quickly add a transaction">
                Add Transaction
            </button>

            <transactions-add v-if="componentState == 'add_transaction'" 
            v-on:cancel="componentState = null"
            v-on:refreshRecentTransactions="refreshRecentTransactions()">
            </transactions-add>
        
            <!-- Add Category -->
            <button v-show="componentState == null" @click="componentState = 'categories'"
            class="btn btn-fill btn-primary" title="Quickly add a category">
                Transaction Categories
            </button>

            <transactions-categories v-if="componentState == 'categories'"
            v-on:cancel="componentState = null">
            </transactions-categories> 

			<div class="row">

				<div class="col-lg-12" style="margin-top: 20px">
					<transactions-all ref="transactionsAll"></transactions-all>
				</div>

			</div>
			
        </div>
	</div>     
</template>

<script>
    export default {

    	data() { 
    		return {

                componentState: null,

    			displayRecentWidgets: true,
    		}
    	},

    	methods: {

    		refreshRecentTransactions() {
    			//console.log('refresh?');
    			this.$refs.transactionsAll.getAllTransactions();
    		}

    	},

        mounted() {

        }
    }
</script>
