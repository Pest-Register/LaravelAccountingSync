<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dylan
 * Date: 29/05/2019
 * Time: 1:45 PM
 */

namespace PestRegister\LaravelAccountingSync\Models;


class ContactGroup extends BaseModel
{
    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function create(array $parameters = [])
    {
        $response = $this->getGateway()->createContactGroup($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception(json_encode($response->getErrorMessage()));
        }
        return $response->getContactGroups();
    }
    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function update(array $parameters = [])
    {
        $response = $this->getGateway()->updateContactGroup($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception(json_encode($response->getErrorMessage()));
        }
        return $response->getContactGroups();
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function get(array $parameters = [])
    {
        $response = $this->getGateway()->getContactGroup($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception(json_encode($response->getErrorMessage()));
        }
        return $response->getContactGroups();
    }

    /**
     * @param array $parameters
     * @return bool
     * @throws \Exception
     */
    public function delete(array $parameters = [])
    {
        $response = $this->getGateway()->deleteContactGroup($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception(json_encode($response->getErrorMessage()));
        }
        return $response->getContactGroups();
    }
}