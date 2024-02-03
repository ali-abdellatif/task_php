<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

<p id=""><?php echo $hijriDate; ?></p>


<a href="?action=logout">Logout</a>

<script>
    // Retrieve data from sessionStorage
    var dashboardData = JSON.parse(sessionStorage.getItem('dashboardData'));

    // Update DOM elements with the data
    document.getElementById('usernameElement').innerText = dashboardData.username;
    document.getElementById('creationDateElement').innerText = 'Account created on: ' + dashboardData.createdAt;
</script>
</body>
</html>