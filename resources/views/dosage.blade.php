<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Save Dosage - MediGuard</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<h2>Save Dosage</h2>

<form id="dosageForm">
    <input type="text" name="medication_name" placeholder="Medication Name" required><br><br>
    <input type="text" name="dosage" placeholder="Dosage" required><br><br>
    <input type="text" name="schedule" placeholder="Schedule" required><br><br>
    <button type="submit">Save Dosage</button>
</form>

<script>
document.getElementById("dosageForm").addEventListener("submit", function(e) {
    e.preventDefault();

    // Collect form data
    const formData = new FormData(e.target);

    // Send data to the backend API
    fetch("/api/save_dosage_schedule", {
        method: "POST",
        body: formData
    })
    .then(response => {
        // Check if response is ok (status 200)
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        return response.json();
    })
    .then(data => {
        // Success - show API message
        console.log("Save Dosage Response:", data);
        alert(data.message);
    })
    .catch(error => {
        // Error - show error message
        console.error("Error:", error);
        alert("Failed to save dosage. Please try again.");
    });
});
</script>

</body>
</html>