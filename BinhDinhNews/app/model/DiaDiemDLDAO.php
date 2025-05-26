<?php
    // Gọi thư viện đã xây sẵn
    require_once $_SERVER['DOCUMENT_ROOT']. '/BinhDinhNews/app/config/database.php';
    class DiaDiemDAO{
        
        // get connection thông qua lớp Database Connection để tiện lợi hơn
        function getConnection()
        {
            $dbConnect =  new DatabaseConnection();
            return $dbConnect->getConnection();
        }
      
	  
        // lấy dữ liệu tất cả bài báo và trả về
        function get_tatca_DiaDiem($query)
        {
            // get connection
            $conn = $this->getConnection();
			
            // thực hiện query từ chuỗi query tham số
            $kqua = mysqli_query($conn,$query);
            // đóng kết nối
            mysqli_close($conn);

            return $kqua;
        }
		
        //lấy dữ liệu bài báo và trả về
        function get_tung_DiaDiem($id)
        {
            $conn = $this->getConnection();
            $sql = "SELECT * FROM `diadiem_dulich` WHERE diadiemID = ".$id."";
            $kqua = mysqli_query($conn, $sql);
            mysqli_close($conn);
            return $kqua;
        }   

		function them_DiaDiem_va_lay_ID($ten, $diachi, $loaihinh, $hinhanh) {
				$conn = $this->getConnection();
				$stmt = $conn->prepare("INSERT INTO diadiem_dulich (TenDiaDiem, DiaChi, LoaiHinhID, HinhAnh) VALUES (?, ?, ?, ?)");
				$stmt->bind_param("ssis", $ten, $diachi, $loaihinh, $hinhanh);
				$stmt->execute();
				$id = $stmt->insert_id;
				$stmt->close();
				$conn->close();
				return $id;
		}
		
		public function xoa_diadiem($id) {
			$conn = $this->getConnection();
			$stmt = $conn->prepare("DELETE FROM diadiem_dulich WHERE DiaDiemID = ?");
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->close();
			$conn->close();
		}
		
		public function capnhat_diadiem($id, $ten, $diachi, $loaihinh, $hinhanh) {
			$conn = $this->connect();
			$stmt = $conn->prepare("UPDATE diadiem SET TenDiaDiem=?, DiaChi=?, LoaiHinhID=?, HinhAnh=? WHERE DiaDiemID=?");
			$stmt->bind_param("ssisi", $ten, $diachi, $loaihinh, $hinhanh, $id);
			$stmt->execute();
			$stmt->close();
			$conn->close();
		}


    }
?>