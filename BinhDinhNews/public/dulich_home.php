<!DOCTYPE html>
<html lang="vi">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="./css/rightmenu-style.css">
      <link rel="stylesheet" href="./css/reset.css">
      <link rel="stylesheet" href="./css/footer-style.css">
      <link rel="stylesheet" href="./css/dulich_home.css">
      <link rel="stylesheet" href="./css/header-style.css">
      <script src="https://kit.fontawesome.com/8f5e4d2946.js" crossorigin="anonymous"></script>
      <link rel="icon" href="./images/logo.webp" type="image/x-icon">
      <script src="./scripts/homePage.js"></script>
      <title>
            Du lịch - Trang du lịch bình định
      </title>
</head>



<?php
    include('../app/views/partials/header.php');
?>

<body>

      <div class="container-loaihinh-dulich">
            <div class="container-left"></div>
            
<div class="container-mid">
    <h1>Danh sách các loại hình du lịch</h1>

    <?php
    require_once('../app/model/dulichDAO.php');
    require_once('../app/model/DiaDiemDLDAO.php');

    $dlDAO = new dulichDAO();
    $ddDAO = new DiaDiemDAO();

    $loaihinh_list = $dlDAO->get_tatca_loaihinh(); // lấy danh sách tất cả loại hình

    while ($loaihinh = mysqli_fetch_array($loaihinh_list, MYSQLI_ASSOC)) {
        //loaihinh block
		echo '<div class="loaihinh-block">';
			echo '<h2>' . $loaihinh['TenLoaiHinh'] . '</h2>';

			$sql_dd = "SELECT * FROM diadiem_dulich WHERE LoaiHinhID = " . $loaihinh['LoaiHinhID'] . " LIMIT 4";
			$diadiem_list = $ddDAO->get_tatca_DiaDiem($sql_dd);// lấy danh sách địa điểm
            
			// các địa điểm
			echo '<div class="diadiem-row">';
				while ($dd = mysqli_fetch_array($diadiem_list, MYSQLI_ASSOC)) {
					$img = empty($dd['HinhAnh']) ? 'default.jpg' : $dd['HinhAnh'];

					// echo '
						// <div class="place-card">
							// <a href="./DiaDiemDL.php?id=' . $dd['DiaDiemID'] . '">
								// <img src="./images/imgDuLich/' . $dd['DiaDiemID'] . '/' . $img . '" alt="' . $img . '">
								// <h4>' . $dd['TenDiaDiem'] . '</h4>
								// <p>' . $dd['DiaChi'] . '</p>
							// </a>
						// </div>';
						
						
					echo'
								<div class="place-card">
									   <a href="./DiaDiemDL.php?id='.$dd['DiaDiemID'].'">
										
										 <img src="./images/imgDuLich/' . $dd['DiaDiemID']. '/' . $img . '" alt="' . $img . '">
										 
										 <div class="place-name">
											<h3>' . $dd['TenDiaDiem'] . '</h3>
										 </div>

										 <div class="place-address">
											<p>' . $dd['DiaChi'] . '</p>
										 </div>
									  </a>
								</div>
								';
				}
			echo '</div>'; // đóng .diadiem-row
		 echo '<div class="xemthem">
		           <a href="./dulich.php?idcat=' . $loaihinh['LoaiHinhID'] . '"> Xem thêm &raquo; </a>
			</div>';
        echo '</div>'; // đóng .loaihinh-block
        mysqli_free_result($diadiem_list);
    }
    mysqli_free_result($loaihinh_list);
    ?>
</div>
			
            <div class="container-right">
                  <?php
                include("../app/views/right/homepage.php");
            ?>
            </div>
      </div>
</body>
<?php
        include('../app/views/partials/footer.php');
    ?>

</html>