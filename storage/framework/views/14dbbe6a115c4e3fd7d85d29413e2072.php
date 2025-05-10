<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MediGuard</title>
  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>
<body>
  <header>
    <h1>Medication Tracking</h1>
  </header>

  <main>
    <section class="tracking-info">
      <h2>Track Your Medications</h2>
      <form id="medication_form">
        <label for="medication-name">Medication Name:</label>
        <input type="text" id="medication-name" name="medication_name" required>

        <label for="dosage">Dosage:</label>
        <input type="text" id="dosage" name="dosage" required>

        <label for="schedule">Schedule:</label>
        <input type="datetime-local" id="schedule" name="schedule" required>

        <button type="button" id="track-Medication" onclick="trackMedication()">Track Medication</button>
      </form>
    </section>

    <div id="tracking-display"></div>
  </main>

  <footer>
    <p>&copy; 2025 MediGuard. All rights reserved.</p>
  </footer>

  <script src="<?php echo e(asset('js/script.js')); ?>"></script>
  <!-- Font Toggle Button -->
  <button id="toggle-font" type="button">Toggle Font Size</button>
</body>
</html><?php /**PATH C:\Users\ONYEKA\Desktop\medicare\resources\views/index.blade.php ENDPATH**/ ?>