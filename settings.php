<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <header>
            <h1>Settings</h1>
            <a href="index.php">Home</a>
        </header>

        <main>
            <form id="settings-form">
                <input type="hidden" name="action" value="save_settings">

                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>

                <label for="country">Country:</label>
                <input type="text" id="country" name="country" required>

                <label for="theme">Theme:</label>
                <select id="theme" name="theme">
                    <option value="light">Light</option>
                    <option value="dark">Dark</option>
                </select>

                <h3>Prayer Time Adjustments (in minutes)</h3>
                <label for="fajr_adjustment">Fajr:</label>
                <input type="number" id="fajr_adjustment" name="fajr_adjustment" value="0">

                <label for="dhuhr_adjustment">Dhuhr:</label>
                <input type="number" id="dhuhr_adjustment" name="dhuhr_adjustment" value="0">

                <label for="asr_adjustment">Asr:</label>
                <input type="number" id="asr_adjustment" name="asr_adjustment" value="0">

                <label for="maghrib_adjustment">Maghrib:</label>
                <input type="number" id="maghrib_adjustment" name="maghrib_adjustment" value="0">

                <label for="isha_adjustment">Isha:</label>
                <input type="number" id="isha_adjustment" name="isha_adjustment" value="0">

                <button type="submit">Save Settings</button>
            </form>
        </main>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function applyTheme(theme) {
                if (theme === 'dark') {
                    document.body.classList.add('dark-theme');
                } else {
                    document.body.classList.remove('dark-theme');
                }
            }

            // Load current settings
            fetch('api.php?action=get_settings')
                .then(response => response.json())
                .then(settings => {
                    document.getElementById('city').value = settings.city;
                    document.getElementById('country').value = settings.country;
                    document.getElementById('theme').value = settings.theme;
                    document.getElementById('fajr_adjustment').value = settings.fajr_adjustment;
                    document.getElementById('dhuhr_adjustment').value = settings.dhuhr_adjustment;
                    document.getElementById('asr_adjustment').value = settings.asr_adjustment;
                    document.getElementById('maghrib_adjustment').value = settings.maghrib_adjustment;
                    document.getElementById('isha_adjustment').value = settings.isha_adjustment;
                    applyTheme(settings.theme);
                });

            // Handle theme change
            document.getElementById('theme').addEventListener('change', function() {
                applyTheme(this.value);
            });

            // Handle form submission
            document.getElementById('settings-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetch('api.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Settings saved!');
                        window.location.href = 'index.php';
                    }
                });
            });
        });
    </script>
</body>
</html>