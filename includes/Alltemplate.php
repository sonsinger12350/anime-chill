<?php
//   $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "vip  ORDER BY name ASC");
//   while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
//   }

function UserIcon($user_id, $width, $height)
{
    global $mysql;
    if(get_total('user_icon'," WHERE user_id = '$user_id' ORDER BY id DESC") < 1) return "";
    $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "user_icon WHERE user_id = '$user_id' ORDER BY id DESC");
    $IconList = '';
    while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
        if ($row['note']) {
            $tooltip = ' data-tooltip="' . $row['note'] . '"';
        } else $tooltip = "";
        $IconList .= '&nbsp;<span' . $tooltip . '><img style="border-radius: 10px;" src="' . $row['icon'] . '" width="' . $width . '" height="' . $height . '" alt="' . $row['note'] . '"></span>';
    }
    return $IconList;
}
function ShowReplyComment($CommentID)
{
    global $mysql, $user;
    $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "comment WHERE reply_comment = '$CommentID' AND show_cmt = 'true' AND reply_comment IS NOT NULL ORDER BY id ASC LIMIT 5");
    $Comment = '';
    while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
        $User_Arr = GetDataArr("user", "id = '{$row['user_id']}'");
        $listItemStore = listUserItemActive($user['id']);
        $htmlItemStore = '<div class="user-figure">';
        $htmlVip = '';

        foreach ($listItemStore as $k => $v) {
            if ($k != 'khung-vien') {
                $htmlItemStore .= '<img src="'.$v.'" alt="'.$k.'" class="'.$k.'-default">';
            }
        }

        $htmlItemStore .= '</div>';

        if ($user['vip'] == 1) {
            $htmlVip = '<div class="vip-icon"><img src="'.$user['vip_icon'].'" /></div>';
        }

        if ($row['user_id'] == $user['id']) {
            $CmtSetting = '<div class="flex flex-hozi-center relative"><a href="javascript:void(0)" onclick="clickEventDropDown(this,\'expand_more\')" class="toggle-dropdown fs-21 inline-flex" bind="drop-down-oc-' . $row['id'] . '"><span class="material-icons-round">expand_more</span></a>
                      <div id="drop-down-oc-' . $row['id'] . '" class="dropdown-option bg-black">
                          <div onclick="showFrameEditComment(' . $row['id'] . ',\'comment_main\')"><span class="material-icons-round margin-0-5">
                                  edit
                              </span>Sửa</div>
                          <div onclick="optionComment({id_comment:' . $row['id'] . ',perform:\'hide\',type_comment:\'comment_main\'})"><span class="material-icons-round margin-0-5">
                                  hide_source
                              </span>Ẩn</div>
                      </div>
                  </div>';
        }
        else $CmtSetting = "";

        $Comment .= '<div id="reply_' . $row['id'] . '" class="user-comment relative">
            <div class="flex bg-comment">
                <div class="left" onclick="initViewProfile(' . $User_Arr['id'] . ')">
                    <div class="avatar">
                        <img class="avatar-img" src="' . $User_Arr['avatar'] . '">
                        <img class="avatar-frame" src="'.getIconStoreActive($User_Arr['id'], 'khung-vien').'">
                        <span class="rank-level">Lv ' . $User_Arr['level'] . '</span>
                    </div>
                    <div class="item-store">
                        '.$htmlItemStore.'
                    </div>
                </div>
                <div class="right">
                    <div class="flex flex-column">
                        <div class="flex flex-space-auto">
                            <div class="flex flex-hozi-center">
                                <div class="nickname"> ' . $User_Arr['nickname'] . LevelIcon($User_Arr['level'], 18, 18) . UserIcon($User_Arr['id'], 18, 18) . '</div>
                                '.$htmlVip.'
                            </div>
                            ' . $CmtSetting . '
                        </div>
                        <div class="content">' . $row['content'] . ' </div>
                        <div class="flex fs-12"> <a href="javascript:void(0)" onclick="showFrameReplyComment(' . $CommentID . ',\'' . $User_Arr['nickname'] . '\',' . $User_Arr['id'] . ',\'65223e7a2be93294129d74f9f934c973\')" class="margin-r-5">Trả lời</a>
                            <div> ' . RemainTime($row['timestap']) . ' </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="feedback_' . $row['id'] . '" class="frame-reply-comments"></div>
        <div id="toggle_frame_comment_' . $row['id'] . '"></div>';
    }
    return $Comment;
}

function ShowFollow($MovieID)
{
    global $user;
    //<div class="movie-following"><span class="material-icons-round">stars</span></div>
    if (!$_SESSION['author']) return "";
    if (get_total('history', "WHERE movie_save = '$MovieID' AND user_id = '{$user['id']}'") < 1 || get_total('movie', "WHERE id = '$MovieID' AND public = 'true'") < 1) return "";
    return '<div class="movie-following"><span class="material-icons-round">stars</span></div>';
}
