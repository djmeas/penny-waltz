<template>
	<div style="margin-bottom:20px">
        <!-- Default -->
		<div v-show="componentState == null" class="page-btn-container">
			<button @click="componentState = 'add';getUserTransactionCategories();_initForm()"
            id="action-add-transaction" class="btn btn-fill btn-primary" title="Quickly add a transaction">
				Add Transaction
			</button>
            <button @click="componentState = 'add_category';getUserTransactionCategories();"
            class="btn btn-fill btn-primary" title="Quickly add a category">
                Add Category
            </button>
		</div>

        <!-- Add -->
        <div v-show="componentState == 'add'" class="card">
            <div class="card-header">
                <h3>Add Transaction</h3>
            </div>
            <div class="card-body">
                
                <div class="row">

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Date <span class="text-danger">*</span></label>
                            <input v-model="form.date" :class="{'border-danger': validationMessages.hasOwnProperty('date')}"
                            id="transaction-date" class="form-control" type="text" >
                            <validation-messages 
                            v-if="validationMessages.hasOwnProperty('date')" :messages="validationMessages.date">
                            </validation-messages>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Type <span class="text-danger">*</span></label>
                            <select v-model="form.type_id" :class="{'border-danger': validationMessages.hasOwnProperty('type_id')}" class="form-control">
                                <option :value="null">Select...</option>
                                <option v-for="option in formTypeOptions" :value="option.value">{{option.title}}</option>
                            </select>
                        </div>
                        <validation-messages 
                            v-if="validationMessages.hasOwnProperty('type_id')" :messages="validationMessages.type_id">
                            </validation-messages>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Category <span class="text-danger">*</span></label>
                            <select v-model="form.category_id" @change="componentStateChecker()"
                            :class="{'border-danger': validationMessages.hasOwnProperty('category_id')}" class="form-control">
                                <option :value="null">Select...</option>
                                <option v-if="computedFormCategories.length > 0" v-for="option in computedFormCategories" :value="option.id">
                                    {{option.title}}
                                </option>
                                <!--<option v-if="computedFormCategories.length > 0" value="0">+ Add New Cateogry</option>-->
                            </select>
                            <validation-messages 
                            v-if="validationMessages.hasOwnProperty('category_id')" :messages="validationMessages.category_id">
                            </validation-messages>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Amount <span class="text-danger">*</span></label>
                            <input :class="{'border-danger': validationMessages.hasOwnProperty('amount')}" v-model="form.amount" type="text" class="form-control" placeholder="$">
                            <validation-messages 
                            v-if="validationMessages.hasOwnProperty('amount')" :messages="validationMessages.amount">
                            </validation-messages>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Short Description <span class="text-danger">*</span></label>
                            <input :class="{'border-danger': validationMessages.hasOwnProperty('short_description')}" v-model="form.short_description" type="text" class="form-control">
                            <validation-messages 
                            v-if="validationMessages.hasOwnProperty('short_description')" :messages="validationMessages.short_description">
                            </validation-messages>
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
                <button @click="saveTransaction" 
                id="action-save-transaction" class="btn btn-fill btn-success">Save</button>
            </div>
        </div>

        <!-- Add Category -->
        <div v-if="componentState == 'add_category'">
            <div class="card">
                <div class="card-header">
                    <h3>Add Category</h3>
                </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <h3>Money In</h3>
                            <table class="table tablesorter">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="category in formCategories.in">
                                        <td>{{category.title}}</td>
                                    </tr>
                                    <tr v-if="formCategories.length == 0" v-for="x in 10">
                                        <td colspan="99">
                                            <div class="ph-item" style="margin:0px;padding:14px"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <h3>Money Out</h3>
                            <table class="table tablesorter">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="category in formCategories.out">
                                        <td>{{category.title}}</td>
                                    </tr>
                                    <tr v-if="formCategories.length == 0" v-for="x in 10">
                                        <td colspan="99">
                                            <div class="ph-item" style="margin:0px;padding:14px"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <button @click="componentState = null" 
                    class="btn btn-fill btn-danger">Cancel</button>
                    <button @click="saveTransaction" 
                    class="btn btn-fill btn-success">Save</button>

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

                // Form
                formTypeOptions: Vue.prototype.$transactionTypeList,
                formCategories: [],
                form: {},

                // Errors
                validationMessages: {}
    		}
    	},

    	methods: {

            // Requests

            getUserTransactionCategories() {

                axios.get(Vue.prototype.$apiRoutes.userTransactionCategories.url).then(response => {
                    this.formCategories = response.data;
                }).catch(error => {
                    this.errorMsg = error.response.data.message;
                });

            },

            saveTransaction() {

                this.errorMsg = null;

                axios.post(Vue.prototype.$apiRoutes.addTransaction.url, this.form).then(response => {
                    Vue.prototype.$flashMessage(response.data.message, 'success');

                    // TODO:
                    // Push individual transaction records into the paginated data
                    this.$emit('refreshRecentTransactions');

                    this._initForm();
                    //this.$emit('refreshRecentTransactions');
                    this.componentState = null;
                }).catch(error => {
                    //console.log(error.response.data);
                    this.validationMessages = error.response.data.errors;
                    Vue.prototype.$flashMessage('Whoops! Please check all fields and try submitting again.', 'error');
                });

            },

            // Helpers
            componentStateChecker() {

                this.componentState = this.form.category_id == 0 ? 'add_category' : this.componentState;

                if(this.componentState == 'add_category') {
                    this.getUserTransactionCategories();
                }

            },

            // Initialize

            _initForm() {
                this.validationMessages = {};
                this.form = {
                    type_id: null,
                    category_id: null,
                    amount: null,
                    short_description: null,
                    additional_notes: null,
                    date: null
                }
            }

    	},

        computed: {

            computedFormCategories() {

                if(!this.form.type_id) {
                    return [];
                }

                return this.form.type_id == -1 ? this.formCategories['out'] : this.formCategories['in'];

            }

        },

        mounted() {
            console.log('Component mounted.')

            this._initForm();

            $("#transaction-date").datepicker({
                onSelect: dateText => {
                    this.form.date = dateText;
                }       
            });

        }
    }
</script>
