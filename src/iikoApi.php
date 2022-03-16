<?php
/**
 * Created by PhpStorm.
 * User: maxim / WEB Котлас / www.web-kotlas.ru
 * Date: 11/03/2022
 * Time: 12:51
 */
namespace webkotlas\iiko;


/**
 * Class iikoApi
 * @package webkotlas\iiko
 */
class iikoApi
{
    /**
     * @var iikoApiCore singleton instance
     */
    private static $instance = null;

    /**
     * Creates instance of singleton
     *
     * @param array $config [
     * @var string $api_key
     * @var string $organization_id
     * @var string $protocol default https
     * @var string $domain default api-ru.iiko.services
     * ]
     *
     * @throws \Exception
     */
    public static function init($config = [])
    {
        self::$instance = new iikoApiCore($config);
    }

    public static function singleton()
    {
        return self::$instance;
    }

    /** API departments */

    public static function clients()
    {
        return self::singleton()->initToken()->clients();
    }

    public static function menu()
    {
        return self::singleton()->initToken()->menu();
    }

    public static function orders(){
        return self::singleton()->initToken()->orders();
    }

    public static function terminalGroup(){
        return self::singleton()->initToken()->terminalGroup();
    }

    public static function operations(){
        return self::singleton()->initToken()->operations();
    }

    public static function organization(){
        return self::singleton()->initToken()->organization();
    }

    public static function dictionary(){
        return self::singleton()->initToken()->dictionary();
    }

    /** Setters and Getters  **/

    public static function setOrganizationId($organizationId)
    {
        self::singleton()->setOrganizationId($organizationId);
    }

    public static function getOrganizationId()
    {
        return self::singleton()->getOrganizationId();
    }

    public static function setAccessToken($accessToken)
    {
        self::singleton()->setAccessToken($accessToken);
    }

    public static function getAccessToken()
    {
        return self::singleton()->getAccessToken();
    }

    public static function getLastRequestHttpCode()
    {
        return self::singleton()->getLastRequestHttpCode();
    }

    public static function getRequestHttpError(){
        return self::singleton()->getRequestHttpError();
    }

    /**
     * @return string
     */
    public static function getToken()
    {
        return self::singleton()->getToken();
    }

    /**
     * @return string
     */
    public static function getApiUrl()
    {
        return self::singleton()->getApiUrl();
    }

    /**
     * @param $url
     * @param string $type
     * @param string $params
     * @param bool $json
     * @param array $headers
     * @return mixed
     */
    public static function sendRequest($url, $type = 'POST', $params = '', $json = false, $headers = [])
    {
        return self::singleton()->sendRequest($url, $type, $params, $json, $headers);
    }

    /**
     * @param $method
     * @param string $type
     * @param string $params
     * @return mixed
     * @throws \Exception
     */
    public static function makeApiRequest($method, $type = 'POST', $params = '')
    {
        return self::singleton()->initToken()->makeApiRequest($method, $type, $params);
    }
}