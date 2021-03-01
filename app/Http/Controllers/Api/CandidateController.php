<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Candidate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CandidateController extends Controller
{
    private $candidate;

    public function __construct(Candidate $candidate)
    {
        $this->candidate = $candidate;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $candidates = $this->candidate->with('tecnologies')->paginate('30');

        return response()->json($candidates,200);
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

        try {
            //code...

            $id_tec = json_decode($data['id_tec'], true);
            
            $candidate = $this->candidate->create($data);
           
            foreach ($id_tec as $key) {

                $candidate->tecnologies()->create([
                    'candidate_id' => $candidate['id'],
                    'description' => $key['label'],
                    'id_tec' => $key['value']
                ]);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Candidato cadastrado com sucesso'
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

            $candidate = $this->candidate->findOrFail($id); 

            return response()->json([
                    'data' => $candidate
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

        try {
            //code...

            // $id_tec = $data['id_tec'];
             $id_tec = json_decode($data['id_tec'], true);

            $candidate = $this->candidate->findOrFail($id);
            $candidate->update($data);

            $candidate->tecnologies()->where('candidate_id',$candidate['id'])->delete();

            foreach ($id_tec as $key) {
                $candidate->tecnologies()->create([
                    'candidate_id' => $id,
                    'description' => $key['label'],
                    'id_tec' => $key['value']
                ]);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Candidato atualizado com sucesso'
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

            $candidate = $this->candidate->findOrFail($id);
            $candidate->tecnologies()->where('candidate_id',$candidate['id'])->delete();
            $candidate->delete($id);

            return response()->json([
                'data' => [
                    'msg' => 'Candidato Removido com sucesso'
                ]
            ],200);

        } catch (\Exception $e) {
            //throw $th;
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }
}
