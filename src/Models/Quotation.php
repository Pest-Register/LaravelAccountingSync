<?php


namespace PestRegister\LaravelAccountingSync\Models;


use PestRegister\LaravelAccountingSync\Exceptions\AccountingException;
use PestRegister\LaravelAccountingSync\Interfaces\CrudInterface;

class Quotation extends BaseModel implements CrudInterface
{
    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function create(array $parameters = [])
    {
        $response = $this->getGateway()->createQuotation($parameters)->send();
        if (!$response->isSuccessful()) {
            AccountingException::handle($response->getErrorMessage());
        }
        return $response->getQuotations();
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function update(array $parameters = [])
    {
        $response = $this->getGateway()->updateQuotation($parameters)->send();
        if (!$response->isSuccessful()) {
            AccountingException::handle($response->getErrorMessage());
        }
        return $response->getQuotations();
    }
    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function get(array $parameters = [])
    {
        $response = $this->getGateway()->getQuotation($parameters)->send();
        if (!$response->isSuccessful()) {
            AccountingException::handle($response->getErrorMessage());
        }
        return $response->getQuotations();
    }
    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function delete(array $parameters = [])
    {
        $response = $this->getGateway()->deleteQuotation($parameters)->send();
        if (!$response->isSuccessful()) {
            AccountingException::handle($response->getErrorMessage());
        }
        return $response->getQuotations();
    }
}
