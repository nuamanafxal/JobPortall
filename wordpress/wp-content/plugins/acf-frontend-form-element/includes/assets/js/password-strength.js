function checkPasswordStrength( $pass1,
                                $pass2,
                                $strengthResult,
                                $submitButton,
								$requiredStrength,
                                blacklistArray ) {
    var pass1 = $pass1.val();
    if( $pass2.length ){
        var pass2 = $pass2.val();
    }else{
        var pass2 = $pass1.val();
    }
    var required = $requiredStrength.val();
 
    // Reset the form & meter
    $strengthResult.removeClass( 'short bad good strong' );
 
    // Extend our blacklist array with those from the inputs & site data
    blacklistArray = blacklistArray.concat( wp.passwordStrength.userInputBlacklist() )
 
    // Get the password strength
    var strength = wp.passwordStrength.meter( pass1, blacklistArray, pass2 );

    $strengthResult.siblings( 'input.password-strength' ).val(strength);
 
    // Add the strength meter results
    switch ( strength ) {
 
        case 2:
            $strengthResult.addClass( 'bad' ).html( pwsL10n.bad );
            break;
 
        case 3:
            $strengthResult.addClass( 'good' ).html( pwsL10n.good );
            break;
 
        case 4:
            $strengthResult.addClass( 'strong' ).html( pwsL10n.strong );
            break;
 
        case 5:
            $strengthResult.addClass( 'short' ).html( pwsL10n.mismatch );
            break;
 
        default:
            $strengthResult.addClass( 'short' ).html( pwsL10n.short );
 
    }
 
    return strength;
}
 
jQuery( document ).ready( function( $ ) {
	var $confirm = $('.acfef_password_confirm input');
	
		var $password = $('.acf-field-password input');

		// Binding to trigger checkPasswordStrength
		$( 'form' ).on( 'keyup', '.acf-field-password input',
			function( event ) {
				checkPasswordStrength(
					$password,   
					$confirm,
					$(this).closest('form').find('#password-strength'),           // Strength meter
					$(this).closest('form').find('input[type=submit]'),           // Submit button
					$(this).closest('form').find('input.password-strength'),	// Required Strength
					[]        // Blacklisted words
				);
			}
		);
});