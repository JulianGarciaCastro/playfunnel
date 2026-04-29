<?php

session_start();

function update_data_card_hp_refreshToken($request){
    
    //if(session('hp_update_card_url')==""){
    if(true){

        $url_hp         = "https://accounts.zoho.com/oauth/v2/token";
        $refreshToken   = "1000.5fb9aa560b50f8ac52e88b98936116a9.d25853bf0a532f5b50e863a229844e49"; // refresh_token
        $client_id      = "1000.68CNC5Q1D4BK42676ELC3BPXXWJFXY";
        $client_secret  = "c585c0d004b099b0316bb21e559755e167a3e6c142";
        $redirect_uri   = "https://accounts.zohoportal.com/accounts/extoauth/clientcallback";
        $body           = array(
            "refresh_token" => $refreshToken,
            "client_id"     => $client_id,
            "client_secret" => $client_secret,
            "redirect_uri"  => $redirect_uri,
            "grant_type"    => "refresh_token"
        );
 
        //$headers = ['content-type: application/json'];

        //hp_update_card_expiring_time

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url_hp);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
       
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  // Evitar error de certificado
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Evitar error de certificado 

        if( ! $result = curl_exec($ch)){
            //echo "SCOREAPPS-ERROR: <br>";
            //print_r(curl_error($ch));, 
            Log::info("SCOREAPPS-ERROR (".__FILE__." - linea: ".__LINE__."): ");
            Log::info(curl_error($ch));
            return "";
        }else{
            //echo "SCOREAPPS-RESULTADO: <br>";
            //print_r($result);
            //echo "============ <br>";
            $result_hp = json_decode($result);
            /** // Ejemplo de resultado:
                {
                    "access_token": "1000.fa053ecd94885ac305bf0a050f721670.76b023940dafa16524c9354bce7a5e9b",
                    "expires_in_sec": 3600,
                    "scope": "ZohoSubscriptions.hostedpages.CREATE",
                    "api_domain": "https://www.zohoapis.com",
                    "token_type": "Bearer",
                    "expires_in": 3600000
                }
             */
            //print_r($result_hp);
            if(!isset($result_hp)){ // 
                //echo "** KO **<br>\n";
                Log::info("SCOREAPPS-ERROR (".__FILE__." - linea: ".__LINE__."): ");
                Log::info("\$result_hp está vacía");
                return "";
            }else{
                //echo "** OK **<br>\n";
                //echo "** access_token: ".$result_hp->access_token."**<br>\n";
                if(isset($result_hp->access_token)){
                    return $result_hp->access_token;
                }else{
                    Log::info("SCOREAPPS-ERROR (".__FILE__." - linea: ".__LINE__."): ");
                    Log::info("Contenido de \$result_hp:");
                    Log::info($result_hp);
                    return "";
                }
            }
        }

        curl_close($ch);
    }else{

    }

}

function update_data_card_hp($request){
    
    //if(session('hp_update_card_url')==""){
    if(true){

        $url_hp         = "https://www.zohoapis.com/billing/v1/hostedpages/updatecard";
        $authToken      = (session('hp_update_card_access_token')=="")?"1000.d4bc6ea036fa353cb6cea7d35c6b7d91.cba282a0be6c420c45587452df6d86e8":session('hp_update_card_access_token'); // Zoho-oauthtoken
        $organizationId = "57733560"; // X-com-zoho-subscriptions-organizationid
        $contentType    = "application/json"; // content-type
        $body           = '{
            "subscription_id": "162146000048894266",
            "auto_collect": true,
            "redirect_url": "https://app.scoreapps.com/updatecard_hp_ok"
        }';
        // session('id_card')

        $headers = [
            'Authorization: Zoho-oauthtoken '.$authToken,
            'X-com-zoho-subscriptions-organizationid: '.$organizationId,
            'content-type: '.$contentType,
        ];
        //hp_update_card_expiring_time

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url_hp);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
       
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  // Evitar error de certificado
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Evitar error de certificado

        if( ! $result = curl_exec($ch)){
            //echo "SCOREAPPS-ERROR: <br>";
            //print_r(curl_error($ch));, 
            Log::info("SCOREAPPS-ERROR (".__FILE__." - linea: ".__LINE__."): ");
            Log::info(curl_error($ch));
        }else{
            //echo "SCOREAPPS-RESULTADO: <br>";
            //print_r($result);
            //echo "============ <br>";
            Log::info("SCOREAPPS-OK (".__FILE__." - linea: ".__LINE__."): ");

            $result_hp = json_decode($result);
            /**
             * Ejemplo de respuesta: 
             {
                "code": 0,
                "message": "La página alojada se ha creado correctamente.",
                "hostedpage": {
                    "hostedpage_id": "2-6d8ed6f9b6a18efb51045895cddb92881ab4d3c9c111b4793e672c1356c4933c7f5b8916e0b4382f95e7f706b749742d",
                    "decrypted_hosted_page_id": "162146000049205553",
                    "status": "fresh",
                    "url": "https://billing.zoho.com/hostedpage/2-6d8ed6f9b6a18efb51045895cddb92881ab4d3c9c111b4793e672c1356c4933c7f5b8916e0b4382f95e7f706b749742d/checkout",
                    "action": "update_card",
                    "expiring_time": "2024-03-04T12:17:51+0100",
                    "created_time": "2024-03-04T11:17:51+0100"
                }
            }
            */

            print_r($result_hp);
            //if(isset($result_hp['code']) && $result_hp['code']==57){ // code:57 -> You are not authorized to perform this operation
            if(isset($result_hp['code']) && $result_hp['code']==57){ // code:57 -> You are not authorized to perform this operation
                //echo "** KO **<br>\n";
                Log::info("SCOREAPPS-OK (".__FILE__." - linea: ".__LINE__."): ");
                $access_token =  update_data_card_hp_refreshToken(1);
                if(session('hp_update_card_intentos')<1){
                    session(['hp_update_card_intentos' => '1']);
                    session(['hp_update_card_access_token' => $access_token]); 
                    Log::info("SCOREAPPS-OK (".__FILE__." - linea: ".__LINE__."): ");
                    Log::info("session(hp_update_card_intentos) = 1");
                    Log::info("Llamada recursiva a 'update_data_card_hp()'");
                    update_data_card_hp($request);
                }else{
                    Log::info("SCOREAPPS-ERROR (".__FILE__." - linea: ".__LINE__."): ");
                    Log::info("Se ha hecho más de un intento de obtención de access token. Hay que revisar porqué no se consigue el nuevo token. Se puede usar Postman para probar qué está pasando");
                    session(['hp_update_card_intentos' => '0']);
                    return "Error al acceder a la pasarela de pago. Contacte con el administrador.";
                }
            }
            //echo "** OK **<br>\n";

            //echo "Hosted page update card:<br>\n";
            session(['hp_update_card_expiring_time' =>  $result_hp->expiring_time]);
            session(['hp_update_card_hp_id'         =>  $result_hp->hostedpage_id]);
            session(['hp_update_card_hp_id_dec'     =>  $result_hp->decrypted_hosted_page_id]);

            return redirect($result_hp->url);   
        }

        curl_close($ch);
    }else{

    }

}

update_data_card_hp(1);

