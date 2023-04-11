<?php


namespace PestRegister\LaravelAccountingSync\Models;


use PestRegister\LaravelAccountingSync\Exceptions\AccountingException;
use PestRegister\LaravelAccountingSync\Interfaces\CrudInterface;

class AccountType extends BaseModel implements CrudInterface
{
    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function get(array $parameters = [])
    {
        $response = $this->getGateway()->getAccountType($parameters)->send();
        if (!$response->isSuccessful()) {
            AccountingException::handle($response->getErrorMessage());
        }
        return $response->getAccountTypes();
    }

    public function create(array $parameters)
    {
        // TODO: Implement create() method.
    }

    public function update(array $parameters)
    {
        // TODO: Implement update() method.
    }

    public function delete(array $parameters)
    {
        // TODO: Implement delete() method.
    }
}
