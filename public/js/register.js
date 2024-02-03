$(document).ready(function() {
    $('#registrationForm').submit(function(event) {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'index.php?action=register',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Registration successful!');
                    window.location.href = response.redirect;
                } else {
                    alert('Registration failed: ' + response.error);
                }
            },
            error: function() {
                alert('Error occurred during registration.');
            }
        });
    });
});