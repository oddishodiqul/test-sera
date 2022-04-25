<?php

namespace Tests;

use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    /**
     * /products [GET]
     */
    public function testShouldReturnAllUsers(){

        $this->get("api/index", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'email',
                    'username',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
        
    }

    /**
     * /products/id [GET]
     */
    public function testShouldReturnSingleUser(){
        $this->get("api/show/2", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                '_id',
                'email',
                'username',
                'created_at',
                'updated_at',
            ]);
    }

    /**
     * /products [POST]
     */
    public function testShouldCreateUser(){

        $parameters = [
            'email' => 'test@email.com',
            'username' => 'testing',
            'password' => Hash::make('test')
        ];
        $this->seeStatusCode(200);
        $this->json('POST', '/api/store', ['email' => 'test@email.com', 'username' => 'test', 'password' => Hash::make('test')])
             ->seeJson([
                'created' => true,
             ]);
             
    }
    
    /**
     * /products/id [PUT]
     */
    public function testShouldUpdateUser(){

        $parameters = [
            'email' => 'test@email.com',
            'username' => 'testing',
            'password' => Hash::make('test')
        ];

        $this->put("api/update/4", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                '_id',
                'email',
                'username',
                'password',
                'created_at',
                'updated_at',
            ]);
    }

    /**
     * /products/id [DELETE]
     */
    public function testShouldDeleteUser(){
        
        $this->delete("api/delete/5", [], []);
        $this->seeStatusCode(410);
        $this->seeJsonStructure([
                'message'
        ]);
    }

}