<?php

use App\Utils\BaseMigration;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends BaseMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('username');
            $table->string('middleName')->nullable();
            $table->string('email');
            $table->string('password');
            $table->string('identifier');
            $table->string('phoneNumber')->nullable();
            $table->enum('gender', [
                'MALE',
                'FEMALE'
            ])->nullable();
            $table->string('nin')->nullable();
            $table->string('bvn')->nullable();
            $table->timestamp('dob')->nullable();
            $table->string('mothersMaidenName');
            $this->status($table);
            $table->timestamp('email_verified_at')->nullable();
            //$table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
