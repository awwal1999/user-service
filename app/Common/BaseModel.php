<?php


namespace App\Common;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class BaseModel extends Model
{
    public function nextLong(string $sequenceName)
    {
        $result = DB::select("select nextval ('" . trim(strtolower($sequenceName)) . "_sequence')");
        $array = json_decode(json_encode($result[0]), true);
        return $array['nextval'];

    }





}
