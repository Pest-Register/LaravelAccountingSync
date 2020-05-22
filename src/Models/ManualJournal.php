<?php
namespace PestRegister\LaravelAccountingSync\Models;
use PestRegister\LaravelAccountingSync\Interfaces\CrudInterface;

class ManualJournal extends BaseModel implements CrudInterface
{
    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function create(array $parameters = [])
    {
        $response = $this->getGateway()->createManualJournal($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception(json_encode($response->getErrorMessage()));
        }
        return $response->getManualJournals();
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function update(array $parameters = [])
    {
        $response = $this->getGateway()->updateManualJournal($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception(json_encode($response->getErrorMessage()));
        }
        return $response->getManualJournals();
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function get(array $parameters = [])
    {
        $response = $this->getGateway()->getManualJournal($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception(json_encode($response->getErrorMessage()));
        }
        return $response->getManualJournals();
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */

    public function delete(array $parameters = [])
    {
        $response = $this->getGateway()->deleteManualJournal($parameters)->send();
        if (!$response->isSuccessful()) {
            throw new \Exception(json_encode($response->getErrorMessage()));
        }
        return $response->getManualJournals();
    }
}