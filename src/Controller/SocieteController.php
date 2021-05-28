<?php

namespace App\Controller;

use App\Entity\Societe;
use App\Form\SiretType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;



class SocieteController extends AbstractController
{

    #[Route('/societe', name: 'societe')]
    public function index( HttpClientInterface $httpClient,
                           EntityManagerInterface $entityManager,
                           Request$request): Response
    {
        $httpClient = HttpClient::create ([
            // HTTP Bearer authentication (also called token authentication)
            'auth_bearer' => '4c957839-cccc-3d3a-8cca-094fac29503f',
        ]);

        $society = new Societe();
        $form = $this->createForm(SiretType::class, $society, [
            'action'=>$this->generateUrl('societe'),
            'method'=>'POST',
        ]);

        $form->handleRequest($request);
        $siret = $form->get('siret')->getData();

        if ($form->isSubmitted() && $form->isValid())
        {

            $response = $httpClient->request('GET', 'https://api.insee.fr/entreprises/sirene/V3/siret/'.$siret, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ]);

            dd($response->toArray());

        }

        return $this->render('societe/index.html.twig', [
            'form' => $form->createView(),

        ]);
    }
}
