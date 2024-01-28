<?php
$mysql->update("user", "online = 0", "id = ".$user['id']);
RemoveCookie();
die(header("location:/"));
