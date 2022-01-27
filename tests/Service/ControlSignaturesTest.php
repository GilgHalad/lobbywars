<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Service\ControlSignatures as control;
use Doctrine\ORM\EntityManagerInterface;

class ControlSignaturesTest extends WebTestCase
{
    public function testSomething(): void
    {
        $this->entity = $this->createMock(EntityManagerInterface::class);
        $control = new control($this->entity);
        $method = $control->controlSignature("vvv");
        $this->assertEquals(2100, $method);
    }       
    // $response = ['total' =>$total,'errorCode' => $error,'haveKing' => $haveKing, 'haveComodin' => $haveComodin];

}