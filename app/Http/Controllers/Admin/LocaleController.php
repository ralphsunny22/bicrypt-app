<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Locale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class LocaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('locale_manager_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = 'Locale Manager';
        $empty_message = 'No Locales Found';
        $locales = Locale::get();
        return view('admin.setting.locale', compact('locales', 'page_title', 'empty_message'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $locale = Locale::where('id', $request->id)->first();

        $jsonString = file_get_contents(resource_path() . '/lang/' . $locale->code . '.json');
        $datas = json_decode($jsonString, true);
        // Update Key
        $datas[$request->string] = $request->translation;
        // Write File
        $newJsonString = json_encode($datas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents(resource_path() . '/lang/' . $locale->code . '.json', stripslashes($newJsonString));

        $notify[] = ['success', 'String added successfully'];
        return back()->withNotify($notify);
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
        abort_if(Gate::denies('locale_manager_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $locale = Locale::where('id', $id)->first();
        $page_title = $locale->title . ' Editor';
        $strings = arrayToObject(json_decode(File::get(resource_path() . '/lang/' . $locale->code . '.json'), true));
        return view('admin.setting.locale_edit', compact('locale', 'page_title', 'strings'));
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
        $locale = Locale::where('id', $id)->first();

        $jsonString = file_get_contents(resource_path() . '/lang/' . $locale->code . '.json');
        $datas = json_decode($jsonString, true);
        // Update Key
        $datas[$request->key] = $request->value;
        // Write File
        $newJsonString = json_encode($datas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents(resource_path() . '/lang/' . $locale->code . '.json', stripslashes($newJsonString));

        return response()->json([
            'type' => 'success',
            'message' => 'Translation updated successfully',
        ]);
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