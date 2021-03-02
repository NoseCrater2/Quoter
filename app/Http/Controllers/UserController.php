<?php

namespace App\Http\Controllers;

use App\User;
use App\ErrorMessages;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MyInfoResource;
use App\Http\Resources\UserIndexResource;
use Illuminate\Support\Facades\Hash;
use App\Mail\UserSaved;
 

class UserController extends Controller
{

    public function __construct() {
        //$this->middleware('can:viewAny,user')->only('index');
        $this->middleware('can:create,user')->only('create');
        $this->middleware('can:update,user')->only('update','show');
        $this->middleware('can:delete,user')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', 'App\User');
       return UserIndexResource::collection(
            User::get()
        );

    }

   public function store(Request $request)
   {
    $data = $request->all();
        $rules =[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|max:255',
            'zip_code' => 'required|max:10',
            'discount_percent' => 'required|numeric|min:0|max:99',

            
        ];

        $validator= Validator::make($data,$rules, ErrorMessages::getMessages());
        
        if($validator->fails()){
            return response($validator->errors(),422);
            
        }else{
           $pass = User::make_password();

            $data['password'] = $pass;
            $user = User::make($data);
            Mail::to($user)->send(new UserSaved($user));
            $user->password = bcrypt($user->password);
            $user->save();
            // $user->roles()->sync($request->get('roleIds'));
        
            return new UserIndexResource(User::findOrFail($user->id));
            
            
        }
   }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->all();
        $rules = [
            'name' => 'string',
            'email' => 'email|unique:users,email,'.$user->id,
            "roles"    => "required|array|min:1",
            "roles.*"  => "required|exists:roles,name|distinct|min:1",
            'password'  => 'min:6|confirmed|nullable'
        ];
       
        $validator= Validator::make($data,$rules, ErrorMessages::getMessages());
        if($validator->fails()){
            return response($validator->errors(),422);
        }else{
            if($request->has('password')){
                $data['password'] = bcrypt($data['password']);
    
            }

            $user->update($data);
            $user->syncRoles($request->get('roles'));
            return new UserIndexResource(User::findOrFail($user->id));
        } 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('info', 'Eliminado correctamente');
    }

    public function getMyInfo(Request $request)
    {
        $this->authorize('view', $request->user());
        return new MyInfoResource(User::findOrFail($request->user()->id));
    
    }

    public function signup(Request $request)
    {
       
        $data = $request->all();
        $rules =[
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'    
        ];

        $validator= Validator::make($data,$rules, ErrorMessages::getMessages());
        
        if($validator->fails()){
            return response($validator->errors(),422);
            
        }else{
            $data['password'] = bcrypt('password');
            $user = User::create($data);
            return new UserIndexResource(User::findOrFail($user->id));
        }
    }


    public function checkPassword(Request $request)
    {
        $this->authorize('view', $request->user());
        if(Hash::check($request->intent, $request->user()->password)){
            return response(['Message' => "Acceso autorizado"],200);
        }
        
        return response(['Message' => "Acceso No autorizado"],401);
    }

}
