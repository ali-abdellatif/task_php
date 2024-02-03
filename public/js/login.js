$(document).ready(function() {
    $('#loginForm').submit(function(event) {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'index.php?action=login',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Login successful!');
                    var username = response.username;
                    var createdAt = response.createdAt;
                    $('#creationDateElement').text('Account created on: ' + createdAt);
                    window.location.href = response.redirect;
                    sessionStorage.setItem('dashboardData', JSON.stringify({ username: username, createdAt: createdAt }));
                } else {
                    alert('Login failed: ' + response.error);
                }
            },
            error: function() {
                alert('Error occurred during login.');
            }
        });
    });
});