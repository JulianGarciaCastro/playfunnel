<?php
  
namespace App\Rules;
  
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
  
class ReCaptcha implements Rule
{
    
    private $error_msg   = '';
    private $errorMessage = [
        "missing-input-secret"   => "The secret parameter is missing.",
        "invalid-input-secret"   => "The secret parameter is invalid or malformed.",
        "missing-input-response" => "The response parameter is missing.",
        "invalid-input-response" => "The response parameter is invalid or malformed.",
        "bad-request"            => "The request is invalid or malformed.",
        "timeout-or-duplicate"   => "The response is no longer valid: either is too old or has been used previously.",
    ];
    
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
          
    }
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        
        Log::debug('ReCaptcha: attr ' . $attribute . ' value: '. $value);
        
        if (empty($value)) {
            $this->error_msg = 'Se requiere validdar reCAPTCHA';
            return false;
        }
        
        $response = Http::get(env('RECAPTCHA_V3_VERIFICATION_URL'),[
            'secret' => env('RECAPTCHA_V3_SECRET_KEY'),
            'response' => $value,
        ]);
        
        Log::debug('ReCaptcha Respuesta $response: '   . json_encode($response));
        Log::debug('ReCaptcha Respuesta successful(): '. $response->successful());
        Log::debug('ReCaptcha Respuesta success: '     . $response->json('success'));
        Log::debug('ReCaptcha Respuesta score: '       . $response->json('score'));
        Log::debug('ReCaptcha Respuesta hostname: '    . $response->json('hostname')); 
        Log::debug('ReCaptcha Respuesta error-codes: ' . json_encode($response->json('error-codes')));
        
        if(!$response->json('success')){
            
            collect($response->object()->{"error-codes"})->each(function ($item) use(&$errorMessage){
                $this->error_msg.=$this->errorMessage[$item];
            });
            
            Log::debug('ReCaptcha error_msg: ' .  $this->error_msg);
            return false;
        }
        
        
        if ($response->successful() && $response->json('success') && $response->json('score') > 0.85) {
            return true;
        }
          
        //return $response->json()["success"];
        return false;
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        //return 'The google recaptcha is required.';
        
        return $this->error_msg;
    }
}