<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Voting;

class VoteController extends Controller
{
    /**
     * Display page to manage current resource.
     *
     * @return Response
     */
    public function manage()
    {
        return view('modules.akun.akun');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$this->validate($request, $this->rules);

        $voting = Voting::create($request->all());

        return response()->json([
            'success' => trans('action.success.add'),
        ]);
    }

    public function getVote($vote){

    	$votes = new Voting;
    	
    	$votes->vote = $vote;

    	$votes->save();

    	return redirect()->back();
    }

}
