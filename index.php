<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prayer Times</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <header>
            <h1>Prayer Times</h1>
            <div>
                <a href="gallery.php" style="margin-right: 10px;">Gallery</a>
                <a href="tarhim.php" style="margin-right: 10px;">Tarhim</a>
                <a href="settings.php">Settings</a>
            </div>
        </header>

        <main>
            <div id="location">Loading location...</div>
            <div id="prayer-times">
                <p>Fajr: <span id="fajr">--:--</span></p>
                <p>Dhuhr: <span id="dhuhr">--:--</span></p>
                <p>Asr: <span id="asr">--:--</span></p>
                <p>Maghrib: <span id="maghrib">--:--</span></p>
                <p>Isha: <span id="isha">--:--</span></p>
            </div>
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

            // Fetch settings and then prayer times
            fetch('api.php?action=get_settings')
                .then(response => response.json())
                .then(settings => {
                    document.getElementById('location').textContent = `${settings.city}, ${settings.country}`;
                    applyTheme(settings.theme);

                    // Now fetch prayer times
                    fetch('api.php?action=get_prayer_times')
                        .then(response => response.json())
                        .then(data => {
                            if (data.data) {
                                const timings = data.data.timings;
                                document.getElementById('fajr').textContent = timings.Fajr;
                                document.getElementById('dhuhr').textContent = timings.Dhuhr;
                                document.getElementById('asr').textContent = timings.Asr;
                                document.getElementById('maghrib').textContent = timings.Maghrib;
                                document.getElementById('isha').textContent = timings.Isha;
                            }
                        });
                });
        });
    </script>
</body>
</html>