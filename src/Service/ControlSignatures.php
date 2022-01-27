<?php

namespace App\Service;

use App\Entity\Signatures;
use Doctrine\ORM\EntityManagerInterface;

class ControlSignatures
{
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    public function controlSignature($signatures)
    {
        $sig = str_split($signatures);
        $error = 0;
        $haveKing = 0;
        $haveComodin = 0;
        $countComodin = 0;
        $total = [];
        $maxSignatures = 3;
        
        if (count($sig) > $maxSignatures){
            $error = 1;
        }

        for ($i=0; $i <count($sig) ; $i++) {
            $result = $this->entityManager
            ->getRepository(Signatures::class)
            ->findBy(['abbreviation' => $sig[$i]]);
            //Not exist signature
            if (count($result) == 0 && $sig[$i] != '#') {
                $error = 1;
            } elseif($sig[$i] == '#') {
                $countComodin+=+1;
                if ( $countComodin > 1) {
                    $error = 1;
                }
                $haveComodin = 1;
            } else {
                array_push($total,['key' => $result[0]->getAbbreviation(), 'point'=>$result[0]->getPoint()]);
                if ($result[0]->getAbbreviation() == 'K') {
                    $haveKing = 1;
                }
            }
        }
        $response = ['total' =>$total,'errorCode' => $error,'haveKing' => $haveKing, 'haveComodin' => $haveComodin];
        return $response;        
    }

    /*
    * Get the total points of all signatures
    */
    public function resultSignature($signatures,$king)
    {     
        $total =0;
        foreach ($signatures as $key => $value) {
            if ($value['key'] == 'V' && $king){
                $value['point'] = 0;
            }
            $total +=$value['point'];
        } 
        $response =['total' =>$total];
        return $response;
        
    }

    /*
    * Get the signature to win with a comodin
    */
    public function comodinSignature($value)
    {
        $repository = $this->entityManager
        ->getRepository('App:Signatures');
        $query = $repository->createQueryBuilder('p')
            ->where('p.point >= :point')
            ->setParameter('point', $value)
            ->orderBy('p.point', 'ASC')
            ->getQuery()
            ->getResult();
    if ($query == null ? $result = 0: $result['point'] = $query[0]->getPoint() and $result['abbreviation']=$query[0]->getAbbreviation());
        return $result;     
    }    
}    
