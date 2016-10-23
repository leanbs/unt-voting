<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Booth;
use App\Setting;
use App\Vote;
use App\ForbiddenEmail;
use DB;
use Validator;
use Session;
use Mail;
use Recaptcha;
use Socialite;

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

    public function getVotePage()
    {
        $booth = Booth::get();
        $setting = Setting::find(1);

        return view('pages.vote')
                ->with('booth', $booth)
                ->with('setting', $setting);
    }

    public function getVoteForm()
    {
        $booth = Booth::get();
        $setting = Setting::find(1);

        return view('module.vote.view')
                ->with('booth', $booth)
                ->with('setting', $setting);
    }

    public function postVote(Request $request)
    {
        $ip = $request->ip();
        Session::put('ip', $ip);
        return $request->id;
    }

    public function getVerifyForm($id)
    {
        $id = strip_tags($id);
        $booth = Booth::find($id);
        Session::put('id_booth', $id);

        
        return view('module.vote.verify')
                ->with('booth', $booth);
    }

    protected function validatorPostEmail(array $data)
    {
        return Validator::make($data, [
            'email'                 => 'required|email|unique:vote,email,null,null,status,1',
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
        $ip = $request->ip();

        $forbiddenEmail = ForbiddenEmail::where('forbidden_email', '=', $extensionEmail[1])->first();
        $checkVote = Vote::where('email', '=', $email)->first();

        if (empty($forbiddenEmail)) 
        {
            if (!empty($checkVote)) 
            {
                DB::beginTransaction();

                    $voteCode = str_random(7);

                    $checkVote->vote_code = $voteCode;
                    $checkVote->ip_addr = $ip;
                    $checkVote->id_booth = $id;
                    $checkVote->save();

                    $data = [
                        'email'             => $email,
                        'vote_code'         => $voteCode
                    ];                    

                DB::commit();  
                Session::put('data', $data);
                Session::put('id_vote', $checkVote->id_vote);
                $this->sendEmail($data);
                
            }
            else
            {
               DB::beginTransaction();

                    $voteCode = str_random(7);

                    $vote = new Vote ([
                        'email'             => $email,
                        'vote_code'         => $voteCode,
                        'ip_addr'           => $ip
                    ]);
                    $vote->booth()->associate($id);
                    $vote->save();

                    $data = [
                        'email'             => $email,
                        'vote_code'         => $voteCode
                    ];     
                
                DB::commit(); 
                Session::put('data', $data);
                Session::put('id_vote', $vote->id_vote); 
                $this->sendEmail($data);   
                  
            }          

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

    public function postSendVerifyAgain(Request $request)
    {
        $data = Session::get('data');
        $this->sendEmail($data);

        return 'Verification code has been sent again to your email address.';
                   
    }

    public function getVerify($vote)
    {       
        $id = Session::get('id_vote');
        $code = strip_tags($vote);        

        $vote = Vote::find($id);

        if ($vote->vote_code == $code) 
        {                
            DB::beginTransaction();
                $vote->status = 1;                
                $vote->save();

                $message = 'success'; 
            DB::commit();  

            $message = '<b class="color-blue" style="font-size: 30px;">Your vote has been submitted successfully.</b><br><p> Thanks for participating :) </p>';

            return view('module.vote.message')
                ->with('message', $message); 
        }          
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

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        $idFacebook = $user->getId();
        $namaFacebook = $user->getName();
        $email = $user->getEmail();
        $id = Session::get('id_booth');
        $ip = Session::get('ip');        

        if (!empty($email)) 
        {
            $checkVote = Vote::where('email', '=', $email)->first();

            if (!empty($checkVote)) 
            {
                if ($checkVote->status == 1) 
                {
                    $message = '<b class="color-blue" style="font-size: 30px;">Sorry, your facebook account has been used.</b><br><p> Thanks for participating :) </p>';
                    
                    return view('module.vote.message')
                        ->with('message', $message);  
                }
                else
                {
                    DB::beginTransaction();

                        $vote = Vote::where('email', '=', $email)->first();
                        $vote->id_booth = $id;
                        $vote->status = 1;
                        $vote->ip_addr = $ip;
                        $vote->save();

                    DB::commit();  

                    $message = '<b class="color-blue" style="font-size: 30px;">Your vote has been submitted successfully.</b><br><p> Thanks for participating :) </p>';

                    return view('module.vote.message')
                        ->with('message', $message);     
                }            
            }
            else
            {
                DB::beginTransaction();

                    $vote = new Vote ([
                                'id_facebook'       => $idFacebook,
                                'nama_facebook'     => $namaFacebook,
                                'email'             => $email,
                                'status'            => 1,
                                'ip_addr'           => $ip
                            ]);
                    $vote->booth()->associate($id);
                    $vote->save();

                DB::commit();  
                $message = '<b class="color-blue" style="font-size: 30px;">Your vote has been submitted successfully.</b><br><p> Thanks for participating :) </p>';

                return view('module.vote.message')
                    ->with('message', $message);  
            }       
        }  
        else
        {
            $message = '<b class="color-blue" style="font-size: 30px;">Sorry, this account cannot be used to vote your favorite booth.</b><br><p>Please put your email address to your account first and try again.</p>';

            return view('module.vote.message')
                    ->with('message', $message);  
        }                     
    }
}
