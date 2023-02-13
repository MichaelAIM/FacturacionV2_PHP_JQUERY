<?php
// echo json_encode($_POST['url']);

function encrypt($text) {
	$key = "1NF0RM4T1C4v3inteV31NT32";
	$iv = "Sg3104La";
	$bit_check=8;
	$text_num =str_split($text,$bit_check);
	$text_num = $bit_check-strlen($text_num[count($text_num)-1]);
	for ($i=0;$i<$text_num; $i++) {
		$text = $text . chr($text_num);
	}
	$cipher = @mcrypt_module_open(MCRYPT_TRIPLEDES,'','cbc','');
	@mcrypt_generic_init($cipher, $key, $iv);
	$encrypted = @mcrypt_generic($cipher,$text);
	@mcrypt_generic_deinit($cipher);
	
	$respuesta = base64_encode($encrypted);
	$respuesta = str_replace(array('+', '/'), array('-', '_'),base64_encode($encrypted));
#	echo json_encode($respuesta);
	return $respuesta;
}

function decrypt($text){
	$key = "1NF0RM4T1C4v3inteV31NT32";
	$iv = "Sg3104La";
	$bit_check=8;
	$cipher = @mcrypt_module_open(MCRYPT_TRIPLEDES,'','cbc','');
	@mcrypt_generic_init($cipher, $key, $iv);
	$text = base64_decode(str_replace(array('-', '_'), array('+', '/'),$text));
	$decrypted = @mdecrypt_generic($cipher,$text);
	@mcrypt_generic_deinit($cipher);
	$last_char=substr($decrypted,-1);
	for($i=0;$i<$bit_check-1; $i++){
		if(chr($i)==$last_char){
			$decrypted=substr($decrypted,0,strlen($decrypted)-$i);
			break;
		}
	}
	return $decrypted;
}
?>