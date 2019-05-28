<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dylan
 * Date: 15/05/2019
 * Time: 1:07 PM
 */

namespace PestRegister\LaravelAccountingSync\Resources;


interface Syncable
{
    public function getAccountingIdAttribute(): ? string;
    public function getAccountingArray() : array;
    public function syncToAccountingProvider(): bool;
}