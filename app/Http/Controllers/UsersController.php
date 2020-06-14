<?php

namespace App\Http\Controllers\API;

# import model & library
use App\Users;
use Illuminate\Http\Request;
namespace App\Http\Controllers;
use Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        # var request
        $key     = $request->get("key");
        $sortBy  = $request->get("sort_by", "created_at");
        $orderBy = $request->get("order_by") == "true" ? "DESC" : "ASC";
        $perPage = (int) $request->get("per_page", 10);

        # get query
        $data = Users::where("name", "like", "%".$key."%")
            ->orderBy($sortBy, $orderBy)
            ->paginate($perPage);

        # send result
        return response()->json(["msg" => "Success", "data" => $data], 200);
    }
}
