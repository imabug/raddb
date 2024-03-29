<?php

use function Pest\Laravel\get;

test('Lising page exists', function ($url) {
    get($url)->assertStatus(200);
})->with([
    'Machines listing'                          => '/machines',
    'Test equipment calibration dates liisting' => '/testequipment/caldates',
]);
// namespace Tests\Feature;

// use Tests\TestCase;

// class ListingsTest extends TestCase
// {
//     /**
//      * Test that the Listings pages load via HTTP requests.
//      *
//      * @dataProvider ListingPages
//      *
//      * @return void
//      **/
//     public function testListingPagesLoadViaHttp($pageName, $value)
//     {
//         $this->get($pageName)->assertStatus(200);
//     }

//     public function listingPages(): array
//     {
//         return [
//             'Machines listing'                 => ['/machines', 'Equipment Inventory - Active'],
//             'Test equipment listing'           => ['/testequipment', 'Equipment Inventory - Test Equipment'],
//             'Test equipment cal dates listing' => ['/testequipment/caldates', 'Recent Test Equipment Calibration Dates'],
//         ];
//     }
//}
