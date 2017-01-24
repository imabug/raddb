<?php

namespace RadDB\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'RadDB\Model' => 'RadDB\Policies\ModelPolicy',
        Location::class => LocationPolicy::class,
        Machine::class => MachinePolicy::class,
        Manufacturer::class => ManufacturerPolicy::class,
        Modality::class => ModalityPolicy::class,
        OpNote::class => OpNotePolicy::class,
        Recommendation::class => RecommendationPolicy::class,
        TestDate::class => TestDatePolicy::class,
        Tester::class => TesterPolicy::class,
        TestType::class => TestTypePolicy::class,
        Tube::class => TubePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

    }
}
