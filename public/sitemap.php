<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");

header('Content-Type: application/xml; charset=utf-8');

// Lấy tất cả phim công khai
$movies = $mysql->query("SELECT slug, timestap FROM " . DATABASE_FX . "movie WHERE public = 'true' ORDER BY timestap DESC");

// Lấy tất cả categories
$categories = $mysql->query("SELECT slug FROM " . DATABASE_FX . "category ORDER BY id ASC");

// Lấy tất cả news/articles
$news = [];
if (get_total("news", "WHERE public = 'true'") > 0) {
	$news = $mysql->query("SELECT slug, timestap FROM " . DATABASE_FX . "news WHERE public = 'true' ORDER BY timestap DESC");
}

// Tính toán lastmod (ngày cập nhật gần nhất)
$lastMod = date('Y-m-d');

// Tạo XML sitemap
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

// Trang chủ
echo "\t<url>\n";
echo "\t\t<loc>" . htmlspecialchars(URL . '/') . "</loc>\n";
echo "\t\t<lastmod>" . $lastMod . "</lastmod>\n";
echo "\t\t<changefreq>daily</changefreq>\n";
echo "\t\t<priority>1.0</priority>\n";
echo "\t</url>\n";

// Trang mới cập nhật
echo "\t<url>\n";
echo "\t\t<loc>" . htmlspecialchars(URL . '/moi-cap-nhat') . "</loc>\n";
echo "\t\t<lastmod>" . $lastMod . "</lastmod>\n";
echo "\t\t<changefreq>daily</changefreq>\n";
echo "\t\t<priority>0.9</priority>\n";
echo "\t</url>\n";

// Trang phim hoàn thành
echo "\t<url>\n";
echo "\t\t<loc>" . htmlspecialchars(URL . '/phim-hoan-thanh') . "</loc>\n";
echo "\t\t<lastmod>" . $lastMod . "</lastmod>\n";
echo "\t\t<changefreq>daily</changefreq>\n";
echo "\t\t<priority>0.8</priority>\n";
echo "\t</url>\n";

// Trang bảng xếp hạng
echo "\t<url>\n";
echo "\t\t<loc>" . htmlspecialchars(URL . '/bang-xep-hang-phim') . "</loc>\n";
echo "\t\t<lastmod>" . $lastMod . "</lastmod>\n";
echo "\t\t<changefreq>daily</changefreq>\n";
echo "\t\t<priority>0.8</priority>\n";
echo "\t</url>\n";

// Trang lịch chiếu
echo "\t<url>\n";
echo "\t\t<loc>" . htmlspecialchars(URL . '/lich-chieu') . "</loc>\n";
echo "\t\t<lastmod>" . $lastMod . "</lastmod>\n";
echo "\t\t<changefreq>daily</changefreq>\n";
echo "\t\t<priority>0.8</priority>\n";
echo "\t</url>\n";

// Categories
while ($category = $categories->fetch(PDO::FETCH_ASSOC)) {
	if (!empty($category['slug'])) {
		echo "\t<url>\n";
		echo "\t\t<loc>" . htmlspecialchars(URL . '/the-loai/' . $category['slug']) . "</loc>\n";
		echo "\t\t<lastmod>" . $lastMod . "</lastmod>\n";
		echo "\t\t<changefreq>weekly</changefreq>\n";
		echo "\t\t<priority>0.7</priority>\n";
		echo "\t</url>\n";
	}
}

// Movies
while ($movie = $movies->fetch(PDO::FETCH_ASSOC)) {
	if (!empty($movie['slug'])) {
		$movieLastMod = !empty($movie['timestap']) ? date('Y-m-d', $movie['timestap']) : $lastMod;
		echo "\t<url>\n";
		echo "\t\t<loc>" . htmlspecialchars(URL . '/info/' . $movie['slug'] . '.html') . "</loc>\n";
		echo "\t\t<lastmod>" . $movieLastMod . "</lastmod>\n";
		echo "\t\t<changefreq>weekly</changefreq>\n";
		echo "\t\t<priority>0.9</priority>\n";
		echo "\t</url>\n";
	}
}

// News/Articles
if (!empty($news)) {
	while ($article = $news->fetch(PDO::FETCH_ASSOC)) {
		if (!empty($article['slug'])) {
			$articleLastMod = !empty($article['timestap']) ? date('Y-m-d', $article['timestap']) : $lastMod;
			echo "\t<url>\n";
			echo "\t\t<loc>" . htmlspecialchars(URL . '/news/' . $article['slug'] . '.html') . "</loc>\n";
			echo "\t\t<lastmod>" . $articleLastMod . "</lastmod>\n";
			echo "\t\t<changefreq>monthly</changefreq>\n";
			echo "\t\t<priority>0.6</priority>\n";
			echo "\t</url>\n";
		}
	}
}

echo '</urlset>';

