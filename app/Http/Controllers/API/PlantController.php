<?php

namespace App\Http\Controllers\API;

use App\Models\Plant;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class PlantController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $name = $request->input('name');
        $types = $request->input('types');

        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        $rate_from = $request->input('rate_from');
        $rate_to = $request->input('rate_to');

        if($id)
        {
            $plant = Plant::find($id);

            if($plant)
                return ResponseFormatter::success(
                    $plant,
                    'Data produk berhasil diambil'
                );
            else
                return ResponseFormatter::error(
                    null,
                    'Data produk tidak ada',
                    404
                );
        }

        $plant = Plant::query();

        if($name)
            $plant->where('name', 'like', '%' . $name . '%');

        if($types)
            $plant->where('types', 'like', '%' . $types . '%');

        if($price_from)
            $plant->where('price', '>=', $price_from);

        if($price_to)
            $plant->where('price', '<=', $price_to);

        if($rate_from)
            $plant->where('rate', '>=', $rate_from);

        if($rate_to)
            $plant->where('rate', '<=', $rate_to);

        return ResponseFormatter::success(
            $plant->paginate($limit),
            'Data list produk berhasil diambil'
        );
    }
}
