<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class EncryptionModel extends Model
{
    use HasFactory;

    private function get_enc_details()
    {
        $enc_iv = Crypt::encryptString("eyJpdiI6IlJvWGIxSGQvVldCSVZEK0lJUU1IM2c9PSIsInZhbHVlIjoiNExCVU4xbFdqaXo1OXJkeU9nN1puQlAzMTJyVDR4OTRueVZZVnJzeGYwbz0iLCJtYWMiOiJhZjJiMmMzZGFmMDIyNzZmMjgxOGRmMDBiNDAyNzc2OWJhNGY2MTZjYjRjZjY4ODZiNTQ3OWM0MTY1YTcyYWE3IiwidGFnIjoiIn0=");
    }

    public function encrypt($data)
    {
        $simple_string = $data;
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = 'aoOqYtRvGbhhJklM';
        $encryption_key = "qfsjotfrrlwvgehylifmfnfmzewuqbsgpgslbkbnbgxhhsfqdctkrjoyzsidsldrkclkfwrrwmqvinhjmwdvlfjiigphpytyxmgvsxlskgxrwfwmuhspvverdsapkrps";
        $encryption = openssl_encrypt($simple_string, $ciphering,
            $encryption_key, $options, $encryption_iv);
        return $encryption;
    }

    public function decrypt($encrypted_data = "mqbgqA==")
    {
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $decryption_iv = 'aoOqYtRvGbhhJklM';
        $decryption_key = "qfsjotfrrlwvgehylifmfnfmzewuqbsgpgslbkbnbgxhhsfqdctkrjoyzsidsldrkclkfwrrwmqvinhjmwdvlfjiigphpytyxmgvsxlskgxrwfwmuhspvverdsapkrps";

        $decrypted_data = openssl_decrypt($encrypted_data, $ciphering,
            $decryption_key, $options, $decryption_iv);

        return $decrypted_data;
    }

}