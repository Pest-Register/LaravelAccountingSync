<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dylan
 * Date: 29/05/2019
 * Time: 2:50 PM
 */

namespace PestRegister\LaravelAccountingSync\Models;


use PestRegister\LaravelAccountingSync\Interfaces\CrudInterface;

class InventoryItem extends BaseModel implements CrudInterface
{

    public function create(array $parameters)
    {
        $response = $this->getGateway()->createInventoryItem($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getInventoryItems();
    }

    public function update(array $parameters)
    {
        $response = $this->getGateway()->updateInventoryItem($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getInventoryItems();
    }

    public function get(array $parameters)
    {
        $response = $this->getGateway()->getInventoryItem($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getInventoryItems();
    }

    public function delete(array $parameters)
    {
        $response = $this->getGateway()->deleteInventoryItem($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getInventoryItems();
    }
}