<?php 

$s = curl_init();
curl_setopt($s, CURLOPT_URL, 'nivel.ende.bo/endesis/lib/wsende/login/telma.soliz/telma.soliz');
$_out = curl_exec($s);
$status = curl_getinfo($s, CURLINFO_HTTP_CODE);
curl_close($s);
echo $_out;
print_r($status);

// curl_setopt($s, CURLOPT_RETURNTRANSFER, true);

//curl_setopt($s, CURLOPT_POST, true);
//curl_setopt($s, CURLOPT_POSTFIELDS, $encriptado);


// header('Content-Type:text/xml');
// $s = curl_init();
// curl_setopt($s, CURLOPT_URL, 'nivel.ende.bo/endesis/lib/wsende/login/12/123');
// curl_setopt($s, CURLOPT_RETURNTRANSFER, true);

// echo "<pre>";
// /*
//  * 
//    $pass_encrypted="aJ9LLQDqqzTzmv2IKSVzaWgbMmOOmRHumYJB3Ybe6LZzopH1K2XwyoFdBankmhA7IebgDoEF3GIK6xG/enfB20naEVM7ayr0sNSglVYdizJLfBy3koMYdqTDaa0D692l";
//    $headers = array("ORIGIN:$origen","ENDESIS_USER: $user","ENDESIS_PASSENCR: $pass_encrypted", "ENDESIS_PASS:$pass");
// */
// //$user = "usr_cadeb";
// $user="ana.villegas";
// $pass=md5("a");
// $origen= "http://10.100.105.59";
// $id_correspondencia=array();
// $id_correspondencia[0]='235';
// $id_correspondencia[1]='239';
// $id_correspondencia[2]='241';


// //echo serialize($id_correspondencia); exit;
// $param='id_correspondencia='.json_encode($id_correspondencia);

// //$pass_encrypted = fnEncrypt(uniqid("Endesis" ,true) . "$$$$####$$$$". $pass, $pass);
$pass_encrypted="aJ9LLQDqqzTzmv2IKSVzaWgbMmOOmRHumYJB3Ybe6LZzopH1K2XwyoFdBankmhA7IebgDoEF3GIK6xG/enfB20naEVM7ayr0sNSglVYdizJLfBy3koMYdqTDaa0D692l";
// $pass_encrypted = "G77mDubIMN0yg/g4t38x/Akk3QWAZucs+yr3YwD8h9PxkxH/vtubCHI2lAAeQlv7EqkjgFtHnV5rDPQFPCim5Q==";
// $headers = array("ORIGIN:$origen","ENDESIS_USER: $user","ENDESIS_PASSENCR: $pass_encrypted", "ENDESIS_PASS:$pass");


// curl_setopt($s, CURLOPT_HTTPHEADER, $headers);
// curl_setopt($s, CURLOPT_POST, true);
// curl_setopt($s, CURLOPT_POSTFIELDS, $param);

// $_out = curl_exec($s);

// $status = curl_getinfo($s, CURLINFO_HTTP_CODE);
// curl_close($s);
// echo $_out;
// print_r($status);
// exit;
//hola("cadeb");
///echo "<br> ENCRIPTADO: $pass_encrypted";



function hola($s){
	$pass_encrypted = fnEncrypt(uniqid("Endesis" ,true) . "$$$$####$$$$". $s, $s);
	echo "DATA: ".$pass_encrypted;	
}

function fnEncrypt($sValue, $sSecretKey)
{
	return rtrim(
			base64_encode(
					mcrypt_encrypt(
							MCRYPT_RIJNDAEL_256,
							$sSecretKey, $sValue,
							MCRYPT_MODE_ECB,
							mcrypt_create_iv(
									mcrypt_get_iv_size(
											MCRYPT_RIJNDAEL_256,
											MCRYPT_MODE_ECB
									),
									MCRYPT_RAND)
					)
			), "\0"
	);
}

?>