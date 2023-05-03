<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ArticalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.articles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'title_ar' => 'required',
            'title_en' => 'required',
            'short_desc_ar' => 'required',
            'short_desc_en' => 'required',
            'full_desc_ar' => 'required',
            'full_desc_en' => 'required',
            'author_name' => 'required',
            'type' => 'required',
            'image' => 'required|file'
        ];

        $this->validate($request, $rules);

        $data = $request->except('image');

        if ($request->image) {
            $filename = rand(111111111, 999999999) . '_' . Carbon::now()->timestamp;
            $filename .= substr($request->image->getClientOriginalName(), strrpos($request->image->getClientOriginalName(), '.'));
            $filename = $request->image->move(public_path('images'), $filename);
            $data['image'] = $filename->getBasename();
        }


        Article::query()->create($data);

        return response()->json(['status' => true]);
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

    public function update(Request $request, $id)
    {
        $article = Article::query()->find($id);

        $rules = [
            'title_ar' => 'required',
            'title_en' => 'required',
            'short_desc_ar' => 'required',
            'short_desc_en' => 'required',
            'full_desc_ar' => 'required',
            'full_desc_en' => 'required',
            'type' => 'required',
            'author_name' => 'required',
            'image' => 'nullable|file'
        ];

        $this->validate($request, $rules);

        $data = $request->except('image');

        if ($request->image) {
            $filename = rand(111111111, 999999999) . '_' . Carbon::now()->timestamp;
            $filename .= substr($request->image->getClientOriginalName(), strrpos($request->image->getClientOriginalName(), '.'));
            $filename = $request->image->move(public_path('images'), $filename);
            $data['image'] = $filename->getBasename();
        }


        $article->update($data);

        return response()->json(['status' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Article::query()->whereIn('id', explode(',', $id))->delete();
        return response()->json(['status' => true]);
    }



    public function indexTable(Request $request)
    {
        // dd('asd');
        $articles = Article::query()->where('type', 1)->orderByDesc('created_at');
        return DataTables::of($articles)->addColumn('type', function ($item) {
            if ($item->type == 1) {
                return  '<span class="badge"> Article </span>';
            } else {
                return  '<span class="badge"> Ad </span>';
            }
        })
        ->addColumn('action', function ($article) {
            $data = '';
            $data .= 'data-title_ar="' . $article->title_ar . '"';
            $data .= 'data-title_en="' . $article->title_en . '"';
            $data .= 'data-short_desc_ar="' . $article->short_desc_ar . '"';
            $data .= 'data-short_desc_en="' . $article->short_desc_en . '"';
            $data .= 'data-full_desc_ar="' . $article->full_desc_ar . '"';
            $data .= 'data-full_desc_en="' . $article->full_desc_en . '"';
            $data .= 'data-author_name="' . $article->author_name . '"';
            $data .= 'data-type="' . $article->type . '"';
            $data .= 'data-image="' . $article->image . '"';
            $data .= 'data-id="' . $article->id . '"';

            $string = '';
            $string .= '<button class="btn btn-warning edit_btn" ' . $data . '  data-bs-target="#editUser" data-bs-toggle="modal">Edit</button>';
            $string .= '<button class="btn btn-danger delete-btn" data-id=' . $article->id . '>Delete</button>';

            return $string;
        })->rawColumns(['type', 'action'])->make(true);
    }
}
