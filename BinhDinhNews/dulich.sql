CREATE TABLE loaihinh_dulich ( 
    LoaiHinhIDID INT AUTO_INCREMENT PRIMARY KEY,
    TenLoaiHinh VARCHAR(255) -- Ví dụ: 'Tiềm năng du lịch', 'Lễ hội', 'Di tích lịch sử - Văn hóa',...
); 


CREATE table diadiem_dulich(
    DiaDiemID INT AUTO_INCREMENT PRIMARY KEY,
    TenDiaDiem VARCHAR(255) NOT NULL, -- Tên cụ thể của địa điểm (VD: Tháp Đôi, Kỳ Co...)
    DiaChi VARCHAR(255),             -- Địa chỉ cụ thể
    LoaiHinhID INT,                   -- Liên kết với thể loại ở bảng trên
    HinhAnh VARCHAR(255),           -- Đường dẫn đến ảnh (URL hoặc tên file ảnh)   
    FOREIGN KEY (LoaiHinhID) REFERENCES loaihinh_dulich(LoaiHinhID)
);


INSERT INTO loaihinh_dulich VALUES
(1, 'Danh lam - thắng cảnh'),
(2, 'Di tích lịch sử'),
(3, 'Khu du lịch'),
(4, 'Ẩm thực Bình Định');

ALTER TABLE diadiem_dulich AUTO_INCREMENT = 1;

INSERT INTO diadiem_dulich (TenDiaDiem, DiaChi,LoaiHinhID, HinhAnh) VALUES
-- Danh lam - thắng cảnh (TheLoaiID = 1)
('Eo Gió', 'Xã Nhơn Lý, TP Quy Nhơn', 1, 'eogio.jpg'),
('Ghềnh Ráng Tiên Sa', 'Phường Ghềnh Ráng, TP Quy Nhơn', 1, 'ghenhrang.jpg'),
('Bãi Xếp', 'Phường Ghềnh Ráng, TP Quy Nhơn', 1, 'baixep.jpg'),
('Đảo Cù Lao Xanh', 'Xã Nhơn Châu, TP Quy Nhơn', 1, 'culaoxanh.jpg'),
('Đồi Cát Phương Mai', 'Xã Nhơn Lý, TP Quy Nhơn', 1, 'phuongmai.jpg'),
('Hải đăng Hòn Nước', 'Xã Mỹ Thọ,Huyện Phù Mỹ', 1, 'haidang.jpg'),


-- Di tích lịch sử (TheLoaiID = 2)
('Tháp Bánh Ít', 'Phước Hiệp, Tuy Phước', 2, 'thapbanhit.jpg'),
('Bảo tàng Quang Trung', 'Thị trấn Phú Phong, Tây Sơn', 2, 'quangtrung.jpg'),
('Tháp Đôi', 'Đường Trần Hưng Đạo, TP Quy Nhơn', 2, 'thapdoi.jpg'),
('Thành cổ Đồ Bàn', 'An Nhơn, Bình Định', 2, 'doban.jpg'),
('Đàn tế Trời Đất', 'Tây Sơn, Bình Định', 2, 'dantetroi.jpg'),
('Di tích Gò Lăng', 'Phù Cát, Bình Định', 2, 'golang.jpg'),

-- Khu du lịch (TheLoaiID = 3)
('Kỳ Co', 'Xã Nhơn Lý, TP Quy Nhơn',  3, 'kyco.jpg'),
('Hòn Khô', 'Xã Nhơn Hải, TP Quy Nhơn', 3, 'honkho.jpg'),
('Khu dã ngoại Trung Lương', 'Xã Cát Tiến, Phù Cát', 3, 'trungluong.jpg'),
('Khu du lịch Hầm Hô', 'Xã Tây Phú, Tây Sơn', 3, 'hamho.jpg'),
('Safari FLC Zoo', 'Xã Nhơn Lý, TP Quy Nhơn', 3, 'flczoo.jpg'),
('Khu du lịch sinh thái Cửa Biển', 'TP Quy Nhơn', 3, 'cuabien.jpg'),

-- Ẩm thực Bình Định (TheLoaiID = 4)
('Bánh hỏi lòng heo Diêu Trì', 'Thị trấn Diêu Trì, Tuy Phước', 4, 'banhhoi.jpg'),
('Bún chả cá Quy Nhơn', 'TP Quy Nhơn', 4, 'buncha.jpg'),
('Bánh xèo tôm nhảy', 'TP Quy Nhơn', 4, 'banhxeo.jpg'),
('Nem chợ Huyện', 'An Nhơn, Bình Định', 4, 'nemchohuyen.jpg'),
('Chả ram tôm đất', 'Phù Mỹ, Bình Định', 4, 'charam.jpg'),
('Bánh ít lá gai', 'Tây Sơn, Bình Định', 4, 'banhitlagai.jpg');