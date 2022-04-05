<?php

    /**
     * IGDB Utils
     *
     * A utility class for useful methods
     *
     * @version 1.0.0
     * @author Enisz Abdalla <enisz87@gmail.com>
     * @link https://github.com/enisz/igdb
     */

    require_once "IGDBInvalidParameterException.php";

    class IGDBUtils {

        /**
         * Helper method to authenticate your application via Twitch
         * @param $client_id - Your client ID from twitch
         * @param $client_secret - The generated secret token for your application
         * @return $response - the response object from Twitch with properties access_token, expires_in, token_type
         * @throws Exception If a non-success response is returned
         */
        public static function authenticate($client_id, $client_secret) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_URL, "https://id.twitch.tv/oauth2/token?client_id=$client_id&client_secret=$client_secret&grant_type=client_credentials");

            $info = curl_getinfo($curl);
            $response = json_decode(curl_exec($curl));
            $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if($responseCode < 200 || $responseCode > 299) {
                throw new Exception($response->message, $response->status);
            } else {
                return $response;
            }
        }
    }

?>