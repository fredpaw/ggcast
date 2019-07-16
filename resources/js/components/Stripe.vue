<template>
	<div>
    <div class="text-center">
      <ul class="nav nav-outline nav-round">
        <li class="nav-item w-140">
          <a class="nav-link active" data-toggle="tab" href="#monthly-1" aria-expanded="true" @click="subscribe('monthly')">$9.99 Monthly</a>
        </li>
        <li class="nav-item w-140">
          <a class="nav-link" data-toggle="tab" href="#yearly-1" aria-expanded="false" @click="subscribe('yearly')">$99.00 Yearly</a>
        </li>
      </ul>
    </div>

		<div class="mt-20">
      <div class="tab-content">
        <div class="tab-pane fade active show" id="monthly-1" aria-expanded="false">
        	<h3 class="text-center">Subscribe to 9.99 Monthly</h3>
        </div>

        <div class="tab-pane fade" id="yearly-1" aria-expanded="false">
          <h3 class="text-center">Subscribe to 99.00 yearly</h3>
        </div>
      </div>
    </div>

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

		  <button class="btn btn-success">Submit Payment</button>
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
			window.stripePlan = 'monthly';

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
			subscribe(plan) {
				if(plan == 'yearly') {
					window.stripePlan = 'yearly'
				} else {
					window.stripePlan = 'monthly'
				}
			},

			submitForm(event) {
			  event.preventDefault();

			  this.stripe.createToken(this.card).then(function(result) {
			    if (result.error) {
			      // Inform the customer that there was an error.
			      var errorElement = document.getElementById('card-errors');
			      errorElement.textContent = result.error.message;
			    } else {
			    	Swal({text: 'Please wait while we subscribe you to a plan ...', buttons: false});
			      // Send the token to your server.
			      Axios.post('/subscribe', {
			      	stripeToken: result.token.id,
			      	plan: window.stripePlan,
			      }).then(resp => {
			      	Swal({text: 'Successfully subscribe', icon: 'success'})
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