<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Illuminate\Http\Request;
use App\Voting;
use App\Http\Requests;
use App\Booth;
use App\rmdir;
use Datatables;

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
                    <a id="delete-booth-'. $booths->IdBooth .'" data-toggle="modal" data-target="#deleteModal" style="color: red; text-decoration: none; cursor: pointer;"><i class="fa fa-trash-o"></i>Delete</a>

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
}
