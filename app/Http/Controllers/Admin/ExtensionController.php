<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Ext\InstallController;
use App\Http\Controllers\Controller;
use App\Models\Extension;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class ExtensionController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('extensions_manager_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = 'Extension';
        $extensions = Extension::orderByDesc('status')->get();
        $api = new InstallController;
        return view('admin.extension.index', compact('page_title', 'extensions', 'api'));
    }

    public function update(Request $request, $id)
    {
        $extension = Extension::findOrFail($id);

        foreach ($extension->shortcode as $key => $val) {
            $validation_rule = [$key => 'required'];
        }
        $request->validate($validation_rule);

        $shortcode = json_decode(json_encode($extension->shortcode), true);
        foreach ($shortcode as $key => $code) {
            $shortcode[$key]['value'] = $request->$key;
        }

        $extension->shortcode = $shortcode;
        $extension->save();
        $notify[] = ['success', $extension->name . ' has been updated'];
        return redirect()->route('admin.extensions.index')->withNotify($notify);
    }

    public function activate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $extension = Extension::findOrFail($request->id);
        if ($extension->installed == 1) {
            $extension->status = 1;
            $extension->save();
            $notify[] = ['success', $extension->name . ' has been activated'];
        }
        return redirect()->route('admin.extensions.index')->withNotify($notify);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $extension = Extension::findOrFail($request->id);
        if ($extension->installed == 1) {
            $extension->status = 0;
            $extension->save();
            $notify[] = ['success', $extension->name . ' has been disabled'];
        }
        return redirect()->route('admin.extensions.index')->withNotify($notify);
    }
}