<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dylan
 * Date: 15/05/2019
 * Time: 12:26 PM
 */

namespace PestRegister\LaravelAccountingSync;


interface CrudInterface
{

    public function create(array $parameters);
    public function update(array $parameters);
    public function get(array $parameters);
    public function delete(array $parameters);
}