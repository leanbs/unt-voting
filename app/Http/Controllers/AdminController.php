<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Voting;
use App\Http\Requests;

class AdminController extends Controller
{

	public function index(Request $request){
		$data = [];
        $result = [];
    	//Query Statuses for 'ACCEPTED' and 'REJECTED'
                $single = DB::table('voting')
                                ->select(DB::raw('vote, count(*) as jumlah'))
                                ->groupBy('voting.vote');
                                

                // foreach ($single->get() as $data) {
                //     $result[] = ["vote" => $data->vote, "jumlah" => $data->jumlah];
                // }
                
                foreach ($single->get() as $data) {
                    array_push($result, [ "Nama" => $data->vote ,"Jumlah" => $data->jumlah ]);
                }

                return response()->json($result);
    }

    /**
     * Display page to manage current resource.
     *
     * @return Response
     */
    public function cpanel()
    {
        return view('pages.admin');
    }
}
