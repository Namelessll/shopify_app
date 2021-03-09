<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GPDRController extends Controller
{
    public function RemoveCustomerData(Request $request) {
        return \response()->json([
            'status' => 200,
            'message' => json_encode($request)
        ], Response::HTTP_OK);
    }

    public function RemoveShopRedact() {
        return \response()->json([
            'status' => 200,
            'message' => 'OK'
        ], Response::HTTP_OK);
    }

    public function RemoveCustomerDataRequest() {
        return \response()->json([
            'status' => 200,
            'message' => 'OK'
        ], Response::HTTP_OK);
    }
}
