<?php
namespace Revolta77\BackupManager\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Returns instance of logged in user.
 *
 * @return \Revolta77\BackupManager\BackupManager
 */
class BackupManager extends Facade
{
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'BackupManager';
    }

} 