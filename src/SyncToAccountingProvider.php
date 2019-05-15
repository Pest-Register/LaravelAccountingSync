<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dylan
 * Date: 15/05/2019
 * Time: 12:30 PM
 */

namespace PestRegister\LaravelAccountingSync;


trait SyncToAccountingProvider
{
    /**
     * @var AccountingResource
     */
    protected $AccountingResourceInstance;
    /**
     * The data to sync to Accounting.
     *
     * @see https://developer.intuit.com/docs/api/accounting
     * @return array
     */
    abstract protected function getAccountingArray(): array;
    /**
     * Allows you to use `$model->Accounting_id` regardless of the actual column being used.
     *
     * @return null|string
     */
    public function getAccountingIdAttribute(): ?string
    {
        $AccountingIdColumn = $this->AccountingIdColumn ?? 'Accounting_id';
        if (isset($this->attributes[$AccountingIdColumn])) {
            return $this->attributes[$AccountingIdColumn];
        }
        return null;
    }
    /**
     * @return null|\AccountingOnline\API\Core\HttpClients\FaultHandler
     */
    public function getLastAccountingError()
    {
        return $this->getAccountingResourceInstance()->getError();
    }
    /**
     * Creates the model in Accounting.
     *
     * @return bool
     * @throws \AccountingOnline\API\Exception\IdsException
     */
    public function insertToAccounting(): bool
    {
        $attributes = $this->getAccountingArray();
        $resourceId = $this->getAccountingResourceInstance()->create($attributes);
        if (!$resourceId) {
            return false;
        }
        $this->accounting_id = $resourceId;
        $this->save();
        return true;
    }
    /**
     * Updates the model in Accounting.
     *
     * @return bool
     * @throws \AccountingOnline\API\Exception\IdsException
     * @throws \Exception
     */
    public function updateToAccounting(): bool
    {
        if (empty($this->Accounting_id)) {
            return false;
        }
        $attributes = $this->getAccountingArray();
        return $this->getAccountingResourceInstance()->update($this->Accounting_id, $attributes);
    }

    /**
     * Syncs the model to Accounting.
     *
     * @param $config
     * @return bool
     * @throws \Exception
     */
    public function syncToAccountingProvider($config): bool
    {
        $this->getAccountingResourceInstance($config);
        if (empty($this->accounting_id)) {
            return $this->insertToAccounting();
        }
        return $this->updateToAccounting();
    }
    /**
     * Returns the class name for the Accounting resource.
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getAccountingResource()
    {
        if (empty($this->AccountingResource)) {
            throw new \Exception('The $AccountingResource property must be set on the model.');
        }
        return $this->AccountingResource;
    }

    /**
     * Return an instance of the associated Accounting resource.
     *
     * @param null $config
     * @return mixed
     */
    protected function getAccountingResourceInstance($config = null)
    {
        if (empty($this->AccountingResourceInstance)) {
            $this->AccountingResourceInstance = new $this->$accountingResource($config);
        }
        return $this->AccountingResourceInstance;
    }
}