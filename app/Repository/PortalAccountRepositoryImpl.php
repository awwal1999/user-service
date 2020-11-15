<?php


namespace App\Repository;


use App\Common\BaseRepository;
use App\Model\Enums\GenericStatusConstant;
use App\Model\PortalAccount;
use App\Model\PortalAccountType;
use App\RepositoryContracts\PortalAccountRepository;
use Illuminate\Database\Eloquent\Model;

class PortalAccountRepositoryImpl extends BaseRepository implements PortalAccountRepository
{
    public function __construct(PortalAccount $portalAccount)
    {
        $this->model = $portalAccount;
    }


    /**
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findByName(string $name): ?Model
    {
        return $this
            ->where('status', GenericStatusConstant::ACTIVE)
            ->where('name', $name)
            ->first();
    }


    /**
     * @param string $accountName
     * @param PortalAccountType $portalAccountType
     * @return PortalAccount
     */
    public function save(string $accountName, PortalAccountType $portalAccountType): PortalAccount
    {
        $portalAccount = new PortalAccount();
        $portalAccount->code = 'null';
        $portalAccount->name = $accountName;
        $portalAccount->type_id = $portalAccountType->id;
        $portalAccount->save();
        return $portalAccount;
    }


}
