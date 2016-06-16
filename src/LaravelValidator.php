<?php

namespace LOOP\ValidationService\src;

use Illuminate\Contracts\Validation\Factory;
use LOOP\ValidationService\Exceptions\ValidationFunctionDoesNotExist;
use LOOP\ValidationService\ValidatorInterface;

/**
 * Class LaravelValidator
 * @package LOOP\ValidationService\src
 */
abstract class LaravelValidator implements ValidatorInterface
{

    protected $validator;
    protected $errors = array();
    protected $data = array();


    /**
     * @param Factory $validator
     */
    public function __construct( Factory $validator )
    {
        $this->validator = $validator;
    }


    /**
     * @param array $data
     * @return $this
     */
    public function with( array $data )
    {
        $this->data = $data;
        return $this;
    }


    /**
     * @param array $setOfRules
     * @return bool
     * @throws ValidationFunctionDoesNotExist
     */
    public function passes( $setOfRules )
    {
        if ( is_string( $setOfRules ) || is_array( $setOfRules ) )
        {
            $validator = NULL;
            if ( is_string( $setOfRules ) && method_exists( $this, $setOfRules ) ) $validator = $this->validator->make( $this->data, $this->{$setOfRules}() );
            else if ( is_array( $setOfRules ) ) $validator = $this->validator->make( $this->data, $setOfRules );
            else
            {
                throw new ValidationFunctionDoesNotExist();
            }

            if ( !is_null( $validator ) )
            {
                if( !$validator->fails() ) return TRUE;
                else $this->errors = $validator->messages()->getMessages();
            }
        }

        return FALSE;
    }


    /**
     * @return mixed
     */
    public function errors()
    {
        return $this->errors;
    }


    /**
     * @param $key
     * @return mixed
     */
    public function get( $key )
    {
        return @$this->data[ $key ];
    }


}