<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Goods\UseCases\GetGoodsByCategoryId;
use Exception;

class GoodController extends Controller
{
    private $getGoodsByCategoryId;

    public function __construct(GetGoodsByCategoryId $getGoodsByCategoryId)
    {
        $this->getGoodsByCategoryId = $getGoodsByCategoryId;
    }

    public function getByCategoryId($categoryID)
    {
        try {
            $goods = $this->getGoodsByCategoryId->execute($categoryID);
            return response()->json(['goods' => $goods], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
