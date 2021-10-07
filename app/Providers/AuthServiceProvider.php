<?php

namespace RadDB\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use RadDB\Models\Location;
use RadDB\Models\Machine;
use RadDB\Models\MachinePhoto;
use RadDB\Models\Manufacturer;
use RadDB\Models\Modality;
use RadDB\Models\OpNote;
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
use RadDB\Models\Recommendation;
use RadDB\Models\TestDate;
use RadDB\Models\Tester;
use RadDB\Models\TestType;
use RadDB\Models\Tube;

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
