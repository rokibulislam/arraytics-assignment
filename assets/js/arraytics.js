jQuery(document).ready(function($) {

    // Function to clone the first field group
    function cloneFieldGroup() {
        const firstFieldGroup = $(".items_container .item_fields:first").clone();
        firstFieldGroup.find("input").val(""); // Clear the input value
        $(".items_container").append(firstFieldGroup);
    }

    $(document).on( 'click', "#addField", function(e) {
        e.preventDefault();
        cloneFieldGroup();
    });

    // Add an event listener to handle removing fields
    $(document).on( 'click', ".remove-field", function(e) {
        e.preventDefault();
        $(this).parent(".item_fields").remove();
    });

    $('#arraytics-submission-form').on( "submit", function( e ) {
        e.preventDefault();
        console.log('submit test');
        clearErrorMessages();
        
        // Frontend validation rules
        var valid = true;
        valid = validateField('#amount', /^\d+$/, 'Amount must be a number.') && valid;
        valid = validateField('#buyer', /^[a-zA-Z0-9\s]{1,20}$/, 'Buyer can only contain text, spaces, and numbers (max 20 characters).') && valid;
        valid = validateField('#receipt_id', /^[a-zA-Z\s]+$/, 'Receipt ID can only contain text.') && valid;
        valid = validateItems() && valid;
        valid = validateField('#buyer_email', /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/, 'Invalid email format.') && valid;
        valid = validateField('#note', /^.{0,30}$/, 'Note can contain up to 30 characters.') && valid;
        valid = validateField('#city', /^[a-zA-Z\s]+$/, 'City can only contain text and spaces.') && valid;
        valid = validateField('#phone', /^\d{11}$/, 'Phone must be 11 digits.') && valid;
        valid = validateField('#entry_by', /^\d+$/, 'Entry By must be a number.') && valid;

        if (valid) {
            var formData = $(this).serialize();
            console.log('formdata');
            console.log(formData);

            if ( document.cookie.indexOf("submission_timestamp") !== -1 ) {
                $('#form-message').html("You have already submitted the form within the last 24 hours.");
            } else {

                $.ajax({
                    type: 'POST',
                    url: arraytics_frontend.ajaxurl,
                    data: {
                        action: 'save_arraytics',
                        data: formData,
                        nonce: arraytics_frontend.nonce
                    },
                    success: function(response) {
                        console.log(response.message);
                        $('#form-message').html(response.message);

                        const now = new Date();
                        now.setTime(now.getTime() + 24 * 60 * 60 * 1000);
                        const expires = "expires=" + now.toUTCString();
                        document.cookie = "submission_timestamp=true; " + expires + "; path=/";        
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        }
    });
});


// Function to validate a field and display an error message if needed
function validateField(selector, regex, errorMessage) {
    var value = jQuery(selector).val();
    if (!regex.test(value)) {
        displayErrorMessage(selector, errorMessage);
        return false;
    }
    return true;
}


function validateItems() {

    return true;
}

// Function to display an error message for a field
function displayErrorMessage(selector, message) {
    jQuery(selector).next('.error-message').text(message);
}

// Function to clear error messages
function clearErrorMessages() {
    jQuery('.error-message').text('');
}