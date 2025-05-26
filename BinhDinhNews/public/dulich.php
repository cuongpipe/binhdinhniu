<!DOCTYPE html>

<?php
    include('../app/model/dulichDAO.php');
    $dlDAO =  new dulichDAO();
    $result = $dlDAO->get_tung_loaihinh($_GET['idcat']);
    if(mysqli_num_rows($result)> 0)
    {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $tenlh = $row['TenLoaiHinh'];
    }
    mysqli_free_result($result);
?>



<html lang="vi">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="./css/rightmenu-style.css">
      <link rel="stylesheet" href="./css/reset.css">
      <link rel="stylesheet" href="./css/footer-style.css">
      <link rel="stylesheet" href="./css/dulich.css">
      <link rel="stylesheet" href="./css/header-style.css">
      <script src="https://kit.fontawesome.com/8f5e4d2946.js" crossorigin="anonymous"></script>
      <link rel="icon" href="./images/logo.webp" type="image/x-icon">
      <script src="./scripts/homePage.js"></script>
      <title>
            <?php 
            if(isset($tenlh)) echo $tenlh; else echo "Không tìm thấy" 
        ?>

      </title>
</head>



<?php
    include('../app/views/partials/header.php');
?>

<body>

      <div class="container-loaihinh-dulich">
            <div class="container-left"></div>
            
            <div class="container-mid">
                 
				 <h1>
                   <?php if(isset($tenlh)) 
                      echo $tenlh; else echo "404 Không tìm thấy" 
                   ?>
                  </h1>
				  
                  <div class="container_cacdiadiem_dulich">
                   
				  
				   <?php
				   // hiện từng địa điểm
                    include('../app/model/DiaDiemDLDAO.php');
					$ddDAO = new DiaDiemDAO();
					
			
					//tính và hiện số địa điểm trên 1 trang 
                    $diadiem_tren1trang = 5;
                    $trang_hientai = isset($_GET['page']) ? $_GET['page'] : 1;
                    
                    $sql = "SELECT * FROM diadiem_dulich WHERE LoaiHinhID = " . $_GET['idcat']."
                            LIMIT " . $diadiem_tren1trang." OFFSET " . ($trang_hientai - 1) * $diadiem_tren1trang."";
							
					// LIMIT: số lượng dòng (địa điểm) hiển thị mỗi trang		
				    // OFFSET: xác định bắt đầu lấy từ dòng số bao nhiêu.
                   
				   $result_dd = $ddDAO->get_tatca_DiaDiem($sql);
                  
                    $total_articles = mysqli_num_rows(mysqli_query($ddDAO->getConnection(), "SELECT * FROM `diadiem_dulich` WHERE LoaiHinhID = ".$_GET['idcat'].""));
					
                    $total_pages = ceil($total_articles / $diadiem_tren1trang);
                    //ceil()dùng để làm tròn lên, vd: 10 địa điểm / 4 = 2.5 ⇒ cần 3 trang
     


                   while($row = mysqli_fetch_array($result_dd, MYSQLI_ASSOC))
                        // MYSQLI_ASSOC    Mảng kết hợp: dùng tên cột làm key
                    {
                        $filename = '../app/dulich_data/'.$row['DiaDiemID'].'.txt';
                        // $row thì là biến bạn gán từ mysqli_fetch_array(), nó chứa mảng dữ liệu trả về từ cơ sở dữ liệu.
                        $f = fopen($filename, 'r');
                        if($f)
                        {

                        }
                        else{
                            $content = "404 NOT FOUND FILE" . $filename;
                        }
						
                        if (empty($row['HinhAnh'])) {
                             $row['HinhAnh'] = 'default.jpg';
                             $row['TheLoaiID'] = 'default';
                        }

                       echo'
                        <div class="place-card">
                               <a href="./DiaDiemDL.php?id='.$row['DiaDiemID'].'">
                                
                                 <img src="./images/imgDuLich/' . $row['DiaDiemID']. '/' . $row['HinhAnh'] . '" alt="' . $row['HinhAnh'] . '">
                                 
                                 <div class="place-name">
                                    <h3>' . $row['TenDiaDiem'] . '</h3>
                                 </div>

                                 <div class="place-address">
                                    <p>' . $row['DiaChi'] . '</p>
                                 </div>
                              </a>
                        </div>
                        ';

                    
                    }
                  
                    mysqli_free_result($result_dd);  

                ?>


                </div>

              <?php
			  
                //nút điều hướng trang
				
                //require_once('../app/controller/phantrang_dulich.php');
                page_navigation($total_pages, $trang_hientai);
				
                function page_navigation($total_pages, $trang_hientai)
                {
                    echo '<div class="page-navigation">';
                    if ($trang_hientai > 1) {
                        echo '<a href="./dulich.php?idcat=' .
                            $_GET["idcat"] .
                            "&page=" .
                            ($trang_hientai - 1) .
                            '"><</a>';
                    }
                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i < $trang_hientai - 1 || $i > $trang_hientai + 1) {
                            continue;
                        }

                        if ($i == $trang_hientai) {
                            echo "<span>" . $i . "</span>";
                        } else {
                            echo '<a href="./dulich.php?idcat=' .
                                $_GET["idcat"] .
                                "&page=" .
                                $i .
                                '">' .
                                $i .
                                "</a>";
                        }
                    }
                    if ($trang_hientai < $total_pages) {
                        echo '<a href="./dulich.php?idcat=' .
                            $_GET["idcat"] .
                            "&page=" .
                            ($trang_hientai + 1) .
                            '">></a>';
                    }
                    echo "</div>";
                }

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