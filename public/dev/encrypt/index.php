<?php
//https://www.geeksforgeeks.org/how-to-encrypt-and-decrypt-a-php-string/#:~:text=In%20PHP%2C%20Encryption%20and%20Decryption,used%20to%20encrypt%20the%20data.&text=Parameters%3A,which%20need%20to%20be%20encrypted.
//https://www.php.net/manual/es/function.openssl-encrypt.php

$simple_string = "Hola Mundo XX";
echo "Original: ".$simple_string;
echo "<br>";
 
// Use openssl_encrypt() function to encrypt the data
$encryption = openssl_encrypt($simple_string, $ciphering="AES-128-CTR",
            $encryption_key="PlayFunnel", $options=0, $encryption_iv="1234567891011121");

echo "Encriptada: ".$encryption;

//==============================================================================
  
  
// Use openssl_decrypt() function to decrypt the data
$decryption=openssl_decrypt ($encryption, $ciphering="AES-128-CTR", 
        $decryption_key="PlayFunnel", $options=0, $decryption_iv="1234567891011121");

echo "<br>";
// Display the decrypted string
echo "Desencriptada: " . $decryption;
