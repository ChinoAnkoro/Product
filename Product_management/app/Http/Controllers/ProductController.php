<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Maker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 商品リストのクエリを構築
        $productsQuery = Product::query();

        // 商品名での検索
        if ($request->has('search') && $request->input('search') != '') 
        {
            $productsQuery->where('product_name', 'like', '%' . $request->input('search') . '%');
        }

        // メーカーでの検索
        if ($request->has('maker_id') && $request->input('maker_id') != '')
        {
            $productsQuery->where('maker_id', $request->input('maker_id'));
        }

        // 商品リストを取得
        $products = $productsQuery->with('maker') // `maker` リレーションを使う
            ->orderBy('id', 'DESC')
            ->paginate(5);

        // メーカーのリストを取得
        $makers = Maker::all();

        // 認証ユーザーの名前とページIDを設定
        $user_name = Auth::check() ? Auth::user()->name : null;
        $page_id = $request->input('page', 1); // ページIDがない場合はデフォルトで1
        $i = ($page_id - 1) * 5;

        return view('products.index', [
            'products' => $products,
            'user_name' => $user_name,
            'page_id' => $page_id,
            'i' => $i,
            'makers' => $makers,
        ]);
    }

    /**
     * Show the form for creating a new resource
     */
    public function create()
    {
        $makers = Maker::all();
        return view('products.create')->with('makers', $makers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Product $product)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|max:2048',
            'product_name' => 'required|max:20',
            'price' => 'required|integer',
            'maker_id' => 'required|integer',
            'stock' => 'required|integer',
            'detail' => 'required|max:140',
        ]);
    
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $validated['image'] = $imagePath;
            }
    
            $validated['user_id'] = Auth::user()->id;
            Product::create($validated);
    
            DB::commit();
            return redirect()->route('products.index')
                ->with('success', '商品を登録しました');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('商品登録エラー: ' . $e->getMessage());
    
            return back()->withErrors('商品登録中にエラーが発生しました。');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'))
        ->with('page_id', request()->page_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $makers = Maker::all();
        return view('products.edit', compact('product', 'makers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'image' => 'image|max:2048',
            'product_name' => 'required|max:20',
            'price' => 'required|integer',
            'maker_id' => 'required|integer',
            'stock' => 'required|integer',
            'detail' => 'required|max:140',
            ]);

            // フィールドの更新
        if ($request->hasFile('image'))
        {
            $product->image = $request->file('image')->store('images', 'public');
        }
        $product->product_name = $request->input('product_name');
        $product->price = $request->input('price');
        $product->maker_id = $request->input('maker_id');
        $product->stock = $request->input('stock');
        $product->detail = $request->input('detail');
        $product->user_id = Auth::user()->id;
        $product->save();

        return redirect()->route('products.edit', $product->id)
                     ->with('success', '商品が更新されました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
        ->with('success', '商品'.$product->product_name.'を削除しました');
    }
}
