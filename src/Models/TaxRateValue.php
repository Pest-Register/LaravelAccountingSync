<?php
/**
 * Created by IntelliJ IDEA.
 * User: MaxYendall
 * Date: 14/10/2019
 * Time: 3:43 PM
 */
namespace PestRegister\LaravelAccountingSync\Models;


use PestRegister\LaravelAccountingSync\Interfaces\CrudInterface;

class TaxRateValue extends BaseModel implements CrudInterface
{

    public function create(array $parameters)
    {
        $response = $this->getGateway()->createTaxRateValue($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception(json_encode($response->getErrorMessage()));
        }
        return $response->getTaxRateValues();
    }

    public function update(array $parameters)
    {
        $response = $this->getGateway()->updateTaxRateValue($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception(json_encode($response->getErrorMessage()));
        }
        return $response->getTaxRateValues();
    }

    public function get(array $parameters)
    {
        $response = $this->getGateway()->getTaxRateValue($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception(json_encode($response->getErrorMessage()));
        }
        return $response->getTaxRateValues();
    }

    public function delete(array $parameters)
    {
        $response = $this->getGateway()->deleteTaxRateValue($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception(json_encode($response->getErrorMessage()));
        }
        return $response->getTaxRateValues();
    }
}