<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dylan
 * Date: 15/05/2019
 * Time: 12:30 PM
 */

namespace PestRegister\LaravelAccountingSync;

class ResourceConnectionInstance
{
    /**
     * @var $accountingResourceInstance
     */
    private $accountingResourceInstance;

    private $accountingResource;

    /**
     * @throws \ReflectionException
     */
    public function __construct ($accountingResource, $config) {
        $this->accountingResource = $accountingResource;
        if (empty($this->accountingResource)) {
            throw new \Exception('The $AccountingResource property must be instantiated.');
        }
        $this->getAccountingResourceInstance($config);
        if ($this->accountingResourceInstance == null) {
            throw new \Exception('Unable to create accounting instance');
        }
    }

    /**
     * @return null|\AccountingOnline\API\Core\HttpClients\FaultHandler
     */
    public function getLastAccountingError()
    {
        return $this->accountingResourceInstance->getError();
    }

    /**
     * @param $params
     * @return mixed
     */
    public function loadFromAccountingProvider($params){
        return $this->accountingResourceInstance->get($params);
    }

    /**
     * Magic method to call method of accountingResourceInstance
     * if the method is not defined on this Connector
     *
     * @param $method
     * @param $args
     * @return mixed
     * @throws \Exception
     */
    public function __call ($method, $args) {
        if (method_exists($this->accountingResourceInstance, $method)) {
            return $this->accountingResourceInstance->$method($args);
        }
        throw new \Exception('Method does not exist');
    }

    /**
     * Return an instance of the associated Accounting resource.
     *
     * @param $config
     * @return mixed
     * @throws \ReflectionException
     */
    private function getAccountingResourceInstance($config)
    {
        $myParameters = array ($config);

        if (empty($this->AccountingResourceInstance)) {
            $reflection = new \ReflectionClass($this->accountingResource);
            $this->accountingResourceInstance = $reflection->newInstanceArgs($myParameters);
        }
        return $this->accountingResourceInstance;
    }
}
