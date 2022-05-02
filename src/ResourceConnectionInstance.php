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
     * Perform a query search to the provider
     *
     * @param $params: Normal params for endpoint request
     * @param array $searchParams : Search parameters (key value pairs - must match keys/values supported by the provider)
     * @param array $searchFilters : Search filters (key value pairs - must match keys/values supported by the provider)
     * @param bool $exactSearchValue : Either perform an exact or partial match on the values supplied within $params
     * @param bool $matchAllFilters : Either match all or at least one of the values supplied in $filters
     * @return mixed
     */
    public function search (array $params = [], array $searchParams = [], array $searchFilters = [], bool $exactSearchValue = true, bool $matchAllFilters = false) {
        $arr = $params + [
            'search_params' => $searchParams,
            'exact_search_value' => $exactSearchValue,
            'search_filters' => $searchFilters,
            'match_all_filters' => $matchAllFilters,
        ];

        return $this->accountingResourceInstance->get($arr);
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
            return $this->accountingResourceInstance->$method(...$args);
        }
        throw new \Exception('Provider connection method does not exist');
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
