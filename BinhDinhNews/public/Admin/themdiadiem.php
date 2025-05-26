<?php
require "../../app/controller/loadsession.php";
if ($_SESSION['role'] < 1) {
    header("Location: ./firewall.php");
    exit();
}

include_once("../../app/model/DiaDiemDLDAO.php");
if (isset($_POST['them'])) {
    $ten = $_POST['tendiadiem'];
    $diachi = $_POST['diachi'];
    $loaihinh = $_POST['loaihinh'];
    $mota = $_POST['mota'];
    $tenfile = $_FILES['hinhanh']['name'];

    $dao = new DiaDiemDAO();
    $id_moi = $dao->them_DiaDiem_va_lay_ID($ten, $diachi, $loaihinh, $tenfile);

    // Tạo thư mục lưu ảnh
    $uploadDir = "../../public/images/imgDuLich/" . $id_moi;
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $path = $uploadDir . "/" . basename($tenfile);
    move_uploaded_file($_FILES['hinhanh']['tmp_name'], $path);

    // Ghi nội dung mô tả vào file .txt
    $txtPath = "../../app/dulich_data/" . $id_moi . ".txt";
    file_put_contents($txtPath, $mota);

    header("Location: dsdiadiem.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm địa điểm</title>
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
		
		.up_anh{
			width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;			
		}
		
        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
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
            <h2>Thêm địa điểm du lịch</h2>
			

            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="tendiadiem" placeholder="Tên địa điểm" required>
                <input type="text" name="diachi" placeholder="Địa chỉ" required>
     
				<select name="loaihinh" required>
                        <?php
							require_once "../../app/model/dulichDAO.php";

							$catDAO = new dulichDAO();
							$result = $catDAO->get_tatca_loaihinh();
                            while($row = mysqli_fetch_assoc($result))
                            {
                                echo '<option value="'.$row['LoaiHinhID'].'">' . $row['TenLoaiHinh'] . '</option>';

                            }
                            mysqli_free_result($result);
                        ?>
               </select>
				 <div class="up_anh">
			       <label> Chọn ảnh: </label>	
                   <input type="file" name="hinhanh" required>
				  </div> 
				<textarea name="mota" rows="8" placeholder="Giới thiệu chi tiết..." required></textarea>
                <button type="submit" name="them">Thêm địa điểm</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
