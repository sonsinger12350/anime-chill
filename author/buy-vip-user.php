<?php
$respon = [
    'error' => '',
    'message' => '',
];
#I. get data
#1. user_id
$user_id = $user['id']; 
#2. vip_package
$vip_package = $_GET['vip_package'];

#II. Handler Buy Vip User
$now = new DateTime();
$date_current = new DateTime();
$vip_date_end = "";

$pay = 0;
if($vip_package == 1){
    $pay = 30000;
    $vip_date_end = $date_current->modify("+30 days");
} elseif($vip_package == 12){
    $pay = 360000;
    $vip_date_end = $date_current->modify("+390 days");
}
if($user['coins'] < $pay){
    $respon['message'] = "Tiền của bạn không đủ để mua gói vip";
}else{
    #.Data to Edit Query
    #1. coins
    $cash_return = $user['coins'] - $pay;
    #2. vip_icon
    $vip_icon = "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiceGOH6jSemvPPWZNRkdgv1pxWy6Th2ZgMLHNReixkU-tWA5WDQGgR3rlzEEvvd45tID_YjLvgejOoug1g_R_OowqBqndC4wvV5RH9UtpG_q3PQ82gYUlCytF02DHQibzX1U26onZHEJQTZGJbDeWbggMg6mYDJq_j-e2-05ysBlK1bKA6V-VG2x2A/s320/vip.";
    #3. vip_date_end
    if($user['vip_term'] > 0){
        $num_days =  "+{$user['vip_term']} days";
        $vip_date_end = $vip_date_end->modify($num_days);
    }
    #4. vip_term
    $vip_term = $vip_date_end->diff($now);
    $vip_term = $vip_term->days;
    
    $vip_date_end = $vip_date_end->getTimestamp();
    #. Query User table
    if(UpdateVipUser($cash_return, $vip_icon, $vip_date_end, $vip_term, $user_id)){
        $respon['message'] = "Bạn Đã Mua Gói Víp Thành Công";
    } else {
        $respon['message'] = "Đã có Lỗi vui lòng thử lại sau";
    }
}
echo json_encode($respon);
?>