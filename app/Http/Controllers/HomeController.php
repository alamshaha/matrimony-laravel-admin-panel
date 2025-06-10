<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\HomeModel;
use App\Models\ApiModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;



class HomeController extends Controller
{
   
    protected $homeModel;
    protected $apiModel;
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->homeModel = new HomeModel();
        $this->apiModel = new ApiModel();
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data[] = DB::table('members')->count();      
        $data[] = DB::table('users')->count();
        $data[] = DB::table('religions')->count();
        $data[] = DB::table('castes')->count();
        $data[] = DB::table('tbl_gender')->count();
        $data[] = DB::table('tbl_height')->count();
        $data[] = DB::table('tbl_marital_status')->count();
        $data[] = DB::table('packages')->count();
        $data[] = DB::table('tbl_occupations_type')->count();
        $data[] = DB::table('tbl_created_by')->count();
        $data[] = DB::table('tbl_income')->count();     
        // echo "<pre></pre>";
        // print_r($data);
        $dashboard['data'] = $data;
        return view('home',$dashboard);
    }

    public function blank()
    {     
        return view('blank');
    }
    public function report_users()
    {
        $data['page_name'] = 'Users';
        $data['users'] =  DB::table('users')->paginate(10);        
        return view('reports.users',$data);
    }
    public function report_religions()
    {
        $data['page_name'] = 'Religions';
        $data['religions'] =  DB::table('religions')->paginate(10);
        return view('reports.religions',$data);
    }
    public function report_caste()
    {
        $data['page_name'] = 'Caste';        
        $data['caste'] =   $this->homeModel->fetchCaste(0);
        return view('reports.caste',$data);
    }

    public function report_gender()
    {
        $data['page_name'] = 'Gender';
        $data['gender'] =  DB::table('tbl_gender')->paginate(10);
        return view('reports.gender',$data);
    }
    public function report_height()
    {
        $data['page_name'] = 'Height';
        $data['height'] =  DB::table('tbl_height')->paginate(10);
        return view('reports.height',$data);
    }
    public function report_packages()
    {
        $data['page_name'] = 'Packages';
        $data['packages'] =  DB::table('packages')->paginate(10);
        return view('reports.packages',$data);
    }

    public function report_members()
    {
        $data['page_name'] = 'Members';
        $data['members'] =  $this->homeModel->fetchMembers();// DB::table('members')->paginate(5);        
        return view('reports.members',$data);
    }  
    public function castewise_data(Request $request)
    {
        // echo "12312"; die();
        $data['page_name'] = 'Members';
        $data['members'] =  $this->homeModel->fetchCastewiseMembers($request->caste_id);// DB::table('members')->paginate(5);        
        return view('reports.members',$data);
    } 
    public function genderwise_data(Request $request)
    {
        // echo "12312"; die();
        $data['page_name'] = 'Members';
        $data['members'] =  $this->homeModel->fetchGenderwiseMembers($request->gender_id);// DB::table('members')->paginate(5);        
        return view('reports.members',$data);
    } 

    
    public function report_occupations()
    {
        $data['page_name'] = 'Occupations';
        $data['occupations'] =  DB::table('tbl_occupations_type')->paginate(10);        
        return view('reports.occupations',$data);
    }  
    public function report_created_by()
    {
        $data['page_name'] = 'Created By';
        $data['created_by'] =  DB::table('tbl_created_by')->paginate(10);        
        return view('reports.created_by',$data);
    }  
    public function report_income()
    {
        $data['page_name'] = 'Income Slab';
        $data['income'] =  DB::table('tbl_income')->paginate(10);        
        return view('reports.income',$data);
    }  
    public function report_marital_status()
    {
        $data['page_name'] = 'Marital Status';
        $data['marital_status'] =  DB::table('tbl_marital_status')->paginate(10);        
        return view('reports.report_marital_status',$data);
    }  


    # Form Sectionbs

    public function deleteRecords(Request $request)
            {
                $request->validate([
                    'table_name' => 'required|string',
                    'table_id' => 'required|string',
                    'table_value' => 'required'
                ]);

                try {
                    $table = $request->input('table_name');
                    $where = [$request->input('table_id') => $request->input('table_value')];

                    $deleted = DB::table($table)->where($where)->delete();

                    if ($deleted) {
                        $data = array('status'=> 'success',
                        'success_message'=>'Religion deleted Successfully !!!');
                       echo json_encode($data);

                    } else {

                        $data = array('status'=> 'failed',
                        'success_message'=>'No record found to delete !!!');
                        echo json_encode($data);                       
                    }

                } catch (\Exception $e) {
                    $data = array('status'=> 'failed',
                        'success_message'=>'Something Goes Wrong !!!');
                        echo json_encode($data);   
                }
            }


    public function save_religion(Request $request)
    {
        $data = [
            'name' => $request->name
        ];
        $rules = [
           'name' => 'required|unique:religions,name'
        ];
        
        $validator = Validator::make($data, $rules);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if($request->type ==0)
        {
            $action =  $this->apiModel->insertData('religions',$data);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Religion added Successfully !!!');
               echo json_encode($data);
            }
        }
        else
        {
            $where['id'] = $request->id;
            $action =  $this->apiModel->updateData('religions',$data,$where);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Religion updated Successfully !!!');
               echo json_encode($data);
            }
            else
            {
                $data = array('status'=> 'failed',
                'success_message'=>'Religion Not updated Successfully !!!');
               echo json_encode($data);
            }

        }
    }
    public function save_marital_status(Request $request)
    {
        $data = [
            'name' => $request->name
        ];
        $rules = [
           'name' => 'required|unique:tbl_marital_status,name'
        ];
        
        $validator = Validator::make($data, $rules);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if($request->type ==0)
        {
            $action =  $this->apiModel->insertData('tbl_marital_status',$data);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Marital Status added Successfully !!!');
               echo json_encode($data);
            }
        }
        else
        {
            $where['id'] = $request->id;
            $action =  $this->apiModel->updateData('tbl_marital_status',$data,$where);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Marital Status updated Successfully !!!');
               echo json_encode($data);
            }
            else
            {
                $data = array('status'=> 'failed',
                'success_message'=>'Marital Status Not updated  !!!');
               echo json_encode($data);
            }

        }
    }

    public function save_gender(Request $request)
    {
        $data = [
            'name' => $request->name
        ];
        $rules = [
           'name' => 'required|unique:tbl_gender,name'
        ];
        
        $validator = Validator::make($data, $rules);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if($request->type ==0)
        {
            $action =  $this->apiModel->insertData('tbl_gender',$data);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Gender added Successfully !!!');
               echo json_encode($data);
            }
        }
        else
        {
            $where['id'] = $request->id;
            $action =  $this->apiModel->updateData('tbl_gender',$data,$where);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Gender updated Successfully !!!');
               echo json_encode($data);
            }
            else
            {
                $data = array('status'=> 'failed',
                'success_message'=>'Gender Not updated  !!!');
               echo json_encode($data);
            }

        }
    }
    public function save_height(Request $request)
    {
        $data = [
            'name' => $request->name
        ];
        $rules = [
           'name' => 'required|unique:tbl_height,name'
        ];
        
        $validator = Validator::make($data, $rules);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if($request->type ==0)
        {
            $action =  $this->apiModel->insertData('tbl_height',$data);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Height added Successfully !!!');
               echo json_encode($data);
            }
        }
        else
        {
            $where['id'] = $request->id;
            $action =  $this->apiModel->updateData('tbl_height',$data,$where);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Height updated Successfully !!!');
               echo json_encode($data);
            }
            else
            {
                $data = array('status'=> 'failed',
                'success_message'=>'Height Not updated  !!!');
               echo json_encode($data);
            }

        }
    }
    public function save_occupations(Request $request)
    {
        $data = [
            'name' => $request->name
        ];
        $rules = [
           'name' => 'required|unique:tbl_occupations_type,name'
        ];
        
        $validator = Validator::make($data, $rules);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if($request->type ==0)
        {
            $action =  $this->apiModel->insertData('tbl_occupations_type',$data);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Occupations added Successfully !!!');
               echo json_encode($data);
            }
        }
        else
        {
            $where['id'] = $request->id;
            $action =  $this->apiModel->updateData('tbl_occupations_type',$data,$where);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Occupations updated Successfully !!!');
               echo json_encode($data);
            }
            else
            {
                $data = array('status'=> 'failed',
                'success_message'=>'Occupations Not updated  !!!');
               echo json_encode($data);
            }

        }
    }
    public function save_created_by(Request $request)
    {
        $data = [
            'name' => $request->name
        ];
        $rules = [
           'name' => 'required|unique:tbl_created_by,name'
        ];
        
        $validator = Validator::make($data, $rules);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if($request->type ==0)
        {
            $action =  $this->apiModel->insertData('tbl_created_by',$data);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Created by added Successfully !!!');
               echo json_encode($data);
            }
        }
        else
        {
            $where['id'] = $request->id;
            $action =  $this->apiModel->updateData('tbl_created_by',$data,$where);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Created by updated Successfully !!!');
               echo json_encode($data);
            }
            else
            {
                $data = array('status'=> 'failed',
                'success_message'=>'Created by Not updated  !!!');
               echo json_encode($data);
            }

        }
    }
    public function save_income(Request $request)
    {
        $data = [
            'name' => $request->name
        ];
        $rules = [
           'name' => 'required|unique:tbl_income,name'
        ];
        
        $validator = Validator::make($data, $rules);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if($request->type ==0)
        {
            $action =  $this->apiModel->insertData('tbl_income',$data);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Income added Successfully !!!');
               echo json_encode($data);
            }
        }
        else
        {
            $where['id'] = $request->id;
            $action =  $this->apiModel->updateData('tbl_income',$data,$where);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Income updated Successfully !!!');
               echo json_encode($data);
            }
            else
            {
                $data = array('status'=> 'failed',
                'success_message'=>'Income Not updated  !!!');
               echo json_encode($data);
            }

        }
    }

    public function edit_caste($caste_id = 0)
    {
        $data['page_name'] = 'Caste Edit';
        $data['caste_data'] = $this->homeModel->fetchCaste($caste_id);
        $data['religion_data'] = DB::table('religions')->get();
        return view('form.edit_caste',$data);
    }
    public function add_caste()
    {
        $data['page_name'] = 'Caste Add';      
        $data['religion_data'] = DB::table('religions')->get();
        return view('form.add_caste',$data);
    }


    public function save_edit_castes(Request $request)
    {
        $data = [
            'name' => $request->name,
            'religion_id' => $request->religion_id
        ];
        $rules = [
           'name' => 'required',
           'religion_id' => 'required'
        ];
        
        $validator = Validator::make($data, $rules);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if($request->type ==0)
        {
            $action =  $this->apiModel->insertData('castes',$data);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Caste added Successfully !!!');
               echo json_encode($data);
            }
        }
        else
        {
            $where['id'] = $request->id;
            $action =  $this->apiModel->updateData('castes',$data,$where);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Caste updated Successfully !!!');
               echo json_encode($data);
            }
            else
            {
                $data = array('status'=> 'failed',
                'success_message'=>'Caste Not updated  !!!');
               echo json_encode($data);
            }

        }
    }


    public function add_packages()
    {
        $data['page_name'] = 'Package Add'; 
        return view('form.add_packages',$data);
    }

    public function edit_packages($package_id = 0)
    {
        $data['page_name'] = 'Package Edit';   
        $data['package_data'] = DB::table('packages')->where('id',$package_id)->get();
        return view('form.edit_packages',$data);
    }


    public function save_packages(Request $request)
    {
        $data = [
            'package_name' => $request->package_name,
            'price' => $request->price,
            'description' => $request->description,
            'view_member' => $request->view_member,
        ];
        $rules = [
           'package_name' => 'required',
           'price' => 'required',
           'description' => 'required',
           'view_member' => 'required'
        ];
        
        $validator = Validator::make($data, $rules);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

                     $directory = public_path('uploads/packages');
                            if (!File::exists($directory)) {
                                File::makeDirectory($directory, 0777, true);
                            }
                           if ($request->hasFile('imageUrl')) {
           
                                    $file = $request->file('imageUrl');
                                   $path = $file->store('uploads/packages', 'public');
                                    $relativePath ='storage/app/public/'. $path; 
                                    $data['imageUrl'] =  $relativePath;
                            }



        if($request->type ==0)
        {
            $action =  $this->apiModel->insertData('packages',$data);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Packages added Successfully !!!');
               echo json_encode($data);
            }
        }
        else
        {
            $where['id'] = $request->id;
            $action =  $this->apiModel->updateData('packages',$data,$where);

            if ($action) {

                $data = array('status'=> 'success',
                'success_message'=>'Packages updated Successfully !!!');
               echo json_encode($data);
            }
            else
            {
                $data = array('status'=> 'failed',
                'success_message'=>'Packages Not updated  !!!');
               echo json_encode($data);
            }

        }
    }

}
