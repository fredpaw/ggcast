<template>
	<div>
		<h4 class="text-center">Update your card details</h4>
		<form action="/charge" method="post" id="payment-form" @submit="submitForm">
		  <div class="form-row">
		    <label for="card-element">
		      Credit or debit card
		    </label>
		    <div id="card-element">
		      <!-- A Stripe Element will be inserted here. -->
		    </div>

		    <!-- Used to display Element errors. -->
		    <div id="card-errors" role="alert"></div>
		  </div>

		  <button class="btn btn-info">Update Card</button>
		</form>
	</div>
</template>

<script>
	import Axios from 'axios';
	import Swal from 'sweetalert';
	
	export default {
		data() {
			return {
				stripe: Stripe('pk_test_JgtZij2gu6YcR4XcJsPb9M8o'),
				card: null
			}
		},

		mounted() {
			var elements = this.stripe.elements();

			var style = {
			  base: {
			    // Add your base input styles here. For example:
			    fontSize: '16px',
			    color: "#32325d",
			  }
			};

			// Create an instance of the card Element.
			this.card = elements.create('card', {style: style});

			// Add an instance of the card Element into the `card-element` <div>.
			this.card.mount('#card-element');

			this.card.addEventListener('change', function(event) {
			  var displayError = document.getElementById('card-errors');
			  if (event.error) {
			    displayError.textContent = event.error.message;
			  } else {
			    displayError.textContent = '';
			  }
			});
		},

		methods: {
			submitForm(event) {
			  event.preventDefault();

			  this.stripe.createToken(this.card).then(function(result) {
			    if (result.error) {
			      // Inform the customer that there was an error.
			      var errorElement = document.getElementById('card-errors');
			      errorElement.textContent = result.error.message;
			    } else {
			    	Swal({text: 'Please wait while we update your card details...', buttons: false});
			      // Send the token to your server.
			      Axios.post('/card/update', {
			      	stripeToken: result.token.id,
			      }).then(resp => {
			      	Swal({text: 'Successfully updated', icon: 'success'})
			      		.then(() => {
			      			window.location = '';
			      		});
			      }).catch(err => {
			      	console.log(err);
			      })
			    }
			  });
			},
		},
	}
</script>