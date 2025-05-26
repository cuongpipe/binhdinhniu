<?php
require "../../app/controller/loadsession.php";
if ($_SESSION['role'] < 1) {
    header("Location: ./firewall.php");
    exit();
}

require_once("../../app/model/DiaDiemDLDAO.php");
require_once("../../app/model/dulichDAO.php");

$dao = new DiaDiemDAO();
$catDAO = new dulichDAO();

if (!isset($_GET['id'])) {
    die("Thiếu ID địa điểm.");
}

$id = intval($_GET['id']);
$result = $dao->get_tung_DiaDiem($id);
$diaDiem = mysqli_fetch_assoc($result);
mysqli_free_result($result);

if (!$diaDiem) {
    die("Không tìm thấy địa điểm.");
}

// Đọc mô tả hiện có
$txtPath = "../../app/dulich_data/" . $id . ".txt";
$mota = file_exists($txtPath) ? file_get_contents($txtPath) : "";

// Xử lý khi nhấn "Lưu"
if (isset($_POST['luu'])) {
    $ten = $_POST['tendiadiem'];
    $diachi = $_POST['diachi'];
    $loaihinh = $_POST['loaihinh'];
    $mota = $_POST['mota'];

    $tenfile = $diaDiem['HinhAnh'];
    if ($_FILES['hinhanh']['name']) {
        $tenfile = $_FILES['hinhanh']['name'];
        $uploadDir = "../../public/images/imgDuLich/" . $id;
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $path = $uploadDir . "/" . basename($tenfile);
        move_uploaded_file($_FILES['hinhanh']['tmp_name'], $path);
    }

    // Cập nhật DB
    $conn = $dao->getConnection();
    $stmt = $conn->prepare("UPDATE diadiem_dulich SET TenDiaDiem=?, DiaChi=?, LoaiHinhID=?, HinhAnh=? WHERE DiaDiemID=?");
    $stmt->bind_param("ssisi", $ten, $diachi, $loaihinh, $tenfile, $id);
    $stmt->execute();
    $stmt->close();
    mysqli_close($conn);

    // Ghi lại mô tả
    file_put_contents($txtPath, $mota);

    header("Location: dsdiadiem.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa địa điểm</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/menu-admin.css">
    <style>
        .form-container {
            padding: 40px;
            max-width: 600px;
            margin: auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        }
        .form-container h2 {
            margin-bottom: 20px;
            color: #007BFF;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }
        .up_anh {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="main-container">
    <div class="left-container">
        <?php include "../../app/views/left/menu-admin.php"; ?>
    </div>
    <div class="right-container">
        <div class="form-container">
            <h2>Sửa địa điểm du lịch</h2>

            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="tendiadiem" value="<?= htmlspecialchars($diaDiem['TenDiaDiem']) ?>" required>
                <input type="text" name="diachi" value="<?= htmlspecialchars($diaDiem['DiaChi']) ?>" required>

                <select name="loaihinh" required>
                    <?php
                    $result = $catDAO->get_tatca_loaihinh();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $selected = ($row['LoaiHinhID'] == $diaDiem['LoaiHinhID']) ? 'selected' : '';
                        echo '<option value="' . $row['LoaiHinhID'] . '" ' . $selected . '>' . $row['TenLoaiHinh'] . '</option>';
                    }
                    mysqli_free_result($result);
                    ?>
                </select>

                <div class="up_anh">
                    <label>Chọn ảnh mới (nếu muốn):</label>
                    <input type="file" name="hinhanh">
                </div>

                <textarea name="mota" rows="8" required><?= htmlspecialchars($mota) ?></textarea>

                <button type="submit" name="luu">Lưu thay đổi</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
