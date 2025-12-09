<?php
	if (!isset($row)) return;
?>
<li class="bookmark-list profile-bm">
	<a href="<?= URL ?>/thong-tin-phim/<?= $row['slug'] ?>.html" title="<?= $row['name'] ?>">
		<img src="<?= $row['image'] ?>" alt="<?= $row['name'] ?>">
		<span class="bookmark-title"><?= $row['name'] ?></span>
		<span class="bookmark-date"><?= $row['created_at'] ?></span>
	</a>
	<span class="remove-bookmark box-shadow" id="<?= $row['id'] ?>">x</span>
</li>