<?php

include 'aes.php';
$inputText = "Manas Vivek";
$inputKey = "7869880718";
$blockSize = 256;
$aes = new AES($inputText, $inputKey, $blockSize);
$enc = $aes->encrypt();
$aes->setData($enc);
$dec=$aes->decrypt();
echo "After encryption: ".$enc."<br/>";
echo "After decryption: ".$dec."<br/>";

?>