<?php
include '../koneksi.php';
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($method) {
    case 'GET':
        if ($id) {
            // GET by ID
            $stmt = $conn->prepare("SELECT * FROM balita WHERE id_balita = ?");
            $stmt->bind_param("i", $id);
        } else {
            // GET all
            $stmt = $conn->prepare("SELECT * FROM balita");
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        
        echo json_encode(['status' => true, 'data' => $data]);
        break;
        
    case 'POST':
        // Tambah data baru
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("INSERT INTO balita (nama_balita, tanggal_lahir, jenis_kelamin, nama_ibu, alamat) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", 
            $input['nama_balita'],
            $input['tanggal_lahir'],
            $input['jenis_kelamin'],
            $input['nama_ibu'],
            $input['alamat']
        );
        
        if ($stmt->execute()) {
            echo json_encode(['status' => true, 'message' => 'Data berhasil ditambahkan', 'id' => $conn->insert_id]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal menambah data']);
        }
        break;
        
    case 'PUT':
        // Update data
        if (!$id) {
            echo json_encode(['status' => false, 'message' => 'ID diperlukan']);
            exit;
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("UPDATE balita SET nama_balita=?, tanggal_lahir=?, jenis_kelamin=?, nama_ibu=?, alamat=? WHERE id_balita=?");
        $stmt->bind_param("sssssi",
            $input['nama_balita'],
            $input['tanggal_lahir'],
            $input['jenis_kelamin'],
            $input['nama_ibu'],
            $input['alamat'],
            $id
        );
        
        if ($stmt->execute()) {
            echo json_encode(['status' => true, 'message' => 'Data berhasil diupdate']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal mengupdate data']);
        }
        break;
        
    case 'DELETE':
        // Hapus data
        if (!$id) {
            echo json_encode(['status' => false, 'message' => 'ID diperlukan']);
            exit;
        }
        
        $stmt = $conn->prepare("DELETE FROM balita WHERE id_balita = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => true, 'message' => 'Data berhasil dihapus']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal menghapus data']);
        }
        break;
        
    default:
        echo json_encode(['status' => false, 'message' => 'Method tidak diizinkan']);
        http_response_code(405);
}
?>