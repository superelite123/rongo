<?php
namespace App\Helper;
use App\ProductRanking;
use App\ProductLike;
use App\ProductClick;
use DB;
trait CommonFunction{
    public function searchArray($attr,$val,$array)
    {
        foreach($array as $key  => $item)
        {
            if($item[$attr] == $val)
            {
                return $key;
            }
        }
        return -1;
    }

    public function runProductRanking()
    {
        $likes = DB::table('product_user_like')
                    ->select('product_id', DB::raw('count(product_id) as cnt'))
                    ->groupBy('product_id')
                    ->get();
        $clicks = DB::table('product_user_click')
                    ->select('product_id', DB::raw('count(product_id) as cnt'))
                    ->groupBy('product_id')
                    ->get();
        $result = [];
        foreach($likes as $like)
        {
            $click = $clicks->firstWhere('product_id',$like->product_id);
            $item = [];
            if($click == null)
            {
                $item['product_id'] = $like->product_id;
                $item['score'] = $like->cnt * 1;
                $result[] = $item;
            }
            else
            {
                $item['product_id'] = $like->product_id;
                $item['score'] = $like->cnt * 1 + $click->cnt * 0.2;
                $result[] = $item;
                //remove click
                foreach($clicks as $key => $item)
                {
                    if($item->product_id == $click->product_id)
                    {
                        $clicks->forget($key);
                    }
                }
            }
        }
        foreach($clicks as $click)
        {
            $item = [];
            $item['product_id'] = $click->product_id;
            $item['score'] = $click->cnt * 0.2;
            $result[] = $item;
        }
        for($i = 0; $i < count($result) - 1; $i ++)
        {
            for($j = $i + 1; $j < count($result); $j ++)
            {
                if($result[$i]['score'] < $result[$j]['score'])
                {
                    $temp = $result[$i]['score'];
                    $result[$i]['score'] = $result[$j]['score'];
                    $result[$j]['score'] = $temp;
                }
            }
        }
        for($i = 0; $i < count($result); $i ++)
        {
            $result[$i]['order'] = $i + 1;
        }

        ProductRanking::truncate();
        ProductRanking::insert($result);
        return $result;
    }

    public function GenerateRandomString($length = 7)
    {
        $alphas = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $result = '';
        for($i = 0; $i < $length; $i ++)
        {
            $result .= $alphas[mt_rand(0,61)];
        }

        return $result;
    }

}
