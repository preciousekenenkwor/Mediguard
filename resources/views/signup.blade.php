<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guardian Signup | MediGuard</title>
    <link rel="stylesheet" href="/css/style.css">

</head>
<body>

<h2>Guardian Signup</h2>
<form id="signupForm">
    <input type="text" name="name" placeholder="Full Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Sign Up</button>
</form>

<script>
document.getElementById("signupForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const fullName = document.querySelector("input[name='name']").value;
    const email = document.querySelector("input[name='email']").value;
    const password = document.querySelector("input[name='password']").value;


    const form_data=new FormData(event.target);
    fetch("/api/guardian_signup", {
        method: "POST",
        body: form_data
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("Signup successful! Redirecting to login...");
            window.location.href = "/login";
        } else {
            alert("Signup failed: " + (data.message || "Unknown error."));
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An error occurred. Please try again later.");
    });
});
</script>


</body>
</html>