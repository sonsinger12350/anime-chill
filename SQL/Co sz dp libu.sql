-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 25, 2022 lúc 07:42 AM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `gogoanime`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_admin`
--

CREATE TABLE `table_admin` (
  `id` int(10) NOT NULL,
  `username` varchar(155) DEFAULT NULL,
  `password` varchar(155) DEFAULT NULL,
  `last_login` varchar(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `table_admin`
--

INSERT INTO `table_admin` (`id`, `username`, `password`, `last_login`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '25/12/2022 - 11:51:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_ads`
--

CREATE TABLE `table_ads` (
  `id` int(10) NOT NULL,
  `position_name` varchar(255) DEFAULT NULL,
  `href` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'false',
  `click` int(10) NOT NULL DEFAULT 0,
  `num` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_category`
--

CREATE TABLE `table_category` (
  `id` int(10) NOT NULL,
  `name` varchar(155) DEFAULT NULL,
  `title` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `slug` varchar(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `table_category`
--

INSERT INTO `table_category` (`id`, `name`, `title`, `description`, `slug`) VALUES
(1, 'Phim 2D', 'Phim Hoạt Hình 2D', 'Phim Hoạt Hình 2D', 'anime'),
(2, 'Bí Ẩn', 'HHTQ thể loại bí ẩn mới nhất', 'HHTQ thể loại bí ẩn mới nhất', 'bi-an'),
(6, 'Kinh Dị', 'HHTQ thể loại kinh dị mới nhất', 'HHTQ thể loại kinh dị mới nhất', 'kinh-di'),
(7, 'Chuyển Sinh', 'HHTQ thể loại chuyển sinh mới nhất', 'HHTQ thể loại chuyển sinh mới nhất', 'chuyen-sinh'),
(8, 'Viễn Tưởng', 'HHTQ thể loại viễn tưởng mới nhất', 'HHTQ thể loại viễn tưởng mới nhất', 'vien-tuong'),
(9, 'Giả Tưởng', 'HHTQ thể loại giả tưởng mới nhất', 'HHTQ thể loại giả tưởng mới nhất', 'gia-tuong-hehe'),
(13, 'Hành Động', 'HHTQ thể loại hành động mới nhất', 'HHTQ thể loại hành động mới nhất', 'hanh-dong'),
(18, 'Phim 3D', 'Phim Hoạt Hình 3D', 'Phim Hoạt Hình 3D', 'cn-animation'),
(19, 'Huyền Ảo', 'HHTQ thể loại huyền Ảo mới nhất', 'HHTQ thể loại huyền Ảo mới nhất', 'huyen-ao'),
(20, 'Tu Tiên', 'HHTQ thể loại tu tiên mới nhất', 'HHTQ thể loại tu tiên mới nhất', 'tu-tien'),
(21, 'Đam Mỹ', 'HHTQ thể loại đam mỹ mới nhất', 'HHTQ thể loại đam mỹ  mới nhất', 'dam-my'),
(22, 'Xuyên Không', 'HHTQ thể loại xuyên không mới nhất', 'HHTQ thể loại xuyên không mới nhất', 'xuyen-khong'),
(23, 'Khoa Huyễn', 'HHTQ thể loại khoa huyễn mới nhất', 'HHTQ thể loại khoa huyễn mới nhất', 'khoa-huyen'),
(24, 'Võ Hiệp', 'HHTQ thể loại  võ hiệp mới nhất', 'HHTQ thể loại võ hiệp mới nhất', 'vo-hiep'),
(25, 'Hệ Thống', 'HHTQ thể loại hệ thống mới nhất', 'HHTQ thể loại hệ thống mới nhất', 'he-thong'),
(26, 'Luyện Cấp', 'HHTQ thể loại luyện cấp mới nhất', 'HHTQ thể loại luyện cấp mới nhất', 'luyen-cap'),
(27, 'Trùng Sinh', 'HHTQ thể loại trùng sinh mới nhất', 'HHTQ thể loại trùng sinh mới nhất', 'trung-sinh'),
(28, 'Tiên Hiệp', 'HHTQ thể loại tiên hiệp mới nhất', 'HHTQ thể loại tiên hiệp mới nhất', 'tien-hiep');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_comment`
--

CREATE TABLE `table_comment` (
  `id` int(10) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `movie_id` mediumtext DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `reply_comment` int(10) DEFAULT NULL,
  `reply_user_id` int(10) DEFAULT NULL,
  `show_cmt` varchar(15) NOT NULL DEFAULT 'true',
  `timestap` varchar(155) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_config`
--

CREATE TABLE `table_config` (
  `id` int(10) NOT NULL,
  `title` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `keyword` mediumtext DEFAULT NULL,
  `favico` varchar(355) DEFAULT NULL,
  `image` varchar(355) DEFAULT NULL,
  `logo` varchar(355) DEFAULT NULL,
  `terms` longtext DEFAULT NULL,
  `view` varchar(155) NOT NULL DEFAULT '0',
  `slider` varchar(10) NOT NULL DEFAULT 'true',
  `googletagmanager` longtext DEFAULT NULL,
  `fb_app_id` varchar(155) DEFAULT NULL,
  `google-site-verification` varchar(255) DEFAULT NULL,
  `limits` int(10) NOT NULL DEFAULT 20,
  `key_seo` longtext DEFAULT NULL,
  `cmt_on` varchar(50) NOT NULL DEFAULT 'true',
  `time_cache` int(10) NOT NULL DEFAULT 3,
  `tvc_on` varchar(50) NOT NULL DEFAULT 'false',
  `firewall` varchar(50) DEFAULT 'true',
  `script_footer` longtext DEFAULT NULL,
  `vast_link` varchar(255) NOT NULL,
  `vast_video` varchar(255) NOT NULL,
  `top_note` longtext DEFAULT NULL,
  `level_notice` int(10) NOT NULL DEFAULT 10,
  `top_chucmung` int(10) NOT NULL DEFAULT 10,
  `on_load_boxchat` varchar(50) NOT NULL DEFAULT 'false',
  `huong_dan` longtext DEFAULT NULL,
  `num_bxh` int(10) NOT NULL DEFAULT 20,
  `day` int(10) DEFAULT NULL,
  `background` varchar(255) NOT NULL DEFAULT 'https://i.imgur.com/ISitmiU.jpg',
  `baotri` varchar(50) NOT NULL DEFAULT 'false',
  `nominations_category` longtext DEFAULT '\'[]\'',
  `sign_up` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `table_config`
--

INSERT INTO `table_config` (`id`, `title`, `description`, `keyword`, `favico`, `image`, `logo`, `terms`, `view`, `slider`, `googletagmanager`, `fb_app_id`, `google-site-verification`, `limits`, `key_seo`, `cmt_on`, `time_cache`, `tvc_on`, `firewall`, `script_footer`, `vast_link`, `vast_video`, `top_note`, `level_notice`, `top_chucmung`, `on_load_boxchat`, `huong_dan`, `num_bxh`, `day`, `background`, `baotri`, `nominations_category`, `sign_up`) VALUES
(1, 'HHTQ.TV | Phim Hoạt Hình Trung Quốc', 'Để mang đến những bộ phim mới nhất, đội ngũ quản trị viên, biên tập viên cũng như cộng tác viên của Website hhtq.tv sẽ đảm bảo cập nhật, việt hóa những phim mới nhất một cách nhanh chóng và chính xác nhất. Nếu các bạn không tìm thấy bộ phim ưa thích, hãy liên hệ với bọn mình nhé.', '[{\"name\":\"[{&quot;name&quot;:&quot;anime vietsub, xem anime, vui ghe, naruto, vua hai tac, one piece, hoi phap su, fairy tail, bleach, dragon ball, dao hai tac&quot;,&quot;url&quot;:&quot;http://localhost&quot;}]\",\"url\":\"http://localhost\"}]', 'https://hhtq.tv/assets/upload/9JRBpYKqzlFderH1655239507.png', 'https://hhtq.tv/assets/upload/4x3cq3XAABa4iBU1655239528.jpeg', 'https://xem1080.com/assets/img/phim1080.png', '&lt;h1&gt;ĐIỀU KHOẢN SỬ DỤNG&lt;/h1&gt;&lt;/br&gt;\r\nChúng tôi không chịu trách nhiệm đối với bất kỳ nội dung nào được đăng tải trong trang web này. Mọi nội dung đều được sưu tầm và nhúng vào website tương tự như công cụ tìm kiếm Google hay những trang web tìm kiếm khác. Nếu có vấn đề liên quan đến bản quyền, vui lòng phản hồi (hhtqads@gmail.com) để chúng tôi tiến hành gỡ bỏ.&lt;br&gt;\r\nCác Điều khoản và Điều kiện sau đây được áp dụng cho việc sử dụng trang web và việc sử dụng toàn bộ thông tin, dữ liệu, chức năng và bất kỳ tài liệu nào khác trên trang web này.&lt;br&gt;\r\nCác nội dung pháp luật đầu tiên bạn cần nắm được khi sử dụng dịch vụ trên trang web HHTQ:&lt;br&gt;\r\n– Không đăng tải hay bình luận về các vấn đề chính trị, tôn giáo, sắc tộc.&lt;br&gt;\r\n– Không đăng tải hay bình luận các thông tin liên quan tới chính sách của Đảng và Nhà nước CHXHCN Việt Nam. . .&lt;br&gt;\r\n– Không lợi dụng để tiếp tay cho các hành động vi phạm pháp luật nước CHXHCN Việt Nam. .&lt;br&gt;\r\n– Không truyền bá các nội dung văn hoá phẩm bạo lực, đồi trụy, trái với thuần phong mỹ tục Việt Nam. \r\n&lt;h2&gt; GIỚI THIỆU DỊCH VỤ HHTQ. &lt;/h2&gt;&lt;br&gt;\r\nNội dung được cho phép xem thông qua các phương thức sau: (Gọi chung là Phương thức) .&lt;br&gt;\r\n1. Xem tại website HHTQ ( gọi tắt là Trang web HHTQ) .&lt;br&gt;\r\n2. Website liên kết và phân phối của HHTQ. .&lt;br&gt;\r\n3. Những website khác mà người sử dụng hoặc điều hành website được phép nhúng Video. .&lt;br&gt;\r\n4. Ứng dụng do HHTQ sở hữu, tính năng hoặc ứng dụng của HHTQ cài đặt trên các thiết bị. .&lt;br&gt;\r\nViệc bạn truy cập, duyệt và sử dụng Dịch vụ HHTQ (bao gồm truy cập Nội dung) bằng các Phương thức trên có nghĩa là bạn hoàn toàn đồng ý với Điều khoản sử dụng (“Điều khoản sử dụng” hoặc “Điều khoản”) và bất kì thỏa thuận cấp phép khác dành cho người sử dụng đầu cuối được đi kèm với các ứng dụng của HHTQ, tính năng hoặc thiết bị. \r\n&lt;h2&gt; CHẤP NHẬN ĐIỀU KHOẢN SỬ DỤNG VÀ SỬA ĐỔI.&lt;/h2&gt;&lt;br&gt;\r\nChúng tôi hân hạnh mang đến Dịch vụ HHTQ phục vụ nhu cầu giải trí, thưởng thức cá nhân của bạn phù hợp với Điều Khoản Sử Dụng này. Để truy cập và thưởng thức Dịch vụ HHTQ, bạn phải đồng ý và tuân theo các điều khoản và điều kiện được quy định tại Điều Khoản Sử Dụng. Việc bạn lướt web, truy cập hoặc sử dụng bất kì Dịch Vụ HHTQ nào (bao gồm việc tiếp cận Nội dung từ các website liên kết, ứng dụng của HHTQ) phải tuân theo các điều khoản và điều kiện sau đây và bất kì điều khoản, điều kiện hoặc hướng dẫn nào khác được quy định tại trang Web này, cũng như tất cả các luật, quy tắc và quy định hiện hành, bao gồm nhưng không giới hạn trong những luật về thương hiệu, bản quyền, quyền riêng tư. BẰNG VIỆC SỬ DỤNG DỊCH VỤ HHTQ, BẠN CHẤP NHẬN VÀ ĐỒNG Ý BỊ RÀNG BUỘC BỞI CÁC ĐIỀU KHOẢN VÀ TẤT CẢ CÁC LUẬT HIỆN HÀNH. Do đó, chúng tôi yêu cầu bạn đọc kỹ các điều khoản được quy định ở đây. Nếu bạn không đồng ý và không muốn bị ràng buộc bởi các điều khoản này, bạn không nên sử dụng dịch vụ của chúng tôi. Nếu bạn có bất kì câu hỏi hoặc phản ánh nào về Điều Khoản Sử Dụng, vui lòng liên hệ với chúng tôi theo địa chỉ hhtqads@gmail.com.&lt;br&gt;\r\nChúng tôi bảo lưu quyền cải tiến, thay đổi, tạm ngưng hoặc tạm thời ngưng toàn bộ hoặc bất kì phần nào của Dịch vụ HHTQ hoặc hạn chế truy cập vào dịch vụ. Bằng việc sử dụng Dịch vụ HHTQ, quý khách đồng ý trước rằng mỗi lần sử dụng sẽ tuân thủ theo các điều khoản và điều kiện áp dụng sau đó. .&lt;br&gt;\r\nChúng tôi có thể bổ sung, sửa đổi Điều khoản sử dụng vào bất cứ lúc nào bằng cách cập nhật sự thay đổi Điều Khoản Sử Dụng ở bên dưới trang Web và thông báo cho các bạn về sự thay đổi đó. \r\n&lt;h2&gt;TRUY CẬP VÀ SỬ DỤNG DỊCH VỤ HHTQ.&lt;/h2&gt;&lt;br&gt;\r\nGiới hạn độ tuổi. Nếu bạn dưới 13 tuổi bạn không được phép sử dụng Dịch vụ HHTQ dưới bất kì Phương thức nào có yêu cầu đăng kí sử dụng. Nếu bạn đăng kí một tài khoản sử dụng HHTQ, có nghĩa là bạn đã trên 13 tuổi và bạn sẽ chịu trách nhiệm về thông tin mình cung cấp cho HHTQ. .&lt;br&gt;\r\nGiấy phép của bạn. HHTQ hân hạnh cấp cho bạn một giấy phép có giới hạn không độc quyền để sử dụng Dịch vụ HHTQ bằng các Phương thức (máy tính, điện thoại, tivi, thiết bị kết nối inteet), bao gồm việc truy cập, gửi nội dung và xem Nội Dung chỉ trên hệ thống streaming và Video Player của chúng tôi phục vụ mục đích cá nhân, không vì mục đích thương mại. .&lt;br&gt;\r\nNội dung. Bạn chỉ được truy cập và xem nội dung cho nhu cầu cá nhân và cho mục đích phi thương mại phù hợp với các Điều khoản này. Bạn không được phép trực tiếp hoặc gián tiếp sử dụng bất kỳ thiết bị, phần mềm, trang web inteet, dịch vụ dựa trên web, hoặc các phương tiện khác để gỡ bỏ, thay đổi, bỏ qua, lẩn tránh, cản trở, hoặc phá hoại bất kỳ bản quyền, thương hiệu, hoặc các dấu hiệu về quyền sở hữu khác được đánh dấu trên Nội dung (như logo) hoặc bất kỳ hệ thống kiểm soát dữ liệu, thiết bị, biện pháp bảo vệ nội dung khác cũng như các biện pháp hạn chế truy cập từ các vùng địa lý khác nhau. .&lt;br&gt;\r\nBạn không được phép trực tiếp hoặc gián tiếp thông qua bất kỳ thiết bị, phần mềm, trang web inteet, dịch vụ dựa trên web, hoặc các phương tiện khác để sao chép, tải về, chụp lại, sản xuất lại, nhân bản, lưu trữ, phân phối, tải lên, xuất bản, sửa đổi, dịch thuật, phát sóng , trình chiếu, hiển thị, bán, truyền tải hoặc truyền lại nội dung trừ khi được sự cho phép của HHTQ bằng văn bản. .&lt;br&gt;\r\nHơn nữa, bạn không được phép tạo ra, tái tạo, phân phối hay quảng cáo một chi tiết của bất kỳ nội dung trừ khi được phép của HHTQ. Bạn không được phép xây dựng mô hình kinh doanh sử dụng các Nội dung cho dù là có hoặc không vì lợi nhuận. Nội dung được đề cập ở đây bao gồm nhưng không giới hạn bất kỳ văn bản, đồ họa, hình ảnh, bố trí, giao diện, biểu tượng, hình ảnh, tài liệu âm thanh và video, và ảnh tĩnh. Ngoài ra, chúng tôi nghiêm cấm việc tạo ra các sản phẩm phát sinh hoặc vật liệu có nguồn gốc từ hoặc dựa trên bất kì Nội dung nào bao gồm dựng phim, làm video tương tự, hình nền, chủ đề máy tính, thiệp chúc mừng, và hàng hóa, trừ khi nó được sự cho phép của HHTQ bằng văn bản. Điều nghiêm cấm này áp dụng trong mọi trường hợp. .&lt;br&gt;\r\nVideo Player. Bạn không được phép chỉnh sửa, nâng cao, loại bỏ, can thiệp, hoặc thay đổi trong bất kỳ cách nào bất kỳ phần nào của Video Player, công nghệ hạ tầng của nó, bất kỳ cơ chế quản lý quyền kỹ thuật số, thiết bị, hoặc biện pháp bảo vệ nội dung, biện pháp kiểm soát truy cập tích hợp vào Video Player. Hạn chế này bao gồm nhưng không giới hạn việc vô hiệu hóa, kỹ thuật đảo ngược, sửa đổi, can thiệp hoặc phá vỡ Video Player bằng bất cứ cách nào làm cho người dùng xem được nội dung mà không có: (i) hiển thị rõ ràng cả Video Player và tất cả các yếu tố xung quanh (bao gồm cả giao diện người dùng đồ họa, bất kì quảng cáo, thông báo bản quyền và thương hiệu) của trang web, (ii) truy cập vào tất cả các chức năng của Video Player bao gồm nhưng không giới hạn tất cả chất lượng video và màn hình hiển thị chức năng, tương tác, tự chọn, hoặc nhấp chuột thông qua quảng cáo chức năng. .&lt;br&gt;\r\nNhúng Video. Chúng tôi đưa ra giải pháp để liên kết với Nội dung trên Dịch vụ HHTQ bằng công cụ Chia sẽ dưới mỗi video nội dung. Bạn có thể nhúng video bằng cách sử dụng Link chúng tôi cung cấp chạy trên Video Player của chúng tôi, miễn là bạn không nhúng Video Player trên bất kì trang web hoặc nơi nào khác vi phạm những điều sau: (i) có chứa hoặc lưu trữ nội dung trái pháp luật, vi phạm, khiêu dâm, tục tĩu, phỉ báng, bôi nhọ, đe dọa, quấy rối, khiếm nhã, không đứng đắn, xúc phạm, hận thù, tấn công phân biệt chủng tộc hoặc dân tộc, khuyến khích hành vi tội ác, làm phát sinh trách nhiệm dân sự, vi phạm luật pháp, nguyên tắc hay quy định, vi phạm bất kỳ quyền của bất kỳ bên thứ ba bao gồm cả quyền sở hữu trí tuệ, hoặc là không thích hợp hoặc gây phản đối tới HHTQ (tùy theo quyết định của HHTQ), hoặc (ii) liên kết vi phạm hoặc nội dung trái phép. Bạn không được nhúng Video Player vào bất kỳ phần cứng hoặc phần mềm ứng dụng, ngay cả đối với mục đích phi thương mại. HHTQ bảo lưu quyền ngăn chặn nhúng vào bất kỳ trang web hoặc địa điểm khác mà HHTQ nhận thấy không phù hợp hoặc có thể bị phản đối (được xác định bởi HHTQ). .&lt;br&gt;\r\nQuyền sở hữu. Bạn đồng ý rằng HHTQ sở hữu và giữ lại tất cả quyền đối với Dịch Vụ HHTQ. Bạn cũng đồng ý rằng Nội dung bạn truy cập và xem như là một phần của Dịch vụ HHTQ được sở hữu hoặc kiểm soát bởi HHTQ và bên cấp phép của HHTQ. .&lt;br&gt;\r\nDịch vụ HHTQ và Nội dung được bảo vệ bởi bản quyền, nhãn hiệu và luật sở hữu trí tuệ khác. .&lt;br&gt;\r\nTrách nhiệm của bạn. Để giữ Dịch vụ HHTQ an toàn và có sẵn cho tất cả mọi người sử dụng, tất cả chúng ta đều phải thực hiện theo những luật lệ như nhau. Bạn và người dùng khác phải sử dụng Dịch vụ HHTQ hợp pháp, phi thương mại, với mục đích thích hợp. Cam kết của bạn với nguyên tắc này là rất quan trọng. Bạn đồng ý thực hiện các điều khoản về dịch vụ HHTQ, Nội dung, Video Player và hạn chế nhúng Video ở trên, và đồng ý thêm rằng bạn sẽ không truy cập vào trang web HHTQ hoặc sử dụng Dịch vụ HHTQ trong bất kì cách nào mà: .&lt;br&gt;\r\n– Vi phạm quyền của người khác, bao gồm bằng sáng chế, thương hiệu, bí mật thương mại, quyền tác giả, quyền riêng tư, công khai, hoặc quyền sở hữu khác; .&lt;br&gt;\r\n– Sử dụng công nghệ hoặc các phương tiện khác để truy cập hoặc liên kết đến Dịch vụ HHTQ (bao gồm cả nội dung) mà không được phép của HHTQ (bao gồm cả bằng cách loại bỏ, vô hiệu hóa, bỏ qua, hoặc phá vỡ bất kỳ sự bảo vệ nội dung hoặc các cơ chế kiểm soát truy cập nhằm mục đích để ngăn chặn tải về trái phép, chụp dòng, liên kết, truy cập, hoặc phân phối của Dịch vụ HHTQ); .&lt;br&gt;\r\n– Liên quan đến việc truy cập vào Dịch vụ HHTQ (bao gồm cả nội dung) thông qua bất kỳ công cụ tự động, bao gồm cả “robot”, “spiders”, hoặc “độc giả ẩn” .&lt;br&gt;\r\nCài mã độc, virus hoặc các mã số máy tính khác, các tập tin, hoặc các chương trình gây cản trở, phá hỏng hoặc hạn chế các chức năng của bất kỳ phần mềm hoặc phần cứng trên máy tính hoặc thiết bị viễn thông; phá hoại, vô hiệu hóa, làm quá tải, làm suy yếu, hoặc làm tăng truy cập trái phép Dịch vụ HHTQ, bao gồm cả máy chủ HHTQ, mạng máy tính, hoặc các tài khoản người dùng; gỡ bỏ, chỉnh sửa, vô hiệu hóa, che khuất hoặc làm suy yếu bất kỳ quảng cáo trong kết nối với Dịch vụ HHTQ (bao gồm cả nội dung); sử dụng Dịch vụ HHTQ để quảng cáo hoặc quảng bá các dịch vụ không được chấp thuận trước bằng văn bản rõ ràng của HHTQ; thu thập những thông tin cá nhân vi phạm Chính sách bảo mật của HHTQ; khuyến khích hành vi phạm tội hoặc làm phát sinh trách nhiệm dân sự; vi phạm những điều khoản hoặc bất kỳ hướng dẫn hoặc chính sách được quy định bởi HHTQ; can thiệp đến việc sử dụng và thưởng thức Dịch vụ HHTQ của những người khác; cố gắng làm bất kì việc nào trong những việc trên. .&lt;br&gt;\r\nNếu HHTQ xác định được rằng bạn đang vi phạm Điều khoản này, chúng tôi có thể (i) thông báo cho bạn, và (ii) sử dụng các biện pháp kỹ thuật để ngăn chặn hoặc hạn chế sự truy cập, sử dụng dịch vụ HHTQ của bạn. Trong cả hai trường hợp, bạn đồng ý ngay lập tức ngừng truy cập hoặc sử dụng Dịch vụ HHTQ bằng bất kì cách nào, và bạn đồng ý không phá vỡ, hoặc bỏ qua những hạn chế như vậy, hoặc cố gắng để khôi phục lại sự truy cập hoặc sử dụng. .&lt;br&gt;\r\nKhông Spam/ Nhắn tin quảng cáo. Không ai được phép sử dụng Dịch vụ HHTQ để thu thập thông tin về người dùng cho mục đích gửi thư từ, hoặc để tạo điều kiện khuyến khích việc gửi thư số lượng lớn. Bạn hiểu rằng chúng tôi có thể thực hiện bất kỳ biện pháp kỹ thuật để ngăn chặn Spam. Nếu bạn Đăng tải (theo quy định tại mục 6 dưới đây) hoặc gửi thư rác, quảng cáo, hoặc các thông tin liên lạc không được yêu cầu khác dưới bất kì loại nào thông qua Dịch vụ HHTQ, bạn thừa nhận rằng bạn sẽ gây ra thiệt hại đáng kể cho HHTQ và số lượng tác hại như vậy sẽ là vô cùng khó khăn để đo lường. Mức ước lượng hợp lý cho những thiệt hại như vậy bạn đồng ý sẽ bồi thường là 500.000 cho mỗi thông tin liên lạc mà bạn gửi thông qua dịch vụ HHTQ. .&lt;br&gt;\r\nTải nội dung. Để tham gia Dịch vụ HHTQ hoặc xem nội dung, bạn có thể được yêu cầu phải download phần mềm hoặc những vật liệu khác hoặc đồng ý với các điều khoản và điều kiện bổ sung. .&lt;br&gt;\r\nĐình chỉ/ ngưng. Chúng tôi có thể thay đổi, đình chỉ, hoặc ngừng tạm thời hoặc vĩnh viễn một số hoặc tất cả các Dịch vụ HHTQ (bao gồm cả nội dung và các thiết bị được truy cập thông qua đó các dịch vụ HHTQ), đối với bất kỳ hoặc tất cả người sử dụng, bất cứ lúc nào mà không cần thông báo. Bạn thừa nhận HHTQ có thể làm như vậy tùy theo quyết định của HHTQ. Bạn cũng đồng ý rằng HHTQ sẽ không có trách nhiệm với bạn cho bất kỳ sửa đổi, đình chỉ, hoặc ngừng cung cấp Dịch vụ HHTQ, mặc dù nếu bạn là một thuê bao HHTQ Premier và HHTQ đình chỉ hoặc không tiếp tục cung cấp dịch vụ HHTQ, HHTQ có thể tùy theo quyết định của mình sẽ hoàn lại tiền, chiết khấu hoặc các hình thức khác. Tuy nhiên, nếu HHTQ chấm dứt hoặc đình chỉ tài khoản của bạn hoặc từ bỏ truy cập của bạn do bạn vi phạm các Điều khoản này thì bạn sẽ không thể được bồi hoàn tiền, giảm giá hoặc các hình thức khác. .&lt;br&gt;\r\nDịch vụ khách hàng. Nếu bạn cần trợ giúp, xin vui lòng liên hệ với bộ phận dịch vụ khách hàng của chúng tôi theo địa chỉ : hhtqads@gmail.com.\r\nTÀI KHOẢN VÀ ĐĂNG KÍ&lt;br&gt;\r\nMột số nội dung tại HHTQ được miễn phí hoàn toàn cho người dùng. Khi bạn sử dụng dịch vụ của HHTQ có nghĩa là bạn đồng ý với việc tuân theo các điều khoản và điều kiện quy định dưới đây. &lt;br&gt;\r\nĐể sử dụng một số tính năng khác của dịch vụ HHTQ, các bạn phải có tài khoản HHTQ hoặc tạo tài khoản tại HHTQ (nếu chưa có tài khoản HHTQ). Nếu bạn đồng ý đăng kí hoặc tạo tài khoản mới để sử dụng dịch vụ của chúng tôi điều đó đồng nghĩa với việc bạn chấp nhận tuân theo các điều khoản và điều kiện quy định dưới đây. &lt;br&gt;\r\nThông tin về tài khoản của bạn phải được cung cấp đầy đủ, chính xác và cập nhật nhất. Vui lòng giữ bí mật mật khẩu của bạn, bạn không nên tiết lộ cho bất kì ai thông tin mật khẩu. Bạn sẽ phải chịu trách nhiệm cho tất cả việc sử dụng dịch vụ từ tài khoản của bạn. Xin vui lòng thông báo cho chúng tôi bằng cách nhấn vào ĐÂY nếu bạn nghi ngờ bất kỳ việc sử dụng trái phép tài khoản của bạn. Hãy đảm bảo cập nhật cho chúng tôi thông tin mới nhất trong bảng đăng kí của bạn để chúng tôi có thể liên lạc với bạn trong trường hợp cần thiết. &lt;br&gt;\r\nChúng tôi có quyền ngay lập tức chấm dứt hoặc khóa tài khoản của bạn hoặc việc sử dụng Dịch vụ HHTQ hoặc truy cập vào nội dung ở bất kỳ thời điểm nào mà không cần thông báo hoặc có trách nhiệm, nếu HHTQ xác định rằng bạn đã vi phạm các Điều khoản sử dụng, vi phạm luật pháp, quy tắc, quy định, tham gia vào các hành vi không thích hợp khác, hoặc vì lý do kinh doanh khác. Chúng tôi cũng có quyền chấm dứt tài khoản của bạn hoặc việc sử dụng của Dịch vụ HHTQ hoặc truy cập vào các nội dung nếu việc sử dụng gây quá tải cho máy chủ của chúng tôi. Trong một số trường hợp, chúng tôi có quyền sử dụng công nghệ để hạn chế hoạt động như là giới hạn số lượt truy cập đến máy chủ HHTQ hoặc dung lượng sử dụng của người dùng. Bạn đồng ý tôn trọng những giới hạn và không có bất kì hành động nào để phá vỡ, lẩn tránh hoặc bỏ qua chúng. \r\n&lt;h2&gt; ĐĂNG TẢI VÀ QUẢN LÝ NỘI DUNG CỦA BẠN &lt;/h2&gt; &lt;br&gt;\r\nKhi đăng kí sử dụng dịch vụ HHTQ bạn có thể được cấp quyền upload nội dung lên HHTQ. Việc cấp quyền upload nội dung hoàn toàn do ban biên tập của HHTQ xem xét và quyết định. Bạn hiểu rằng HHTQ không đảm bảo bất kì sự bí mật nào đối với nội dung bạn đăng tải. &lt;br&gt;\r\nBạn phải chịu trách nhiệm về nội dung của riêng bạn và hậu quả của việc đăng tải và xuất bản nội dung của bạn trên Dịch vụ HHTQ. Bạn khẳng định, đại diện, và đảm bảo rằng bạn sở hữu hoặc có các giấy phép cần thiết, quyền, sự đồng ý và cho phép để xuất bản nội dung bạn đã gửi lên, và cấp phép cho HHTQ tất cả bằng sáng chế, thương mại, bí mật thương mại, hoặc quyền sở hữu khác liên quan đến Nội dung để phổ biến nội dung trên dịch vụ HHTQ theo các Điều khoản Dịch vụ. &lt;br&gt;\r\nRõ ràng rằng bạn giữ lại tất cả quyền sở hữu nội dung của bạn. Tuy nhiên, việc gửi nội dung lên HHTQ đồng nghĩa với việc bạn cấp cho HHTQ một giấy phép truyền tải nội dung không độc quyền, miễn phí bản quyền để sử dụng, tái xuất bản, phân phối lại, chuẩn bị các sản phẩm phát sinh, hiển thị và thực hiện các nội dung liên quan đến dịch vụ và mô hình kinh doanh của HHTQ bao gồm nhưng không giới hạn cho việc thúc đẩy và phân phối lại một phần hoặc toàn bộ Dịch vụ (và các sản phẩm phát sinh của chúng) trong bất kỳ định dạng phương tiện truyền thông và thông qua bất kỳ kênh truyền thông nào. Bạn cũng đồng ý cấp cho từng người dùng của dịch vụ HHTQ một giấy phép không độc quyền để truy cập vào nội dung của bạn thông qua Dịch vụ và sử dụng, tái sản xuất, phân phối, hiển thị và thực hiện các nội dung như thông qua các chức năng của Dịch vụ và theo các Điều khoản Dịch vụ cho phép. Giấy phép cấp trên của bạn trong nội dung video bạn gửi cho Dịch vụ sẽ chấm dứt trong một thời gian hợp lý về mặt thương mại sau khi bạn loại bỏ hoặc xóa các video của bạn khỏi các dịch vụ. Bạn hiểu và đồng ý, tuy nhiên, rằng HHTQ có thể giữ lại, nhưng không hiển thị, phân phối, hoặc thực hiện, bản sao máy chủ video của bạn đã được gỡ bỏ hoặc bị xóa. &lt;br&gt;\r\nBạn cũng đồng ý rằng Nội dung bạn gửi cho Dịch vụ sẽ không chứa một phần nội dung nào của bên thứ ba có bản quyền về vật chất, hoặc vật liệu là đối tượng để các quyền khác của bên thứ ba độc quyền, trừ khi bạn có sự cho phép của chủ sở hữu hợp pháp của vật liệu hoặc bạn có quyền hợp pháp để đăng các vật chất và cấp HHTQ tất cả các quyền cấp phép được cấp ở đây. &lt;br&gt;\r\nBạn cũng đồng ý rằng bạn sẽ không gửi lên Dịch vụ các Nội dung hoặc bất kỳ tài liệu khác nào trái với Nguyên tắc cộng đồng của HHTQ (bên dưới cùng trang Web và nguyên tắc này có thể được cập nhật theo thời gian), hoặc trái với luật và quy định áp dụng ở địa phương, quốc gia và quốc tế. &lt;br&gt;\r\nHHTQ không chứng thực bất kỳ nội dung được gửi lên Dịch Vụ bởi bất kỳ người sử dụng hoặc người cấp phép nào, hoặc bất kỳ ý kiến, đề nghị, hoặc tư vấn, và HHTQ rõ ràng từ chối bất kỳ và tất cả các trách nhiệm pháp lý trong việc kết nối với nội dung. HHTQ không cho phép các hoạt động vi phạm bản quyền và xâm phạm quyền sở hữu trí tuệ trên Dịch vụ, và HHTQ sẽ loại bỏ tất cả các nội dung nếu được thông báo rằng những nội dung vi phạm quyền sở hữu trí tuệ khác. HHTQ có quyền bỏ nội dung mà không cần thông báo trước.\r\n&lt;/h2&gt; ĐÁNH GIÁ, Ý KIẾN CỦA NGƯỜI DÙNG &lt;/h2&gt; &lt;br&gt;\r\nBài viết của bạn. Là một phần của Dịch vụ HHTQ, người dùng có cơ hội xuất bản, truyền tải, gửi đi, hoặc đăng tải (Gọi chung là “Đăng tải”) những đánh giá, ý kiến, hoặc những tài liệu khác (gọi chung là “Bài viết”). Để đảm bảo Dịch vụ HHTQ hấp dẫn và dành cho tất cả mọi người, bạn phải tuân thủ các quy tắc dưới dây. &lt;br&gt;\r\nXin vui lòng lựa chọn cẩn thận Bài viết mà bạn muốn gửi lên. Hãy giới hạn ngôn từ và nội dung của Bài viết để liên quan trực tiếp đến Dịch vụ HHTQ. Ngoài ra, bạn không được phép Đăng tải những Bài viết có tính chất: (i) chứa những thông tin không phù hợp (Được xác định ở phần 3); hoặc (ii) tuyên bố danh tính của người khác một cách không đúng. Xin lưu ý rằng chúng tôi sử dụng tên tài khoản của bạn để đại diện cho bạn và có thể được nhìn thấy bởi tất cả mọi người, do đó bạn không nên Đăng thông tin cá nhân như địa chỉ mail, số điện thoại, địa chỉ …&lt;br&gt;\r\nBạn phải là người đầu tiên Đăng tải hoặc có sự cho phép từ chủ sở hữu hợp pháp của bất kỳ Bài viết bạn Đăng tải. Khi bạn Đăng tải một Bài viết nào bạn đại điện và đảm bảo rằng bạn sở hữu chúng và rằng bạn không vi phạm bất kỳ quyền của bên nào, bao gồm cả quyền riêng tư, quyền công khai, quyền sở hữu trí tuệ. Ngoài ra bạn đồng ý chịu trách nhiệm chi phí cho tất cả bản quyền, lệ phí và khoản thanh toán cho bất kỳ bên nào nếu có liên quan đến Bài viết đăng tải của bạn. HHTQ sẽ loại bỏ tất cả các Bài viết nào mà chúng tôi được thông báo rằng có vi phạm quyền của người khác. Bạn thừa nhận rằng HHTQ không đảm bảo bất kỳ bí mật đối với bất kỳ Bài viết nào. &lt;br&gt;\r\nKhi đăng tải bài viết trên HHTQ, bạn cấp cho HHTQ một giấy phép sử dụng, hiển thị, tái xuất bản, phân phối, chỉnh sửa, xóa, thêm vào, chỉnh sửa để tái xuất bản, thực hiện công khai, và xuất bản bài viết thông qua dịch vụ của HHTQ trên toàn thế giới, vĩnh viễn và dưới bất kì định dạng truyền thông nào hiện nay vào sau này. Chúng tôi không phải chịu bất kì chi phí nào cho việc sử dụng các bài viết của bạn. Ngoài ra bạn đồng ý rằng cấp một giấy phép tương tự cho đối tác của HHTQ và người dùng. &lt;br&gt;\r\nBài viết của Bên Thứ Ba. Mặc dù có những hạn chế, xin vui lòng lưu ý rằng một số bài viết được Đăng tải bởi người sử dụng có thể gây phản đối, bất hợp pháp, không chính xác, hoặc không phù hợp. HHTQ không có trách nhiệm cho bất kỳ bài viết nào, và bài viết được đăng không phản ánh quan điểm hay chính sách của HHTQ. Chúng tôi có quyền, nhưng không có nghĩa vụ, giám sát Bài viết và hạn chế hoặc loại bỏ các Bài viết mà tùy theo quyết định của chúng tôi là không phù hợp hoặc vì bất kỳ lý do kinh doanh khác. &lt;br&gt;\r\nHHTQ không phải chịu trách nhiệm cho bất kỳ Bài viết nào của người dùng. Bạn có thể thông báo cho chúng tôi về các Bài viết không phù hợp mà bạn tìm thấy. Nếu một tính năng “báo cáo” thông qua Dịch vụ HHTQ không có sẵn cho một trường hợp cụ thể, xin vui lòng phản hồi qua email Info@cuaban.info (dòng tiêu đề: “Báo cáo nội dung không phù hợp”). \r\n&lt;h2&gt;  ĐƯỜNG DẪN (LINK) VÀ QUẢNG CÁO &lt;/h2&gt; &lt;br&gt;\r\nĐường dẫn. Nếu chúng tôi cung cấp các liên kết hoặc con trỏ đến các website khác, bạn không nên suy luận rằng HHTQ hoạt động, kiểm soát hoặc kết nối với những website này. Liên kết của bạn đến các trang khác hoàn toàn có thể gặp rủi ro, nguy hiểm. Khi bạn bấm vào một liên kết, chúng tôi sẽ không đưa ra cảnh báo rằng bạn phải rời khỏi dịch vụ HHTQ. Bạn phải chịu trách nhiệm cho việc truy cập và tuân thủ các giới hạn và điều khoản, các điều khoản bí mật thông tin và các chú ý pháp lý khác được quy định tại các trang liên kết này. HHTQ không chấp nhận bảo đảm, các hiển thị hoặc ngụ ý, liên quan đến sự chính xác, thời hạn, tính pháp lý hoặc các tài nguyên khác hoặc các thông tin chứa đựng trên các trang web này&lt;br&gt;\r\nHHTQ không chịu trách nhiệm về nội dung của bất kì website hoặc điểm đến nào ngoài trang HHTQ. Khi sử dụng Dịch vụ HHTQ, bạn nhận thức được và đồng ý rằng HHTQ không có trách nhiệm với bạn về bất kì nội dung hoặc tài liệu nào được lưu trữ và phục vụ từ trang web khác ngoài HHTQ. &lt;br&gt;\r\nNHÃN HIỆU&lt;br&gt;\r\nThương hiệu HHTQ, Logo HHTQ, trang web www.HHTQ và những biểu tượng, hình ảnh, logo, âm thanh là nhãn hiệu của HHTQ. Không ai được quyền sao chép, chỉnh sửa hoặc sử dụng, khai thác. \r\nTỪ CHỐI BẢO ĐẢM&lt;br&gt;\r\nCÁC DỊCH VỤ HHTQ BAO GỒM SỬ DỤNG TRÊN WEBSITE VÀ NHỮNG PHƯƠNG THỨC SỬ DỤNG KHÁC, NỘI DUNG, VIDEO PLAYER, BÀI VIẾT CỦA NGƯỜI DÙNG, VÀ NHỮNG DỮ LIỆU KHÁC CÓ TRÊN CÁC PHƯƠNG THỨC KHÁC NHAU, ĐƯỢC CUNG CẤP “NGUYÊN TRẠNG” MÀ KHÔNG CÓ ĐẢM BẢO DƯỚI BẤT KỲ HÌNH THỨC NÀO, RÕ RÀNG HAY NGỤ Ý. HHTQ TUYÊN BỐ MIỄN TRỪ MỌI BẢO ĐẢM, BAO GỒM NHƯNG KHÔNG GIỚI HẠN TRONG CÁC BẢO ĐẢM NGỤ Ý VỀ KHẢ NĂNG THƯƠNG MẠI, SỰ PHÙ HỢP CHO MỘT MỤC ĐÍCH CỤ THỂ, HOÀN THIỆN, CÓ SẴN, AN NINH, SỰ KHÔNG VI PHẠM, TÍNH BẢO MẬT, NỘI DUNG THÔNG TIN, TÍCH HỢP HỆ THỐNG HAY TÍNH CHÍNH XÁC VÀ BẢO ĐẢM RÕ RÀNG VỀ SỰ HƯỞNG LỢI ỔN ĐỊNH. &lt;br&gt;\r\nHHTQ KHÔNG ĐẠI DIỆN HAY BẢO ĐẢM RẰNG DỊCH VỤ HHTQ HOẶC MÁY CHỦ, ỨNG DỤNG, CHỨC NĂNG KHÔNG BỊ ẢNH HƯỞNG BỞI VIRUS, CÁC THÀNH PHẦN GÂY HẠI KHÁC, HOẶC BỊ LỖI, BẠN CHỊU TOÀN BỘ RỦI RO VỀ MẤT MÁT HOẶC THIỆT HẠI MÀ BẠN CÓ THỂ GẶP PHẢI HOẶC CHỊU ĐỰNG DO VIỆC SỬ DỤNG DỊCH VỤ HHTQ. HHTQ KHÔNG ĐẢM BẢO KHẢ NĂNG TRUY CẬP LIÊN TỤC, KHÔNG GIÁN ĐOẠN, KHÔNG CÓ LỖI HOẶC AN TOÀN KHI SỬ DỤNG DỊCH VỤ HHTQ, VÌ HOẠT ĐỘNG CỦA WEBSITE HOẶC CÁC PHƯƠNG THỨC KHÁC CÓ THỂ BỊ CAN THIỆP BỞI RẤT NHIỀU YẾU TỐ NGOÀI TẦM KIỂM SOÁT CỦA HHTQ. \r\n&lt;h2&gt; GIỚI HẠN TRÁCH NHIỆM VÀ BỒI THƯỜNG &lt;/h2&gt; &lt;br&gt;\r\nHHTQ  ĐẶC BIỆT TUYÊN BỐ MIỄN TRỪ MỌI TRÁCH NHIỆM PHÁP LÝ VÀ TRONG MỌI TRƯỜNG HỢP, HHTQ, CÁC QUAN CHỨC, GIÁM ĐỐC, CỔ ĐÔNG HOẶC NHÂN VIÊN CỦA HHTQ KHÔNG CHỊU TRÁCH NHIỆM PHÁP LÝ CHO BẤT KỲ THIỆT HẠI NÀO MANG TÍNH TRỰC TIẾP, GIÁN TIẾP, NGẪU NHIÊN, DO HẬU QUẢ, BỊ TRỪNG PHẠT HOẶC THIỆT HẠI ĐẶC BIỆT HAY BẤT KỲ THIỆT HẠI NÀO KHÁC, BAO GỒM NHƯNG KHÔNG GIỚI HẠN TRONG VIỆC MẤT QUYỀN SỬ DỤNG, MẤT LỢI NHUẬN HOẶC MẤT DỮ LIỆU, CHO DÙ TRONG MỘT HÀNH ĐỘNG CỦA HỢP ĐỒNG, SAI LẦM, TRÁCH NHIỆM PHÁP LÝ NGHIÊM NGẶT HOẶC THIỆT HẠI KHÁC (BAO GỒM NHƯNG KHÔNG GIỚI HẠN TRONG SỰ BẤT CẨN), PHÁT SINH TỪ HOẶC CÓ BẤT KỲ LIÊN QUAN NÀO ĐẾN VIỆC TRUY CẬP HAY SỬ DỤNG DỊCH VỤ HHTQ (NGAY CẢ KHI HHTQ ĐÃ ĐƯỢC BÁO VỀ KHẢ NĂNG XẢY RA THIỆT HẠI ĐÓ), BAO GỒM TRÁCH NHIỆM PHÁP LÝ LIÊN QUAN ĐẾN VIRUS, MACRO HOẶC PHẦN MỀM VÔ HIỆU KHÁC CÓ THỂ ẢNH HƯỞNG ĐẾN THIẾT BỊ MÁY TÍNH CỦA BẠN. &lt;br&gt;\r\nBẠN CÓ NGHĨA VỤ BỒI THƯỜNG CHO HHTQ7 HOẶC BẤT CỨ BÊN THỨ BA NÀO CHO TOÀN BỘ/BẤT CỨ THIỆT HẠI THỰC TẾ NÀO MÀ PHẦN LỖI ĐƯỢC XÁC ĐỊNH LÀ DO BẠN KHI XẢY RA MỘT TRONG CÁC TÌNH HUỐNG DƯỚI ĐÂY: &lt;br&gt;\r\nVI PHẠM CÁC ĐIỀU KHOẢN NÀY HOẶC CÁC THỎA THUẬN SỬ DỤNG DỊCH VỤ KHÁC CỦA HHTQ\r\nVI PHẠM CÁC QUY ĐỊNH VÀ PHÁP LUẬT HIỆN HÀNH GÂY ẢNH HƯỞNG/THIỆT HẠI ĐẾN HHTQ\r\nSỰ VÔ Ý HOẶC HÀNH VI CỐ Ý LÀM SAI CỦA BẠN, HOẶC NHÂN VIÊN VÀ ĐẠI LÝ CỦA BẠN GÂY ẢNH HƯỞNG/THIỆT HẠI ĐẾN HHTQ. &lt;br&gt;\r\nVI PHẠM BẤT CỨ QUY ĐỊNH/THOẢ THUẬN NÀO TẠI CHÍNH SÁCH BẢO MẬT. &lt;br&gt;\r\nXÂM PHẠM QUYỀN SỞ HỮU TRÍ TUỆ HOẶC QUYỀN LỢI HỢP PHÁP CỦA BẤT KỲ CÁ NHÂN/TỔ CHỨC NÀO GÂY ẢNH HƯỞNG/THIỆT HẠI ĐẾN HHTQ. &lt;br&gt;\r\nTRANH CHẤP TRONG VIỆC QUẢNG CÁO, KHUYẾN MÃI, PHÂN PHỐI HÀNG HÓA CỦA BẠN GÂY ẢNH HƯỞNG/THIỆT HẠI ĐẾN HHTQ. &lt;br&gt;\r\nTHÔNG BÁO VÀ QUY TRÌNH BÁO CÁO VI PHẠM BẢN QUYỀN&lt;br&gt;\r\nVui lòng xem ở bên dưới trang Web. Mục “DMCA” \r\n&lt;h2&gt; THÔNG TIN CHUNG &lt;/h2&gt; &lt;br&gt;\r\nKiểm soát xuất khẩu. Phần mềm và sự truyền tải dữ liệu kỹ thuật, nếu có, kết nối với Dịch vụ HHTQ được kiểm soát xuất khẩu. Bạn đồng ý tuân thủ với tất cả các luật liên quan đến phần mềm và truyền tải dữ liệu kỹ thuật từ Việt Nam hoặc quốc gia mà bạn cư trú. &lt;br&gt;\r\nLuật áp dụng: Bạn đồng ý rằng bản Điều khoản sử dụng và bất kỳ bất đồng nào phát sinh từ việc bạn sử dụng dịch vụ của chúng tôi sẽ được giải quyết theo luật pháp hiện hành của Nước Cộng hoà Xã hội Chủ nghĩa Việt Nam . Thông qua việc đăng ký hoặc sử dụng dịch vụ của chúng tôi, bạn mặc nhiên đồng ý và tuân thủ toàn bộ các quy định của Luật pháp Việt Nam. \r\n&lt;h2&gt; THÔNG TIN BỔ SUNG &lt;/h2&gt; &lt;br&gt;\r\nTrong trường hợp một hoặc một số điều khoản của bản Điều khoản sử dụng này xung đột với các quy định của luật pháp và bị Tòa án coi là vô hiệu, điều khoản đó sẽ được chỉnh sửa cho phù hợp với quy định của pháp luật hiện hành, và phần còn lại của Điều khoản sử dụng vẫn giữ nguyên giá trị; &lt;br&gt;\r\nViệc bất kỳ bên nào không thể chứng minh được về quyền của mình trong Quy định sử dụng sẽ không bị xem là việc từ bỏ quyền của bên đó và quyền này vẫn còn nguyên giá trị và hiệu lực; &lt;br&gt;\r\nBạn đồng ý rằng, bất kỳ khiếu nại hoặc tố tụng nào phát sinh từ website này phải được đệ trình trong vòng một (1) năm sau khi khiêu tố hoặc tố tụng ấy phát sinh, nếu không khiếu nại sẽ hoàn toàn vô hiệu; &lt;br&gt;\r\n(iv) Chúng tôi có thể chuyển nhượng quyền lợi và nghĩa vụ của mình chiếu theo bản Điều khoản sử dụng này và chúng tôi sẽ được giải phóng khỏi bất kỳ nghĩa vụ nào phát sinh sau đó. &lt;br&gt;\r\nTích hợp, bổ sung, chia rẽ. Xin chú ý rằng các Điều khoản sử dụng, bao gồm cả Chính sách bảo mật của HHTQ được kết hợp trong Điều khoản này và bất kì thỏa thuận giấy phép nào của người sử dụng cuối có thể đi kèm với ứng dụng của HHTQ, tính năng, thiết bị, tạo thành các thỏa thuận pháp lý cuối cùng giữa bạn và HHTQ và hoàn toàn thay thế bất kỳ thỏa thuận nào trước đó giữa bạn và HHTQ liên quan đến Dịch vụ HHTQ. Trừ trường hợp quy định tại Điều 2 trên đây, các Điều khoản này có thể không được sửa đổi, bổ sung hoặc thay đổi ngoại trừ trong một văn bản có chữ ký của HHTQ. Những Điều khoản sử dụng hoạt động đến mức tối đa cho phép theo quy định của pháp luật. Nếu bất kỳ điều khoản nào của các Điều khoản này bị coi là bất hợp pháp, có hiệu lực, hoặc không thể thực thi, bạn và chúng tôi đồng ý điều khoản đó sẽ được coi là tách từ các Điều khoản và sẽ không ảnh hưởng đến hiệu lực và tính thực thi của các Điều khoản quy định còn lại. &lt;br&gt;\r\nCảm ơn bạn đã dành thời gian để đọc các Điều khoản sử dụng. Với sự hiểu biết và đồng ý tuân theo các Điều khoản này việc sử dụng dịch vụ sẽ dễ dàng hơn cho mọi người dùng.', '3130819', 'true', '&lt;!-- Global site tag (gtag.js) - Google Analytics --&gt;\r\n&lt;script async src=&quot;https://www.googletagmanager.com/gtag/js?id=UA-207050834-1&quot;&gt;&lt;/script&gt;\r\n&lt;script&gt;\r\n  window.dataLayer = window.dataLayer || [];\r\n  function gtag(){dataLayer.push(arguments);}\r\n  gtag(&#39js&#39, new Date());\r\n\r\n  gtag(&#39config&#39, &#39UA-207050834-1&#39);\r\n&lt;/script&gt;\r\n&lt;!-- Global site tag (gtag.js) - Google Analytics --&gt;\r\n&lt;script async src=&quot;https://www.googletagmanager.com/gtag/js?id=G-DS9GNTH1W1&quot;&gt;&lt;/script&gt;\r\n&lt;script&gt;\r\n  window.dataLayer = window.dataLayer || [];\r\n  function gtag(){dataLayer.push(arguments);}\r\n  gtag(&#39js&#39, new Date());\r\n\r\n  gtag(&#39config&#39, &#39G-DS9GNTH1W1&#39);\r\n&lt;/script&gt;\r\n', 'sadsdasdasdsad', NULL, 20, '[{\"name\":\"Quyến Tư Lượng\",\"url\":\"https://hhtq.tv/thong-tin-phim/quyen-tu-luong.html\"},{\"name\":\"Tuyết Ưng Lĩnh Chủ\",\"url\":\"https://hhtq.tv/thong-tin-phim/tuyet-ung-linh-chu-phan-3.html\"},{\"name\":\"Độc Bộ Tiêu Dao\",\"url\":\"https://hhtq.tv/thong-tin-phim/doc-bo-tieu-dao.html\"},{\"name\":\"Soul Land – Đấu La Đại Lục\",\"url\":\"https://hhtq.tv/thong-tin-phim/dau-la-dai-luc.html\"},{\"name\":\"Tinh Thần Biến\",\"url\":\"https://hhtq.tv/thong-tin-phim/tinh-than-bien-phan-4.html\"},{\"name\":\"Mộ vương chi vương\",\"url\":\"https://hhtq.tv/thong-tin-phim/mo-vuong-chi-vuong-phan-1-ky-lan-quyet.html\"},{\"name\":\"Vạn Giới Tiên Tung\",\"url\":\"https://hhtq.tv/thong-tin-phim/van-gioi-tien-tung.html\"}]', 'true', 3, 'true', 'false', '', 'https://www.i9bet2.com/?uagt=vip344&amp;path=signup', 'https://bf.333xbet.com/18881999/video888.mp4', 'Trang website không quảng cáo &lt;a href=&quot;https://animevip.tv/&quot; class=&quot;color-red-2 fw-500&quot;&gt;https://animevip.tv/&lt;/a&gt;', 3, 10, 'false', '&lt;h3&gt;1. Làm sao để tăng level&lt;/h3&gt; &lt;br&gt;\r\n- Khi bạn tạo tài khoản, bạn sẽ tăng lên level 1.&lt;br&gt;\r\n- Mỗi khi bạn xem một bộ phim, bạn sẽ được cộng thêm 1 exp ( sau 24h nếu bạn xem lại bộ phim đó, bạn sẽ được cộng 1 điểm exp )&lt;br&gt;\r\n- Mỗi level sẽ có một mức điểm exp cố định, nếu đủ điểm bạn sẽ được lên level tiếp theo\r\n &lt;h3&gt;2. Cách tăng cảnh giới &lt;/h3&gt; &lt;br&gt;\r\n - Khi bạn tăng lên exp bạn sẽ có cảnh giới được cố định theo mỗi level&lt;br&gt;\r\n-(level 1: Luyện Khí )&lt;br&gt;\r\n-(level 2: Trúc Cơ)&lt;br&gt;\r\n-(level 5: Kim Đan)&lt;br&gt;\r\n-(level 10: Nguyên Anh)&lt;br&gt;\r\n-(level 20: Hóa Thần)&lt;br&gt;\r\n-(level 30: Luyện Hư Kỳ)&lt;br&gt;\r\n-(level 40: Hợp Đạo Kỳ)&lt;br&gt;\r\n-(level 50: Đại Thừa Kỳ)&lt;br&gt;\r\n-(level 60: Độ Kiếp Kỳ)&lt;br&gt;\r\n-(level 70: Tiên Cảnh)&lt;br&gt;\r\n-(level 80: Tán Tiên)&lt;br&gt;\r\n-(level 90: Tiên Nhân Cảnh)&lt;br&gt;\r\n-(level 100: Tiên Tôn Cảnh)&lt;br&gt;\r\n-(level 110: Đạo Tôn)&lt;br&gt;\r\n-(level 120: Thiên Đạo)&lt;br&gt;\r\n&lt;h3&gt;3. Làm thế nào để có icon&lt;/h3&gt;&lt;br&gt;\r\n- Tương ứng với mỗi cảnh giới, bạn sẽ có 1 icon cố định&lt;br&gt;\r\n- level cao, đứng trong top 3 sẽ được tặng thêm icon&lt;br&gt;\r\nhoặc bạn sẽ được chúng tôi tặng icon khi hoạt động tích cực và có đóng góp nhiều cho website \r\n( ví dụ: báo phim lỗi, báo cáo thành viên vi phạm cộng đồng, ... )&lt;br&gt;\r\n&lt;h3&gt;Cảm ơn bạn đã đọc hướng dẫn, nếu có gì thắc mắc hãy liên hệ cho chúng mình qua fanpage&lt;h3&gt;', 20, 25, 'https://i.imgur.com/ISitmiU.jpg', 'false', '[{\"id\":\"28\"},{\"id\":\"27\"},{\"id\":\"26\"},{\"id\":\"25\"},{\"id\":\"24\"},{\"id\":\"21\"},{\"id\":\"19\"},{\"id\":\"18\"}]', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_episode`
--

CREATE TABLE `table_episode` (
  `id` int(10) NOT NULL,
  `movie_id` int(10) DEFAULT NULL,
  `ep_name` varchar(155) DEFAULT NULL,
  `ep_num` int(10) NOT NULL DEFAULT 0,
  `server` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_history`
--

CREATE TABLE `table_history` (
  `id` int(10) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `movie_save` int(10) DEFAULT NULL,
  `movie_view` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_level_color`
--

CREATE TABLE `table_level_color` (
  `id` int(10) NOT NULL,
  `level` int(10) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `danh_hieu` varchar(255) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_lien_he`
--

CREATE TABLE `table_lien_he` (
  `id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `table_lien_he`
--

INSERT INTO `table_lien_he` (`id`, `name`, `url`) VALUES
(6, 'Telegram', 'https://t.me/asds11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_lien_ket`
--

CREATE TABLE `table_lien_ket` (
  `id` int(10) NOT NULL,
  `movie_id` int(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_movie`
--

CREATE TABLE `table_movie` (
  `id` int(10) NOT NULL,
  `name` varchar(355) DEFAULT NULL,
  `other_name` varchar(355) DEFAULT NULL,
  `image` varchar(355) DEFAULT NULL,
  `image_big` varchar(355) DEFAULT NULL,
  `cate` longtext DEFAULT NULL,
  `loai_phim` varchar(255) DEFAULT NULL,
  `de_cu` varchar(10) NOT NULL DEFAULT 'false',
  `year` int(10) DEFAULT NULL,
  `vote_point` int(10) DEFAULT 0,
  `vote_all` int(10) DEFAULT 0,
  `movie_duration` varchar(255) DEFAULT NULL,
  `view` int(10) DEFAULT 0,
  `trang_thai` varchar(155) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `ep_num` varchar(100) NOT NULL DEFAULT '??',
  `ep_hien_tai` varchar(355) DEFAULT NULL,
  `lich_chieu` longtext DEFAULT NULL,
  `keyword` longtext DEFAULT NULL,
  `seo_mota` longtext DEFAULT NULL,
  `seo_title` longtext DEFAULT NULL,
  `public` varchar(50) DEFAULT NULL,
  `time` varchar(155) DEFAULT NULL,
  `timestap` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_movie_server`
--

CREATE TABLE `table_movie_server` (
  `id` int(10) NOT NULL,
  `movie_id` int(10) DEFAULT NULL,
  `server_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_notice`
--

CREATE TABLE `table_notice` (
  `id` int(10) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `timestap` varchar(100) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `view` varchar(50) NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_report`
--

CREATE TABLE `table_report` (
  `id` int(10) NOT NULL,
  `movie_id` int(10) DEFAULT NULL,
  `episode_id` int(10) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_server`
--

CREATE TABLE `table_server` (
  `id` int(10) NOT NULL,
  `server_name` varchar(155) DEFAULT NULL,
  `server_player` varchar(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `table_server`
--

INSERT INTO `table_server` (`id`, `server_name`, `server_player`) VALUES
(1, 'Server 4', 'iframe'),
(2, 'Server 3', 'iframe'),
(10, 'Server 2', 'iframe'),
(11, 'Server 1', 'iframe'),
(12, 'Vip 2', 'player'),
(13, 'Vip 1', 'player');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_user`
--

CREATE TABLE `table_user` (
  `id` int(10) NOT NULL,
  `email` varchar(155) DEFAULT NULL,
  `password` varchar(155) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `nickname` varchar(155) DEFAULT NULL,
  `exp` int(10) NOT NULL DEFAULT 1,
  `level` int(10) NOT NULL DEFAULT 1,
  `banned` varchar(15) NOT NULL DEFAULT 'false',
  `quote` varchar(255) DEFAULT NULL,
  `coins` int(10) NOT NULL DEFAULT 0,
  `vip` int(10) NOT NULL DEFAULT 0,
  `_accesstoken` mediumtext DEFAULT NULL,
  `ipadress` varchar(100) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_user_icon`
--

CREATE TABLE `table_user_icon` (
  `id` int(10) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_user_movie`
--

CREATE TABLE `table_user_movie` (
  `id` int(10) NOT NULL,
  `movie_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `day` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `table_year`
--

CREATE TABLE `table_year` (
  `id` int(10) NOT NULL,
  `year` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `table_year`
--

INSERT INTO `table_year` (`id`, `year`) VALUES
(1, 2021),
(2, 2022),
(7, 2015),
(8, 2014),
(9, 2016),
(10, 2017),
(11, 2018),
(12, 2019),
(13, 2013),
(14, 2020);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `table_admin`
--
ALTER TABLE `table_admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_ads`
--
ALTER TABLE `table_ads`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_category`
--
ALTER TABLE `table_category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_comment`
--
ALTER TABLE `table_comment`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_config`
--
ALTER TABLE `table_config`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_episode`
--
ALTER TABLE `table_episode`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_history`
--
ALTER TABLE `table_history`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_level_color`
--
ALTER TABLE `table_level_color`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_lien_he`
--
ALTER TABLE `table_lien_he`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_lien_ket`
--
ALTER TABLE `table_lien_ket`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_movie`
--
ALTER TABLE `table_movie`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_movie_server`
--
ALTER TABLE `table_movie_server`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_notice`
--
ALTER TABLE `table_notice`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_report`
--
ALTER TABLE `table_report`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_server`
--
ALTER TABLE `table_server`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_user`
--
ALTER TABLE `table_user`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_user_icon`
--
ALTER TABLE `table_user_icon`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_user_movie`
--
ALTER TABLE `table_user_movie`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `table_year`
--
ALTER TABLE `table_year`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `table_admin`
--
ALTER TABLE `table_admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `table_ads`
--
ALTER TABLE `table_ads`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT cho bảng `table_category`
--
ALTER TABLE `table_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `table_comment`
--
ALTER TABLE `table_comment`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5187;

--
-- AUTO_INCREMENT cho bảng `table_config`
--
ALTER TABLE `table_config`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `table_episode`
--
ALTER TABLE `table_episode`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9649;

--
-- AUTO_INCREMENT cho bảng `table_history`
--
ALTER TABLE `table_history`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5646;

--
-- AUTO_INCREMENT cho bảng `table_level_color`
--
ALTER TABLE `table_level_color`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `table_lien_he`
--
ALTER TABLE `table_lien_he`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `table_lien_ket`
--
ALTER TABLE `table_lien_ket`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=339;

--
-- AUTO_INCREMENT cho bảng `table_movie`
--
ALTER TABLE `table_movie`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=470;

--
-- AUTO_INCREMENT cho bảng `table_movie_server`
--
ALTER TABLE `table_movie_server`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=986;

--
-- AUTO_INCREMENT cho bảng `table_notice`
--
ALTER TABLE `table_notice`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=276210;

--
-- AUTO_INCREMENT cho bảng `table_report`
--
ALTER TABLE `table_report`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;

--
-- AUTO_INCREMENT cho bảng `table_server`
--
ALTER TABLE `table_server`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `table_user`
--
ALTER TABLE `table_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2324;

--
-- AUTO_INCREMENT cho bảng `table_user_icon`
--
ALTER TABLE `table_user_icon`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT cho bảng `table_user_movie`
--
ALTER TABLE `table_user_movie`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273491;

--
-- AUTO_INCREMENT cho bảng `table_year`
--
ALTER TABLE `table_year`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
