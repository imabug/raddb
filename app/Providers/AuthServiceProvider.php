<?php

namespace RadDB\Providers;

use RadDB\Tube;
use RadDB\OpNote;
use RadDB\Tester;
use RadDB\Machine;
use RadDB\Location;
use RadDB\Modality;
use RadDB\TestDate;
use RadDB\TestType;
use RadDB\Manufacturer;
use RadDB\Recommendation;
use RadDB\Policies\TubePolicy;
use RadDB\Policies\OpNotePolicy;
use RadDB\Policies\TesterPolicy;
use RadDB\Policies\MachinePolicy;
use RadDB\Policies\LocationPolicy;
use RadDB\Policies\ModalityPolicy;
use RadDB\Policies\TestDatePolicy;
use RadDB\Policies\TestTypePolicy;
use RadDB\Policies\MachinePhotoPolicy;
use RadDB\Policies\ManufacturerPolicy;
use RadDB\Policies\RecommendationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'RadDB\Model'         => 'RadDB\Policies\ModelPolicy',
        Location::class       => LocationPolicy::class,
        Machine::class        => MachinePolicy::class,
        MachinePhoto::class   => MachinePhotoPolicy::class,
        Manufacturer::class   => ManufacturerPolicy::class,
        Modality::class       => ModalityPolicy::class,
        OpNote::class         => OpNotePolicy::class,
        Recommendation::class => RecommendationPolicy::class,
        TestDate::class       => TestDatePolicy::class,
        Tester::class         => TesterPolicy::class,
        TestType::class       => TestTypePolicy::class,
        Tube::class           => TubePolicy::class,
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
