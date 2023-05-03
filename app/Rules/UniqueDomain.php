<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;


class UniqueDomain implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {   // Extract The Domain from Email
       $Domain = explode('@',$value)[1];
       
       $Located =  DB::SELECT("SELECT * FROM `users` WHERE LOCATE('{$Domain}', `email`) > 0 limit 1");
     
        return  count($Located) === 0 ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your email domain must be unqiue.';
    }
}
