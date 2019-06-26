<?php


namespace PestRegister\LaravelAccountingSync\Models;

use PestRegister\LaravelAccountingSync\Interfaces\CrudInterface;

class Account extends BaseModel implements CrudInterface
{

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function create(array $parameters = [])
    {
        $response = $this->getGateway()->createAccount($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getAccounts();
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function update(array $parameters = [])
    {
        $response = $this->getGateway()->updateAccount($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getAccounts();
    }
    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function get(array $parameters = [])
    {
        $response = $this->getGateway()->getAccount($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getAccounts();
    }
    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function delete(array $parameters = [])
    {
        $response = $this->getGateway()->deleteAccount($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getAccounts();
    }
}