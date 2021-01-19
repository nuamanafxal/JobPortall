jQuery(function (e) {
	function requestHandler(settings, card, form) {
		data = {
			action: 'acfef_new_payment',
			acfef_nonce: acfef_vars.cc_nonce,
			payment_card: card,
			payment_data: settings,
		};
		jQuery.post(acfef_vars.ajax_url, data, function(result) {
			if (!result.success) {
				addCreditCardError(result.data, form);
			}else{		
				addCreditCardSuccess(result.data, form);
			}
		});
	}
	
	function addCreditCardError( message, form ){
		form.find('.card-wrapper').append('<div class="acf-notice acf-error-message -error"><p>' + message + '</p></div>');
		form.find('.acf-spinner').css( 'display', 'none' );
		form.find("button[type=submit]").attr('disabled',false).css('display', 'block');
	}
	function addCreditCardSuccess( message, form ){
		var widget = e('.elementor-element-' + form.data('widget'));
		widget.find('.acf-form-submit').prepend('<div class="acf-notice acf-success-message payment-success"><p>' + message + '</p></div>').find('.acfef-submit-button').attr('disabled',false).removeClass('acf-hidden');
		form.addClass('acf-hidden');
	}


	e(".cc-purchase").submit(function (event) {
		event.preventDefault();
		var form = e(this);
		var settings = e('.elementor-element-' + form.data('widget')).data('settings');
		form.find("button[type=submit]").attr('disabled',true).css('display', 'none');
		form.find('.acf-spinner').css( 'display', 'inline-block' );
		form.find('.acf-error-message').remove();
		
		if(settings.payment_processor == 'stripe'){
			if(acfef_vars.stripe_spk == ''){
				addCreditCardError('Could not connect to Stripe. Please check your API keys.', form);
			}
			if(typeof Stripe != 'undefined'){
				Stripe.setPublishableKey(acfef_vars.stripe_spk);
				if(form.find("input[name=stripeToken]").length == 0){
					Stripe.card.createToken(form, function(event, result){
						if (result.error) {
							// Inform the customer that there was an error.
							addCreditCardError(result.error.message, form);
						}else{					
							requestHandler(settings, result.id, form);
						}
					});
				}
			} 
		}
		if(settings.payment_processor == 'paypal'){

			card = {
				number: form.find("input.number").val(),
				name: form.find("input.name").val(),
				expiry: form.find("input.exp").val(),
				cvv: form.find("input.cvc").val(),
			}

			var cardValid = true;
			e.each( card, function( key, value ){
				if(value == ''){
					addCreditCardError('The ' + key + ' field is required', form);
					cardValid = false;
					return false;
				}	
			});

			if(cardValid){
				requestHandler(settings, card, form);
			}	
		}
	});
});