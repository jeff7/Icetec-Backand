<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Candidate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\CandidateRepository;

class CandidateSearchController extends Controller
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
    public function index(Request $request)
    {
        //
        $candidate = $this->candidate->with('tecnologies')->paginate(10);

        $repository = new CandidateRepository($this->candidate);

        if($request->has('coditions')) {
		    $repository->selectCoditions($request->get('coditions'));
	    }

	    if($request->has('fields')) {
		    $repository->selectFilter($request->get('fields'));
	    }

        $repository->setlocation($request->all(['id_tec']));

        return response()->json([
            // 'data' => $candidate
            'data' => $repository->getResult()->paginate(10)
        ],200);
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
            $candidate = $this->candidate->with('tecnologies')->findOrFail($id);

            return response()->json([
                'data' => $candidate
            ],200);

        } catch (\Exception $e) {
            //throw $th;
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }
}
