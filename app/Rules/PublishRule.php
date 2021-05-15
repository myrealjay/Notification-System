<?php

namespace App\Rules;

use App\Http\Requests\PublishRequest;
use Illuminate\Contracts\Validation\Rule;

class PublishRule implements Rule
{
    private $request;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(PublishRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $data = json_decode(json_encode($this->request->all()));

        if(gettype($data) != 'object'){
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The supplied body must be a javascript object';
    }
}
