<?php

namespace RadDB\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use RadDB\Location;
use RadDB\Machine;
use RadDB\MachinePhoto;
use RadDB\Manufacturer;
use RadDB\Modality;
use RadDB\OpNote;
use RadDB\Policies\LocationPolicy;
use RadDB\Policies\MachinePhotoPolicy;
use RadDB\Policies\MachinePolicy;
use RadDB\Policies\ManufacturerPolicy;
use RadDB\Policies\ModalityPolicy;
use RadDB\Policies\OpNotePolicy;
use RadDB\Policies\RecommendationPolicy;
use RadDB\Policies\TestDatePolicy;
use RadDB\Policies\TesterPolicy;
use RadDB\Policies\TestTypePolicy;
use RadDB\Policies\TubePolicy;
use RadDB\Recommendation;
use RadDB\TestDate;
use RadDB\Tester;
use RadDB\TestType;
use RadDB\Tube;

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
