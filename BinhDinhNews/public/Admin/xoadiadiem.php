<?php
require "../../app/controller/loadsession.php";
if ($_SESSION['role'] < 1) {
    header("Location: ./firewall.php");
    exit();
}

require_once("../../app/model/DiaDiemDLDAO.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $dao = new DiaDiemDAO();
    $dao->xoa_diadiem($id); // chỉ xóa dòng theo id

    // Xoá thư mục ảnh theo ID
    $imgFolder = "../../public/images/imgDuLich/" . $id;
    if (is_dir($imgFolder)) {
        array_map('unlink', glob("$imgFolder/*"));
        rmdir($imgFolder);
    }

    // Xoá file mô tả txt theo ID
    $txtFile = "../../app/dulich_data/" . $id . ".txt";
    if (file_exists($txtFile)) {
        unlink($txtFile);
    }

    header("Location: dsdiadiem.php");
    exit();
} else {
    echo "Thiếu ID để xoá.";
}
?>
