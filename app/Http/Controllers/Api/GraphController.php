<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Config;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GraphController extends Controller
{
    public function getGraph(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'host' => 'required',
            'database' => 'required',
            'username' => 'required',
            'password' => 'nullable',
            'query' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            // Extract connection parameters from the request
            $host = $request->input('host');
            $username = $request->input('username');
            $password = $request->input('password');
            $database = $request->input('database');
            $query = $request->input('query');
            config(['database.connections.multi.host' => $host]);
            config(['database.connections.multi.database' => $database]);
            config(['database.connections.multi.username' => $username]);
            config(['database.connections.multi.password' => $password]);
            //change the db connection
            DB::purge('multi');
            DB::reconnect('multi');
            \Artisan::call('config:clear');
            \Artisan::call('config:cache');

            $data = DB::connection('multi')->select($request->input('query'));

            // Extract keys from the first item
            $keys = array_keys((array) $data[0]);

            $newData = [$keys];
            foreach ($data as $item) {
                $values = [];
                foreach ($keys as $key) {
                    $values[] = (float) $item->$key;
                }
                $newData[] = $values;
            }
            return response()->json($newData, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 400);
        }
    }
}
