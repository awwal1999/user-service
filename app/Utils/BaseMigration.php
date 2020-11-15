<?php


namespace App\Utils;


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class BaseMigration extends Migration
{


    protected function status(Blueprint $table)
    {
        $table->enum('status', [
            'ACTIVE',
            'IN_ACTIVE',
            'PENDING'
        ])->default('ACTIVE');
    }

    protected function createSequenceTable(array $sequenceTableNames)
    {
        foreach ($sequenceTableNames as $sequenceTableName) {
            DB::statement('DO $$ BEGIN CREATE SEQUENCE ' . trim(strtolower($sequenceTableName)).'_sequence' . ' ; EXCEPTION WHEN duplicate_table THEN END $$ LANGUAGE plpgsql');
        }
    }


}
