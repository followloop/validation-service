<?php

namespace LOOP\ValidationService;

use LOOP\ValidationService\Exceptions\ValidationFunctionDoesNotExist;

/**
 * Interface ValidatorInterface
 * @package LOOP\ValidationService
 */
interface ValidatorInterface
{
    /**
     * Injects the data to be validated.
     *
     * @param array $data array of data to be validated.
     * @return ValidatorInterface current instance of the validator.
     */
    public function with( array $data );

    /**
     * Performs the given validation against the given data passed on "with()".
     *
     * @param $setOfRules array/string array of rules to validate, or the name of a function that contains the rules already.
     * @return mixed bool TRUE if it passes the validation, FALSE if it fails. For more info, retrieve errors after the fail.
     * @throws ValidationFunctionDoesNotExist
     */
    public function passes( $setOfRules );

    /**
     * Returns an array of validation errors that may be empty.
     *
     * @return array
     */
    public function errors();

    /**
     * Returns the requested key loaded via "with()", or NULL if the key does not exist.
     *
     * @param $key string Key to fetch.
     * @return mixed value for requested key or NULL if key does not exist.
     */
    public function get( $key );
}