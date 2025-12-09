<?php
	if (!isset($row)) return;
?>
<article class="col-md-2 col-sm-4 col-xs-6 thumb grid-item">
	<div class="halim-item">
		<a class="halim-thumb" href="<?= URL ?>/thong-tin-phim/<?= $row['slug'] ?>.html" title="<?= $row['name'] ?>">
			<figure>
				<img class="blur-up img-responsive lazyloaded" data-src="<?= $row['image'] ?>" alt="<?= $row['name'] ?>" title="<?= $row['name'] ?>" sizes="300x400" src="<?= $row['image'] ?>" />
			</figure>
			<?php if (!empty($status)): ?>
				<span class="episode"><?= $status ?></span>
			<?php endif; ?>
			<?php if (!empty($popover_content)): ?>
				<div class="icon_overlay" data-html="true" data-toggle="halim-popover" data-placement="top" 
					data-trigger="hover" title="" data-content="<?= htmlspecialchars($popover_content) ?>" 
					data-original-title="<?= htmlspecialchars($popover_original_title) ?>
				"></div>
			<?php endif; ?>

			<div class="halim-post-title-box">
				<div class="halim-post-title">
					<h2 class="entry-title"><?= $row['name'] ?></h2>
					<p class="original_title"><?= $row['other_name'] ?></p>
				</div>
			</div>
		</a>
	</div>
</article>