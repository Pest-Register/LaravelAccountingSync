<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dylan
 * Date: 15/05/2019
 * Time: 2:22 PM
 */

namespace PestRegister\LaravelAccountingSync\Models;


use PestRegister\LaravelAccountingSync\Interfaces\CrudInterface;

class Invoice extends BaseModel implements CrudInterface
{

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function create(array $parameters = [])
    {
        $response = $this->getGateway()->createInvoice($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getInvoice();
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function update(array $parameters = [])
    {
        $response = $this->getGateway()->updateInvoice($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getInvoice();
    }
    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function get(array $parameters = [])
    {
        $response = $this->getGateway()->getInvoice($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getInvoice();
    }
    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function delete(array $parameters = [])
    {
        $response = $this->getGateway()->deleteInvoice($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getData();
    }
}