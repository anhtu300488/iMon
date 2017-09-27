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
            $string = $string .  (string)$cuoc1 . ": ";
            foreach ($array_bet_[$i] as $i => $bet){
                foreach ($bet as $userId => $bet){
                    $string = $string .(string)$userId . " đặt " .  number_format((string)$bet) . ", ";
                }
            }
        }
    }
    $string = $string . "+Ip ";
    foreach ($arr["playerInfo"] as $user){
        //  $user_ip = (array)(get_object_vars($arr["player"]));
        $string = $string . $user->userId . ":" . $user->ip . ", ";
    }
    $array_refund= (array)(get_object_vars($arr["refundMoney"]));

    if (sizeof($array_refund) > 0){
        $string = $string . "+Refund ";
        foreach ($array_refund as $userId => $refund){
            $string = $string .(string)$userId . " hoàn " .  number_format((string)$refund) . ", ";
        }
    }
    return $string;
}
function getDescriptionXocDiaHtml($content){
    $arr =  (array) json_decode($content);
//    var_dump($arr);die;
    $minbet = isset($arr["minbet"]) ? $arr["minbet"] : "0";
    $string = "Mức Cược: " . $minbet . " mon+";
    $room = $arr["vipRoom"] ? "Vip" : "Thường";
    $string = $string . "Phòng: " . $room . "+";
    $startTime = isset($arr["startTime"])? $arr["startTime"] : "";
    $endTime = isset($arr["endTime"])? $arr["endTime"] : "";
    $string = $string .  "Thời gian bắt đầu:" . $startTime . "+";
    $string = $string .  "Thời gian kết thúc:" . $endTime . "+";
    $array_bet_ = (array)(get_object_vars($arr["betMoney"]));
    $cuoc = array(0 => "+4 mặt đỏ", 4 => "+4 mặt lẻ", 10 => "+Chẵn", 11 => "+Lẻ", 1 => "+3 mặt đỏ", 3 => "+3 mặt trắng:");
    $string = $string . "+Người chơi+";
    if(isset($arr["playerInfo"])){
        foreach ($arr["playerInfo"] as $user){
            $string = $string . "  " . $user->userId . "(" . $user->ip . ")+";
        }
    }

    foreach ($cuoc as $i => $cuoc1){
        if (sizeof($array_bet_[$i]) > 0){
            $string = $string .  (string)$cuoc1 . ": ";
            foreach ($array_bet_[$i] as $i => $bet){
                foreach ($bet as $userId => $bet){
                    $string = $string .(string)$userId . " -- " .  number_format((string)$bet) . "Mon, ";
                }
            }
        }
    }
    $array_refund= (array)(get_object_vars($arr["refundMoney"]));

    if (sizeof($array_refund) > 0){
        $string = $string . "+Hoàn tiền cân cửa ";
        foreach ($array_refund as $userId => $refund){
            $string = $string .(string)$userId . " hoàn " .  number_format((string)$refund) . ", ";
        }
    }
    $num_trang = 4 - $arr["turn"];
    $string = $string . "+Kết quả: " . $arr["turn"] . " đỏ " . $num_trang . " trắng";
    $string = $string . "+Người thắng: " . $arr["winner"];
    return $string;
}
function getDescriptionBaCay($content){
    $arr =  (array) json_decode($content);
//    var_dump($arr);die;
    $minbet = isset($arr["minbet"]) ? $arr["minbet"] : "0";
    $string = "Mức Cược: " . $minbet . " mon+";
    $room = (isset($arr["vipRoom"]) && $arr["vipRoom"] ) ? "Vip" : "Thường";
    $string = $string . "Phòng: " . $room . "+";
    $startTime = isset($arr["startTime"])? $arr["startTime"] : "";
    $endTime = isset($arr["endTime"])? $arr["endTime"] : "";
    $string = $string .  "Thời gian bắt đầu: " . $startTime. "+";
    $string = $string .  "Thời gian kết thúc: " . $endTime . "+";
//    $string = $string . "Nhà cái: " . $arr["hostPlayer"] . "+";
    $string = $string . "+Người chơi+";
    if(isset($arr["playerInfo"])){
        foreach ($arr["playerInfo"] as $user){
            $string = $string . "  " . $user->userId . "(" . $user->ip . ")+";
        }
    }

    $string = $string . "  Chi tiết bài:" . "+";
    $currentCards = (array)get_object_vars($arr["currentCards"]);

    foreach ($currentCards as $userId => $card){
        $string = $string . "  " .  (string)$userId . ": " . convertStringToCardBaCay($card) . "+";
    }
    $string = $string .  "  Lượt cược" . "+";
    if(isset($arr["turn"])){
        $turn = $arr["turn"];
        foreach ($turn as $i => $rurnBet){
            $string = $string . "  " . $rurnBet->userId . " " . $rurnBet->description . " " . $rurnBet->data . " Mon" . "+";
        }
    }

    $string = $string . "Cập nhật tiền" . "+";
    $changeMoney= (array)(get_object_vars($arr["changeMoney"]));

    if (sizeof($changeMoney) > 0){
        foreach ($changeMoney as $userId => $changeMoney){
            $change_text = $changeMoney > 0 ? " Thắng " : " Thua ";
            $string = $string .(string)$userId . $change_text .  (string)number_format($changeMoney) . " Mon,+";
        }
    }
    return $string;
}
function getDescriptionTLMN($content){
    $arr =  (array) json_decode($content);
//    var_dump($arr);die;
    $minbet = isset($arr["minbet"]) ? $arr["minbet"] : "0";
    $string = "Mức Cược: " . $minbet . " mon+";
    $room = $arr["vipRoom"] ? "Vip" : "Thường";
    $firstTurnPlayer = $arr["firstTurnPlayer"] ? $arr["firstTurnPlayer"] : NULL;
    $string = $string . "Phòng: " . $room . "+";
    $string = $string .  "Thời gian bắt đầu:" . $arr["startTime"] . "+";
    $string = $string .  "Thời gian kết thúc:" . $arr["endTime"] . "+";
    $string = $string . "+Người chơi+";
    if(isset($arr["playerInfo"])){
        foreach ($arr["playerInfo"] as $user){
            $string = $string . "  " . $user->userId . "(" . $user->ip . ")+";
        }
    }
    $string = $string . "  Chi tiết bài:" . "+";
    $originalCard = $arr["originalCards"];

    foreach ($originalCard as $userId => $card){

            $string = $string . "  " .  (string)$userId . ": " . convertStringToCardTLMN($card) . "+";
    }
    $string = $string . "+Người đánh đầu tiên" . $firstTurnPlayer . "+";
    $string = $string .  "  Lượt đánh" . "+";
    if(isset($arr["turn"])){
        $turn = $arr["turn"];
        foreach ($turn as $i => $objrurn){
            $luot_danh =(string) $i + 1;
            $string = $string . "  Lượt " . $luot_danh . ":";
//        if($objcard->action < 4){
            $data = $objrurn->data;
            $arrData =  (array) json_decode($data);
//var_dump($arrData);die;
            $cards = isset($arrData["cards"])? $arrData["cards"] : "";
            $string = $string . "  ". (string) $objrurn->userId . "  " . $objrurn->description . " " . convertStringToCardTLMN((string) $cards) ;
            if(isset($arrData["changeMoney"])){
                foreach ($arrData["changeMoney"] as $userId => $money){
                    $change_text = $money > 0 ? " Thắng " : " Thua ";
                    $string = $string . (string) $userId . $change_text .  $money . ", ";
                }
            }
            $string = $string . "+";
        }
    }

//    $string = $string . "Người thắng:" . $arr["winner"] . "+";
    $string = $string . "Cập nhật tiền" . "+";
    $changeMoney= (array)(get_object_vars($arr["changeMoney"]));

    if (sizeof($changeMoney) > 0){
        foreach ($changeMoney as $userId => $changeMoney){
            $change_text = $changeMoney > 0 ? " Thắng " : " Thua ";
            $string = $string .(string)$userId . $change_text .  (string)number_format($changeMoney) . " Mon, ";
        }
    }
    return $string;
}
function getDescriptionPhom($content){
    $arr =  (array) json_decode($content);
    //dang hoan thanhd
//    var_dump($arr);die;
    $minbet = isset($arr["minbet"]) ? $arr["minbet"] : "0";
    $string = "Mức Cược: " . $minbet . " mon+";
    $room = $arr["vipRoom"] ? "Vip" : "Thường";
    $firstTurnPlayer = $arr["firstTurnPlayer"] ? $arr["firstTurnPlayer"] : NULL;
    $string = $string . "Phòng: " . $room . "+";
    $startTime = isset($arr["startTime"])? $arr["startTime"] : "";
    $endTime = isset($arr["endTime"])? $arr["endTime"] : "";
    $string = $string .  "Thời gian bắt đầu:" . $startTime . "+";
    $string = $string .  "Thời gian kết thúc:" . $endTime . "+";
    $string = $string . "+Người chơi+";
    if(isset($arr["playerInfo"])){
        foreach ($arr["playerInfo"] as $user){
            $string = $string . "  " . $user->userId . "(" . $user->ip . ")+";
        }
    }
    $string = $string . "  Chi tiết bài:" . "+";
//    $originalCard = $arr["originalCard"];
    $originalCard = (array)get_object_vars($arr["originalCards"]);

    foreach ($originalCard as $userId => $card){

        $string = $string . "  " .  (string)$userId . ": " . convertStringToCardPhom($card) . "+";
    }
//    var_dump($string);die;
    $string = $string . "+Người đánh đầu tiên: " . $firstTurnPlayer . "+";
    $string = $string .  "  Lượt đánh" . "+";
    $arr_actions = array("", "đánh bài", "bốc bài", "ăn bài", "gửi bài", "hạ phỏm", "tự động hạ");
    if(isset($arr["turn"])){
        $turn = $arr["turn"];

        foreach ($turn as $i => $objrurn){
            $luot_danh =(string) $i + 1;
            $string = $string . "  Lượt " . $luot_danh . ":";
//        if($objcard->action < 4){
            $data = $objrurn->data;
            $arrData =  (array) json_decode($data);
//var_dump($arrData);die;
            $string = $string . "  ". (string) $objrurn->userId . "  " . $objrurn->description . " " . convertStringToCardPhom((string) $arrData["cards"]) ;
            if(isset($arrData["changeMoney"])){
                foreach ($arrData["changeMoney"] as $userId => $money){
                    $change_text = $money > 0 ? " Thắng " : " Thua ";
                    $string = $string . (string) $userId . $change_text .  $money . ", ";
                }
            }
            $string = $string . "+";
//        }
        }
    }

//    $string = $string . "Người thắng:" . $arr["winner"] . "+";
    $string = $string . "Cập nhật tiền" . "+";
    $changeMoney= (array)(get_object_vars($arr["changeMoney"]));

    if (sizeof($changeMoney) > 0){
        foreach ($changeMoney as $userId => $changeMoney){
            $change_text = $changeMoney > 0 ? " Thắng " : " Thua ";
            $string = $string .(string)$userId . $change_text .  (string)number_format($changeMoney) . " Mon, ";
        }
    }
    return $string;
}
function getDescriptionMauBinh($content){
    $arr =  (array) json_decode($content);
//    var_dump($arr);die;
    $minbet = isset($arr["minbet"]) ? $arr["minbet"] : "0";
    $string = "Mức Cược: " . $minbet . " mon+";
    $room = isset($arr["vipRoom"]) ? "Vip" : "Thường";
    $string = $string . "Phòng: " . $room . "+";
    $startTime = isset($arr["startTime"])? $arr["startTime"] : "";
    $endTime = isset($arr["endTime"])? $arr["endTime"] : "";
    $string = $string .  "Thời gian bắt đầu:" . $startTime . "+";
    $string = $string .  "Thời gian kết thúc:" . $endTime . "+";
    $string = $string . "+Người chơi+";
    if(isset($arr["playerInfo"])){
        foreach ($arr["playerInfo"] as $user){
            $string = $string . "  " . $user->userId . "(" . $user->ip . ")+";
        }
    }

    $string = $string . "  Chi tiết bài:" . "+";
    if(isset($arr["currentCards"])){
        $currentCards = (array)get_object_vars($arr["currentCards"]);
        foreach ($currentCards as $userId => $objcard){
            $arrUserIdCard = (array)(get_object_vars($objcard));
            $string = $string . "  " .  (string)$userId . "+";
            $string = $string .  ".  Chi 1: " . convertStringToCardMauBinh($arrUserIdCard["firstBranch"]) . "+";
            $string = $string .  ".  Chi 2: " . convertStringToCardMauBinh($arrUserIdCard["centerBranch"]) . "+";
            $string = $string .  ".  Chi 3: " . convertStringToCardMauBinh($arrUserIdCard["lastBranch"]) . "+";
        }
    }
    $string = $string . "Cập nhật tiền:" . "+";
    if(isset($arr["changeMoney"])){
        $changeMoney= (array)(get_object_vars($arr["changeMoney"]));
        if (sizeof($changeMoney) > 0){
            foreach ($changeMoney as $userId => $changeMoney){
                $change_text = $changeMoney > 0 ? " Thắng " : " Thua ";
                $string = $string .(string)$userId . $change_text .  (string)number_format($changeMoney) . " Mon,+";
            }
        }
    }


    return $string;
}
function getDescriptionXiTo($content){
    $arr =  (array) json_decode($content);
//    var_dump($arr);die;
    $minbet = isset($arr["minbet"]) ? $arr["minbet"] : "0";
    $string = "Mức Cược: " . $minbet . " mon+";
    $room = isset($arr["vipRoom"]) ? "Vip" : "Thường";
    $string = $string . "Phòng: " . $room . "+";
    $startTime = isset($arr["startTime"])? $arr["startTime"] : "";
    $endTime = isset($arr["endTime"])? $arr["endTime"] : "";
    $string = $string .  "Thời gian bắt đầu:" . $startTime . "+";
    $string = $string .  "Thời gian kết thúc:" . $endTime . "+";
    $string = $string . "+Người chơi+";
    if(isset($arr["playerInfo"])){
        foreach ($arr["playerInfo"] as $user){
            $string = $string . "  " . $user->userId . "(" . $user->ip . ")+";
        }
    }

    $string = $string . "  Chi tiết bài:" . "+";
    if(isset($arr["currentCards"])){
        $currentCards = (array)get_object_vars($arr["currentCards"]);
        foreach ($currentCards as $userId => $stringCard){
            $string = $string . "  " .  (string)$userId .":". convertStringToCardMauBinh((string) $stringCard) . "+";
        }
    }
    $turn = $arr["turn"];
//    $arr_actions = array("", "đánh bài", "bốc bài", "ăn bài", "gửi bài", "hạ phỏm", "tự động hạ");
    if(isset($turn)){
        foreach ($turn as $i => $objrurn){
            $luot_danh =(string) $i + 1;
            $string = $string . "  Lượt " . $luot_danh . ":";
            $money = "";
            if(isset($objrurn->data)){
//                $data = $objrurn->data;
//                var_dump(json_decode($objrurn->data));die;
                $arrayCard = explode(":", $objrurn->data);
                $money = isset($arrayCard[1]) ? $arrayCard[1] : "";
            }
            $string = $string . "  ". (string) $objrurn->userId . "  " . $objrurn->description . "  " . (string) $money . "+";

        }
    }

    $string = $string . "Cập nhật tiền:" . "+";
    if(isset($arr["changeMoney"])){
        $changeMoney= (array)(get_object_vars($arr["changeMoney"]));
        if (sizeof($changeMoney) > 0){
            foreach ($changeMoney as $userId => $changeMoney){
                $change_text = $changeMoney > 0 ? " Thắng " : " Thua ";
                $string = $string .(string)$userId . $change_text .  (string)number_format($changeMoney) . " Mon,+";
            }
        }
    }


    return $string;
}
//poker
function getDescriptionPoker($content){
    $arr =  (array) json_decode($content);
//    var_dump($arr);die;
    $minbet = isset($arr["minbet"]) ? $arr["minbet"] : "0";
    $string = "Mức Cược: " . $minbet . " mon+";
    $room = isset($arr["vipRoom"]) ? "Vip" : "Thường";
    $string = $string . "Phòng: " . $room . "+";
    $startTime = isset($arr["startTime"])? $arr["startTime"] : "";
    $endTime = isset($arr["endTime"])? $arr["endTime"] : "";
    $string = $string .  "Thời gian bắt đầu:" . $startTime . "+";
    $string = $string .  "Thời gian kết thúc:" . $endTime . "+";
    $string = $string . "+Người chơi+";
    if(isset($arr["playerInfo"])){
        foreach ($arr["playerInfo"] as $user){
            $string = $string . "  " . $user->userId . "(" . $user->ip . ")+";
        }
    }
    $string = $string . "+Người đầu tiên: " . $arr["firstTurnPlayer"] . "+";

    $string = $string . "  Chi tiết bài:" . "+";
    if(isset($arr["currentCards"])){
        $currentCards = (array)get_object_vars($arr["currentCards"]);
        foreach ($currentCards as $userId => $stringCard){
            $string = $string . "  " .  (string)$userId .":". convertStringToCardMauBinh($stringCard) . "+";
        }
    }
    $turn = $arr["turn"];
//    $arr_actions = array("", "đánh bài", "bốc bài", "ăn bài", "gửi bài", "hạ phỏm", "tự động hạ");
    if(isset($turn)){
        foreach ($turn as $i => $objrurn){
            $luot_danh =(string) $i + 1;
            $string = $string . "  Lượt " . $luot_danh . ":";
            $money = "";
            if(isset($objrurn->data)){
                $arrayCard = explode(":", $objrurn->data);
                $money = isset($arrayCard[1]) ? $arrayCard[1] : "";
            }
            $string = $string . "  ". (string) $objrurn->userId . "  " . $objrurn->description . "  " . (string) $money . "+";

        }
    }

    $string = $string . "Cập nhật tiền:" . "+";
    if(isset($arr["changeMoney"])){
        $changeMoney= (array)(get_object_vars($arr["changeMoney"]));
        if (sizeof($changeMoney) > 0){
            foreach ($changeMoney as $userId => $changeMoney){
                $change_text = $changeMoney > 0 ? " Thắng " : " Thua ";
                $string = $string .(string)$userId . $change_text .  (string)number_format($changeMoney) . " Mon,+";
            }
        }
    }


    return $string;
}
//Lieng
function getDescriptionLieng($content){
    $arr =  (array) json_decode($content);
//    var_dump($arr);die;
    $minbet = isset($arr["minbet"]) ? $arr["minbet"] : "0";
    $string = "Mức Cược: " . $minbet . " mon+";
    $room = isset($arr["vipRoom"]) ? "Vip" : "Thường";
    $string = $string . "Phòng: " . $room . "+";
    $startTime = isset($arr["startTime"])? $arr["startTime"] : "";
    $endTime = isset($arr["endTime"])? $arr["endTime"] : "";
    $string = $string .  "Thời gian bắt đầu:" . $startTime . "+";
    $string = $string .  "Thời gian kết thúc:" . $endTime . "+";
    $string = $string . "+Người chơi+";
    if(isset($arr["playerInfo"])){
        foreach ($arr["playerInfo"] as $user){
            $string = $string . "  " . $user->userId . "(" . $user->ip . ")+";
        }
    }
    $string = $string . "+Người đầu tiên: " . $arr["firstTurnPlayer"] . "+";

    $string = $string . "  Chi tiết bài:" . "+";
    if(isset($arr["currentCards"])){
        $currentCards = (array)get_object_vars($arr["currentCards"]);
        foreach ($currentCards as $userId => $stringCard){
            $string = $string . "  " .  (string)$userId .":". convertStringToCardLieng((string) $stringCard) . "+";
        }
    }
    $turn = $arr["turn"];
//    $arr_actions = array("", "đánh bài", "bốc bài", "ăn bài", "gửi bài", "hạ phỏm", "tự động hạ");
    if(isset($turn)){
        foreach ($turn as $i => $objrurn){
            $luot_danh =(string) $i + 1;
            $string = $string . "  Lượt " . $luot_danh . ":";
            $money = "";
            if(isset($objrurn->data)){
                $arrayCard = explode(":", $objrurn->data);
                $money = isset($arrayCard[1]) ? $arrayCard[1] : "";
            }
            $string = $string . "  ". (string) $objrurn->userId . "  " . $objrurn->description . "  " . (string) $money . "+";

        }
    }

    $string = $string . "Cập nhật tiền:" . "+";
    if(isset($arr["changeMoney"])){
        $changeMoney= (array)(get_object_vars($arr["changeMoney"]));
        if (sizeof($changeMoney) > 0){
            foreach ($changeMoney as $userId => $changeMoney){
                $change_text = $changeMoney > 0 ? " Thắng " : " Thua ";
                $string = $string .(string)$userId . $change_text .  (string)number_format($changeMoney) . " Mon,+";
            }
        }
    }


    return $string;
}
function convertStringToCardLieng($string){
    if($string == ""){
        return "Bỏ lượt";
    }
    $arrayCard = explode(",", $string);
    $str = "";
//    var_dump($arrayCard);die;
    foreach ($arrayCard as $card){
        $str = $str . getNameCardLieng($card). ", ";
    }
//    var_dump($str);die;
    return $str;
}
function getNameCardLieng($int){
    $sodu = $int % 4;
    $arr_chat = array("rô", "bích", "tép", "cơ");
    $chat = $arr_chat[$sodu];
    $array_quan = array(2, 3, 4, 5, 6, 7, 8, 9, 10, "J", "Q", "K", "Át");
    $quan = $array_quan[($int - 1) / 4];
    return $quan . " " . $chat;
}
function convertStringToCardTLMN($string){
    if($string == ""){
        return "";
    }
    $arrayCard = explode(",", $string);
    $str = "";
//    var_dump($arrayCard);die;
    foreach ($arrayCard as $card){
        $str = $str . getNameCardTLMN($card). ", ";
    }
//    var_dump($str);die;
    return $str;
}
function getNameCardTLMN($int){
    $sodu = $int % 4;
    $arr_chat = array("cơ", "bích", "tép", "rô");
    $chat = $arr_chat[$sodu];
    $array_quan = array(3, 4, 5, 6, 7, 8, 9, 10, "J", "Q", "K", "Át", "2");
    $quan = $array_quan[($int - 1) / 4];
    return $quan . " " . $chat;
}
// ba cay
function convertStringToCardBaCay($string){
//    if($string == ""){
//        return "Bỏ lượt";
//    }
    $arrayCard = explode(",", $string);
    $str = "";
//    var_dump($arrayCard);die;
    $sum = 0;
    foreach ($arrayCard as $card){
        $str = $str . getNameCardBaCay($card). ", ";
        $sum = $sum + (int)(($card-1) /4 + 1);
    }
    $sum = $sum % 10;
    if($sum == 0){
        $sum = "10";
    }
    return $str ."(". (string) $sum . " Điểm" . ")";
}
function getNameCardBaCay($int){
    $sodu = $int % 4;
    $arr_chat = array("rô", "bích", "tép", "cơ");
    $chat = $arr_chat[$sodu];
    $array_quan = array("Át", 2, 3, 4, 5, 6, 7, 8, 9);
    $quan = $array_quan[($int - 1) / 4];
    return $quan . " " . $chat;
}
//xito
function convertStringToCardXiTo($string){
    $arrayCard = explode(",", $string);
    $str = "";
//    var_dump($arrayCard);die;
    foreach ($arrayCard as $card){
        $str = $str . getNameCardXiTo($card). ", ";
    }
//    var_dump($str);die;
    return $str;
}
function getNameCardXiTo($int){
    $int = $int - 20;
    $sodu = $int % 4;
    $arr_chat = array("cơ", "bích", "tép", "rô");
    $chat = $arr_chat[$sodu];
    $array_quan = array(7, 8, 9, 10, "J", "Q", "K", "Át");
    $quan = $array_quan[($int - 1) / 4];
    return $quan . " " . $chat;
}

//mau binh
// ba cay
function convertStringToCardMauBinh($string){
    $arrayCard = explode(",", $string);
    $str = "";
//    var_dump($arrayCard);die;
    foreach ($arrayCard as $card){
        $str = $str . getNameCardMauBinh($card). ", ";
    }
//    var_dump($str);die;
    return $str;
}
function getNameCardMauBinh($int){
    $sodu = $int % 4;
    $arr_chat = array("cơ", "bích", "tép", "rô");
    $chat = $arr_chat[$sodu];
    $array_quan = array(2, 3, 4, 5, 6, 7, 8, 9, 10, "J", "Q", "K", "Át");
    $quan = $array_quan[($int - 1) / 4];
    return $quan . " " . $chat;
}
// danh sách quân bài
function convertStringToCardPhom($string){
    $arrayCard = explode(",", $string);
    $str = "";
    foreach ($arrayCard as $card){
        $str = $str . getNameCardPhomString($card). ", ";
    }
    return $str;
}
// bộ bài
function getNameCardPhomString($string){
//    var_dump($string);die;
    if(strlen($string) > 2){
        // bộ bài cách nhau bằng dấu -
        $str = "";

        $arrayCard = explode("-", $string);
//        var_dump($arrayCard);
        foreach ($arrayCard as $card){
//            var_dump($card);die;
            $str = $str . getNameCardPhom($card). "-";
        }
        return substr($str, 0, -1);
    } else {
        return getNameCardPhom($string);
    }

}
function getNameCardPhom($int){
    $sodu = $int % 4;
    $arr_chat = array("cơ", "bích", "tép", "rô");
    $chat = $arr_chat[$sodu];
    $array_quan = array("Át", 2, 3, 4, 5, 6, 7, 8, 9, 10, "J", "Q", "K");
    $quan = isset($array_quan[($int - 1) / 4]) ? $array_quan[($int - 1) / 4] : $int;
    return $quan . " " . $chat;
}

function checkAlarm(){
    return \App\CrashTableAlarm::where('isAlarm','=','1')->count();
}

function getSerial($responseData){
    if($responseData != ''){
        $result = substr($responseData, 1, -1);
        return json_decode($result)->serial;
    }
    return null;
}

function getToday(){
    $today = date("m/d/Y");

    return $today . ' - ' . $today;
}

function get7Day(){
    $today = date('m/d/Y');

    $sevenDay = date('m/d/Y', strtotime("-7 days"));

    return $sevenDay . ' - ' . $today;
}

function getTodayPicker(){
    $today = date("m/d/Y");

    return $today . ' - ' . $today;
}

function checkPurchaseMoney($cardSerial,$cardPin){
    $check = 0;
    $checkLogPayment = \App\LogPayment::where(['seria' => $cardSerial, 'pin_card' => $cardPin, 'status' => 1])->count();
    $checkPurchaseMoney = \App\PurchaseMoney::where(['cardSerial' => $cardSerial, 'cardPin' => $cardPin, 'status' => 1])->count();
    if($checkLogPayment > 0 && $checkPurchaseMoney == 0){
        $check = 1;
    }

    if($checkLogPayment == 1 && $checkPurchaseMoney == 1){
        \App\PurchaseMoneyError::where(['cardSerial' => $cardSerial, 'cardPin' => $cardPin, 'active' => 1])->update(['active' => 0]);
    }

    return $check;
}

function getParValue($cardSerial,$cardPin){
    $rs = \App\LogPayment::where(['seria' => $cardSerial, 'pin_card' => $cardPin, 'status' => 1])->first();

    $money = null;
    if($rs != null){
        $money = $rs['money'];
    }

    return $money;
}