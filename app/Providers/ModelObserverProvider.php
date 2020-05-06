<?php

namespace App\Providers;

use App\Models\CompanyStaff;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

use App\Models\AdPlace;
use App\Models\Menu;
use App\Models\Manager;
use App\Models\Role;
use App\Models\Contract;
use App\Models\ContractFile;
//use App\Models\ContractTplFill;
//use App\Models\SinglePage;

class ModelObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        AdPlace::observe(\App\Observers\AdPlaceObserver::class);
        Menu::observe(\App\Observers\MenuObserver::class);
        Manager::observe(\App\Observers\ManagerObserver::class);
        Role::observe(\App\Observers\RoleObserver::class);
        Contract::observe(\App\Observers\ContractObserver::class);
        ContractFile::observe(\App\Observers\ContractFileObserver::class);
        Setting::observe(\App\Observers\SettingObserver::class);
        CompanyStaff::observe(\App\Observers\CompanyStaffObserver::class);
        //ContractTplFill::observe(\App\Observers\ContractTplFillObserver::class);
        //SinglePage::observe(\App\Observers\SinglePageObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
