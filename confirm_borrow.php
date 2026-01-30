<?php
include "connect.php";
session_start();

if (!isset($_SESSION['is_logged_in'])) {
    header("location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("location: index.php");
    exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM book WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if (!$book) {
    die("Book not found");
}


if ($book['status'] != '0') {
    echo "<script>alert('หนังสือถูกยืมไปแล้ว'); window.location='index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ยืนยันการยืมและระบุที่อยู่จัดส่ง</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php include "navbar.php"; ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-custom p-4">
                    <h2 class="mb-4 text-center"><i class="bi bi-geo-alt-fill text-danger"></i> ระบุสถานที่จัดส่ง</h2>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> กรุณาปักหมุดตำแหน่งที่ต้องการให้จัดส่งหนังสือยืม: <strong>
                            <?= htmlspecialchars($book['title']) ?>
                        </strong>
                    </div>

                    <form action="borrow.php" method="post">
                        <input type="hidden" name="id" value="<?= $book['id'] ?>">
                        <input type="hidden" name="lat" id="lat" value="13.736717">
                        <input type="hidden" name="lng" id="lng" value="100.523186">

                        <div id="map"></div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="delivery_address" id="delivery_address"
                                style="height: 100px; background-color: #2c2c2c; color: white;"
                                placeholder="รายละเอียดที่อยู่เพิ่มเติม" required></textarea>
                            <label for="delivery_address">รายละเอียดที่อยู่เพิ่มเติม (บ้านเลขที่, ซอย, ฯลฯ)</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit"
                                class="btn btn-primary-custom py-2 text-uppercase fw-bold">ยืนยันการยืม</button>
                            <a href="index.php" class="btn btn-outline-secondary">ยกเลิก</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        
        var map = L.map('map').setView([13.736717, 100.523186], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var marker = L.marker([13.736717, 100.523186], { draggable: true }).addTo(map);

        function updatePosition(lat, lng) {
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
        }

        marker.on('dragend', function (e) {
            var position = marker.getLatLng();
            updatePosition(position.lat, position.lng);
        });

        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            updatePosition(e.latlng.lat, e.latlng.lng);
        });

        
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                var newLatLng = new L.LatLng(lat, lng);
                marker.setLatLng(newLatLng);
                map.setView(newLatLng, 15);
                updatePosition(lat, lng);
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>