<?php

namespace PestRegister\LaravelAccountingSync\Models;

use PestRegister\LaravelAccountingSync\Interfaces\CrudInterface;

class Payment extends BaseModel implements CrudInterface
{

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function create(array $parameters = [])
    {
        $response = $this->getGateway()->createPayment($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getPayments();
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function update(array $parameters = [])
    {
        $response = $this->getGateway()->updatePayment($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getPayments();
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function get(array $parameters = [])
    {
        $response = $this->getGateway()->getPayment($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getPayments();
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function delete(array $parameters = [])
    {
        $response = $this->getGateway()->deletePayment($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getPayments();
    }
}