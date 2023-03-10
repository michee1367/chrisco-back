<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\CityRepository;
use App\Repository\ParishRepository;
use App\Repository\PresbyteryRepository;
use App\Repository\ProvinceRepository;
use App\Repository\TerritoryRepository;
use App\Repository\TownRepository as TownRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class MemberStateProvider implements ProviderInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var ParishRepository
     */
    private $parishRepository;
    /**
     * @var TownRepository
     */
    private $townRepository;
    /**
     * @var TerritoryRepository
     */
    private $territoryRepository;
    /**
     * @var CityRepository
     */
    private $cityRepository;
    /**
     * @var ProvinceRepository
     */
    private $provinceRepository;
    /**
     * @var PresbyteryRepository
     */
    private $presbyteryRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * 
     */
    public function __construct(
        RequestStack $requestStack,
        ParishRepository $parishRepository,
        TownRepository $townRepository,
        TerritoryRepository $territoryRepository,
        CityRepository $cityRepository,
        PresbyteryRepository $presbyteryRepository,
        UserRepository $userRepository,
        ProvinceRepository $provinceRepository
    ) {
        
        $this->requestStack = $requestStack;
        $this->parishRepository = $parishRepository;
        $this->townRepository = $townRepository;
        $this->territoryRepository = $territoryRepository;
        $this->cityRepository = $cityRepository;
        $this->provinceRepository = $provinceRepository;
        $this->presbyteryRepository = $presbyteryRepository;
        $this->userRepository = $userRepository;
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
            if ($query->has("parish")) 
            {
                $parish = $this->parishRepository->find($query->get("parish"));
                $data = $this->userRepository->findByParish($parish);
            }
            elseif ($query->has("town")) 
            {
                $town = $this->townRepository->find($query->get("town"));
                $data = $this->userRepository->findByTown($town);
            }
            elseif ($query->has("city"))
            {
                $city = $this->cityRepository->find($query->get("city"));
                $data = $this->userRepository->findByCity($city);
            }
            elseif ($query->has("territory")) 
            {
                $territory = $this->territoryRepository->find($query->get("territory"));
                $data = $this->userRepository->findByTerritory($territory);
            }
            elseif ($query->has("presbytery")) 
            {
                $presbytery = $this->presbyteryRepository->find($query->get("presbytery"));
                $data = $this->userRepository->findByPresbytery($presbytery);
            }
            else if ($query->has("province")) 
            {
                $province = $this->provinceRepository->find($query->get("province"));
                $data = $this->userRepository->findByProvince($province);
            }else
            {
                $data = $this->userRepository->findAll();
            }
            
        } catch (\Throwable $th) {
            $data = $this->cityRepository->findAll();
        }

        return $data;
    }
}
