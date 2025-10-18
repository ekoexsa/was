<?php
require_once 'config.php';

header('Content-Type: application/json');

function get_setting($key) {
    global $conn;
    $stmt = $conn->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_assoc()['setting_value'];
    }
    return null;
}

function get_all_settings() {
    global $conn;
    $settings = [];
    $result = $conn->query("SELECT setting_key, setting_value FROM settings");
    while ($row = $result->fetch_assoc()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    return $settings;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'get_prayer_times') {
            $city = get_setting('city');
            $country = get_setting('country');

            if ($city && $country) {
                $url = "http://api.aladhan.com/v1/timingsByCity?city=$city&country=$country&method=2";
                $response = file_get_contents($url);
                $data = json_decode($response, true);

                // Apply adjustments
                if ($data && isset($data['data']['timings'])) {
                    $adjustments = get_all_settings();
                    foreach ($data['data']['timings'] as $prayer => &$time) {
                        $adjustment_key = strtolower($prayer) . '_adjustment';
                        if (isset($adjustments[$adjustment_key])) {
                            $adjustment = (int)$adjustments[$adjustment_key];
                            if ($adjustment !== 0) {
                                $time_obj = DateTime::createFromFormat('H:i', $time);
                                if ($time_obj) {
                                    $time_obj->modify("$adjustment minutes");
                                    $time = $time_obj->format('H:i');
                                }
                            }
                        }
                    }
                }
                echo json_encode($data);
            } else {
                echo json_encode(['error' => 'Location not set']);
            }
        } elseif ($_GET['action'] === 'get_settings') {
            echo json_encode(get_all_settings());
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_settings') {
    foreach ($_POST as $key => $value) {
        if ($key !== 'action') {
            $stmt = $conn->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
            $stmt->bind_param("ss", $value, $key);
            $stmt->execute();
        }
    }
    echo json_encode(['success' => true]);
}

$conn->close();
?>