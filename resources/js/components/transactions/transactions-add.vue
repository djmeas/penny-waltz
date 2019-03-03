<template>
	<div>
        <!-- Default -->
		<div v-if="componentState == null" class="page-btn-container">
			<button @click="componentState = 'add';getUserTransactionCategories()"
            id="action-add-transaction" class="btn btn-fill btn-primary" title="Quickly add a transaction">
				Add Transaction
			</button>
		</div>

        <!-- Add -->
        <div v-if="componentState == 'add'" class="card">
            <div class="card-header">Add Transaction</div>
            <div class="card-body">
                
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Type</label>
                            <select class="form-control" v-model="form.type_id">
                                <option :value="null">Select...</option>
                                <option v-for="option in formTypeOptions">{{option.title}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" v-model="form.category_id">
                                <option :value="null">Select...</option>
                                <option v-if="formCategories.length > 0" v-for="option in formCategories" :value="option.id">
                                    {{option.title}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Amount</label>
                            <input v-model="form.amount" type="text" class="form-control" placeholder="$">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Short Description</label>
                            <input v-model="form.short_description" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Additional Notes</label>
                            <textarea v-model="form.additional_notes" class="form-control"></textarea>
                        </div> 
                    </div>
                </div>

                <button @click="componentState = null" 
                id="action-cancel-transaction" class="btn btn-fill btn-danger">Cancel</button>
            </div>
        </div>
	</div>     
</template>

<script>
    export default {

    	data() { 
    		return {
                componentState: null,

                // Form
                formTypeOptions: Vue.prototype.$transactionTypeList,
                formCategories: []
    		}
    	},

    	methods: {

            getUserTransactionCategories() {

                axios.get(Vue.prototype.$apiRoutes.userTransactionCategories.url).then(response => {
                    this.formCategories = response.data;
                }).catch(error => {

                });

            }

    	},

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
