<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Website;
use App\Models\Category;
use App\Models\ItemSchema;
use Illuminate\Http\Request;
use App\Lib\Scraper;
use Goutte\Client;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Link::latest()
            ->paginate(10);
        $item_schemas = ItemSchema::all();

        return view('dashboard.links.index', [
            'results' => $results,
            'item_schemas' => $item_schemas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $websites = Website::all();

        return view('dashboard.links.create', [
            'categories' => $categories,
            'websites' => $websites
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => 'required',
            'main_filter_selector' => 'required',
            'website_id' => 'required',
            'category_id' => 'required'
        ]);

        $link = new Link;
        $link->url = $request->input('url');
        $link->main_filter_selector = $request->input('main_filter_selector');
        $link->website_id = $request->input('website_id');
        $link->category_id = $request->input('category_id');
        $link->save();

        return redirect()->route('links.index');
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
    public function edit(Link $link)
    {
        $categories = Category::all();
        $websites = Website::all();

        return view('dashboard.links.edit', [
            'result' => $link,
            'categories' => $categories,
            'websites' => $websites
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Link $link)
    {
        $this->validate($request, [
            'url' => 'required',
            'main_filter_selector' => 'required',
            'website_id' => 'required',
            'category_id' => 'required'
        ]);

        $link->url = $request->input('url');
        $link->main_filter_selector = $request->input('main_filter_selector');
        $link->website_id = $request->input('website_id');
        $link->category_id = $request->input('category_id');
        $link->save();

        return redirect()->route('links.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link)
    {
        $link->delete();

        return redirect()->route('links.index');
    }

    /**
     * @param Request $request
     */
    public function setItemSchema(Request $request)
    {
        if (!$request->item_schema_id && !$request->link_id)
            return;
        $link = Link::find($request->link_id);
        $link->item_schema_id = $request->item_schema_id;
        $link->save();
        return response()->json(['msg' => 'Link updated!']);
    }
    /**
     * scrape specific link
     *
     * @param Request $request
     */
    public function scrape(Request $request)
    {
        if (!$request->link_id)
            return;
        $link = Link::find($request->link_id);
        if (empty($link->main_filter_selector) && (empty($link->item_schema_id) || $link->item_schema_id == 0)) {
            return;
        }
        $scraper = new Scraper(new Client());
        $scraper->handle($link);
        if ($scraper->status == 1) {
            return response()->json(['status' => 1, 'msg' => 'Scraping done']);
        } else {
            return response()->json(['status' => 2, 'msg' => $scraper->status]);
        }
    }
}
