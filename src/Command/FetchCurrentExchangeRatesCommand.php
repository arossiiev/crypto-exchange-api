<?php

namespace App\Command;

use App\Entity\ExchangeRate;
use App\Repository\AssetPairRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FetchCurrentExchangeRatesCommand extends Command
{

    protected static $defaultName = 'app:fetch';
    private $entityManager;
    private $assetPairRepository;
    private $client;


    public function __construct(
        EntityManagerInterface $entityManager,
        AssetPairRepository $assetPairRepository,
        HttpClientInterface $client,
        string $apiKey,
        string $apiUrl
    )
    {
        $this->entityManager = $entityManager;
        $this->assetPairRepository = $assetPairRepository;
        $this->client = $client->withOptions([
            'base_uri' => $apiUrl,
            'headers' => ['X-CoinAPI-Key' => $apiKey ]
        ]);


        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Fetches current exchange rates of asset pairs in asset_pair table');
    }




    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write("In command!");
        $assetPairs = $this->assetPairRepository->findAll();

        foreach ($assetPairs as $assetPair){
            $base = $assetPair->getBase();
            $quote = $assetPair->getQuote();

            try {

                $response = $this->client->request(
                    'GET',
                    "v1/exchangerate/$base/$quote"

                );


                if($response->getStatusCode() == 200){

                    $data = $response->toArray();
                    $newExchangeRate = new ExchangeRate();
                    $newExchangeRate->setAssetPair($assetPair);

                    $time = new DateTime($data["time"]);
                    $newExchangeRate->setTime($time);
                    $newExchangeRate->setRate($data["rate"]);
                    $this->entityManager->persist($newExchangeRate);

                }

            } catch (TransportExceptionInterface $e) {
                $output->write("Fail!!");
                continue;
            }
        }

        $this->entityManager->flush();
        $output->write("Success!!");
        return Command::SUCCESS;
    }

}

