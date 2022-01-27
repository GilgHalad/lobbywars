<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Service\ControlSignatures as ControlSignatures;
use App\Entity\Signatures;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
class ControlSignaturesTest extends WebTestCase
{
    public function testUrlOk()
    {
        $client = static::createClient();
        $client->request('GET', '/judgment?plaintiff=kkn&defendant=KVK');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1','Judgement');
    }

    public function testUrlComodin()
    {
        $client = static::createClient();
        $client->request('GET', '/judgment?plaintiff=kk%23&defendant=KVK');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('','have a comodin');
    }
    
    public function testUrlNotComodin()
    {
        $client = static::createClient();
        $client->request('GET', '/judgment?plaintiff=kkn&defendant=KVK');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextNotContains('p','have a comodin');
    }
}