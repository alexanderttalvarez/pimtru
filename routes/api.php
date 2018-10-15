<?php

use App\Models\TaxonomyType;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Product routes
Route::apiResources([ 'products' => 'Product\ProductController' ]);
Route::resource('products.taxonomies', 'Product\ProductTaxonomyController', [ 'only' => [ 'index' ] ]);

// Taxonomy routes
Route::apiResources([ 'taxonomies' => 'Taxonomy\TaxonomyController' ]);
Route::resource('taxonomies.products', 'Taxonomy\TaxonomyProductController', [ 'only' => [ 'index' ] ]);

// Taxonomy types routes
Route::apiResources([ 'taxonomyTypes' => 'Taxonomy\TaxonomyTypeController' ]);
Route::resource('taxonomyTypes.taxonomies', 'Taxonomy\TaxonomyTypeTaxonomyController', [ 'only' => [ 'index' ] ]);

// Taxonomy type metas routes
Route::apiResources([ 'taxonomyTypeMetas' => 'Taxonomy\TaxonomyTypeMetaController' ]);
Route::resource('taxonomyTypeMetas.taxonomyType', 'Taxonomy\TaxonomyTypeMetaTaxonomyTypeController', [ 'only' => [ 'index' ] ]);
Route::resource('taxonomyTypeMetas.taxonomyTypeMetaValues', 'Taxonomy\TaxonomyTypeMetaTaxonomyTypeMetaValueController', [ 'only' => [ 'index' ] ]);

// Taxonomy type meta values routes
Route::resource('taxonomyTypeMetaValues', 'Taxonomy\TaxonomyTypeMetaValueController', [ 'only' => [ 'index', 'store' ] ]);
Route::resource('taxonomies.taxonomyTypeMetas', 'Taxonomy\TaxonomyTaxonomyTypeMetaController', [ 'only' => [ 'destroy', 'update', 'show' ] ]);

// TODO New routes depending on the taxonomy type name

// Manufacturer routes
Route::apiResources([ 'manufacturers' => 'Manufacturer\ManufacturerController' ]);

// Users
Route::resource('users', 'User\UserController', [ 'except' => [ 'create', 'edit' ] ]);
Route::name('verify')->get('users/verify/{token}', 'User\UserController@verify');
Route::name('resend')->get('users/{user}/resend', 'User\UserController@resendVerification');

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');