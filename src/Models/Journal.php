<?php


namespace PestRegister\LaravelAccountingSync\Models;

use PestRegister\LaravelAccountingSync\Interfaces\CrudInterface;

class Journal extends BaseModel implements CrudInterface
{
    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function create(array $parameters = [])
    {
        $response = $this->getGateway()->createJournal($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getJournals();
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function update(array $parameters = [])
    {
        $response = $this->getGateway()->updateJournal($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getJournals();
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function get(array $parameters = [])
    {
        $response = $this->getGateway()->getJournal($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getJournals();
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function delete(array $parameters = [])
    {
        $response = $this->getGateway()->deleteJournal($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->getJournals();
    }
}