<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use apirest\User;


class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    /*public function testExample()
    {
        $this->assertTrue(true);
    }*/
    use WithoutMiddleware;
    use DatabaseMigrations;

    public function testUserCreate()
    {
        $data = $this->getData();
        //creamos un nuevo usuario y verificamos

        $this->post('/user',$data)
        ->seeJsonEquals(['create'=> true]);

        $data = $this->getdata(['name' => 'jane']);
        // actualizamos al usuario recien creado (id=1)

        $this->put('/user/1',$data)
            ->seeJsonEquals(['update'=> true]);

        //obtenemos los datos de dicho usuario modificado
        //y verificamos que el nombre sea correcto


        $this->get('user/1')->seeJson(['name'=>'jane']);


        // eliminamos al usuario

        $this->delete('user/1')->seeJson(['deleted'=> true]);
    }


    public function testValidatioErrorOnCreateUser(){

        $data = $this->getData(['name' =>'','email' =>'jane']);
        $this->post('user',$data)->dump();
    }


    public function testNotFoundUser(){

        $this->get('user/10')->seeJsonEquals(['errors'=>'model not found']);
    }

    public function getData($custom= array()){

        $data = [

            'name' => 'joe',
            'email' => 'joe@doe.com',
            'password' => '12345'

        ];

        $data = array_merge($data,$custom);
        return $data;
    }


}
