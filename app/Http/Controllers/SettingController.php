<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsUpdateRequest;
use App\Http\Requests\SmtpSettings;
use App\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class SettingController extends Controller
{
    public function index()
    {
        $auth = Auth::user();

        $service = Service::first();

        return view('settings.index', compact('auth', 'service'));
    }

    public function update(SettingsUpdateRequest $request)
    {
        $auth = Auth::user();

        $auth->name = $request->name;
        $auth->email = $request->email;
        $auth->save();

        return back();
    }

    public function sending()
    {
        $service = Service::first();
        return view('settings.sending', compact('service'));
    }

    public function aws()
    {
        return view('settings.aws');
    }

    public function smtp()
    {
        return view('settings.smtp');
    }

    public function saveSmtp(SmtpSettings $request)
    {
        $service = new Service();
        $service->service = 'smtp';
        $service->credentials = [ 
            'host' => $request->host, 
            'port' => $request->port, 
            'username' => $request->username,
            'password' => $request->password,
            'encription' => $request->encription
            ];
        $service->save();

        return redirect()->route('settings.index');
    }
}
