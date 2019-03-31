<template>
	<div>
		<!-- Add Category -->
        <div>
            <div class="card">
                <div class="card-header">
                    <h4>Transaction Category</h4>
                </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <h4>Revenue</h4>
                            <table class="table tablesorter">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th style="width:50px">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="category in formCategories.in" class="hidden-children">
                                        <td>{{category.title}}</td>
                                        <td>
                                            <i v-on:click="deleteTransactionCategory(category.id)" 
                                            class="clickable tim-icons icon-simple-remove show-on-hover"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="99">
                                            <input v-model="categoryForm.revenue" v-on:keyup.enter="saveCategory('revenue')"
                                            class="form-control" type="text" placeholder="Add a new revenue category">
                                        </td>
                                       
                                    </tr>
                                    <tr v-if="formCategories.length == 0" v-for="x in 5">
                                        <td colspan="99">
                                            <div class="ph-item" style="margin:0px;padding:14px"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <h4>Expense</h4>
                            <table class="table tablesorter">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th style="width:50px">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="category in formCategories.out" class="hidden-children">
                                        <td>{{category.title}}</td>
                                        <td>
                                            <i v-on:click="deleteTransactionCategory(category.id)"
                                            class="tim-icons icon-simple-remove show-on-hover"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="99">
                                            <input v-model="categoryForm.expense" v-on:keyup.enter="saveCategory('expense')"
                                            class="form-control" type="text" placeholder="Add a new expense category">
                                        </td>
                                       
                                    </tr>
                                    <tr v-if="formCategories.length == 0" v-for="x in 5">
                                        <td colspan="99">
                                            <div class="ph-item" style="margin:0px;padding:14px"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <button @click="$emit('cancel')" 
                    class="btn btn-fill btn-danger">
                		Back
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
                componentState: null,

                // Form
                formTypeOptions: Vue.prototype.$transactionTypeList,
                formCategories: [],

                categoryForm: {},

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

            saveCategory(type) {

                this.categoryForm.title = type == 'revenue' ? this.categoryForm.revenue : this.categoryForm.expense;
                this.categoryForm.type_id = type == 'revenue' ? 1 : -1;

                axios.post(Vue.prototype.$apiRoutes.addTransactionCategory.url, this.categoryForm).then(response => {
                    Vue.prototype.$flashMessage(response.data.message, 'success');
                    this.getUserTransactionCategories();
                    this._initForm();
                }).catch(error => {

                }).finally(response => {

                });

            },

            deleteTransactionCategory(categoryID) {

                axios.delete(Vue.prototype.$apiRoutes.deleteTransactionCategory.url + categoryID,).then(response => {
                    Vue.prototype.$flashMessage(response.data.message, 'success');
                    this.getUserTransactionCategories();
                    this._initForm();
                }).catch(error => {
                    Vue.prototype.$flashMessage(error.data.message, 'error');
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

                this.categoryForm = {
                    revenue: '',
                    expense: '',
                    type_id: null
                }
            }

    	},

        computed: {

        },

        mounted() {
            console.log('Transaction Categories Component mounted.');

            this.getUserTransactionCategories();
            this._initForm();

        }
    }
</script>

