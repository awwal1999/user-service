<?php

use App\Model\Permission;
use App\Model\PortalAccount;
use App\Model\PortalAccountType;
use App\Model\Role;
use App\Model\User;
use App\Utils\BaseMigration;


class CreateSequenceTable extends BaseMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createSequenceTable([
            PortalAccount::PORTAL_ACCOUNT_CODE_SEQUENCE,
            Role::ROLE_CODE_SEQUENCE,
            User::USER_IDENTIFIER_SEQUENCE,
            PortalAccountType::PORTAL_ACCOUNT_TYPE_CODE_SEQUENCE,
            Permission::PERMISSION_CODE_SEQUENCE
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
