<?php
/**
 * Created by PhpStorm.
 * User: maxim / WEB Котлас / www.web-kotlas.ru
 * Date: 11/03/2022
 * Time: 12:51
 */
namespace webkotlas\iiko;


class iikoApiCore
{
    const VERSION = "1.0.0";

    // required without access_token
    public $api_key;
    public $access_token;
    public $organization_id;


    // optional / defaults
    public $user_agent = 'WK iiko PHP API Library';
    public $domain = 'api-ru.iiko.services';
    public $protocol = 'https';
    public $proxy = '';
    public $proxy_pwd = '';

    // helpers
    public $base_api_url;
    public $error = null;

    public $curl_ipresolve_supported;
    public $last_request_http_code;


    public function __construct($config)
    {
        foreach ($config as $key => $value) {
            $this->$key = $value;
        }

        $this->base_api_url = $this->protocol . '://' . $this->domain . '/api/1/';

        if (!$this->api_key && !$this->organization_id) {
            throw new \Exception('Missing access api_key or organization_id');
        }

        if (!$this->user_agent) {
            throw new \Exception('Missing user agent');
        }

        // PHP 5.3.0
        $this->curl_ipresolve_supported = defined('CURLOPT_IPRESOLVE');

    }

    /**
     * @return $this
     */
    public function initToken(){
        if(empty($this->access_token)) $this->setAccessToken($this->getToken());
        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        try {
            $response = $this->makeApiRequest("access_token", "POST",
                [
                    'apiLogin' => $this->getApiKey()
                ]
            );
            return ($this->getLastRequestHttpCode() === 200 && !empty($response->token)) ? $response->token : '';
        }catch (\Exception $e){
            return '';
        }
    }

    /**
     * Makes request to Poster
     *
     * @param string $url
     * @param string $type
     * @param string $params
     * @param bool $json
     * @param array $headers
     * @return mixed
     */
    public function sendRequest($url, $type = 'POST', $params = '', $json = false, $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


        // подключение к прокси-серверу
        if(!empty($this->proxy)) {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        }
        if(!empty($this->proxy_pwd)) {
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_pwd);
        }

        if (count($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if ($type == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);

            if ($json) {
                $params = json_encode($params);

                curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($headers, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($params)
                ]));
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        if ($this->curl_ipresolve_supported) {
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        }

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60 * 20);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent." ".self::VERSION);
        $result = curl_exec($ch);
        $this->last_request_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $result;
    }

    /**
     * Makes request to poster API method
     *
     * @param string $method – method name, e.g. menu.getProducts
     * @param string $type – GET or POST
     * @param string $params
     * @return mixed
     * @return mixed
     * @throws \Exception
     */
    public function makeApiRequest($method, $type = 'POST', $params = '', $headers=[])
    {
        $getParams = [];
        $_getParams = '';

        if ($this->access_token) {
            $headers[] = "Authorization: Bearer {$this->access_token}";
        }

        $arguments = $params ? $params : [];

        if(!empty($this->organization_id)){
            $arguments['organizationId'] = $this->organization_id;
        }

        if ($type == 'GET') {
            $getParams = array_merge($getParams, $arguments);
            $_getParams = '?' . self::prepareGetParams($getParams);
            $postParams = '';
        } else {
            $postParams = $arguments;
        }

        $request_url = self::getApiUrl() . $method . $_getParams;
        $response = self::sendRequest($request_url, $type, $postParams, true, $headers);
        $result = json_decode($response);
        if($this->getLastRequestHttpCode() !== 200 ){
            $this->error = (!empty($result->errorDescription)) ? $result->errorDescription : $response;
            throw new \Exception($this->error, $this->getLastRequestHttpCode());
        }

        return $result;
    }


    /** API departments */

    public function clients()
    {
        return new ClientsAPI($this);
    }

    public function menu()
    {
        return new MenuAPI($this);
    }

    public function orders()
    {
        return new OrdersAPI($this);
    }

    public function terminalGroup()
    {
        return new TerminalGroupAPI($this);
    }

    public function operations(){
        return new CommandsStatusAPI($this);
    }

    public function organization(){
        return new OrganizationAPI($this);
    }

    public function dictionary(){
        return new DictionaryAPI($this);
    }

    /** Setters and Getters  **/

    public function setAccessToken($accessToken)
    {
        $this->access_token = $accessToken;

        return $this;
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function setOrganizationId($organizationId)
    {
        $this->organization_id = $organizationId;
        return $this;
    }

    public function getOrganizationId()
    {
        return $this->organization_id;
    }

    public function getLastRequestHttpCode()
    {
        return (int) $this->last_request_http_code;
    }

    public function getRequestHttpError(){
        return $this->error;
    }

    public function getApiKey()
    {
        return $this->api_key;
    }

    public function getApiUrl()
    {
        return $this->base_api_url;
    }

    public function prepareGetParams($params)
    {
        $result = [];

        foreach ($params as $key => $value) {
            $result[] = $key . '=' . urlencode($value);
        }

        return implode('&', $result);
    }
}