<?php
namespace PestRegister\LaravelAccountingSync\Exceptions;

use PestRegister\LaravelAccountingSync\Exceptions\Model\DuplicateModelException;
use PestRegister\LaravelAccountingSync\Exceptions\Model\ModelCannotEditException;
use PestRegister\LaravelAccountingSync\Exceptions\Model\ModelNotFoundException;
use PestRegister\LaravelAccountingSync\Exceptions\Provider\AccessTokenExpiredException;
use PestRegister\LaravelAccountingSync\Exceptions\Provider\EndOfPaginationException;
use PestRegister\LaravelAccountingSync\Exceptions\Provider\RateLimitException;

class AccountingException extends \Exception {

    protected $payload;

    /**
     * @param $payload array Standardised array of information from the provider
     */
    public function __construct ($payload, $previous = null) {
        $this->payload = $payload;

        $message = $payload['message'] ?? null;
        $code = $payload['error_code'] ?? 0;

        parent::__construct($message, $code, $previous);
    }

    public function getPayload () {
        return $this->payload;
    }


    /**
     * Handle method is used for throwing the correct child exception based on returned payload
     * @throws AccountingException
     */
    public static function handle ($payload) {
        $exceptionClass = AccountingException::class;
        $message = isset($payload['message']) ? strtolower($payload['message']) : null;

        switch (true) {
            case $message == 'unauthorized':
            case $message == 'the access token has expired':
                $exceptionClass = AccessTokenExpiredException::class;
                break;
            case $message == 'null returned':
            case $message == 'null returned from api or end of pagination':
                $exceptionClass = EndOfPaginationException::class;
                break;
            case strpos($message, 'the api rate limit for your organisation/application pairing has been exceeded') !== false:
                $exceptionClass = RateLimitException::class;
                break;
            case strpos($message, 'duplicate model found') !== false:
            // myob
            case strpos($message, 'card_duplicatecardid') !== false:
            case strpos($message, 'inventory_duplicateitemnumber') !== false:
                $exceptionClass = DuplicateModelException::class;
                break;
            case strpos($message, 'no model found from given id') !== false:
            case strpos($message, 'object not found') !== false:
            case strpos($message, 'resource not found') !== false:
                $exceptionClass = ModelNotFoundException::class;
                break;
            case strpos($message, 'model cannot be edited') !== false:
                $exceptionClass = ModelCannotEditException::class;
                break;
            case strpos($message, 'required param missing') !== false:
            case strpos($message, 'validation exception') !== false:
            case strpos($message, 'invalid account type') !== false:
            case strpos($message, 'malformed web site address format') !== false:
            case strpos($message, 'invalid number') !== false:
                $exceptionClass = ValidationException::class;
                break;
        }

        throw new $exceptionClass($payload);
    }
}
