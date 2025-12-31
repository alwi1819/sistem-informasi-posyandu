<?php
include '../koneksi.php';
header("Content-Type: application/json");

// Cek koneksi
if (!$conn) {
    echo json_encode([
        'status' => false,
        'message' => 'Koneksi database gagal'
    ]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {

    $query = mysqli_query($conn, "SELECT * FROM balita");

    if (!$query) {
        echo json_encode([
            'status' => false,
            'message' => 'Query gagal',
            'error' => mysqli_error($conn)
        ]);
        exit;
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }

    echo json_encode([
        'status' => true,
        'data' => $data
    ]);
}
