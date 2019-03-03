<template>
	<div class="row">
		<div class="col-lg-12">

			<transactions-add></transactions-add>

			<div class="row">
				<div class="col-lg-6">
					<div class="card">
						<div class="card-header">Recent Money-In</div>
				        <div class="card-body">
				            [Example Data]
				        </div>
			        </div>
				</div>

				<div class="col-lg-6">
					<div class="card">
						<div class="card-header">Recent Money-Out</div>
				        <div class="card-body">
				            [Example Data]
				        </div>
			        </div>
				</div>
			</div>
			
        </div>
	</div>     
</template>

<script>
    export default {

    	data() { 
    		return {

    		}
    	},

        mounted() {
            console.log('Component mounted.')
            console.log('test') 
        }
    }
</script>
