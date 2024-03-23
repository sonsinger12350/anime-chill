<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
FireWall();
?>
<div class="vip_user" data-vip="<?= $user['vip'] ?? 0 ?>"> </div>
<script>
    $(function() {
        $(window).scroll(function() {
            if ($(this).scrollTop() > 500)
                $('#top-up').fadeIn(400);
            else
                $('#top-up').fadeOut(100);
        });
        $("#top-up").click(function() {
            $("html, body").animate({
                scrollTop: 0
            }, {
                duration: 300
            })
        });
    });
</script>
<?php
if (!empty($user['vip'])) {
    if ($user['vip'] <> 1) {
        echo un_htmlchars($cf['script_foog']);
    }
} else {
    echo un_htmlchars($cf['script_foog']);
}
?>