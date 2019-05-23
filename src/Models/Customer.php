<?php


namespace PestRegister\LaravelAccountingSync\Models;

use PestRegister\LaravelAccountingSync\CrudInterface;

/**
 * Created by IntelliJ IDEA.
 * User: Dylan
 * Date: 15/05/2019
 * Time: 1:04 PM
 */

class Customer extends BaseModel implements CrudInterface
{

    public function create(array $parameters = [])
    {
        $response = $this->getGateway()->createContact($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception('charge card unsuccessful');
        }
        return $response->getCustomerReference();
        // TODO: Implement create() method.
    }

    public function update(array $parameters = [])
    {
        $response = $this->getGateway()->updateContact($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception('charge card unsuccessful');
        }
        return $response->getCustomerReference();
        // TODO: Implement create() method.
    }

    public function get(array $parameters = [])
    {
        $response = $this->getGateway()->getContact($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception('charge card unsuccessful');
        }
        return $response->getCustomerReference();
        // TODO: Implement create() method.
    }

    public function delete(array $parameters = [])
    {
        $response = $this->getGateway()->deleteContact($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception('charge card unsuccessful');
        }
        return true;
    }
}