<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Voting;
use App\Booth;
use App\Vote;
use App\ForbiddenEmail;
use DB;
use Validator;
use Session;
use Mail;
use Recaptcha;

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

    public function getVote($vote)
    {
        $votes = new Voting;
        $votes->vote = $vote;
        $votes->save();
        return redirect()->back();
    }

    public function getVoteForm()
    {
        $booth = Booth::get();

        return view('module.vote.view')
                ->with('booth', $booth);
    }

    public function postVote(Request $request)
    {
        return $request->id;
    }

    public function getVerifyForm($id)
    {
        $booth = Booth::find($id);

        return view('module.vote.verify')
                ->with('booth', $booth);
    }

    protected function validatorPostEmail(array $data)
    {
        return Validator::make($data, [
            'email'                 => 'required|email|unique:vote,email',
            'g-recaptcha-response'  => 'required|recaptcha',
        ]);      
    }

    public function postEmail(Request $request)
    {
        $validator = $this->validatorPostEmail($request->all());
        if ($validator->fails()) 
        {
            $this->throwValidationException($request, $validator);
        }

        $id = $request->input('id');
        $email = strip_tags($request->input('email'));
        $extensionEmail = explode("@", $email);
        $error = [];

        $forbiddenEmail = ForbiddenEmail::where('forbidden_email', '=', $extensionEmail[1])->first();

        if (empty($forbiddenEmail)) 
        {
            DB::beginTransaction();

                $voteCode = str_random(7);

                $vote = new Vote ([
                    'email'             => $email,
                    'vote_code'         => $voteCode
                ]);
                $vote->booth()->associate($id);
                $vote->save();

                $data = [
                    'email'             => $email,
                    'vote_code'         => $voteCode
                ];
                $this->sendEmail($data);

                Session::put('id_vote', $vote->id_vote);
            
            DB::commit(); 

            return 'success';
        }
        else
        {
            return 'Your email address is invalid';
        }
            
    }

    public function sendEmail($data)
    {     
        Mail::send('module.email.email', $data, function($message) use ($data)
        {    
            $message->from('entrepreneurweek_untar@mail.com', 'Entrepreneurweek-Untar');
            $message->to($data['email'], $data['email'])->subject('Voting Online Vote Code');  
        });
    }

    protected function validatorPostVerify(array $data)
    {
        return Validator::make($data, [
            'code'                 => 'required',
        ]);      
    }

    public function postVerify(Request $request)
    {
        $validator = $this->validatorPostVerify($request->all());
        if ($validator->fails()) 
        {
            $this->throwValidationException($request, $validator);
        }

        DB::beginTransaction();

            $id = Session::get('id_vote');
            $code = strip_tags($request->input('code'));        

            $vote = Vote::find($id);

            if ($vote->vote_code == $code) 
            {                
                $vote->status = 1;                
                $vote->save();

                $message = 'success'; 
            }
            else
            {
                $message = 'wrong code, please check your email to see the real code'; 
            }
        
        DB::commit();  

        return $message;
                   
    }

    public function getThankyouForm()
    {
        return view('module.vote.thankyou');
    }

}
