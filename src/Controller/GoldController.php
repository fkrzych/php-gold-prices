<?php

namespace App\Controller;

use App\Service\GoldServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoldController extends AbstractController
{
    private HttpClientInterface $client;

    private GoldServiceInterface $goldService;

    public function __construct(HttpClientInterface $client, GoldServiceInterface $goldService)
    {
        $this->client = $client;
        $this->goldService = $goldService;
    }

    #[Route('/api/request', name: 'app_post')]
    public function post(): Response {
        $url = 'http://localhost/main/public/api/gold/';

        $curl = curl_init($url);

        $data = array(
            'from' => '2001-01-04 00:00:00',
            'to' => '2001-01-04 00:00:00'
        );

        $encoded = json_encode(array($data));

        curl_setopt($curl, CURLOPT_POSTFIELDS, $encoded);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);

        curl_close($curl);

        return new Response($result);
    }

    #[Route('/api/gold/', name: 'app_gold', methods: [ 'POST' ])]
    public function index(): JsonResponse
    {
        $content = trim(file_get_contents("php://input"));

        $decoded = json_decode($content, true);

        $startDate = implode($this->goldService->getColumn($decoded, 'from'));
        $endDate = implode($this->goldService->getColumn($decoded, 'to'));

        $startTimezone = $this->goldService->getTimezone($startDate);
        $endTimezone = $this->goldService->getTimezone($endDate);

        $startDateNoTimezone = $this->goldService->getDateNoTimezone($startDate);
        $endDateNoTimezone = $this->goldService->getDateNoTimezone($endDate);

        $request = $this->client->request(
            'GET',
            'https://api.nbp.pl/api/cenyzlota/'.$startDateNoTimezone.'/'.$endDateNoTimezone.'?format=json',
        );

        $response = $this->goldService->getResponse($request);

        $dates = $this->goldService->getColumn($response, 'data');

        $avg = $this->goldService->getAvg($response, 'cena');

        return $this->json([
            'from' => $dates[0].$startTimezone,
            'to' => $dates[count($dates) - 1].$endTimezone,
            'avg' => $avg
        ]);
    }
}
