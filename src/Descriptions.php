<?php
/**
 * Created by PhpStorm.
 * User: maxim / WEB Котлас / www.web-kotlas.ru
 * Date: 11/03/2022
 * Time: 12:51
 */
namespace webkotlas\iiko;

/**
 * Класс API меню
 * Class MenuAPI
 * @package webkotlas\iiko
 */
class MenuAPI
{
    private $api;

    public function __construct(iikoApiCore $params)
    {
        $this->api = $params;
    }

    /**
     * nomenclature: Список товаров, тех. карт, категорий
     * @link https://api-ru.iiko.services/#tag/Menu/paths/~1api~11~1nomenclature/post
     *
     * @param mixed $startRevision Initial revision. Items list will be received only in case there is a newer revision in the database.
     * @param mixed $organizationId Organization ID.
     *
     * @return NomenclatureResponse
     * @throws \Exception
     */
    public function nomenclature($startRevision = 0, $organizationId ='')
    {
        try {
            $params = ['startRevision' => $startRevision];
            if(!empty($organizationId)) $params['organizationId'] = $organizationId;
            $response = $this->api->makeApiRequest('nomenclature', 'POST', $params);
            return new NomenclatureResponse((array) $response);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * stop_lists: Стоп лист
     * @link https://api-ru.iiko.services/#tag/Menu/paths/~1api~11~1stop_lists/post
     *
     * @param mixed $organizationId Organization ID.
     *
     * @return StopListResponse
     * @throws \Exception
     */
    public function stopLists($organizationId = '')
    {
        try {
            $params = [];
            if(!empty($organizationId)) $params['organizationId'] = $organizationId;
            $response = $this->api->makeApiRequest('stop_lists', 'POST', $params);
            return new StopListResponse((array) $response);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * combo: Получить информацию о комбо
     * @link https://api-ru.iiko.services/#tag/Menu/paths/~1api~11~1combo/post
     *
     * @param mixed $organizationId Organization ID.
     *
     * @return ComboResponse
     * @throws \Exception
     */
    public function combo($organizationId = '')
    {
        try {
            $params = [];
            if(!empty($organizationId)) $params['organizationId'] = $organizationId;
            $response = $this->api->makeApiRequest('combo', 'POST', $params);
            return new ComboResponse((array) $response);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * combo/calculate: Make combo price calculation.
     * @link https://api-ru.iiko.services/#tag/Menu/paths/~1api~11~1combo~1calculate/post
     *
     * @param array $params [
     * @var mixed $items[
     *      @var $productId string required
     *      @var $price float
     *      @var $primaryComponent array Compound [
     *          @var $productId string required
     *          @var $price float
     *          @var $positionId string
     *          @var $modifiers []
     *      ]
     *      @var $secondaryComponent array Compound [
     *          @var $productId string required
     *          @var $price float
     *          @var $positionId string
     *          @var $modifiers []
     *      ]
     *      @var $commonModifiers array Compound [
     *          @var $productId string required
     *          @var $amount float required
     *          @var $productGroupId
     *          @var $price
     *          @var $positionId
     *      ]
     *      @var $modifiers array Product [
     *          @var $productId string required
     *          @var $amount float required
     *          @var $productGroupId
     *          @var $price
     *          @var $positionId
     *      ]
     *      @var $positionId string
     *      @var $type string required Product | Compound
     *      @var $amount float required
     *      @var $productSizeId string
     *      @var $comboInformation
     *      @var $comment string
     * ]
     * @var mixed $organizationId Organization ID.
     * ]
     *
     * @return object $response — response from API
     * @throws \Exception
     */
    public function comboCalculate($params = array())
    {
        try {
            $response = $this->api->makeApiRequest('combo/calculate', 'POST', $params);
            return $response;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

}

/**
 * Класс API клиентов
 * Class MenuAPI
 * @package webkotlas\iiko
 */
class ClientsAPI{
    private $api;

    public function __construct(iikoApiCore $params)
    {
        $this->api = $params;
    }

    /**
     * loyalty/iiko/customer/info: Получить информацию о клиенте по заданному критерию.
     * @link https://api-ru.iiko.services/#tag/Customers/paths/~1api~11~1loyalty~1iiko~1customer~1info/post
     *
     * @param string $value
     * @param string $type (required) phone | cardTrack | cardNumber | email | id
     * @param string $organizationId Organization ID.
     *
     * @return ClientInfoResponse
     * @throws \Exception
     */
    public function getClient($value, $type = 'phone', $organizationId = '')
    {
        try {
            $params = [];
            if(!empty($organizationId)) $params['organizationId'] = $organizationId;
            switch ($type){
                case 'phone':
                    $params['phone'] = $value;
                    break;
                case 'cardTrack':
                    $params['cardTrack'] = $value;
                    break;
                case 'cardNumber':
                    $params['cardNumber'] = $value;
                    break;
                case 'email':
                    $params['email'] = $value;
                    break;
                default:
                    $params['id'] = $value;
                    break;
            }
            $response = $this->api->makeApiRequest('loyalty/iiko/customer/info', 'POST', $params);
            return new ClientInfoResponse((array) $response);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * loyalty/iiko/customer/create_or_update : Добавить клиента или Обновить
     * @link https://api-ru.iiko.services/#tag/Customers/paths/~1api~11~1loyalty~1iiko~1customer~1create_or_update/post
     * @param array $params [
     * @var string $organizationId Organization ID. uuid
     * @var string $id uuid
     * @var string $referrerId uuid
     * @var string $phone
     * @var string $cardTrack
     * @var string $cardNumber
     * @var string $email
     * @var string $name
     * @var string $middleName
     * @var string $surName
     * @var string $birthday Y-m-d H:i:s.fff
     * @var int $sex 0 | 1 | 2
     * @var int $consentStatus 0 | 1 | 2
     * @var string $shouldReceivePromoActionsInfo
     * @var string $userData
     * ]
     * @return object $response — response from API
     * @throws \Exception
     */
    public function addClient($params = array()){
        try {
            $response = $this->api->makeApiRequest('loyalty/iiko/customer/create_or_update', 'POST', $params);
            return $response;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Добавить карту.
     * @link https://api-ru.iiko.services/#tag/Customers/paths/~1api~11~1loyalty~1iiko~1customer~1card~1add/post
     *
     * @param string $customerId uuid
     * @param string $cardTrack
     * @param string $cardNumber
     * @param string $organizationId Organization ID. uuid
     *
     * @return boolean
     * @throws \Exception
     */
    public function addCard($customerId, $cardTrack, $cardNumber, $organizationId = ''){
        try {
            $params = ['customerId' => $customerId, 'cardTrack' => $cardTrack, 'cardNumber'=> $cardNumber];
            if(!empty($organizationId)) $params['organizationId'] = $organizationId;
            $response = $this->api->makeApiRequest('loyalty/iiko/customer/card/add', 'POST', $params);
            return true;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Удалить карту.
     * @link https://api-ru.iiko.services/#tag/Customers/paths/~1api~11~1loyalty~1iiko~1customer~1card~1remove/post
     *
     *
     * @param string $customerId uuid
     * @param string $cardTrack
     * @param string $organizationId Organization ID. uuid
     *
     * @return boolean
     * @throws \Exception
     */
    public function deleteCard($customerId, $cardTrack, $organizationId = ''){
        try {
            $params = ['customerId' => $customerId, 'cardTrack' => $cardTrack];
            if(!empty($organizationId)) $params['organizationId'] = $organizationId;
            $response = $this->api->makeApiRequest('loyalty/iiko/customer/card/remove', 'POST', $params);
            return true;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Держите деньги клиента в программе лояльности. Оплата будет производиться на POS во время обработки заказа.
     * @link https://api-ru.iiko.services/#tag/Customers/paths/~1api~11~1loyalty~1iiko~1customer~1wallet~1hold/post
     * @param array $params [
     * @var string $organizationId Organization ID. uuid
     * @var string $customerId uuid
     * @var string $transactionId uuid
     * @var string $walletId uuid
     * @var float $sum uuid
     * @var string $comment
     * ]
     * @return object $response — response from API
     * @throws \Exception
     */
    public function holdMoney($params = array()){
        try {
            $response = $this->api->makeApiRequest('loyalty/iiko/customer/wallet/hold', 'POST', $params);
            return $response;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Отменить удерживающую транзакцию, созданную ранее.
     * @link https://api-ru.iiko.services/#tag/Customers/paths/~1api~11~1loyalty~1iiko~1customer~1wallet~1cancel_hold/post
     * @param string $transactionId uuid
     * @param string $organizationId Organization ID. uuid
     *
     * @return boolean
     * @throws \Exception
     */
    public function cancelHoldMoney($transactionId, $organizationId = ''){
        try {
            $params = ['transactionId' => $transactionId];
            if(!empty($organizationId)) $params['organizationId'] = $organizationId;
            $response = $this->api->makeApiRequest('loyalty/iiko/customer/wallet/cancel_hold', 'POST', $params);
            return true;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Получить категории клиентов
     * @link https://api-ru.iiko.services/#tag/Customer-categories/paths/~1api~11~1loyalty~1iiko~1customer_category/post
     * @param string $organizationId Organization ID. uuid
     * @return array<ClientInfoCategories>
     * @throws \Exception
     */
    public function getCategories($organizationId = ''){
        try {
            if(!empty($organizationId)) $params['organizationId'] = $organizationId;
            $response = $this->api->makeApiRequest('loyalty/iiko/customer_category', 'POST', $params);
            if(!empty($response->guestCategories) && is_array($response->guestCategories)){
                return ClientInfoCategories::set($response->guestCategories);
            }
            return [];
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Добавить категорию к клиенту
     * @link https://api-ru.iiko.services/#tag/Customer-categories/paths/~1api~11~1loyalty~1iiko~1customer_category~1add/post
     *
     * @param string $customerId uuid
     * @param string $categoryId uuid
     * @param string $organizationId Organization ID. uuid
     *
     * @return bool
     * @throws \Exception
     */
    public function addCategoryForClient($customerId, $categoryId, $organizationId = ''){
        try {
            $params = ['customerId' => $customerId, 'categoryId' => $categoryId];
            if(!empty($organizationId)) $params['organizationId'] = $organizationId;
            $response = $this->api->makeApiRequest('loyalty/iiko/customer_category/add', 'POST', $params);
            return true;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Удалить категорию у клиента
     * @link https://api-ru.iiko.services/#tag/Customer-categories/paths/~1api~11~1loyalty~1iiko~1customer_category~1remove/post
     * @param string $customerId uuid
     * @param string $categoryId uuid
     * @param string $organizationId Organization ID. uuid
     * @return bool
     * @throws \Exception
     */
    public function deleteCategoryForClient($customerId, $categoryId, $organizationId = ''){
        try {
            $params = ['customerId' => $customerId, 'categoryId' => $categoryId];
            if(!empty($organizationId)) $params['organizationId'] = $organizationId;
            $response = $this->api->makeApiRequest('loyalty/iiko/customer_category/remove', 'POST', $params);
            return true;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }


    /**
     * Рассчитайте скидки и другие предметы лояльности для заказа.
     * @link https://api-ru.iiko.services/#tag/Discounts-and-promotions/paths/~1api~11~1loyalty~1iiko~1calculate/post
     *
     * @param array $orderData
     *
     * @return object - Api
     * @throws \Exception
     */
    public function calculateDiscounts($orderData = []){
        try {
            $response = $this->api->makeApiRequest('loyalty/iiko/calculate', 'POST', $orderData);
            return $response;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Получить все ручные условия организации.
     * @link https://api-ru.iiko.services/#tag/Discounts-and-promotions/paths/~1api~11~1loyalty~1iiko~1manual_condition/post
     *
     * @param string $organizationId Organization ID. uuid
     *
     * @return object - Api
     * @throws \Exception
     */
    public function manualConditionDiscounts($organizationId = ''){
        try {
            $params = [];
            if(!empty($organizationId)) $params = ['organizationId' => $organizationId];
            $response = $this->api->makeApiRequest('loyalty/iiko/manual_condition', 'POST', $params);
            return $response;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Получить все программы лояльности для организации.
     * @link https://api-ru.iiko.services/#tag/Discounts-and-promotions/paths/~1api~11~1loyalty~1iiko~1program/post
     *
     * @param string $organizationId Organization ID. uuid
     *
     * @return object - Api
     * @throws \Exception
     */
    public function programDiscounts($organizationId = ''){
        try {
            $params = [];
            if(!empty($organizationId)) $params = ['organizationId' => $organizationId];
            $response = $this->api->makeApiRequest('loyalty/iiko/program', 'POST', $params);
            return new ProgramDiscountsResponse($response);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}

/**
 * Класс API заказы
 * Class OrdersAPI
 * @package webkotlas\iiko
 */
class OrdersAPI{
    private $api;
    /**
     * @var NewOrderData | null
     */
    private $instanceOrder = null;

    public function __construct(iikoApiCore $params)
    {
        $this->api = $params;
    }

    /**
     * @return NewOrderData
     */
    public function new(){
        $this->instanceOrder = new NewOrderData($this->api->organization_id);
        return $this->instanceOrder;
    }

    /**
     * order/create: Создать заказ
     * @link https://api-ru.iiko.services/#tag/Orders/paths/~1api~11~1order~1create/post
     *
     * @return ResponseOrderInfo - Api Response
     * @throws \Exception
     */
    public function create()
    {
        $params = $this->instanceOrder->export();
        try {
            $response = $this->api->makeApiRequest('order/create', 'POST', $params);
            return ResponseOrderInfo::setCreateOrder($response);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * deliveries/create: Создать заказ на доставку
     * @link https://api-ru.iiko.services/#tag/Deliveries:-Create-and-update/paths/~1api~11~1deliveries~1create/post
     *
     * @return ResponseOrderInfo - Api Response
     * @throws \Exception
     */
    public function createDelivery()
    {
        $params = $this->instanceOrder->export();
        try {
            $response = $this->api->makeApiRequest('deliveries/create', 'POST', $params);
            return ResponseOrderInfo::setCreateOrder($response);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Вызывать перед созданием заказа, Если используете купоны
     * @return object
     * @throws \Exception
     */
    public function calculate(){
        $client = new ClientsAPI($this->api);
        $orderData = $this->instanceOrder->export();
        try {
            return $client->calculateDiscounts($orderData);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * order/by_id: Получить заказы по идентификаторам
     * @param string $orderId
     * @return ResponseOrderInfo API
     * @throws \Exception
     */
    public function searchOrder($orderId, $sourceKeys = ''){
        try {
            $params = [
                'organizationIds' => [$this->api->organization_id],
                'orderIds' => [$orderId]
            ];
            if(!empty($sourceKeys)){
                $params['sourceKeys'] = $sourceKeys;
            }
            $response = $this->api->makeApiRequest('order/by_id', 'POST', $params);
            return ResponseOrderInfo::setSearchOrder($response);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * order/close: Отменить заказ
     * @param string $orderId
     * @return mixed
     * @throws \Exception
     */
    public function cancel($orderId){
        try {
            $params = [
                'organizationId' => $this->api->organization_id,
                'orderId' => $orderId
            ];
            $response = $this->api->makeApiRequest('order/close', 'POST', $params);
            return $response;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * deliveries/by_id: Получить заказы по идентификаторам
     * @param string $orderId
     * @return ResponseOrderInfo API
     * @throws \Exception
     */
    public function searchOrderDelivery($orderId, $sourceKeys = ''){
        try {
            $params = [
                'organizationIds' => [$this->api->organization_id],
                'orderIds' => [$orderId]
            ];
            if(!empty($sourceKeys)){
                $params['sourceKeys'] = $sourceKeys;
            }
            $response = $this->api->makeApiRequest('deliveries/by_id', 'POST', $params);
            return ResponseOrderInfo::setSearchOrder($response);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * deliveries/close: Отменить заказ доставки
     * @param string $orderId
     * @return object API
     * @throws \Exception
     */
    public function cancelDelivery($orderId){
        try {
            $params = [
                'organizationId' => $this->api->organization_id,
                'orderId' => $orderId
            ];
            $response = $this->api->makeApiRequest('deliveries/close', 'POST', $params);
            return $response;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}

/**
 * Класс API  Метод, возвращающий информацию о группах терминалов доставки.
 * Class TerminalGroupAPI
 * @package webkotlas\iiko
 */
class TerminalGroupAPI{
    private $api;

    public function __construct(iikoApiCore $params)
    {
        $this->api = $params;
    }

    /**
     * terminal_groups: Метод, возвращающий информацию о группах терминалов доставки.
     * @link https://api-ru.iiko.services/#tag/Terminal-groups/paths/~1api~11~1terminal_groups/post
     *
     * @param bool $includeDisabled Атрибут, показывающий, что ответ содержит отключенные группы терминалов.
     * @return array - Api Response
     * @throws \Exception
     */
    public function get($includeDisabled = false)
    {
        $params = [
            'organizationIds' => [$this->api->organization_id],
            'includeDisabled' => $includeDisabled
        ];
        try {
            $response = $this->api->makeApiRequest('terminal_groups', 'POST', $params);
            return $response->terminalGroups;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param array $terminalGroupsResponse
     * @return object
     */
    public function getGroup($terminalGroupsResponse = [], $index = 0){
        return (!empty($terminalGroupsResponse[0]->items[$index]->id)) ? $terminalGroupsResponse[0]->items[$index] : new \stdClass();
    }
}

/**
 * Класс API список организаций
 * Class OrganizationAPI
 * @package webkotlas\iiko
 */
class OrganizationAPI{
    private $api;

    /**
     * OrganizationAPI constructor.
     * @param iikoApiCore $params
     */
    public function __construct(iikoApiCore $params)
    {
        $this->api = $params;
    }

    /**
     * Возвращает организации, доступные пользователю
     * @link https://api-ru.iiko.services/#tag/Organizations/paths/~1api~11~1organizations/post
     * @param bool $returnAdditionalInfo Признак, следует ли возвращать дополнительную информацию об организации (версия RMS, страна, адрес ресторана и т. д.) или следует возвращать только минимальную информацию (id и имя).
     * @param bool $includeDisabled Атрибут, показывающий, что ответ содержит отключенные организации.
     * @return array
     * @throws \Exception
     */
    public function get($returnAdditionalInfo = true, $includeDisabled = false){
        try {
            $params = [
                'returnAdditionalInfo' => $returnAdditionalInfo,
                'includeDisabled' => $includeDisabled
            ];
            $response = $this->api->makeApiRequest('organizations', 'POST', $params);
            return $response->organizations;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

}

/**
 * Класс API список справочников
 * Class DictionaryAPI
 * @package webkotlas\iiko
 */
class DictionaryAPI{
    private $api;

    /**
     * DictionaryAPI constructor.
     * @param iikoApiCore $params
     */
    public function __construct(iikoApiCore $params)
    {
        $this->api = $params;
    }

    /**
     * Скидки/доплаты.
     * @return array
     * @throws \Exception
     */
    public function getDiscount(){
        try {
            $params = [
                'organizationIds' => [$this->api->organization_id],
            ];
            $response = $this->api->makeApiRequest('discounts', 'POST', $params);
            return $response->discounts;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Типы заказов.
     * @return array
     * @throws \Exception
     */
    public function getOrder(){
        try {
            $params = [
                'organizationIds' => [$this->api->organization_id],
            ];
            $response = $this->api->makeApiRequest('deliveries/order_types', 'POST', $params);
            return $response->orderTypes;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Типы оплаты.
     * @return array
     * @throws \Exception
     */
    public function getPayment(){
        try {
            $params = [
                'organizationIds' => [$this->api->organization_id],
            ];
            $response = $this->api->makeApiRequest('payment_types', 'POST', $params);
            return $response->paymentTypes;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Типы удаления (причины удаления).
     * @return array
     * @throws \Exception
     */
    public function getRemoval(){
        try {
            $params = [
                'organizationIds' => [$this->api->organization_id],
            ];
            $response = $this->api->makeApiRequest('removal_types', 'POST', $params);
            return $response->removalTypes;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}

/**
 * Класс API проверка статуса
 * Class CommandsStatusAPI
 * @package webkotlas\iiko
 */
class CommandsStatusAPI{
    private $api;

    public function __construct(iikoApiCore $params)
    {
        $this->api = $params;
    }

    /**
     * commands/status: Получить информацию о клиенте по заданному критерию.
     * @link https://api-ru.iiko.services/#tag/Operations/paths/~1api~11~1commands~1status/post
     *
     * @param string $correlationId
     * @param string $organizationId
     *
     * @return CommandsStatusResponse
     * @throws \Exception
     */
    public function status($correlationId, $organizationId = '')
    {
        try {
            $params = ['correlationId' => $correlationId];
            if(!empty($organizationId)) $params['organizationId'] = $organizationId;
            $response = $this->api->makeApiRequest('commands/status', 'POST', $params);
            return new CommandsStatusResponse((array)$response);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

}

/**
 * Вспомогательный класс сущности
 * Class Nomenclature
 * @package webkotlas\iiko
 */
class NomenclatureResponse
{
    private $products = [];
    private $groups = [];
    private $productCategories = [];
    private $sizes = [];
    private $revision = 0;

    /**
     * NomenclatureResponse constructor.
     * @param array $response
     */
    public function __construct($response = [])
    {
        foreach($response as $key => $value){
            if($key == "products"){
                $value = NomenclatureProduct::set($value);
            }
            if($key == "groups"){
                $value = NomenclatureGroups::set($value);
            }
            if($key == "productCategories"){
                $value = NomenclatureProductCategories::set($value);
            }
            if($key == "sizes"){
                $value = NomenclatureSizes::set($value);
            }
            $this->$key = $value;
        }
    }

    /**
     * @return array<NomenclatureGroups>
     */
    public function getGroups(){
        return $this->groups;
    }
    /**
     * @return array<NomenclatureProductCategories>
     */
    public function getProductCategories(){
        return $this->productCategories;
    }
    /**
     * @return array<NomenclatureProduct>
     */
    public function getProducts(){
        return $this->products;
    }
    /**
     * @return array<NomenclatureSizes>
     */
    public function getSizes(){
        return $this->sizes;
    }
    /**
     * @return int
     */
    public function getRevision(){
        return $this->revision;
    }
}

/**
 * Вспомогательный класс сущности
 * Class ClientInfoResponse
 * @package webkotlas\iiko
 */
class ClientInfoResponse{
    public $id = ''; // uuid
    public $referrerId = ''; // uuid Идентификатор реферера гостя.
    public $name = ''; //Имя гостя.
    public $surname = ''; //Фамилия гостя.
    public $middleName = ''; //Отчество гостя.
    public $comment = ''; //Комментарий
    public $phone = ''; //телефон
    public $email = ''; //телефон
    public $sex = 0; // 0 | 1 | 2
    public $birthday = ''; // Y-m-d H:m:s.fff
    public $cultureName = ''; // Название гостевой культуры.
    public $consentStatus = 0; //0 | 1 | 2 Статус согласия гостя.
    public $anonymized = false; // Гость анонимный.
    public $userData = ''; // Технические данные пользователя, настраиваемые ресторатором.
    public $cards = []; // Карты клиентов.
    public $categories = []; // Категории клиентов.
    public $walletBalances = []; // Пользовательские кошельки клиента. Содержит бонусные балансы различных программ лояльности.
    public $isDeleted = false; // Клиент отмечен как удаленный.
    public $shouldReceivePromoActionsInfo = false; // Клиент получает рекламные сообщения (email, sms). Если ноль - неизвестно.
    public $shouldReceiveLoyaltyInfo = false; // Гость должен получить информацию о лояльности.
    public $shouldReceiveOrderStatusInfo = false; // Гость должен получить информацию о статусе заказа.
    public $personalDataConsentFrom = ''; // Y-m-d H:m:s.fff Согласие с персональными данными гостя от.
    public $personalDataConsentTo = ''; // Y-m-d H:m:s.fff Согласие с персональными данными гостя.
    public $personalDataProcessingFrom = ''; // Y-m-d H:m:s.fff Обработка персональных данных гостей от.
    public $personalDataProcessingTo = ''; // Y-m-d H:m:s.fff Обработка персональных данных гостей.
    /**
     * ClientInfoResponse constructor.
     * @param array $response
     */
    public function __construct($response = [])
    {
        foreach($response as $key => $value){
            if($key == "cards"){
                $value = ClientInfoCards::set($value);
            }
            if($key == "categories"){
                $value = ClientInfoCategories::set($value);
            }
            if($key == "walletBalances"){
                $value = ClientInfoWalletBalances::set($value);
            }
            $this->$key = $value;
        }
    }
}

/**
 * Вспомогательный класс сущности
 * Class NomenclatureProduct
 * @package webkotlas\iiko
 */
class NomenclatureProduct{
    public $id = ''; //uuid
    public $code = '';//sku
    public $name = '';
    public $description = '';
    public $type = 'Good'; // Dish | Good | Modifier (блюдо | хорошо | модификатор.)
    public $orderItemType = 'Product'; //"Product" "Compound" Продукт или соединение. Зависит от наличия схемы модификаторов.
    public $sizePrices = []; //Цены
    public $modifiers = []; //Модификаторы
    public $groupModifiers = []; //Группы модификаторов
    public $imageLinks = []; //Ссылки на изображения.
    public $isDeleted = false;
    public $splittable = false; //Является ли продукт разделяемым.
    public $doNotPrintInCheque = false; //Не печатайте на счете.
    public $useBalanceForSell = false; //Взвешенный продукт.
    public $canSetOpenPrice = false; //Открытая цена.
    public $groupId = '';//uuid Группа номенклатуры в RMS.
    public $parentGroup = '';//uuid Группа внешнего меню.
    public $productCategoryId = '';//uuid Категория продукта в RMS.
    public $modifierSchemaId = '';//uuid
    public $modifierSchemaName = ''; //Имя схемы модификатора
    public $fatAmount = 0.00;
    public $proteinsAmount = 0.00;
    public $carbohydratesAmount = 0.00;
    public $energyAmount = 0.00;
    public $fatFullAmount = 0.00;
    public $proteinsFullAmount = 0.00;
    public $carbohydratesFullAmount = 0.00;
    public $energyFullAmount = 0.00;
    public $weight = 0.00;
    public $measureUnit = '';
    public $order = 0; //Порядок продуктов (приоритет) в меню.
    public $fullNameEnglish = ''; //Полное имя на иностранном языке.
    public $additionalInfo = ''; //Дополнительная информация.
    public $seoDescription = '';
    public $seoText = '';
    public $seoKeywords = '';
    public $seoTitle = '';
    public $tags = [];
    /**
     * NomenclatureProduct constructor.
     * @param array $product
     */
    public function __construct($product = [])
    {
        foreach($product as $key => $value){
            if($key == "modifiers"){
                $value = NomenclatureModifiers::set($value);
            }
            if($key == "groupModifiers"){
                $value = NomenclatureGroupModifiers::set($value);
            }
            $this->$key = $value;
        }
    }

    /**
     * @return bool
     */
    public function isProduct(){
        return ($this->type == 'Good' || $this->type == 'good');
    }
    /**
     * @return bool
     */
    public function isDish(){
        return ($this->type == 'Dish' || $this->type == 'dish' );
    }
    /**
     * @return bool
     */
    public function isModifier(){
        return ($this->type == 'Modifier' || $this->type == 'modifier');
    }
    /**
     * @return float
     */
    public function getPrice(){
        $price = 0.00;
        if(!empty($this->sizePrices) && !empty($this->sizePrices[0]->price->currentPrice)){
            $price = $this->sizePrices[0]->price->currentPrice;
        }
        return $price;
    }

    public static function set($products = []){
        if(count($products) > 0) {
            foreach ($products as $k => $v) {
                $products[$k] = new self($v);
            }
        }
        return $products;
    }
}
/**
 * Вспомогательный класс сущности
 * Class NomenclatureGroups
 * @package webkotlas\iiko
 */
class NomenclatureGroups{
    public $id = ''; //uuid
    public $code = '';//sku
    public $name = '';
    public $description = '';
    public $isDeleted = false;
    public $isIncludedInMenu = false;//Атрибут в меню.
    public $isGroupModifier = false;//true - групповой модификатор | false - внешняя группа меню.
    public $parentGroup = '';//uuid Родительская группа.
    public $imageLinks = []; //Ссылки на изображения.
    public $order = 0; //Порядок продуктов (приоритет) в меню.
    public $additionalInfo = ''; //Дополнительная информация.
    public $seoDescription = '';
    public $seoText = '';
    public $seoKeywords = '';
    public $seoTitle = '';
    public $tags = [];
    /**
     * NomenclatureGroups constructor.
     * @param array $group
     */
    public function __construct($group = [])
    {
        foreach($group as $key => $value){
            $this->$key = $value;
        }
    }

    /**
     * @param array $groups
     * @return array
     */
    public static function set($groups = []){
        if(count($groups) > 0) {
            foreach ($groups as $k => $v) {
                $groups[$k] = new self($v);
            }
        }
        return $groups;
    }
}
/**
 * Вспомогательный класс сущности
 * Class NomenclatureProductCategories
 * @package webkotlas\iiko
 */
class NomenclatureProductCategories{
    public $id = ''; //uuid
    public $name = '';
    public $isDeleted = false;

    /**
     * NomenclatureProductCategories constructor.
     * @param array $productCategory
     */
    public function __construct($productCategory = [])
    {
        foreach($productCategory as $key => $value){
            $this->$key = $value;
        }
    }
    /**
     * @param array $groups
     * @return array
     */
    public static function set($productCategories = []){
        if(count($productCategories) > 0) {
            foreach ($productCategories as $k => $v) {
                $productCategories[$k] = new self($v);
            }
        }
        return $productCategories;
    }
}
/**
 * Вспомогательный класс сущности
 * Class NomenclatureSizes
 * @package webkotlas\iiko
 */
class NomenclatureSizes{
    public $id = ''; //uuid
    public $name = '';
    public $priority = 0; //Приоритет (порядковый номер) размера в размерной шкале.
    public $isDefault = false; //Размер по умолчанию в шкале размеров.

    /**
     * NomenclatureSizes constructor.
     * @param array $size
     */
    public function __construct($size = [])
    {
        foreach($size as $key => $value){
            $this->$key = $value;
        }
    }
    /**
     * @param array $groups
     * @return array
     */
    public static function set($sizes = []){
        if(count($sizes) > 0) {
            foreach ($sizes as $k => $v) {
                $sizes[$k] = new self($v);
            }
        }
        return $sizes;
    }
}
/**
 * Вспомогательный класс сущности
 * Class NomenclatureModifiers
 * @package webkotlas\iiko
 */
class NomenclatureModifiers{
    public $id = '';
    public $minAmount = 0; //Минимальное количество.
    public $maxAmount = 0; //Максимальное количество.
    public $defaultAmount = 0; //Сумма по умолчанию.
    public $freeOfChargeAmount = 0; //Свободная сумма.
    public $required = false; //Требуемая доступность.
    public $splittable = false; //Модификатор можно разделить
    public $hideIfDefaultAmount = false; //Скрыть, если сумма установлена ​​по умолчанию.
    /**
     * NomenclatureModifiers constructor.
     * @param array $modifier
     */
    public function __construct($modifier = [])
    {
        foreach($modifier as $key => $value){
            $this->$key = $value;
        }
    }

    /**
     * @param array $modifiers
     * @return array
     */
    public static function set($modifiers = []){
        if(count($modifiers) > 0) {
            foreach ($modifiers as $k => $v) {
                $modifiers[$k] = new self($v);
            }
        }
        return $modifiers;
    }
}
/**
 * Вспомогательный класс сущности
 * Class NomenclatureGroupModifiers
 * @package webkotlas\iiko
 */
class NomenclatureGroupModifiers{
    public $id = '';
    public $minAmount = 0; //Минимальное количество.
    public $maxAmount = 0; //Максимальное количество.
    public $defaultAmount = 0; //Сумма по умолчанию.
    public $freeOfChargeAmount = 0; //Свободная сумма.
    public $required = false; //Требуемая доступность.
    public $splittable = false; //Модификатор можно разделить
    public $hideIfDefaultAmount = false; //Скрыть, если сумма установлена ​​по умолчанию.
    public $childModifiersHaveMinMaxRestrictions = false; //Наличие ограничения максимального/минимального количества дочерних модификаторов.
    public $childModifiers = []; //Список дочерних модификаторов.

    /**
     * NomenclatureGroupModifiers constructor.
     * @param array $groupModifier
     */
    public function __construct($groupModifier = [])
    {
        foreach($groupModifier as $key => $value){
            if($key == "childModifiers"){
                $value = NomenclatureModifiers::set($value);
            }
            $this->$key = $value;
        }
    }

    /**
     * @param array $groupModifiers
     * @return array
     */
    public static function set($groupModifiers = []){
        if(count($groupModifiers) > 0) {
            foreach ($groupModifiers as $k => $v) {
                $groupModifiers[$k] = new self($v);
            }
        }
        return $groupModifiers;
    }
}

/**
 * Вспомогательный класс сущности
 * Class ClientInfoCards
 * @package webkotlas\iiko
 */
class ClientInfoCards{
    public $id = ''; // uuid Card id
    public $track = ''; // Card track.
    public $number = ''; // Card number.
    public $validToDate = ''; // Y-m-d H:m:s.fff
    /**
     * ClientInfoCards constructor.
     * @param array $item
     */
    public function __construct($item = [])
    {
        foreach($item as $key => $value){
            $this->$key = $value;
        }
    }

    /**
     * @param array $array
     * @return array
     */
    public static function set($array = []){
        if(count($array) > 0) {
            foreach ($array as $k => $v) {
                $array[$k] = new self($v);
            }
        }
        return $array;
    }
}
/**
 * Вспомогательный класс сущности
 * Class ClientInfoCategories
 * @package webkotlas\iiko
 */
class ClientInfoCategories{
    public $id = ''; // uuid
    public $name = ''; //Название категории.
    public $isActive = false; //Категория активна или нет.
    public $isDefaultForNewGuests = false; //Является ли категория по умолчанию для новых гостей или нет.
    /**
     * ClientInfoCategories constructor.
     * @param array $item
     */
    public function __construct($item = [])
    {
        foreach($item as $key => $value){
            $this->$key = $value;
        }
    }

    /**
     * @param array $array
     * @return array
     */
    public static function set($array = []){
        if(count($array) > 0) {
            foreach ($array as $k => $v) {
                $array[$k] = new self($v);
            }
        }
        return $array;
    }
}
/**
 * Вспомогательный класс сущности
 * Class ClientInfoWalletBalances
 * @package webkotlas\iiko
 */
class ClientInfoWalletBalances{
    public $id = ''; // uuid
    public $name = ''; //Название категории.
    public $type = 0; // 0 | 1 | 2 | 3 | 4
    public $balance = 0.00; // float
    /**
     * ClientInfoWalletBalances constructor.
     * @param array $item
     */
    public function __construct($item = [])
    {
        foreach($item as $key => $value){
            $this->$key = $value;
        }
    }

    /**
     * @param array $array
     * @return array
     */
    public static function set($array = []){
        if(count($array) > 0) {
            foreach ($array as $k => $v) {
                $array[$k] = new self($v);
            }
        }
        return $array;
    }
}

/**
 * Вспомогательный класс сущности
 * Class StopList
 * @package webkotlas\iiko
 */
class StopListResponse{
    private $terminalGroupStopLists = [];

    /**
     * StopList constructor.
     * @param array $response
     */
    public function __construct($response = [])
    {
        foreach($response as $key => $value){
            $this->$key = $value;
        }
    }

    /**
     * @return array
     */
    public function getTerminalGroupStopLists(){
        return $this->terminalGroupStopLists;
    }
}

/**
 * Вспомогательный класс сущности
 * Class Combo
 * @package webkotlas\iiko
 */
class ComboResponse{
    private $comboSpecifications = [];
    private $comboCategories = [];

    /**
     * StopList constructor.
     * @param array $response
     */
    public function __construct($response = [])
    {
        foreach($response as $key => $value){
            $this->$key = $value;
        }
    }

    /**
     * @return array
     */
    public function getSpecifications(){
        return $this->comboSpecifications;
    }

    /**
     * @return array
     */
    public function getCategories(){
        return $this->comboCategories;
    }
}

/**
 * Вспомогательный класс сущности
 * Class ProgramDiscountsResponse
 * @package webkotlas\iiko
 */
class ProgramDiscountsResponse{
    private $Programs = [];

    /**
     * ProgramDiscountsResponse constructor.
     * @param $response
     */
    public function __construct($response)
    {
        $this->Programs = ProgramDiscount::set($response->Programs);
    }

    /**
     * @return array<ProgramDiscount>
     */
    public function getPrograms(){
        return $this->Programs;
    }
}
/**
 * Class ProgramDiscount
 * @package webkotlas\iiko
 */
class ProgramDiscount{
    public $id = ''; // uuid
    public $name = ''; // Название программы.
    public $description = ''; // Описание программы.
    public $serviceFrom = ''; // Программа работает с даты.
    public $serviceTo = ''; // Программа работает до указаного времени.
    public $walletId = ''; // uuid Идентификатор кошелька. Программа имеет только кошелек, что означает глобальный тип оплаты для клиентов.
    public $notifyAboutBalanceChanges = false; // Уведомлять клиента об изменении баланса (sms/push).
    public $isActive = false; // Программа активна.
    public $hasWelcomeBonus = false; // Программа имеет приветственный бонус.
    public $isExchangeRateEnabled = false; // Курс обмена на бонусы и реальную валюту.
    public $programType = 0; // Тип программы программы. 0 | 1 | 2 | 3 | 4
    public $templateType = 0; // Тип шаблона программы.  0 | 1 | 2 | 3 | 4 | 5 | 6
    public $welcomeBonusSum = 0; // Все новые клиенты получат бонус.
    public $marketingCampaigns = []; // Программные маркетинговые кампании.
    public $appliedOrganizations = []; // Программа прикладных организаций. список uuid
    /**
     * ProgramDiscount constructor.
     * @param array $item
     */
    public function __construct($item = [])
    {
        foreach($item as $key => $value){
            if($key == "marketingCampaigns"){
                $value = MarketingCampaigns::set($value);
            }
            $this->$key = $value;
        }
    }

    /**
     * @return array<MarketingCampaigns>
     */
    public function getMarketingCampaigns(){
        return $this->marketingCampaigns;
    }

    /**
     * @return string[]
     */
    public function getAppliedOrganizations(){
        return $this->appliedOrganizations;
    }

    /**
     * @param array $array
     * @return array
     */
    public static function set($array = []){
        if(count($array) > 0) {
            foreach ($array as $k => $v) {
                $array[$k] = new self($v);
            }
        }
        return $array;
    }
}
/**
 * Class MarketingCampaigns
 * @package webkotlas\iiko
 */
class MarketingCampaigns{
    public $id = ''; // uuid Идентификатор маркетинговой кампании.
    public $programId = ''; // uuid Идентификатор программы лояльности.
    public $name = ''; // Название программы лояльности.
    public $description = ''; // Описание маркетинговой кампании.
    public $isActive = false; // Маркетинговая кампания активна.
    public $periodFrom = ''; // Маркетинговая кампания работает с даты.
    public $periodTo = ''; // Маркетинговая кампания работает до этой даты. Нулевой означает безграничный.
    public $orderActionConditionBindings = []; // Условия и действия, которые будут проверяться при обработке заказа.
    public $periodicActionConditionBindings = []; // Условия и действия, которые будут проверяться по расписанию.
    public $overdraftActionConditionBindings = []; // Условия и действия, которые будет проверять овердрафт.
    /**
     * MarketingCampaigns constructor.
     * @param array $item
     */
    public function __construct($item = [])
    {
        foreach($item as $key => $value){
            if(in_array($key, ['orderActionConditionBindings','periodicActionConditionBindings','overdraftActionConditionBindings'])){
                $value = ConditionBindings::set($value);
            }
            $this->$key = $value;
        }
    }

    /**
     * @return array<ConditionBindings>
     */
    public function getOrderAction(){
        return $this->orderActionConditionBindings;
    }
    /**
     * @return array<ConditionBindings>
     */
    public function getPeriodicAction(){
        return $this->periodicActionConditionBindings;
    }
    /**
     * @return array<ConditionBindings>
     */
    public function getOverdraftAction(){
        return $this->overdraftActionConditionBindings;
    }

    /**
     * @param array $array
     * @return array
     */
    public static function set($array = []){
        if(count($array) > 0) {
            foreach ($array as $k => $v) {
                $array[$k] = new self($v);
            }
        }
        return $array;
    }
}
/**
 * Class ConditionBindings
 * @package webkotlas\iiko
 */
class ConditionBindings{
    public $id = ''; // uuid
    public $stopFurtherExecution = false; // Обработка лояльности прекращается после успешного выполнения привязки. Значит порядок привязок влияет.
    public $actions = []; // Маркетинговые действия.
    public $conditions = []; // Условия маркетинга.
    /**
     * ConditionBindings constructor.
     * @param array $item
     */
    public function __construct($item = [])
    {
        foreach($item as $key => $value){
            if(in_array($key, ['actions','conditions'])){
                $value = ActionsConditions::set($value);
            }
            $this->$key = $value;
        }
    }
    /**
     * @return array<ActionsConditions>
     */
    public function getActions(){
        return $this->actions;
    }
    /**
     * @return array<ActionsConditions>
     */
    public function getConditions(){
        return $this->conditions;
    }
    /**
     * @param array $array
     * @return array
     */
    public static function set($array = []){
        if(count($array) > 0) {
            foreach ($array as $k => $v) {
                $array[$k] = new self($v);
            }
        }
        return $array;
    }
}
/**
 * Class ActionsConditions
 * @package webkotlas\iiko
 */
class ActionsConditions{
    public $id = ''; // uuid
    public $settings = ''; // Настройки действия/условия. Хранится как Json.
    public $typeName = ''; // Имя типа действия/условия.
    public $checkSum = ''; // Хэш-значение контрольной суммы
    /**
     * ActionsConditions constructor.
     * @param array $item
     */
    public function __construct($item = [])
    {
        foreach($item as $key => $value){
            $this->$key = $value;
        }
    }
    /**
     * @param array $array
     * @return array
     */
    public static function set($array = []){
        if(count($array) > 0) {
            foreach ($array as $k => $v) {
                $array[$k] = new self($v);
            }
        }
        return $array;
    }
}

/**
 * Class CommandsStatusResponse
 * @package webkotlas\iiko
 */
class CommandsStatusResponse{
    public $state = ''; //InProgress | Success | Error
    public $exception = null; //Сведения о произошедшем исключении.
    /**
     * CommandsStatusResponse constructor.
     * @param array $item
     */
    public function __construct($item = [])
    {
        foreach($item as $key => $value){
            $this->$key = $value;
        }
    }

    /**
     * @return string
     */
    public function getState(){
        return $this->state;
    }

    /**
     * @return null | string
     */
    public function getException(){
        return $this->exception;
    }

    public function isInProgress(){
        return ($this->state == "InProgress");
    }

    public function isSuccess(){
        return ($this->state == "Success");
    }

    public function isError(){
        return ($this->state == "Error");
    }
}

/**
 * Class NewOrderData
 * @package webkotlas\iiko
 */
class NewOrderData
{
    public $organizationId = '';
    private $terminalGroupId = ''; //Идентификатор фронтовой группы, на которую должен быть отправлен заказ. Можно получить на /api/1/terminal_groups операции.
    private $order = [];
    private $phone = '+79999999999';
    private $customerInfo = [];
    private $items = [];
    private $combos = [];
    private $payments = [];
    private $tips = [];
    private $discountsInfo = '';
    private $deliveryPoint = [];
    private $orderServiceType = '';
    private $orderTypeId = ''; //Идентификатор типа заказа. Можно получить при /api/1/deliveries/order_typesоперации
    private $comment = '';
    private $tabName = ''; //Название вкладки (только для группы терминалов быстрого питания в режиме вкладки).
    private $coupon = '';
    private $sourceKey = ''; //Строковый ключ (маркер) источника (партнера - пользователя API), создавшего заказ. Нужен для ограничения видимости заказов для внешней интеграции.
    private $guests = [];
    private $transportToFrontTimeout = 8;

    /**
     * NewOrderData constructor.
     * @param string $organizationId
     * @throws \Exception
     */
    public function __construct($organizationId)
    {
        if (empty($organizationId))
        {
            throw new \Exception('Organization id is required!');
        }
        $this->organizationId = $organizationId;
    }

    /**
     * @param string $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param array $customerInfo
     * @return $this
     * @throws \Exception
     */
    public function setCustomerInfo($customerInfo)
    {
        //Если 'id' null - номер телефона ищется в базе данных, иначе новый клиент создается в RMS.
        if(!isset($customerInfo['id'])) {
            if (!isset($customerInfo['name']) || (isset($customerInfo['name']) && empty($customerInfo['name'])))
            {
                throw new \Exception('Customer name is required!');
            }
        }

        if (isset($customerInfo['gender']) && !in_array($customerInfo['gender'], ['NotSpecified', 'Male', 'Female']))
        {
            $customerInfo['gender'] = 'NotSpecified';
        }

        if (!isset($customerInfo['surname'])){
            $customerInfo['surname'] = null;
        }
        if (!isset($customerInfo['comment'])){
            $customerInfo['comment'] = null;
        }
        if (!isset($customerInfo['email'])){
            $customerInfo['email'] = null;
        }
        if (isset($customerInfo['birthdate']))
        {
            $date = \DateTime::createFromFormat('Y-m-d h:i:s \G\M\T', $customerInfo['birthdate']);
            if (!$date || !$date->format('Y-m-d h:i:s \G\M\T') == $customerInfo['birthdate']) {
                $customerInfo['birthdate'] = date('Y-m-d h:i:s \G\M\T');
            }
        }

        $this->customerInfo = $customerInfo;
        return $this;
    }

    /**
     * @param array $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @param array $items
     * @return $this
     * @throws \Exception
     */
    public function setItems(array $items)
    {
        if(count($items) === 0){
            throw new \Exception('Items array not been empty!');
        }
        foreach ($items as $item) {
            if ($item['type'] !== 'Compound')
            {
                if (!isset($item['productId']) || (isset($item['productId']) && empty($item['productId']))) {
                    throw new \Exception('productId is required for Item!');
                }
            }
            if (!isset($item['amount']) || (isset($item['amount']) && empty($item['amount']))) {
                throw new \Exception('amount is required for Item!');
            }
        }
        $this->items = $items;
        return $this;
    }

    /**
     * @param array $combos
     * @return $this
     * @throws \Exception
     */
    public function setCombos(array $combos)
    {
        if(count($combos) === 0){
            throw new \Exception('Combos array not been empty!');
        }
        foreach ($combos as $combo)
        {
            if (!isset($combo['id']) || (isset($combo['id']) && empty($combo['id']))) {
                throw new \Exception('id is required for combo!');
            }
            if (!isset($combo['name']) || (isset($combo['name']) && empty($combo['name']))) {
                throw new \Exception('name is required for combo!');
            }
            if (!isset($combo['amount']) || (isset($combo['amount']) && empty($combo['amount']))) {
                throw new \Exception('amount is required for combo!');
            }
            if (!isset($combo['price']) || (isset($combo['price']) && empty($combo['price']))) {
                throw new \Exception('price is required for combo!');
            }
            if (!isset($combo['sourceId']) || (isset($combo['sourceId']) && empty($combo['sourceId']))) {
                throw new \Exception('sourceId is required for combo!');
            }
        }
        $this->combos = $combos;
        return $this;
    }

    /**
     * @param array $payments
     * @return $this
     * @throws \Exception
     */
    public function setPayments(array $payments)
    {
        foreach ($payments as $payment){
            if (
                !isset($payment['paymentTypeKind']) ||
                !in_array(
                    $payment['paymentTypeKind'],
                    [
                        'Cash',
                        'Card',
                        'IikoCard',
                        'External'
                    ]
                )
            ) {
                $payment['paymentTypeKind'] = 'Cash';
            }
            if (!isset($payment['sum']) || (isset($payment['sum']) && empty($payment['sum']))) {
                throw new \Exception('sum is required!');
            }
            if (!isset($payment['paymentTypeId']) || (isset($payment['paymentTypeId']) && empty($payment['paymentTypeId']))) {
                throw new \Exception('paymentTypeId is required!');
            }
        }
        $this->payments = $payments;
        return $this;
    }

    /**
     * @param array $tips
     * @return $this
     * @throws \Exception
     */
    public function setTips($tips)
    {
        foreach ($tips as $payment){
            if (
                !isset($payment['paymentTypeKind']) ||
                !in_array(
                    $payment['paymentTypeKind'],
                    [
                        'Cash',
                        'Card',
                        'External'
                    ]
                )
            ) {
                $payment['paymentTypeKind'] = 'Cash';
            }
            if (!isset($payment['sum']) || (isset($payment['sum']) && empty($payment['sum']))) {
                throw new \Exception('sum is required!');
            }
            if (!isset($payment['paymentTypeId']) || (isset($payment['paymentTypeId']) && empty($payment['paymentTypeId']))) {
                throw new \Exception('paymentTypeId is required!');
            }
        }
        $this->tips = $tips;
        return $this;
    }

    /**
     * @param string|null $track
     * @return $this
     */
    public function setDiscount($track)
    {
        if (!empty($track)) {
            $this->discountsInfo = $track;
            $this->coupon = $track; //Номер купона, который необходимо учитывать при расчете программы лояльности
        }
        return $this;
    }

    /**
     * @param string $organizationId
     * @return $this
     */
    public function setOrganizationId($organizationId)
    {
        $this->organizationId = $organizationId;
        return $this;
    }

    /**
     * @param array $address
     * @return $this
     * @throws \Exception
     */
    public function setDeliveryPoint($address)
    {
        if (count($address) === 0)
        {
            throw new \Exception('Delivery address not be empty!');
        }
        if (!isset($address['street']) || (isset($address['street']) && count($address['street']) === 0))
        {
            throw new \Exception('Delivery street is required!');
        }
        if (!isset($address['house']) || (isset($address['house']) && empty($address['house'])))
        {
            throw new \Exception('Delivery house is required!');
        }
        $this->deliveryPoint = $address;
        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setOrderServiceType($type = '')
    {
        if(!in_array($type, ['DeliveryByCourier', 'DeliveryByClient'])) {
            $type = 'DeliveryByCourier';
        }
        $this->orderServiceType = $type;
        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setOrderTypeId($type = '')
    {
        $this->orderTypeId = $type;
        return $this;
    }

    /**
     * @param int $count
     * @return $this
     */
    public function setPersons($count)
    {
        $this->guests = [
            'count' => $count,
            'splitBetweenPersons' => false //Атрибут, показывающий, должен ли заказ быть разделен между гостями.
        ];
        return $this;
    }

    /**
     * @param string $comment
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @param string $terminalGroupId
     * @return $this
     */
    public function setTerminalGroupId($terminalGroupId)
    {
        $this->terminalGroupId = $terminalGroupId;
        return $this;
    }

    /**
     * @param string $sourceKey
     * @return $this
     * @throws \Exception
     */
    public function setSourceKey($sourceKey = '')
    {
        if (empty($sourceKey)) {
            throw new \Exception('source key not been empty!');
        }
        $this->sourceKey = $sourceKey;
        return $this;
    }

    /**
     * @param string $tabName
     * @return $this
     */
    public function setTabName($tabName = ''){
        $this->tabName = $tabName;
        return $this;
    }

    /**
     * Y-m-d H:i:s.000
     * Дата выполнения заказа.
     * Дата и время должны быть местными для терминала доставки, без часового пояса (см. пример).
     * Если ноль, то заказ срочный и время рассчитывается исходя из настроек клиента, т.е. максимально короткое время доставки.
     * @param string $completeBefore
     * @return $this
     */
    public function completeTime($completeTime = ''){
        $this->completeBefore = $completeTime;
        return $this;
    }

    public function export()
    {
        $response = [];
        $response['organizationId'] = $this->organizationId;

        if (count($this->order) === 0)
        {
            if (!empty($this->terminalGroupId)) {
                $response['terminalGroupId'] = $this->terminalGroupId;
            } else {
                throw new \Exception('terminalGroupId is required!');
            }
            if (count($this->customerInfo) !== 0) {
                $response['order']['customer'] = $this->customerInfo;
            } else {
                throw new \Exception('Customer is required for order!');
            }

            $response['order']['phone'] = $this->phone;

            if(!empty($this->completeBefore)){
                $response['order']['completeBefore'] = $this->completeBefore;
            }

            if(!empty($this->tabName)){
                $response['order']['tabName'] = $this->tabName;
            }

            if(!empty($this->guests)) {
                $response['order']['guests'] = $this->guests;
            }


            if (count($this->items) === 0)
            {
                throw new \Exception('Items is required for order!');
            }
            $response['order']['items'] = $this->items;
            if (count($this->combos) !== 0) {
                $response['order']['combos'] = $this->combos;
            }
            if (count($this->payments) !== 0) {
                $response['order']['payments'] = $this->payments;
            }
            if(count($this->tips) !== 0){
                $response['order']['tips'] = $this->tips;
            }
            if (count($this->deliveryPoint) !== 0) {
                $response['order']['deliveryPoint']['address'] = $this->deliveryPoint;
            }
            if (!empty($this->coupon)) {
                $response['order']['iikoCard5Info']['coupon'] = $this->coupon;
            }
            if (!empty($this->orderTypeId)) {
                $response['order']['orderTypeId'] = $this->orderTypeId;
            }

            if (!empty($this->orderServiceType)) {
                $response['order']['orderServiceType'] = $this->orderServiceType;
            }

            if (!empty($this->sourceKey)) {
                $response['sourceKey'] = $this->sourceKey;
            }
            $response['order']['comment'] = $this->comment;

            if(!empty($this->transportToFrontTimeout)){
                $response['createOrderSettings']['transportToFrontTimeout'] = $this->transportToFrontTimeout;
            }
        } else {
            $response['order'] = $this->order;
        }
        if (!isset($response['order'])) {
            throw new \Exception('Order not been empty!');
        }
        return $response;
    }

}

/**
 * Class ResponseOrderInfo
 * @package webkotlas\iiko
 */
class ResponseOrderInfo{
    public $correlationId = '';
    public $id = '';
    public $organizationId = '';
    public $timestamp = 0;
    public $creationStatus = ''; //"Success" "InProgress" "Error"
    public $errorInfo = null;
    /**
     * @var OrderInfo|null
     */
    public $order = null;

    /**
     * ResponseOrderInfo constructor.
     * @param string $correlationId
     * @param \stdClass $orderInfo
     */
    public function __construct($correlationId, \stdClass $orderInfo)
    {
        $this->correlationId = $correlationId;
        $this->id = (!empty($orderInfo->id)) ? $orderInfo->id : '';
        $this->organizationId = (!empty($orderInfo->organizationId)) ? $orderInfo->organizationId : '';
        $this->timestamp = (!empty($orderInfo->timestamp)) ? $orderInfo->timestamp : 0;
        $this->creationStatus = (!empty($orderInfo->creationStatus)) ? $orderInfo->creationStatus : 'Error';
        $this->errorInfo = (!empty($orderInfo->errorInfo)) ? $orderInfo->errorInfo : null;
        $this->order = (!empty($orderInfo->order)) ? new OrderInfo((array) $orderInfo->order) : null;
    }

    /**
     * @return bool
     */
    public function isInProgress(){
        return ($this->creationStatus == "InProgress");
    }

    /**
     * @return bool
     */
    public function isSuccess(){
        return ($this->creationStatus == "Success");
    }

    /**
     * @return bool
     */
    public function isError(){
        return ($this->creationStatus == "Error");
    }

    /**
     * @return string|null
     */
    public function getStatusOrder(){
        return ($this->order instanceof OrderInfo) ? $this->order->getStatus() : null;
    }

    /**
     * @return OrderInfo|null
     */
    public function getOrder(){
        return ($this->order instanceof OrderInfo) ? $this->order : null;
    }

    /**
     * @param $response
     * @return ResponseOrderInfo
     */
    public static function setCreateOrder($response){
        if(empty($response->correlationId) || empty($response->orderInfo)) {
            return new self('', new \stdClass());
        }
        return new self($response->correlationId, $response->orderInfo);
    }

    /**
     * @param $response
     * @return ResponseOrderInfo
     */
    public static function setSearchOrder($response){
        $info = (!empty($response->orders[0])) ? $response->orders[0] : null;
        if(empty($response->correlationId) || empty($info)) {
            return new self('', new \stdClass());
        }
        return new self($response->correlationId, $info);
    }
}

/**
 * Class OrderInfo
 * @package webkotlas\iiko
 */
class OrderInfo{
    public $parentDeliveryId = '';
    public $customer = null;
    public $phone = null;
    public $deliveryPoint = null;
    public $status = ''; //статус заказаа "Unconfirmed" "WaitCooking" "ReadyForCooking" "CookingStarted" "CookingCompleted" "Waiting" "OnWay" "Delivered" "Closed" "Cancelled"
    public $cancelInfo = null;
    public $courierInfo = null;
    public $completeBefore = '';
    public $whenCreated = '';
    public $whenConfirmed = '';
    public $whenPrinted = '';
    public $whenSended = '';
    public $whenDelivered = '';
    public $comment = '';
    public $problem = null;
    public $operator = null;
    public $marketingSource = null;
    public $deliveryDuration = 0;
    public $indexInCourierRoute = 0;
    public $cookingStartTime = '';
    public $isDeleted = false;
    public $whenReceivedByApi = ''; //дата получения заказа на Api
    public $whenReceivedFromFront = '';  //дата получения заказа на теримнал
    public $movedFromDeliveryId = '';  //uuid
    public $movedFromTerminalGroupId = '';  //uuid
    public $movedFromOrganizationId = '';  //uuid
    public $externalCourierService = null;
    public $sum = 0.00; // Order amount (after discount or surcharge).
    public $number = 0; // Delivery No.
    public $sourceKey = ''; // Delivery source.
    public $whenBillPrinted = ''; // nvoice printing time (guest bill time).
    public $whenClosed = ''; // Delivery closing time.
    public $conception = null; //
    public $guestsInfo = null; //
    public $items = null; //
    public $combos = null; //
    public $payments = null; //
    public $tips = null; //
    public $discounts = null; //
    public $orderType = null; //
    public $terminalGroupId = ''; //
    public $processedPaymentsSum = 0; //

    const StatusUnconfirmed = "Unconfirmed";
    const StatusWaitCooking = "WaitCooking";
    const StatusReadyForCooking = "ReadyForCooking";
    const StatusCookingStarted = "CookingStarted";
    const StatusCookingCompleted = "CookingCompleted";
    const StatusWaiting = "Waiting";
    const StatusOnWay = "OnWay";
    const StatusDelivered = "Delivered";
    const StatusClosed = "Closed";
    const StatusCancelled = "Cancelled";
    /**
     * OrderInfo constructor.
     * @param array $item
     */
    public function __construct($item = [])
    {
        if(!empty($item) && is_array($item)) {
            foreach ($item as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @return string
     */
    public function getStatus(){
        return $this->status;
    }

    /**
     * @return bool
     */
    public function isStatusUnconfirmed(){
        return self::StatusUnconfirmed == $this->getStatus();
    }

    /**
     * @return bool
     */
    public function isStatusWaitCooking(){
        return self::StatusWaitCooking  == $this->getStatus();
    }

    /**
     * @return bool
     */
    public function isStatusReadyForCooking(){
        return self::StatusReadyForCooking == $this->getStatus();
    }

    /**
     * @return bool
     */
    public function isStatusCookingStarted(){
        return self::StatusCookingStarted == $this->getStatus();
    }

    /**
     * @return bool
     */
    public function isStatusCookingCompleted(){
        return self::StatusCookingCompleted == $this->getStatus();
    }

    /**
     * @return bool
     */
    public function isStatusWaiting(){
        return self::StatusWaiting == $this->getStatus();
    }

    /**
     * @return bool
     */
    public function isStatusOnWay(){
        return self::StatusOnWay == $this->getStatus();
    }

    /**
     * @return bool
     */
    public function isStatusDelivered(){
        return self::StatusDelivered == $this->getStatus();
    }

    /**
     * @return bool
     */
    public function isStatusClosed(){
        return self::StatusClosed == $this->getStatus();
    }

    /**
     * @return bool
     */
    public function isStatusCancelled(){
        return self::StatusCancelled == $this->getStatus();
    }
}