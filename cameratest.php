<?php
include "../connect/dbconnect.php"; 
ini_set("memory_limit", "200000000"); //setup memory ไม่เกิน 200000000
$data_back = json_decode(file_get_contents('php://input'));
$qrcode = $data_back->{"qrcode"}; // รับค่า json ที่ส่งมา
$return = array("resultcode"=>"200","qrcode"=>$qrcode); //แล้วตอบกลับ
header("Content-type: application/json");
echo json_encode($return);
$sql = "SELECT columnname FROM tablename WHERE qrcode = '$qrcode'"; // เช็ค database ว่ามี qrcode นี้เป็นสินค้าอะไร
$result = mssql_query($sql);
$num_row = mssql_num_rows($result);
if($num_row > 0){ #ถ้ามีสินค้าให้ทำในนี้
    $row = mssql_fetch_array($result);
    $sql2 = "SELECT Camera1,id FROM fg_takephoto WHERE id = '6'"; #เรียกข้อมูล URL กล้องเพื่อใช้เก็บรูป
    $result2 = mssql_query($sql2);
    $row2 = mssql_fetch_array($result2);
    $Camera1 = $row2["http://admin:ID@Passwrod@IPcamera/ISAPI/Streaming/channels/1/picture"]; #๊URL กล้องเพื่อใช้ถ่ายรูป
    $billingid = $row[billingid];
    $picname = date("YmdHis");
    $date_take = date("Y-m-d H:i:s");
    $imagestr = file_get_contents("$Camera1"); #รับค่ามาจากกล้อง
    $image = imagecreatefromstring($imagestr); #สร้างรูปจากค่า string ที่ได้รับ
    imagejpeg($image,"image/".$billingid."_".$picname.".jpg"); #แปลงเป็น jpg พร้อมตั้งชื่อ 
    $picname1 = $billingid."_".$picname.".jpg";
    $sql3 ="INSERT INTO tablename (column1,column2,...) VALUES (value1,value2,...)";
    $result3 = mssql_query($sql3);
}else{

}
