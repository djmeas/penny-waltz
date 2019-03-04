<template>
	<div class="row">
		<div class="col-lg-12">

			<transactions-add v-on:refreshRecentTransactions="refreshRecentTransactions()"></transactions-add>

			<div class="row">
				<div class="col-lg-6">
					<transactions-recent ref="transactionsRecentIn" widgetType="in">
						Recent Money-In
					</transactions-recent>
				</div>

				<div class="col-lg-6">
					<transactions-recent ref="transactionsRecentOut" widgetType="out">
						Recent Money-Out
					</transactions-recent>
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
    			console.log('refresh?');
    			this.$refs.transactionsRecentIn.getRecentTransactions();
    		}

    	},

        mounted() {
            console.log('Component mounted.')
            console.log('test') 
        }
    }
</script>
