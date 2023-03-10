<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\TerritoryPresbytery;
use App\Repository\ProvinceRepository;
use App\Repository\TerritoryRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class TerritoryStateProvider implements ProviderInterface
{
    /**
     * @var ProvinceRepository
     */
    private $provinceRepository;
    /**
     * @var TerritoryRepository
     */
    private $territoryRepository;
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * 
     */
    public function __construct(
        RequestStack $requestStack, 
        ProvinceRepository $provinceRepository,
        TerritoryRepository $territoryRepository
    ) 
    {
        $this->requestStack = $requestStack;
        $this->provinceRepository = $provinceRepository;
        $this->territoryRepository = $territoryRepository;
    }
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // Retrieve the state from somewhere
        $request = $this->requestStack->getCurrentRequest();

        $query = $request->query;

        $data = [];
        
        try {
            if ($query->has("province")) 
            {
                $province = $this->provinceRepository->find($query->get("province"));
                $data = $this->territoryRepository->findByProvince($province);
            }else {
                $data = $this->territoryRepository->findAll();
            }
            
        } catch (\Throwable $th) {
            $data = $this->territoryRepository->findAll();
        }

        return $data;
    }
}
