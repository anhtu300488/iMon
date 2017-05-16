<?php
/**
 * Return nav-here if current path begins with this path.
 *
 * @param string $path
 * @return string
 */
use Illuminate\Http\Request;
function setActive($path)
{
    return \Request::is($path . '*') ? ' class=active' :  '';
}

function setOpen($path)
{
    return \Request::is($path . '*') ? ' class=open' :  '';
}

function getAdminName($id)
{
    $result = \App\Admin::find($id);
    return $result['name'];
}

function reFormatDate($datetime, $format='d-m-Y H:i:s'){
    return (isset($datetime) & ($datetime != '0000-00-00 00:00:00'))? date($format, strtotime($datetime)) : '';
}

function numberFormat($money = 0, $dec_point = '.' , $thousands_sep = ','){
    $arr = explode('.', sprintf("%.2f", $money));
    $decimal = (count($arr) > 1 && $arr[1] != '00') ? 2 : 0;
    return number_format($money, $decimal, $dec_point, $thousands_sep);
}

function decodeEmoji($content){
    return \App\Emoji::Decode($content);
}

function getDescriptionXocDia($content){
    $arr =  (array) json_decode($content);
    $string = "Thắng:" . $arr["winner"];
    $array_bet_ = (array)(get_object_vars($arr["betMoney"]));
    $cuoc = array(0 => "+4 trắng", 4 => "+4 lẻ", 10 => "+Chẵn", 11 => "+Lẻ", 1 => "+3 trắng", 3 => "+3 đỏ:");
    foreach ($cuoc as $i => $cuoc1){
        if (sizeof($array_bet_[$i]) > 0){
            //    var_dump($array_bet_0[$i]);die;
            $string = $string .  (string)$cuoc1 . ": ";
            foreach ($array_bet_[$i] as $i => $bet){
                foreach ($bet as $userId => $bet){
                    $string = $string .(string)$userId . " đặt " .  number_format((string)$bet) . ", ";
                }
            }
        }
    }
//      $array_player = (array)(get_object_vars($arr["player"]));
    $string = $string . "+Ip ";
    foreach ($arr["player"] as $user){
        //  $user_ip = (array)(get_object_vars($arr["player"]));
        $string = $string . $user->userId . ":" . $user->ip . ", ";
    }
    $array_refund= (array)(get_object_vars($arr["refundMoney"]));

    if (sizeof($array_refund) > 0){
        $string = $string . "+Refund ";
//           var_dump($array_refund);die;
        foreach ($array_refund as $userId => $refund){
            //  $user_ip = (array)(get_object_vars($arr["player"]));
//               var_dump($refund_);die;
//              foreach ($refund_ as $userId => $refund){
            $string = $string .(string)$userId . " hoàn " .  number_format((string)$refund) . ", ";
//              }
        }
    }
    return $string;
}

function checkAlarm(){
    return \App\CrashTableAlarm::where('isAlarm','=','1')->count();
}
