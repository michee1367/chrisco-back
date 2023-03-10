<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\CityRepository;
use App\Repository\ProvinceRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CityStateProvider implements ProviderInterface
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
     * 
     */
    public function __construct(
        RequestStack $requestStack, 
        CityRepository $cityRepository,
        ProvinceRepository $provinceRepository
    ) {
        $this->requestStack = $requestStack;
        $this->cityRepository = $cityRepository;
        $this->provinceRepository = $provinceRepository;
    }
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // Retrieve the state from somewhere
        $request = $this->requestStack->getCurrentRequest();

        $query = $request->query;

        $data = [];

        try {
            if ($query->has("province")) {

                $province = $this->provinceRepository->find($query->get("province"));
                $data = $this->cityRepository->findByProvince($province);

            }else {

                $data = $this->cityRepository->findAll();
                
            }
            
        } catch (\Throwable $th) {
            $data = $this->cityRepository->findAll();
        }


        return $data;
    }
}
