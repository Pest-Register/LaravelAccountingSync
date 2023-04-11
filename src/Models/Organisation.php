<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dylan
 * Date: 12/07/2019
 * Time: 11:58 AM
 */

namespace PestRegister\LaravelAccountingSync\Models;


use PestRegister\LaravelAccountingSync\Exceptions\AccountingException;
use PestRegister\LaravelAccountingSync\Interfaces\CrudInterface;

class Organisation extends BaseModel implements CrudInterface
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
        $response = $this->getGateway()->getOrganisation()->send();
        if (!$response->isSuccessful()) {
            AccountingException::handle($response->getErrorMessage());
        }
        return $response->getOrganisations();
    }

    public function delete(array $parameters)
    {
        // TODO: Implement delete() method.
    }
}
