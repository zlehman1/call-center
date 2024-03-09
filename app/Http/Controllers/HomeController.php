<?php

namespace App\Http\Controllers;

use App\Models\ac_company;
use App\Models\ac_extension;
use App\Models\ac_user;
use App\Models\ac_user_types;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    

    public function index()
    {
        return view('layouts/dashboard');
    }

    public function dashboard(Request $request)
    {
        $variable = $request->query('var');
        view()->share('variable', $variable);
        return view('admin/dashboard')->with('variable', $variable);
    }

    public function leads(Request $request)
    {
        $variable = $request->query('var');
        view()->share('variable', $variable);
        return view('admin/leads')->with('variable', $variable);
    }

    public function orders(Request $request)
    {
        $variable = $request->query('var');
        view()->share('variable', $variable);
        return view('admin/orders')->with('variable', $variable);;
    }

    public function reports(Request $request)
    {
        $variable = $request->query('var');
        view()->share('variable', $variable);
        return view('admin/reports')->with('variable', $variable);
    }
    public function settings(Request $request)
    {
        $variable = $request->query('var');
        view()->share('variable', $variable);
        return view('admin/settings')->with('variable', $variable);
    }
    public function tickets(Request $request)
    {
        $variable = $request->query('var');
        view()->share('variable', $variable);
        return view('admin/tickets')->with('variable', $variable);
    }
    public function contact(Request $request)
    {
        $variable = $request->query('var');
        view()->share('variable', $variable);
        return view('admin/contact')->with('variable', $variable);
    }
    public function user_settings()
    {
        //$users=ac_user::all();
        $ext = ac_extension::all();
        $users = ac_user::with('userType')->get();
        return view('users/user_home',['users'=>$users , 'ext'=>$ext]);
    }
    public function company_settings()
    {
        
        $company=ac_company::all();
            //return view(route('companies'),['company'=>$company]);
        return view('companies/company_home',['companies'=>$company]);
    }
    public function extension_settings()
    {
        $extension=ac_extension::all();
        return view('extensions/extension_home',['extensions'=>$extension]);
    }
    public function asign_extensions()
    {
        return view('users/asign_extensions');
    }
    public function assign_exten(Request $request)
    {
        $userId = $request->input('user_type_id');
        $extensionId = $request->input('extension');
        
        $user = ac_user::findOrFail($userId);
        $exten = ac_extension::findOrFail($extensionId);
        
        $user->update(['status'=>'1']);
        $exten->update(['status'=>'1']);
        $user->update(['extension'=>$exten->extension]);

        return redirect(route('users'));
        
    }

    public function unasign_extension(ac_user $user)
    {
        $ext =$user->extension;
        // dd($ext);
        // $extension = ac_extension::find($ext);
        $extension = ac_extension::where('extension', $user->extension)->first();
        // dd($extension);
        $user->update(['status'=>0 , 'extension'=>1]);
        $extension->update(['status'=>0]);

        return redirect(route('users'));
    }

 
    public function skills()
    {
        return view('skills.skill_home');
    }
    
}