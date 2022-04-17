<?php

if (! function_exists('granted_access')) {

    function granted_access(array $roles): bool
    {
        return in_array(\Illuminate\Support\Facades\Auth::user()->role->value, $roles);
    }
}
