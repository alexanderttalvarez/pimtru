<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Mail\UserCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Transformers\UserTransformer;
use App\Http\Controllers\ApiController;
use App\Http\Requests\User\StoreUserRequest;

class UserController extends ApiController
{
    public function __construct() {
        // $this->middleware('client.credentials')->only(['store', 'resend']);
        // $this->middleware('auth:api')->except(['store','verify','resend']);
        $this->middleware('transform.input:' . UserTransformer::class)->only(['store', 'update']);
        // $this->middleware('scope:manage-account')->only(['show', 'update']);
        // $this->middleware('can:view,user')->only(['show']);
        // $this->middleware('can:update,user')->only(['update']);
        // $this->middleware('can:delete,user')->only(['destroy']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$this->allowedAdminAction();

        $users = User::all();

        return $this->showAll( $users );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Requests\StoreUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        
        $fields = $request->all();
        $fields['password'] = bcrypt( $request->password );
        $fields['verified'] = User::NOT_VERIFIED_USER;
        $fields['verification_token'] = User::generateVerificationToken();
        $fields['admin'] = User::REGULAR_USER;

        $user = User::create( $fields );

        return $this->showOne( $user, 201 );
        
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
 
        return $this->showOne( $user );

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\User\UpdateUserRequest  $request
     * @param  int                                        $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {

        $reglas = [
            'password' => 'min:6|confirmed',
            'email'    => 'email|unique:users,email,' . $user->id,
            'admin'    => 'in:' . User::USUARIO_ADMINISTRADOR . ',' . User::USUARIO_REGULAR,
        ];

        $this->validate($request, $reglas);

        if($request->has('name')) {
            $user->name = $request->name;
        }

        if($request->has('email') && $user->email != $request->email) {
            $user->verified = User::USUARIO_NO_VERIFICADO;
            $user->verification_token = User::generarVerificationToken();
            $user->email = $request->email;
        }

        if($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if($request->has('admin')) {

            $this->allowedAdminAction();
            
            if( !$user->esVerificado() ) {
                return $this->errorResponse('Únicamente los usuarios verificados pueden cambiar su valor de administrador', 409);
            }

            $user->admin = $request->admin;
        }

        if( !$user->isDirty() ) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',422);
        }

        $user->save();

        return $this->showOne( $user );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user The User Instance we want to delete  
     * 
     * @return json The info of the User we just deleted
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->showOne( $user );
    }

    /**
     * It searchs the user which a token belongs to, and turns its status to
     * verified.
     * 
     * @param string $token The token for verifying the user
     * 
     * @return json A message as a json
     */
    public function verify($token) {

        $user = User::where('verification_token', $token)->firstOrFail();

        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;

        $user->save();

        return $this->showMessage('La cuenta ha sido verificada');

    }

    public function resendVerification(User $user) {

        if( $user->isVerified() ) {
            return $this->errorResponse('Este usuario ya ha sido verificado.', 409);
        }

        retry( 5, function() use ($user) {
            Mail::to($user)->send(new UserCreated($user));
        }, 100 );

        return $this->showMessage('El correo de verificación se ha reenviado.');

    }
}
