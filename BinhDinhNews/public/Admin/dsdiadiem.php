<?php
require "../../app/controller/loadsession.php";
if ($_SESSION['role'] < 1) {
    header("Location: ./firewall.php");
    exit();
}

include_once("../../app/model/DiaDiemDLDAO.php");
$dao = new DiaDiemDAO();
$query = "SELECT * FROM diadiem_dulich";
$ds = $dao->get_tatca_DiaDiem($query);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý địa điểm du lịch</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/menu-admin.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f6f8fa;
            margin: 0;
        }

.main-container{
    display: grid;
    grid-template-columns: 20% 80%;
    grid-template-rows: 100%;
}

        .right-container {
            flex-grow: 1;
            padding: 20px 40px;
        }

        .container-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .container-header h1 {
            font-size: 28px;
            color: #333;
        }

        .btn-add {
            background-color: #28a745;
            border: none;
            padding: 10px 20px;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-add:hover {
            background-color: #218838;
        }

        .place-card {
            display: flex;
            align-items: flex-start;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: 0.3s;
        }

        .place-card:hover {
            transform: scale(1.01);
        }

        .place-img img {
            width: 180px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
        }

        .place-info {
            margin-left: 20px;
            flex-grow: 1;
        }

        .place-info h3 {
            margin-top: 0;
            color: #007BFF;
        }

        .place-info p {
            margin: 5px 0;
            color: #555;
        }

        .btn-group {
            margin-top: 10px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            margin-right: 10px;
        }

        .btn-edit {
            background-color: #ffc107;
            color: #fff;
        }

        .btn-edit:hover {
            background-color: #e0a800;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }
		
		.btn-view {
            background-color: blue;
            color: white;
        }

        .btn-view:hover {
            background-color: #167da6;
        }
		

        @media screen and (max-width: 768px) {
            .place-card {
                flex-direction: column;
                align-items: center;
            }
            .place-info {
                margin-left: 0;
                text-align: center;
            }
        }
		
		
    </style>
</head>
<body>
<div class="main-container">
    <div class="left-container">
        <?php include "../../app/views/left/menu-admin.php"; ?>
    </div>

    <div class="right-container">
        <div class="container-header">
            <h1>Địa điểm du lịch</h1>
            <a href="themdiadiem.php"><button class="btn-add"> + Thêm địa điểm </button></a>
        </div>

		<?php
		while ($item = mysqli_fetch_assoc($ds)) {
			echo '
			<div class="place-card">
				<div class="place-img">
					<img src="../images/imgDuLich/' . $item['DiaDiemID'] . '/' . $item['HinhAnh'] . '" 
						 alt="' . $item['TenDiaDiem'] . '">
				</div>
				<div class="place-info">
					<h3>' . $item['TenDiaDiem'] . '</h3>
					<p><strong>Địa chỉ:</strong> ' . $item['DiaChi'] . '</p>
					<div class="btn-group">
						<a href="suadiadiem.php?id=' . $item['DiaDiemID'] . '">
							<button class="btn btn-edit">Sửa</button>
						</a>
						<a href="xoadiadiem.php?id=' . $item['DiaDiemID'] . '" class="btn-delete-link">
							<button class="btn btn-delete">Xóa</button>
						</a>
						<a href="../DiaDiemDL.php?id=' . $item['DiaDiemID'] . '">
							<button class="btn btn-view">Xem</button>
						</a>
					</div>
				</div>
			</div>
			';
		}
		mysqli_free_result($ds);
		?>


	
    </div>
</div>

<script>
    document.querySelectorAll(".btn-delete-link").forEach(function(el) {
        el.addEventListener("click", function(e) {
            if (!confirm("Bạn có chắc chắn muốn xóa địa điểm này?")) {
                e.preventDefault();
            }
        });
    });
</script>
</body>
</html>
