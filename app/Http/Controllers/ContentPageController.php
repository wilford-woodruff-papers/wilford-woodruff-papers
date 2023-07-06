<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContentPageRequest;
use App\Http\Requests\UpdateContentPageRequest;
use App\Models\ContentPage;
use Illuminate\Http\Request;

class ContentPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContentPageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ContentPage $contentPage)
    {
        return view('public.content-pages.show', [
            'contentPage' => $contentPage,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContentPage $contentPage)
    {
        abort_unless(auth()->user()->hasAnyRole(['Admin']), 403);

        return view('public.content-pages.edit', [
            'contentPage' => $contentPage,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContentPageRequest $request, ContentPage $contentPage)
    {
        $validated = $request->validated();
        $contentPage->body = $validated['body'];
        $contentPage->save();

        $request->session()->flash('success', 'Page updated successfully!');

        return redirect()->route('content-page.edit', ['contentPage' => $contentPage->slug]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentPage $contentPage)
    {
        //
    }

    /**
     * Store a added image.
     */
    public function upload(Request $request, ContentPage $contentPage)
    {
        abort_unless(auth()->user()->hasAnyRole(['Admin']), 403);

        $count = $request->get('count');
        $base64 = $request->get('hidimg-'.$count);
        $name = $request->get('hidname-'.$count);
        $type = $request->get('hidtype-'.$count);

        $media = $contentPage->addMediaFromBase64($base64)
            ->usingName($name)
            ->usingFileName($name.'.'.$type)
            ->toMediaCollection('content-pages', 'content-pages');

        return "<html><body onload=\"parent.document.getElementById('img-".$count."').setAttribute('src','".$media->getUrl()."');  parent.document.getElementById('img-".$count."').removeAttribute('id') \"></body></html>";
    }
}
