<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Show the check unique value.
     *
     * @return \Illuminate\Http\Response
     */

    public function checkUnique(Request $request, $table, $columnName)
    {
        //dd($request->all());
        if ($request->ajax()) {


            if (!empty($request->value)) {
                $where = [
                    [$columnName, '=', $request->value],
                ];

                if (!empty($request->id)) {
                    $where[] = ['id', '!=', $request->id];
                }

                $count = \DB::table($table)
                    ->where($where)
                    ->count();

                return $count > 0 ?  'false' : 'true';
            }
        }
    }
}
