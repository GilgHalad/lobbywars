<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ControlSignatures;

class JudgmentController extends AbstractController
{
    //private ControlSignatures $controlSignatures;

    public function __construct(ControlSignatures $controlSignatures)
    {
        $this->controlSignatures = $controlSignatures;
    }

    /**
     * @Route("/judgment", name="judgment")
     */
    public function index(Request $request): Response
    {            
        $plaintiff=$request->query->get('plaintiff');
        $defendant=$request->query->get('defendant');
        $total = ['maxPoint' => 0, 'win'=>'NaN'];
        $signatures=[$plaintiff,$defendant];
        $plaintiffComodin = 0;
        $defendantComodin = 0;
        $defendantTotal = 0;
        $plaintiffTotal = 0;
        $win = 0;
        $result = ['msg'=>[],'error'=>[]];
        
        foreach ($signatures as $key => $value) {
            $response = $this->controlSignatures->controlSignature($value);

            //Signature not valid
            if ($response['errorCode'] == 1) {   
                $error = 'The signature '.$value.' is not valid.</br>  ';
                array_push($result['error'],$error);
            } else {
                $responseResult = $this->controlSignatures->resultSignature($response['total'],$response['haveKing']);
                if ($win == 0) {
                    if ($response['haveComodin'] == 1) {
                        $plaintiffComodin = 1;
                    }
                    $plaintiffTotal=$responseResult['total'];
                } else if ($win > 0) {
                    if ($response['haveComodin'] == 1) {
                        $defendantComodin = 1;
                    }
                    $defendantTotal=$responseResult['total'];
                }

                if ($responseResult['total'] > $win) {
                    $win = $responseResult['total'];
                    $total = ['maxPoint' => $responseResult['total'], 'win'=>$value];
                } else if ($responseResult['total'] == $win) {
                    $total = ['maxPoint' => $responseResult['total'], 'win'=>'TIE'];
                }            

                $arrayResumen=[[    'signature' =>$plaintiff,
                                    'total'     =>$plaintiffTotal,
                                    'comodin'   =>$plaintiffComodin, 
                                    'minus' => $plaintiffTotal-$defendantTotal],
                                   ['signature' =>$defendant,  
                                    'total'     =>$defendantTotal,
                                    'comodin'   =>$defendantComodin,
                                    'minus'=> $defendantTotal-$plaintiffTotal]
                                ];
                $msg = 'The signature: '.$value .' have a '.$responseResult['total']. 'points. </br> ';
                array_push($result['msg'],$msg) ;
            }
        }
        
        //Control comodin
        if (empty($result['error'])) {
        $msg = $this->controlComodin($arrayResumen/*$arrayComodin,$arrayTotal,$arraySignatures*/);
            array_push($result['msg'],$msg);
        }

        return $this->render('judgment/index.html.twig', [
            'controller_name' => 'JudgmentController',
            'result' => $result,
            'total'=> $total,
            'error'=> $result['error']
        ]);
    }

    public function controlComodin($arrayResumen/*$arrayComodin,$arrayTotal,$arraySignatures*/) 
    {
        $msg = null;
        $necesaryToWin = 0;
        $minus = 0;

        for ($i=0; $i <count($arrayResumen) ; $i++) { 
            if ($arrayResumen[$i]['comodin'] == 1){

                $header = 'The signature '.$arrayResumen[$i]['signature'].' have a comodin and ';

                if ($i == 0 && $arrayResumen[0]['comodin'] == 1 && $arrayResumen[0]['total'] < $arrayResumen[1]['total']) {
                    $minus = $arrayResumen[1]['total'] - $arrayResumen[0]['total'];           
                }
                if ($i == 1 && $arrayResumen[1]['comodin'] == 1 && $arrayResumen[1]['total'] < $arrayResumen[0]['total']) {
                        $minus = $arrayResumen[0]['total'] - $arrayResumen[1]['total'];           
                }

                if ($minus < 5 && $minus >= -5) {
                    $minus+=+1;
                    $necesaryToWin =  $this->controlSignatures->comodinSignature($minus);  
                    $msg= $msg .$header.' need '. $necesaryToWin['point'] . ' points ('.$necesaryToWin['abbreviation'].'). </br> ';
                } else {
                    $msg= $msg . $header.' dont can add more signature to win. </br> ';
                }
            }        
        }
        
        return $msg;
    }
}
