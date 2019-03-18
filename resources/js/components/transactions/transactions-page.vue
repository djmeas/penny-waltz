<template>
	<div class="row">
		<div class="col-lg-12">

			<transactions-add v-on:refreshRecentTransactions="refreshRecentTransactions()"></transactions-add>

			<div class="row">

				<div class="col-lg-12">
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
