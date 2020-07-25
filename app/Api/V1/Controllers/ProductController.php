<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use DB;
use Storage;
//Load Model
use App\User;
use App\Product;
use App\Shipper;
use App\ShippDays;
use App\Live;
use App\ProductUserLike;
use App\ProductRanking;
use App\ProductHasTag;
use App\ProductPortfolio;
use App\Tag;
//Config
use Config;
use App\Traits\LoadList;
class ProductController extends Controller
{
    //'user_id' => auth()->user()->id
    /**
     * Product List with thumbnail
     * which staged to live
     *
     */
    use LoadList;
    public function index(Request $request)
    {
        $options = [];
        $options['type'] = $request->type;
        $options['status'] = [];
        $options['status'][0] = Config::get('constants.pStatus.staged');
        $options['status'][1] = Config::get('constants.pStatus.restaged');
        $options['status'][2] = Config::get('constants.pStatus.sold');
        return response()->json($this->loadProducts($options));
    }
    public function getAdminList($type)
    {
        $options['status'] = [];
        if($type == 0)
        {
            $options['status'][0] = Config::get('constants.pStatus.registered');
            $options['status'][1] = Config::get('constants.pStatus.draft');
            $options['status'][2] = Config::get('constants.pStatus.added');
            $options['status'][3] = Config::get('constants.pStatus.staged');
            $options['status'][4] = Config::get('constants.pStatus.restaged');
            $options['status'][5] = Config::get('constants.pStatus.sold');
        }
        if($type == 1)
        {
            $options['status'][0] = Config::get('constants.pStatus.staged');
            $options['status'][1] = Config::get('constants.pStatus.restaged');
        }
        if($type == 2)
        {
            $options['status'][0] = Config::get('constants.pStatus.draft');
        }
        return response()->json($this->loadProducts($options));
    }
    public function edit($id)
    {
        $shippers = Shipper::select([DB::raw("id as value"),DB::raw("name as label")])->get();
        $shippDays = ShippDays::select([DB::raw("id as value"),DB::raw("day as label")])->get();
        $response = [
            'suggestTags' => [],
            'shipDays' => $shippDays,
            'shippers' => $shippers
        ];
        //get SuggestTags;
        $productTags = ProductHasTag::select('tag_id')->get()->toArray();
        $suggestTagIDs = [];
        foreach($productTags as $tag)
        {
            $suggestTagIDs[] = $tag['tag_id'];
        }
        foreach(Tag::select(['label'])->whereIn('id',$suggestTagIDs)->get() as $tag)
        {
            $response['suggestTags'][] = $tag->label;
        }
        $response['portfolios'] = [null,null,null,null,null,null,null,null,];
        $product = Product::find($id);
        if($product != null)
        {
            $response['id'] = $product->id;
            $response['label'] = $product->label;
            $response['number'] = $product->number;
            $response['description'] = $product->description;
            $response['qty'] = $product->qty;
            $response['price'] = $product->price;
            $response['shipper'] = $product->shipper_id;
            $response['shipDay'] = $product->ship_days;
            $response['dFee'] = $product->shipping_fee;
            //portfolios
            foreach($product->rPortfolio()->orderby('order')->get() as $key => $portfolio)
            {
                $response['portfolios'][$key] = asset(Storage::url('ProductPortfolio')).'/'.$product->id.'/'.$portfolio->filename;
            }
            //get product tags
            $response['tags'] = [];
            foreach($product->rTag as $tag)
            {
                $response['tags'][] = $tag->rTag->label;
            }
        }
        else
        {
            $response['id'] = -1;
            $response['label'] = '';
            $response['number'] = '';
            $response['description'] = '';
            $response['qty'] = 0;
            $response['price'] = 0;
            $response['shipper'] = 1;
            $response['shipDay'] = 1;
            $response['dFee'] = 0;
            //get product tags
            $response['tags'] = [];
        }
        return response()->json($response);
    }
    public function show($id){
        $product = Product::find($id);
        $response = ['product' => null];
        if($product != null){
            $response = [];
            $response['id'] = $product->id;
            $response['label'] = $product->label;
            $response['number'] = $product->number;
            $response['description'] = $product->description;
            $response['price'] = $product->totalPrice;
            $response['nLikes'] = $product->rUserLike()->count();
            $response['isLike'] = $product->IsLike;
            //Delivery Name
            $response['shipper'] = $product->rShipper != null?$product->rShipper->name:'';
            $response['ship_days'] = $product->ship_days;
            //relatied store
            $response = array_merge($response,$product->StoreInfo);

            //Related Lives
            $response['lives'] = [];
            $lives = $product->rLive;
            foreach($lives as $liveId)
            {
                $live = Live::find($liveId->live_id);
                $response['lives'][] = $this->liveToArray($live);
            }
            //portfolios
            $response['portfolios'] = [];
            foreach($product->rPortfolio()->orderby('order')->get() as $portfolio)
            {
                $response['portfolios'][] = asset(Storage::url('ProductPortfolio')).'/'.$product->id.'/'.$portfolio->filename;
            }
        }
        return response()->json(['product' => $response]);
    }

    public function addLikeProduct(Request $request){

        $product = Product::find($request->product_id);

        $bUserLike = $product->rUserLike()->where('user_id' , auth()->user()->id)->first();
        if($bUserLike == null)
        {
            $product->rUserLike()->saveMany([
                new ProductUserLike(['user_id' => auth()->user()->id])
            ]);
            return response()->json(['like' => 1]);
        }
        else{
            $bUserLike->delete();
            return response()->json(['like' => 0]);
        }
    }

    public function rankings()
    {
        $rankings = ProductRanking::orderBy('order')->get();
        $response = [];
        foreach($rankings as $ranking)
        {
            $response[] = $this->proucttoArray($ranking->rProduct);
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $formData = $request->formData;
        $status_id = Config::get('constants.pStatus.registered');

        if(Product::find($formData['id']) == null)
        {
            $product = new Product;
        }
        else
        {
            $product = Product::find($formData['id']);
            $status_id = $product->status_id;
        }
        if($formData['mode'] == 2)
        {
            $status_id = Config::get('constants.pStatus.draft');
        }

            $product->label = $formData['label'];
            $product->store_id = auth()->user()->rStore->id;
            $product->number = $formData['number'];
            $product->description = $formData['description'];
            $product->qty = $formData['qty'];
            $product->price = $formData['price'];
            $product->ship_days = $formData['shipDay'];
            $product->shipper_id = $formData['shipper'];
            $product->shipping_fee = $formData['dFee'];
            $product->status_id = $status_id;
            $product->save();
            //save portfolio
            //store explaintion
            $product->rPortfolio()->delete();
            //Storage::disk('store_explantion')->delete(Storage::disk('store_explantion')->allFiles($store_id));
            $insertData = [];
            $cnt = 0;
            foreach($formData['portfolios'] as $portfolio)
            {
                if($portfolio != null)
                {
                    $file_name = $cnt.'.png';
                    //if updated image
                    if(strlen($portfolio) > 100)
                    {
                        $image =  base64_decode($portfolio);
                        $filename = $product->id.'/'.$file_name;
                        Storage::disk('product_portfolio')->put($filename, $image );
                    }
                    $insertData[] = new ProductPortfolio(['filename' => $file_name,'order' => $cnt]);
                    $cnt ++;
                }
            }
            $product->rPortfolio()->saveMany($insertData);
            //save tags
            $product->rTag()->delete();
            $insertData = [];
            $cnt = 0;
            foreach($formData['tags'] as $tag)
            {
                $newTag = Tag::where('label',$tag)->first();
                if($newTag == null)
                {
                    $newTag = new Tag;
                    $newTag->label = $tag;
                    $newTag->save();
                }
                $insertData[] = new ProductHasTag(['tag_id' => $newTag->id]);
            }
            $product->rTag()->saveMany($insertData);
            return response()->json(['success' => 1]);
    }

    public function update(Request $request,$id)
    {

    }

    public function delete(Request $request)
    {
        $products = Product::whereIn('id',$request->IDs)->get();
        $deletedIDs = [];
        foreach($products as $product)
        {
            // $product->rPortfolio()->delete();
            // $product->rTag()->delete();
            // $product->delete();
            $product->status_id = 3;
            $product->save();
            $deletedIDs[] = $product->id;
        }
        return response()->json(['result' => 1,'IDs' => $deletedIDs]);
    }
}
