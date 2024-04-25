<?php

function displayGBPFormatted($amount): string
{
    if (!$amount) $amount = 0;
    return '£' . number_format($amount, 2);
}

function loggedInSociety()
{
    return auth('society')->user()->society;
}

function checkAdminPermissions($role, $permission)
{
    $user = auth('admin')->user();
    $societyUserHasRole = $user->hasRole($role);

    if($role == 'society user')
    {
        if($societyUserHasRole)
        {
            return true;
        }
    }
    if($role == 'SuperAdmin')
    {
        if($societyUserHasRole)
        {
            return true;
        }   
    }
    if($user->can($permission))
    {
        return $user->can($permission);
    }
    return false;

}
