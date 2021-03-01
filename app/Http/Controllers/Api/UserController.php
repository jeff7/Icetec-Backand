<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json('Hellou Heroku');
        $users = $this->user->paginate('10');

        return response()->json($users,200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->all();

        if (!$request->has('password') || !$request->get('password')) {
            $message = new ApiMessages('É necessário informar uma senha!!');
            return response()->json($message->getMessage(),401);
        }

        try {
            //code...
            $data['password'] = bcrypt($data['password']);

            $user = $this->user->create($data);

            return response()->json([
                'data' => [
                    'msg' => 'Usuário cadastrado com sucesso'
                ]
            ],200);

        } catch (\Exception $e) {
            //throw $th;
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(),401);
        }
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
        try {
            //code...

            $user = $this->user->findOrFail($id); 

            return response()->json([
                    'data' => $user
            ],200);

        } catch (\Exception $e) {
            //throw $th;
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(),401);
        }
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
        //
        $data = $request->all();

        if ($request->has('password') && $request->get('password')) {
            $data['password'] = bcrypt($data['password']);
        }
        else
        {
            unset($data['password']);
        }

        try {
            //code...

            $user = $this->user->findOrFail($id);
            $user->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'Usuário atualizado com sucesso'
                ]
            ],200);

        } catch (\Exception $e) {
            //throw $th;
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(),401);
        }
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
        try {
            //code...

            $user = $this->user->findOrFail($id);
            $user->delete($id);

            return response()->json([
                'data' => [
                    'msg' => 'Usuário Removido com sucesso'
                ]
            ],200);

        } catch (\Exception $e) {
            //throw $th;
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }
}
