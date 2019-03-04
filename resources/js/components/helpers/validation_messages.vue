<template>
	<div>
        <span v-if="messages.length >= 1" class="text-danger"> 
            {{messages[0]}}
        </span>
        <span v-if="messages.length >= 1 && key > 1" v-for="(msg, key) in messages" class="text-danger"> 
            <br>{{msg}}
        </span>
	</div>     
</template>

<script>
    export default {

    	data() { 
    		return {

    		}
    	},

    	props: {
    		validationType: {
    			type: String,
    			required: false,
    			default: 'error'
    		},
    		messages: {
    			type: [Object, Array],
    			required: false, 
    			default: []
    		}
    	},

    	computed: {

    		_alertContext() {

    			return this.validationType == 'error' ? 'alert-danger' : 'alert-info'; 

    		}

    	}, 

        mounted() {
            //console.log('Component mounted.')
        }
    }
</script>
