<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Taxonomy;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class APITaxonomiesTest extends TestCase
{

    private $_basic_route = '/taxonomies';

    private $_single_item_structure = [
        'id',
        'name',
        'description',
        'image',
        'parentId',
        'taxonomyTypeId',
        'creationDate',
        'lastUpdate',
        'links' => [
            [
                'rel',
                'href'
            ]
        ]
    ];

    /**
     * Testing the list of taxonomies
     *
     * @return void
     */
    public function testGetList()
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
     * Testing a single taxonomy
     * 
     * @return void
     */
    public function testGetSingle()
    {

        $response = $this->json('GET', $this->_basic_route . '/1');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->_single_item_structure
            ]);

    }

    /**
     * Testing taxonomy creation
     * 
     * @return void
     */
    public function testPostSuccess()
    {

        $taxonomy = factory(Taxonomy::class, 1)
                ->make();

        $data = $taxonomy->first();

        // Sending a post request to create a taxonomy
        $response = $this->json('POST', $this->_basic_route, [
            'name' => $data->name,
            'description' => $data->description,
            'image' => $data->image,
            'parentId' => $data->parent_id,
            'taxonomyTypeId' => $data->taxonomy_type_id,
        ]);

        $data = json_decode($response->content(), true);

        if (isset($data['error'])) {
            $response
                ->assertStatus(700);
        } else {
            $response
                ->assertStatus(201)
                ->assertJsonStructure([
                    'data' => $this->_single_item_structure
                ]);

            // We delete the record as it's not real
            Taxonomy::find( $data['data']['id'] )->delete();
        }

    }

    /**
     * It tests the response when posting a duplicate taxonomy
     */
    public function testPostRepeatedEntry() {

        $taxonomy = Taxonomy::first();

        // Sending a post request to create a taxonomy
        $response = $this->json('POST', $this->_basic_route, [
            'name' => $taxonomy->name,
            'description' => "Description 1",
            'image' => "image1.jpg",
            'parentId' => 1,
            'taxonomyTypeId' => 1,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'error'    
            ]);

    }

}
