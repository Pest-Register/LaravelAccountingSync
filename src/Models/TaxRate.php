<?php
namespace PestRegister\LaravelAccountingSync\Models;


use PestRegister\LaravelAccountingSync\Exceptions\AccountingException;
use PestRegister\LaravelAccountingSync\Interfaces\CrudInterface;

class TaxRate extends BaseModel implements CrudInterface
{

    public function create(array $parameters)
    {
        $response = $this->getGateway()->createTaxRate($parameters)->send();
        if (!$response->isSuccessful()) {
            AccountingException::handle($response->getErrorMessage());
        }
        return $response->getTaxRates();
    }

    public function update(array $parameters)
    {
        $response = $this->getGateway()->updateTaxRate($parameters)->send();
        if (!$response->isSuccessful()) {
            AccountingException::handle($response->getErrorMessage());
        }
        return $response->getTaxRates();
    }

    public function get(array $parameters)
    {
        $response = $this->getGateway()->getTaxRate($parameters)->send();
        if (!$response->isSuccessful()) {
            AccountingException::handle($response->getErrorMessage());
        }
        return $response->getTaxRates();
    }

    public function delete(array $parameters)
    {
        $response = $this->getGateway()->deleteTaxRate($parameters)->send();
        if (!$response->isSuccessful()) {
            AccountingException::handle($response->getErrorMessage());
        }
        return $response->getTaxRates();
    }
}
