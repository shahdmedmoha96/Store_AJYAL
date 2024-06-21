<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories = Category::with('parent')
            // leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            // ->select([
            //     'categories.*',
            //     'parents.name as parent_name'
            // ])
            // ->select('SELECT products.* FROM products JOIN categories ON products.category_id = categories.id;')
            ->withCount('products as products_count')
            ->orderBy('categories.name') // latest => for order tables
            ->Fillter([request('status'), request('name')])
            ->paginate(5);


        // foreach($categories as $category){
        //     $products_count = ($category->with('products'))->count();
        //     $category->merge([
        //         'products_count'=>$products_count,
        //     ]);
        // }
        // $products_count = Category::with('products')->count();

        // dd($products_count->count());
        // dd($products_count);


        return view('dashboard.categories.index', compact('categories'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate((Category::rules()));
        // slug => remove spacial char and space
        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }
        //  dd($data['image']);
        Category::create($data);
        return redirect()->route('categories.index')->with('success', 'Category Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        //select * where id !=$id
        //no get current category
        $parents = Category::where('id', '<>', $id)
            ->Where(function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orwhere('parent_id', '<>', $id);
            })
            ->get();
        return view('dashboard.categories.edit', ['parents' => $parents, 'category' => $category]);
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
        $category = Category::find($id);
        $category->slug = Str::slug($request->post('name'));

        $old_image = $category->image;
        $request->validate(Category::rules($id));
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
            if ($old_image != $data['image']) {
                Storage::disk('public')->delete($old_image);
            }
        }

        $category->update($data);
        return redirect()->route('categories.index')->with('info', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();
        return redirect()->route('categories.index')->with('danger', 'Category Deleted');
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate(5);  // only categories was deleted
        return view('dashboard.categories.trash', compact('categories'));
    }
    public function restore(Request $request, $id)
    {

        $category = Category::onlyTrashed()->findOrFail($id);  // get the deleted category
        $category->restore();
        return redirect()->route('categories.trash')->with('success', 'Category Restored');
    }
    public function forceDelete($id)
    {

        $category = Category::onlyTrashed()->findOrFail($id);  // get the deleted category
        $category->forceDelete();
        $path_image = $category->image;
        //    dd($path_image);
        if ($path_image) {
            Storage::disk('public')->delete($path_image);
        }

        return redirect()->route('categories.trash')->with('danger', 'Category deleted');
    }
}
