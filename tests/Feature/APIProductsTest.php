<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

class APIProductsTest extends TestCase
{

    private $_basic_route = '/products';

    private $_single_item_structure = [
        'name',
        'description',
        'image',
        'legalText',
        'quantityPerUnit',
        'unitName',
        'storehouseStock',
        'discontinued',
        'creationDate',
        'lastUpdate',
        'removalDate',
        'links' => [
            [
                'rel',
                'href'
            ]
        ]
    ];

    /**
     * Testing the list of products
     *
     * @return void
     */
    public function testList()
    {
        $response = $this->json('GET', $this->_basic_route);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    $this->_single_item_structure
                ],
            ]);

    }

    /**
     * Testing a single product
     * 
     * @return void
     */
    public function testSingle() {

        $response = $this->json('GET', $this->_basic_route . '/1');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->_single_item_structure
            ]);

    }

    /**
     * Testing product creation
     * 
     * @return void
     */
    public function testPost() {

        $response = $this->json('POST', $this->_basic_route, [
            'name'            => 'Test 1',
            'description'     => 'Description 1',
            'legalText'       => 'Legal text 1',
            'quantityPerUnit' => 'Quantity1',
            'unitName'        => 'Kg',
            //'image'           => 'https://lorempixel.com/400/400/?69557',
            'storehouseStock' => 1,
            'manufacturerId'  => 1,
            'discontinued'    => 0
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => $this->_single_item_structure
            ]);

    }

}
