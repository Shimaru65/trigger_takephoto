<?php
include "../connect/dbconnect.php"; 
ini_set("memory_limit", "200000000"); //setup memory ����Թ 200000000
$data_back = json_decode(file_get_contents('php://input'));
$qrcode = $data_back->{"qrcode"}; // �Ѻ��� json �������
$return = array("resultcode"=>"200","qrcode"=>$qrcode); //���ǵͺ��Ѻ
header("Content-type: application/json");
echo json_encode($return);
$sql = "SELECT columnname FROM tablename WHERE qrcode = '$qrcode'"; // �� database ����� qrcode ������Թ�������
$result = mssql_query($sql);
$num_row = mssql_num_rows($result);
if($num_row > 0){ #������Թ�������㹹��
    $row = mssql_fetch_array($result);
    $sql2 = "SELECT Camera1,id FROM fg_takephoto WHERE id = '6'"; #���¡������ URL ���ͧ���������ٻ
    $result2 = mssql_query($sql2);
    $row2 = mssql_fetch_array($result2);
    $Camera1 = $row2["http://admin:ID@Passwrod@IPcamera/ISAPI/Streaming/channels/1/picture"]; #�URL ���ͧ����������ٻ
    $billingid = $row[billingid];
    $picname = date("YmdHis");
    $date_take = date("Y-m-d H:i:s");
    $imagestr = file_get_contents("$Camera1"); #�Ѻ����Ҩҡ���ͧ
    $image = imagecreatefromstring($imagestr); #���ҧ�ٻ�ҡ��� string ������Ѻ
    imagejpeg($image,"image/".$billingid."_".$picname.".jpg"); #�ŧ�� jpg �������駪��� 
    $picname1 = $billingid."_".$picname.".jpg";
    $sql3 ="INSERT INTO tablename (column1,column2,...) VALUES (value1,value2,...)";
    $result3 = mssql_query($sql3);
}else{

}
