<?php

namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AppAvailabilityFunctionalTest extends WebTestCase
{

    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessfulLogout($url, $expectedCode)
    {
        $client = self::createClient();

        $client->request('GET', $url);

        $this->assertEquals($expectedCode, $client->getResponse()->getStatusCode());
    }

    public function urlProvider()
    {
        return [
            ['/',200],
            ['/inscription',200],
            ['/connexion',200],
            ['/reset',200],
            ['/activation/token',302],
            ['/supprimer-une-figure/13',302],
            ['/editer-une-figure/13',302],
            ['/reset_password/token',302],
            ['/ajouter-une-figure',302],
            ['/deconnexion',302],
            ['/trick/13',200],

        ];
    }
    /**
     * @dataProvider urlLoginProvider
     */
    public function testPageIsSuccessfulLogin($url, $expectedCode)
    {
        $client = self::createClient([], [
            'PHP_AUTH_USER' => 'admin@admin.com',
            'PHP_AUTH_PW'   => 'adminadmin',
        ]);


        $client->request('GET', $url);

        $this->assertEquals($expectedCode, $client->getResponse()->getStatusCode());
    }

    public function urlLoginProvider()
    {
        return [

            ['/editer-une-figure/13',200],
            ['/ajouter-une-figure',200],

        ];
    }
}