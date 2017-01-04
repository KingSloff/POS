<?php

namespace App\Policies;

class Policy
{
    /**
     * Create a new policy instance.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Admin always has access
     */
    public function before($user, $ability)
    {
        return true;
        /*if ($user->is_admin)
        {
            return true;
        }*/
    }
}
