<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Illuminate\Http\Request;
use App\Vote;
use App\Http\Requests;
use App\Booth;
use App\Setting;
use App\rmdir;
use App\ForbiddenEmail;
use Datatables;

class AdminController extends Controller
{

    /**
     * Constructor + restrict user to access cpanel.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display page to manage current resource.
     *
     * @return Response
     */
    public function cpanel()
    {
        $setting = SEtting::find(1);

        return view('pages.admin')
                    ->with('setting', $setting);
    }
    
    public function getModalAddBooth()
    {
        return view('modal.admin.booth.add.formAdd');
    }

    protected function validatorPostModalAddBooth(array $data)
    {
        return Validator::make($data, [
            'NamaBrand'             => 'required|unique:booth,nama_produk',
            'AnggotaKelompok'       => 'required',
            'DeskripsiProduk'       => 'required',
            'photo'                 => 'required|image',
        ]);      
    }

    public function postModalAddBooth(Request $request)
    {
        $validator = $this->validatorPostModalAddBooth($request->all());
        if ($validator->fails()) 
        {
            $this->throwValidationException($request, $validator);
        }

        $NamaBrand = strip_tags($request->input('NamaBrand'));
        $AnggotaKelompok = strip_tags($request->input('AnggotaKelompok'));
        $DeskripsiProduk = strip_tags($request->input('DeskripsiProduk'));

        $Photo = $request->file('photo')->getClientOriginalName();
        $extension = pathinfo($Photo, PATHINFO_EXTENSION);
        $newPhotoName = $NamaBrand .'.'. $extension;
        
        $desired_dir = public_path(). '/assets/logo/' . $NamaBrand;
        $logoURL = asset('assets/logo/'. $NamaBrand.'/');

        if (is_dir($desired_dir) == false) 
        {
            mkdir("$desired_dir", 0700);
            if(is_dir("$desired_dir/". $newPhotoName) == false)
            {
                $request->file('photo')->move($desired_dir, $newPhotoName);                     
            }
        }
        else
        {
            if(is_dir("$desired_dir/". $newPhotoName) == false)
            {
                $request->file('photo')->move($desired_dir, $newPhotoName);                     
            }
        }

        DB::beginTransaction();
            $booth = new Booth ([
                'directory_logo'    => $logoURL,
                'logo_name'         => $newPhotoName,
                'nama_produk'       => $NamaBrand,
                'anggota_kelompok'  => $AnggotaKelompok,
                'deskripsi_produk'  => $DeskripsiProduk
            ]);
            $booth->save();
        DB::commit(); 

        return 'booth added';

    }

    public function getTableBooth()
    {
        $booth = Booth::select([
            'id_booth as IdBooth',
            'directory_logo as Dir',
            'logo_name as LogoName',
            'nama_produk as NamaBrand',
            'anggota_kelompok as Agt',
            'deskripsi_produk as Des',      
        ]);

        return Datatables::of($booth)
            ->addColumn('Logo', function ($booths) {
                // $moo = asset('assets/logo/'. $booths->NamaBrand .'/'. $booths->LogoName );
                return  '<img src="'. $booths->Dir .'/'. $booths->LogoName .'" width="200">';
            })
            ->addColumn('AnggotaKelompok', function ($booths) {
                $agt = explode(",", $booths->Agt);
                $moo = '<ul>';
                foreach ($agt as $value) 
                {                    
                    $moo .= '<li>'. $value .'</li>';
                }
                $moo .= '</ul>';
                return $moo;
            })
            ->addColumn('Pengaturan', function ($booths) {
                return
                    '<a id="edit-booth-'. $booths->IdBooth .'" style="color: blue; text-decoration: none; cursor: pointer;"><i class="fa fa-pencil-square-o"></i>Edit</a>&nbsp;&nbsp;
                    <a id="delete-booth-'. $booths->IdBooth .'" style="color: red; text-decoration: none; cursor: pointer;"><i class="fa fa-trash-o"></i>Delete</a>

                    <script type="text/javascript">
                        // edit
                        $(function(){
                            $.ajaxSetup ({
                                cache: false
                            });
                            var id = "'. $booths->IdBooth .'";                                  
                            var loadUrl = "modalEditBooth/"+id;
                            $("#edit-booth-"+id).click(function(){
                                $("#modal-body-editBooth").load(loadUrl, function(result){
                                    $("#modalEditBooth").modal({show:true});
                                });
                            });
                        });

                        // delete
                        $(function(){
                            $.ajaxSetup ({
                                cache: false
                            });
                            var id = "'. $booths->IdBooth .'";                                  
                            var loadUrl = "modalDeleteBooth/"+id;
                            $("#delete-booth-"+id).click(function(){
                                $("#modal-body-deleteBooth").load(loadUrl, function(result){
                                    $("#modalDeleteBooth").modal({show:true});
                                });
                            });
                        });
                    </script>';
            })
            ->removeColumn('IdBooth')
            ->removeColumn('Agt')
            ->removeColumn('Dir')
            ->removeColumn('LogoName')
            ->removeColumn('Harga')
            ->make(true);
    }

    public function getModalEditBooth($id)
    {
        $booth = Booth::find($id);
        return view('modal.admin.booth.edit.formEdit')
                    ->with('booth', $booth);
    }

    protected function validatorPostModalEditBooth(array $data)
    {
        return Validator::make($data, [
            'NamaBrand'             => 'required|unique:booth,nama_produk',
            'AnggotaKelompok'       => 'required',
            'DeskripsiProduk'       => 'required',
            'photo'                 => 'image',
        ]);      
    }

    public function postModalEditBooth(Request $request)
    {
        $validator = $this->validatorPostModalEditBooth($request->all());
        if ($validator->fails()) 
        {
            $this->throwValidationException($request, $validator);
        }

        DB::beginTransaction();

            $id = $request->input('id');
            $NamaBrand = strip_tags($request->input('NamaBrand'));
            $AnggotaKelompok = strip_tags($request->input('AnggotaKelompok'));
            $DeskripsiProduk = strip_tags($request->input('DeskripsiProduk'));

            $booth = Booth::find($id);
            $desired_dir_prev = public_path(). '/assets/logo/' . $booth->nama_produk;
            $desired_dir_next = public_path(). '/assets/logo/' . $NamaBrand;
            rename($desired_dir_prev, $desired_dir_next); 

            if (empty($request->file('photo'))) 
            {   
                $booth->nama_produk = $NamaBrand;
                $booth->anggota_kelompok = $AnggotaKelompok;
                $booth->deskripsi_produk = $DeskripsiProduk;
                $booth->save();
            }
            else
            {
                $Photo = $request->file('photo')->getClientOriginalName();
                $extension = pathinfo($Photo, PATHINFO_EXTENSION);
                $newPhotoName = $NamaBrand .'.'. $extension;

                $logoURL = asset('assets/logo/'. $NamaBrand .'/');

                unlink("$desired_dir_next/$booth->logo_name");
                $request->file('photo')->move($desired_dir_next, $newPhotoName); 

                $booth = Booth::find($id);
                $booth->directory_logo = $logoURL;
                $booth->logo_name = $newPhotoName;
                $booth->nama_produk = $NamaBrand;
                $booth->anggota_kelompok = $AnggotaKelompok;
                $booth->deskripsi_produk = $DeskripsiProduk;
                $booth->save();     
            }               
            

        DB::commit(); 

        return 'booth edited';

    }

    public function getModalDeleteBooth($id)
    {
        return view('modal.admin.booth.delete.formDelete')
                    ->with('id', $id);
    }    

    public function postModalDeleteBooth(Request $request)
    {       
        DB::beginTransaction();

            $id = $request->id;

            $booth = Booth::find($id);
            $desired_dir_prev = public_path(). '/assets/logo/' . $booth->nama_produk; 
            $rmdir = new rmdir(); 
            $result = $rmdir->rmdir_recursive($desired_dir_prev);  
            $booth->delete();         

        DB::commit(); 

        return $result;

    }

    public function getTableVote()
    {
        $vote = Vote::join('booth', 'vote.id_booth', '=', 'booth.id_booth')
                    ->where('vote.status', '=', '1')
                    ->select([
                        'vote.id_vote as IdVote',
                        'booth.nama_produk as NamaBrand',
                        'vote.ip_addr as AlamatIP',
                        'vote.email as Email',
                        'vote.updated_at as Tanggal',      
                    ]);

        return Datatables::of($vote)
            ->addColumn('Pengaturan', function ($votes) {
                return
                    '<a id="delete-vote-'. $votes->IdVote .'" style="color: red; text-decoration: none; cursor: pointer;"><i class="fa fa-trash-o"></i> Delete</a>

                    <script type="text/javascript">
                        // delete
                        $(function(){
                            $.ajaxSetup ({
                                cache: false
                            });
                            var id = "'. $votes->IdVote .'";                           
                            var loadUrl = "modalDeleteVote/"+id;   
                            $("#delete-vote-"+id).click(function(){
                                $("#modal-body-deleteVote").load(loadUrl, function(result){
                                    $("#modalDeleteVote").modal({show:true});
                                });
                            });
                        });
                    </script>';
            })
            ->removeColumn('IdVote')
            ->make(true);
    }

    public function getModalDeleteVote($id)
    {
        return view('modal.admin.vote.delete.formDelete')
                    ->with('id', $id);
    }    

    public function postModalDeleteVote(Request $request)
    {       
        DB::beginTransaction();

            $id = $request->id;

            $vote = Vote::find($id);
            $vote->delete();         

        DB::commit(); 

        return 'vote deleted';

    }

    public function getModalDeleteAllVote()
    {
        $result = [];
        $Vote = Vote::select(
                        'id_vote as IdVote',
                        'email as Email'
                    )
                    ->where('status', '=', '1')
                    ->groupBy('Email')
                    ->get();

        foreach ($Vote as $value) {
            $extensionEmail = explode("@", $value->Email);

            $result[$extensionEmail[1]] =  $extensionEmail[1];
        }

        return view('modal.admin.vote.deleteAll.formDelete')
                    ->with('Extension', $result);
    } 

    protected function validatorPostModalDeleteAllVote(array $data)
    {
        return Validator::make($data, [
            'ExtensionEmail'             => 'required',
        ]);      
    }

    public function postModalDeleteAllVote(Request $request)
    {
        $validator = $this->validatorPostModalDeleteAllVote($request->all());
        if ($validator->fails()) 
        {
            $this->throwValidationException($request, $validator);
        }

        DB::beginTransaction();

            $ExtensionEmail = strip_tags($request->input('ExtensionEmail'));  
            
            $Vote = Vote::where('email', 'LIKE', '%'. $ExtensionEmail .'%');
            $Vote->delete(); 

        DB::commit(); 

        return 'all vote deleted';
    } 

    public function getTableForbidden()
    {
        $forbiddenEmail = ForbiddenEmail::select([
                        'id_forbiddenemail as IdForbiddenEmail',
                        'forbidden_email as ForbiddenEmail',    
                    ]);

        return Datatables::of($forbiddenEmail)
            ->addColumn('Pengaturan', function ($forbidden) {
                return
                    '<a id="edit-ForbiddenEmail-'. $forbidden->IdForbiddenEmail .'" style="color: blue; text-decoration: none; cursor: pointer;"><i class="fa fa-pencil-square-o"></i>Edit</a>&nbsp;&nbsp;
                    <a id="delete-ForbiddenEmail-'. $forbidden->IdForbiddenEmail .'" style="color: red; text-decoration: none; cursor: pointer;"><i class="fa fa-trash-o"></i>Delete</a>

                    <script type="text/javascript">
                        // edit
                        $(function(){
                            $.ajaxSetup ({
                                cache: false
                            });
                            var id = "'. $forbidden->IdForbiddenEmail .'";                                  
                            var loadUrl = "modalEditForbiddenEmail/"+id;
                            $("#edit-ForbiddenEmail-"+id).click(function(){
                                $("#modal-body-editForbiddenEmail").load(loadUrl, function(result){
                                    $("#modalEditForbiddenEmail").modal({show:true});
                                });
                            });
                        });

                        // delete
                        $(function(){
                            $.ajaxSetup ({
                                cache: false
                            });
                            var id = "'. $forbidden->IdForbiddenEmail .'";                                  
                            var loadUrl = "modalDeleteForbiddenEmail/"+id;
                            $("#delete-ForbiddenEmail-"+id).click(function(){
                                $("#modal-body-deleteForbiddenEmail").load(loadUrl, function(result){
                                    $("#modalDeleteForbiddenEmail").modal({show:true});
                                });
                            });
                        });
                    </script>';
            })
            ->removeColumn('IdForbiddenEmail')
            ->make(true);
    }

    public function getModalAddForbidden()
    {
        return view('modal.admin.forbiddenEmail.add.formAdd');
    }

    protected function validatorPostModalAddForbidden(array $data)
    {
        return Validator::make($data, [
            'Email'             => 'required|unique:forbiddenemail,forbidden_email',
        ]);      
    }

    public function postModalAddForbidden(Request $request)
    {
        $validator = $this->validatorPostModalAddForbidden($request->all());
        if ($validator->fails()) 
        {
            $this->throwValidationException($request, $validator);
        }



        $Email = strip_tags($request->input('Email'));

        DB::beginTransaction();
            $forbiddenEmail = new ForbiddenEmail ([
                'forbidden_email'    => $Email
            ]);
            $forbiddenEmail->save();
        DB::commit(); 

        return 'forbidden email added';

    }

    public function getModalEditForbidden($id)
    {
        $forbiddenEmail = ForbiddenEmail::find($id);

        return view('modal.admin.forbiddenEmail.edit.formEdit')
                    ->with('forbiddenEmail', $forbiddenEmail);
    }

    public function postModalEditForbidden(Request $request)
    {
        $validator = $this->validatorPostModalAddForbidden($request->all());
        if ($validator->fails()) 
        {
            $this->throwValidationException($request, $validator);
        }

        $id = $request->input('id');
        $Email = strip_tags($request->input('Email'));

        DB::beginTransaction();
            $forbiddenEmail = ForbiddenEmail::find($id);
            $forbiddenEmail->forbidden_email = $Email;
            $forbiddenEmail->save();
        DB::commit(); 

        return 'forbidden email added';

    }

    public function getModalDeleteForbiddenEmail($id)
    {
        return view('modal.admin.forbiddenEmail.delete.formDelete')
                    ->with('id', $id);
    }    

    public function postModalDeleteForbiddenEmail(Request $request)
    {       
        DB::beginTransaction();

            $id = $request->id;

            $vote = ForbiddenEmail::find($id);
            $vote->delete();         

        DB::commit(); 

        return 'forbidden email deleted';

    }

    public function getChartVote()
    {
        $report = Booth::select([
                        'nama_produk as NamaBooth',
                        DB::raw(
                            '(SELECT COALESCE(COUNT(vote.id_vote), 0) 
                             FROM vote 
                             WHERE id_booth = booth.id_booth AND status = 1) as Jumlah'
                        )
                    ]);            


        foreach ($report->get() as $value) {
            $result[] = ["Nama" => $value->NamaBooth, "Jumlah" => $value->Jumlah];
        }

        return response()->json($result);;
    }  

    public function postEvent(Request $request)
    {
        $status = strip_tags($request->status);

        DB::beginTransaction();
            $setting = Setting::find(1);
            $setting->status = $status;
            $setting->save();
        DB::commit(); 

        return 'setting updated';

    }
}
