<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Website::latest()
            ->paginate(10);

        return view('dashboard.websites.index', [
            'results' => $results
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.websites.create');
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
            'title' => 'required',
            'url' => 'required',
            'logo' => 'required'
        ]);

        $website = new Website;
        $website->title = $request->input('title');
        $website->url = $request->input('url');
        $website->logo = $this->uploadFile('logo', public_path('uploads/'), $request)["filename"];
        $website->save();

        return redirect()->route('websites.index');
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
    public function edit(Website $website)
    {
        return view('dashboard.websites.edit', [
            'result' => $website
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Website $website)
    {
        $this->validate($request, [
            'title' => 'required',
            'url' => 'required'
        ]);

        $website->title = $request->input('title');
        $website->url = $request->input('url');
        if ($request->file('logo') != null) {
            $website->logo = $this->uploadFile('logo', public_path('uploads/'), $request)["filename"];
        }
        $website->save();

        return redirect()->route('websites.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Website $website)
    {
        $website->delete();

        return redirect()->route('websites.index');
    }
}
