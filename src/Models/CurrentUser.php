<?php


namespace PestRegister\LaravelAccountingSync\Models;


use PestRegister\LaravelAccountingSync\Interfaces\CrudInterface;

class CurrentUser extends BaseModel implements CrudInterface
{

    public function create(array $parameters)
    {
        // TODO: Implement create() method.
    }

    public function update(array $parameters)
    {
        // TODO: Implement update() method.
    }

    public function get(array $parameters)
    {
        $response = $this->getGateway()->getCurrentUser()->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getCurrentUser();
    }

    public function delete(array $parameters)
    {
        // TODO: Implement delete() method.
    }
}