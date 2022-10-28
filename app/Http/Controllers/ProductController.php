<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('product.index');

        $products = Product::latest()->paginate(5);
        return view('product.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('product.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(
            [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required|integer',
                'category' => 'required',
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg'
            ],
            [
                'name.required' => '商品名を入力してください。',
                'description.required' => '詳細を入力してください。',
                'price.required' => '値段を入力してください。',
                'category.required' => 'カテゴリーを入力してください。',
                'image.required' => '画像を選択してください。'
            ]
        );

        // フォームからアップされた画像を変数に代入
        $image = $request->file('image');
        // アップロードした日時と画像の拡張子をつけてユニークな画像名にします。
        $name = time().'.'.$image->getClientOriginalExtension();
        //  C:\xampp\htdocs\restaurant_menu\public にimagesという名前でフォルダを作っておきます。そして、そこに画像を保存するようにします。
        $destinationPath = public_path('/images');
        $image->move($destinationPath,$name);

        Product::create([
            'name'=>request('name'),
            'description'=>request('description'),
            'price'=>request('price'),
            'category_id'=>request('category'),
            'image'=>$name
        ]);

        return redirect()->back()->with('message', '商品情報が追加されました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
