<?php

namespace App\Providers;

use App\Models\Location;
use App\Models\Machine;
use App\Models\Manufacturer;
use App\Models\Modality;
use App\Models\OpNote;
use App\Models\Recommendation;
use App\Models\TestDate;
use App\Models\Tester;
use App\Models\TestType;
use App\Models\Tube;
use App\Policies\LocationPolicy;
use App\Policies\MachinePolicy;
use App\Policies\ManufacturerPolicy;
use App\Policies\ModalityPolicy;
use App\Policies\OpNotePolicy;
use App\Policies\RecommendationPolicy;
use App\Policies\TestDatePolicy;
use App\Policies\TesterPolicy;
use App\Policies\TestTypePolicy;
use App\Policies\TubePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //'App\Models\Model'         => 'App\Policies\ModelPolicy',
        Location::class       => LocationPolicy::class,
        Machine::class        => MachinePolicy::class,
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
