<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\DataRequest;
use App\Http\Requests\FileRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**Show form to get data
     *
     * @return view
    */
    public function index () {
        return view('form');
    }

    /**Get data from form
     *
     * @
     */
    public function store(DataRequest $request) {
        $value = $request->status;
        dd($value);
    }

    /**Show form upload file
     *
     * @return view
     */
    public function showForm() {
        return view('formUpload');
    }

    /**Store file
     *
     * @return bool
     */
    public function uploadFiles(FileRequest $request) {
        $status = true;
        foreach ($request->file('files') as $file) {
            $name = time().'_'.$file->getClientOriginalName();;
            $result = $file->storeAs('files', $name);
             if (!$result) {
                $status = false;
             }
        }
        if(!$status) {
            echo '<div class="alert alert-warning"> Upload failed </div>';
        } else {
            echo '<div class="alert alert-success"> Upload successfully </div>';
        }
    }

    /**Show form to login
     *
     * @return view
     */
    public function login() {
        return view('login');
    }

    /**Login
     *
     * @return redirect
     */
    public function postLogin(Request $request) {
        $credentials = $request->only(['username','password']);
        $result = Auth::attempt($credentials);

        if ($result) {
            if($request->remember == 1) {
                $minutes = 1;
                $response = new Response();
                $value = Auth::user()->remember_token;
                $cookie = cookie('remember_token', $value, $minutes);
                if(Auth::user()->role_id == 1) {
                    return response()->view('admin')->withCookie($cookie);
                } else {
                    return response()->view('home')->withCookie($cookie);
                }
            }
            if(Auth::user()->role_id == 1) {
                return redirect()->route('admin');
            } else {
                return redirect()->route('home');
            }
        } else {
            return back()->with(['msgF'=>'Username or password is incorrect']);
        }
    }

    /**Show home page
     *
     * @reutrn view
     */
    public function home() {
        $username = $this->getUsername();
        return view('home',compact('username'));
    }

    /**Show admin page
     *
     * @return view
     */
    public function admin() {
        $username = $this->getUsername();
        return view('admin',compact('username'));
    }

    /**Logout
     *
     * @return view
     */
    public function logout(Request $request) {
        $request->session()->forget('user');
        return redirect()->route('login1');
    }

     /**Login with use base session
      *
      *@return route
      */
      public function postLogin1(UserRequest $request) {
        $username = $request->username;
        $password = $request->password;
        $result = DB::table('users')->where('username',$username)->first();

        if ($result !=null) {
            if (Hash::check($password,$result->password)) {
                $value = ['username'=>$username,'password'=>$password,'role_id'=>$result->role_id];
                $remember = $request->remember;
                if ($remember == 1) {
                    do {
                        $remember_token = Str::random(45);
                        $result1 = DB::table('users')->where('remember_token',$remember_token)->first();
                    }
                    while($result1 != null);

                    DB:: table('users')->where('id',$result->id)->update(['remember_token'=>$remember_token]);
                    setcookie("remember_token", $remember_token, time()+ 3600);

                }
                $request->session()->put('user',$value);
                return redirect()->route('home');
            } else {
                return redirect()->route('lo')->with(['msgF'=>'Username or password is incorrect']);
            }
        } else {
            return redirect()->route('lo');
        }
      }

      /**Get usernamr login
       *
       * @return string
       */
      public function getUsername() {
        if (session()->has('user')) {
            $username = session()->get('user')['username'];
        }
        if (isset($_COOKIE['remember_token'])) {
            $result = DB::table('users')->where('remember_token','=',$_COOKIE['remember_token'])->first();
            $username = $result->username;
        }
        return $username;
      }
}
