<?php


namespace App\Command;


use App\Entity\Societe;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;


/**
 * @property EntityManagerInterface entityManager
 */
class GetSocieteBySiretCommand extends Command
{



    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected static $defaultName = 'app:get-society';

    protected function configure()
    {
        $this->setDescription('Récupérer les infos d\'une societe en rentrant son n°siret')
            ->addArgument('siret', InputArgument::REQUIRED, 'n°siret');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$output instanceof ConsoleOutputInterface) {
            throw new \LogicException('This command accepts only an instance of "ConsoleOutputInterface".');
        }
        $httpClient = HttpClient::create ([
            // HTTP Bearer authentication (also called token authentication)
            'auth_bearer' => '4c957839-cccc-3d3a-8cca-094fac29503f',
        ]);

        $response = $httpClient->request('GET', 'https://api.insee.fr/entreprises/sirene/V3/siret/'.$input->getArgument("siret"), [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $siret = $input->getArgument('siret');

        $array = $response->toArray();

        $nom            = $array['etablissement']['uniteLegale']['denominationUniteLegale'];
        $siren          = $array['etablissement']['siren'];
        $nic            = $array['etablissement']['nic'] ;
        $dateCreation   = $array['etablissement']['dateCreationEtablissement'] ;
        $anneeEffectif  = $array['etablissement']['anneeEffectifsEtablissement'];


        $output->writeln("Nom de la société : "         .$nom           );
        $output->writeln("Siren : "                     .$siren         );
        $output->writeln("Nic :"                        .$nic           );
        $output->writeln("Date creation de la société :".$dateCreation  );
        $output->writeln("Annee effectif :"             .$anneeEffectif );

        $society = new Societe();

        $society->setSiret($siret);
        $society->setNom($nom);

        $society->setSiren($siren);
        $society->setDateCreationEtablissement($dateCreation);
        $society->setAnneeEffectifEtablissement($anneeEffectif);

        $this->entityManager->persist($society);
        $this->entityManager->flush();

        $output->writeln("La société a été enregistrée en BDD");


        return Command::SUCCESS;

    }



}