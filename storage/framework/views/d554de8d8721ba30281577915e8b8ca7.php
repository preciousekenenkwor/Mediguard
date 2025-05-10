<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guardian Login</title>
    <link rel="stylesheet" href="/css/style.css">

</head>
<body>
    <h2>Guardian Login</h2>

    <form id="loginForm">
        <input type="text" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button>Login</button>
    </form>

    <script>
document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const email = document.querySelector('input[name="email"]').value;
    const password = document.querySelector('input[name="password"]').value;

    const form_data=new FormData(event.target);

    fetch("/api/guardian_login", {
        method: "POST",
        body: form_data
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("Login successful! Redirecting to dashboard...");
            window.location.href = "/dashboard"; // Redirect after successful login
        } else {
            alert("Login failed: " + (data.message || "Invalid credentials."));
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An error occurred. Please try again later.");
    });
});
</script>


</body>
</html><?php /**PATH C:\Users\ONYEKA\Desktop\medicare\resources\views/login.blade.php ENDPATH**/ ?>