<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\CityRepository;
use App\Repository\ProvinceRepository;
use App\Repository\TownRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class TownStateProvider implements ProviderInterface
{

    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var CityRepository
     */
    private $cityRepository;
    /**
     * @var ProvinceRepository
     */
    private $provinceRepository;
    /**
     * @var TownRepository
     */
    private $townRepository;

    /**
     * 
     */
    public function __construct(
        RequestStack $requestStack,
        CityRepository $cityRepository,
        ProvinceRepository $provinceRepository,
        TownRepository $townRepository
    ) {
        $this->requestStack = $requestStack;
        $this->cityRepository = $cityRepository;
        $this->provinceRepository = $provinceRepository;
        $this->townRepository = $townRepository;
    }
    /**
     * 
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // Retrieve the state from somewhere
        $request = $this->requestStack->getCurrentRequest();

        $query = $request->query;

        $data = [];
        
        try {
            if ($query->has("city")) 
            {
                $city = $this->cityRepository->find($query->get("city"));
                //dd($city);
                $data = $this->townRepository->findByCity($city);

                //dd($data);
            }
            else if ($query->has("province")) 
            {
                $province = $this->provinceRepository->find($query->get("province"));
                $data = $this->townRepository->findByProvince($province);
            }else
            {
                $data = $this->townRepository->findAll();
            }
            
        } catch (\Throwable $th) {
            $data = $this->cityRepository->findAll();
        }

        return $data;
    }
}
