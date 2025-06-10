<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\ApiModel;
use Illuminate\Support\Facades\File;

class Authentication extends Controller
{
      protected $apiModel;
    //
    public function __construct()
    {
        $this->apiModel = new ApiModel();
    }

    public function authenticate(Request $request)
    {
		
		
                try {
        
                $validator = Validator::make($request->all(), [
                    'mobile' => 'required',
                    'password' => 'required|string|min:6',
                ]);
        
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $validator->errors(),
                    ], 422);
                }
        
                $where['members.mobile'] = $request->mobile;
                $where['members.password'] = md5($request->password); // Caution: Use bcrypt in real apps
        
                $users = $this->apiModel->getRows('*', 'members', $where);
                $user_data =[];
                if($users)
                {
                     $user_data = $this->apiModel->getMemberById($users[0]->id);
                }
                if (empty($users)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid mobile number or password',
                    ], 401);
                }
                return response()->json([
                    'status' => 'success',
                    'message' => 'Authenticated successfully',
                    'data' => $user_data,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Something went wrong. ' . $e->getMessage(),
                ], 500);
            }
    }
    
    public function checkMobileExist(Request $request)
            {
                 try {
                        $validator = Validator::make($request->all(), [
                            'mobile' => 'required'
                        ]);
                
                        if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'message' => $validator->errors(),
                            ], 422);
                        }
                        $mobile = $request->mobile;
                        $where['members.mobile'] = $mobile;
                        $users = $this->apiModel->getRows('*', 'members', $where);
                
                        if (empty($users)) {
                            return response()->json([
                                  'status' => 200,
                                'message' => 'Mobile Number is unique',
                            ], 200);
                        }
                    
                 
                       if (!empty($users)) {
                            return response()->json([
                                  'status' => 404,
                                'message' => 'Mobile Number is exist',
                            ], 404);
                        }
                        return response()->json($response);
                    } catch (\Exception $e) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Something went wrong. ' . $e->getMessage(),
                        ], 500);
                    }
            }
    
        public function forgetPassword(Request $request)
            {
                 try {
                        $validator = Validator::make($request->all(), [
                            'mobile' => 'required'
                        ]);
                
                        if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'message' => $validator->errors(),
                            ], 422);
                        }
                        $mobile = $request->mobile;
                        $where['members.mobile'] = $mobile;
                        $users = $this->apiModel->getRows('*', 'members', $where);
                
                        if (empty($users)) {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Invalid mobile number or password',
                            ], 401);
                        }
                    
                    $otp = rand(100000, 999999);

                        // Optional: Save OTP to database
            
                        $response = [
                            'status' => 200,
                            'message' => 'OTP generated successfully.' .$otp,
                            'otp' => $otp,
                            'mobile' => $mobile
                        ];
                        
                        return response()->json($response);
                    } catch (\Exception $e) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Something went wrong. ' . $e->getMessage(),
                        ], 500);
                    }
            }
            
            public function updatePassword(Request $request)
                {
                    try {
                        // Validate input
                        $validated = $request->validate([
                            'mobile' => 'required',
                            'password' => 'required|min:6',
                        ]);
                
                        $mobile = $request->mobile;
                        $password = md5($request->password); // ⚠️ MD5 not recommended for production
                
                        // Update password in members table
                        $updated = DB::table('members')
                                    ->where('mobile', $mobile)
                                    ->update(['password' => $password]);
                                    
                            return response()->json([
                                'status' => 200,
                                'message' => 'Password updated successfully.'
                            ], 200);
                            
                        if ($updated) {
                           
                        } else {
                            return response()->json([
                                'status' => 404,
                                'message' => 'Mobile number not found or no change made.'
                            ], 404);
                        }
                    } catch (\Exception $e) {
                        return response()->json([
                            'status' => 500,
                            'message' => 'An error occurred: ' . $e->getMessage()
                        ], 500);
                    }
                }
                
                public function getUsers(Request $request, $gender = 0, $featured = 0)
                    {
                        try {
                            // Flip gender logic like in original
                            $gender = ($gender == 1) ? 2 : 1;
                            
                            // return response()->json([
                            //     'status' => false,
                            //     'message' => 'An error occurred: ' .$gender
                            // ], 500);
                            
                             //$gender =1;
                            $where = [
                                'members.featured' => $featured,
                                'members.status' => 1,
                                'members.gender' => $gender,
                            ];
                    
                            // Assuming ApiModel is injected or instantiated elsewhere
                            $users = $this->apiModel->getMembers($where);
                    
                            if (!empty($users)) {
                                return response()->json($users, 200);
                            } else {
                                return response()->json([
                                    'status' => false,
                                    'message' => 'No user was found.'
                                ], 404);
                            }
                        } catch (\Exception $e) {
                            return response()->json([
                                'status' => false,
                                'message' => 'An error occurred: ' . $e->getMessage()
                            ], 500);
                        }
                    }
                    
                    public function search_user(Request $request, $religion_id = 0, $caste_id = 0, $height_start = 0, $height_end = 0)
                    {
                        try {
                            $users = DB::table('members')
                                ->join('religions', 'members.religion_id', '=', 'religions.id')
                                ->join('castes', 'members.caste_id', '=', 'castes.id')
                                ->where('members.status', 1)
                                ->where('religions.id', $religion_id)
                                ->where('castes.id', $caste_id)
                                ->whereBetween('members.height', [$height_start, $height_end])
                                ->select('members.*') // select fields as needed
                                ->get();
                    
                            if ($users->isNotEmpty()) {
                                return response()->json($users, 200);
                            } else {
                                return response()->json([
                                    'status' => false,
                                    'message' => 'No user was found.'
                                ], 404);
                            }
                        } catch (\Exception $e) {
                            return response()->json([
                                'status' => false,
                                'message' => 'An error occurred: ' . $e->getMessage()
                            ], 500);
                        }
                    }
                    
                    public function user_with_caste(Request $request, $gender = 0, $caste_id = 0)
                    {
                          $gender = ($gender == 1) ? 2 : 1;
                        try {
                            $users = DB::table('members')
                                ->join('religions', 'members.religion_id', '=', 'religions.id')
                                ->join('castes', 'members.caste_id', '=', 'castes.id')
                                ->where('members.status', 1)
                                ->where('castes.id', $caste_id)
                               ->where('members.gender', $gender)
                                ->select('members.*') // select fields as needed
                                ->get();
                    
                            if ($users->isNotEmpty()) {
                                return response()->json($users, 200);
                            } else {
                                return response()->json([
                                    'status' => false,
                                    'message' => 'No user was found.'
                                ], 404);
                            }
                        } catch (\Exception $e) {
                            return response()->json([
                                'status' => false,
                                'message' => 'An error occurred: ' . $e->getMessage()
                            ], 500);
                        }
                    }
                    
                    public function single_user(Request $request, $id = 0, $viewed_member_id = 0)
                    {
                        try {
                            $flag = 0;
                    
                            // Check if user already viewed this profile
                            $alreadyViewed = DB::table('tbl_who_viewed')
                                ->where('member_id', $id)
                                ->where('viewed_member_id', $viewed_member_id)
                                ->exists();
                    
                            if ($alreadyViewed) {
                                $flag = 2;
                            } else {
                                // Fetch the viewed member
                                $viewedMember = DB::table('members')->where('id', $viewed_member_id)->first();
                    
                                if ($viewedMember) {
                                    if ($viewedMember->view_member < 1 && $viewed_member_id != $id) {
                                        return response()->json([
                                            'status' => 'plan_expired',
                                            'message' => 'Upgrade your plan !!!'
                                        ], 403);
                                    } else {
                                        // Log the view (only if not self-view)
                                        if ($viewed_member_id != $id) {
                                            DB::table('tbl_who_viewed')->insert([
                                                'member_id' => $id,
                                                'viewed_member_id' => $viewed_member_id,
                                                'date' => now()->toDateString()
                                            ]);
                    
                                            // Decrease remaining views
                                            DB::table('members')
                                                ->where('id', $viewed_member_id)
                                                ->decrement('view_member');
                                        }
                    
                                        $flag = 2;
                                    }
                                }
                            }
                    
                            if ($flag == 2) {
                                // Fetch the actual member info
                                // $user = DB::table('members')
                                //     ->where('id', $id)
                                //     ->where('status', 1)
                                //     ->first();
                                
                                $where['members.id'] =$id;
                        		 $where['members.status'] =1;
                                 $user = $this->apiModel->getMemberById($id);
                    
                                if ($user) {
                                    return response()->json($user, 200);
                                } else {
                                    return response()->json([
                                        'status' => false,
                                        'message' => 'No user was found.'
                                    ], 404);
                                }
                            }
                    
                        } catch (\Exception $e) {
                            return response()->json([
                                'status' => false,
                                'message' => 'An error occurred: ' . $e->getMessage()
                            ], 500);
                        }
                    }
                    
                    
           public function pages($id = 0)
                {
                    try {
                        if ($id > 0) {
                            $page = DB::table('pages')->where('id', $id)->first();
                        } else {
                            $page = DB::table('pages')->get();
                        }
                
                        if ($page) {
                            return response()->json($page, 200);
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'No page was found.'
                            ], 404);
                        }
                
                    } catch (\Exception $e) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Something went wrong.',
                            'error' => $e->getMessage()
                        ], 500);
                    }
                }  
           public function notifications($id = 0)
                {
                    try {
                        if ($id > 0) {
                            $page = DB::table('notifications')->where('user_id', $id)->first();
                        } else {
                            $page = DB::table('notifications')->get();
                        }
                
                        if ($page) {
                            return response()->json($page, 200);
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'No page was found.'
                            ], 404);
                        }
                
                    } catch (\Exception $e) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Something went wrong.',
                            'error' => $e->getMessage()
                        ], 500);
                    }
                }       
                
            public function packages()
                {
                    try {
                        $packages = DB::table('packages')
                            ->select('id', 'package_name as name', 'imageUrl as photo', 'price', 'description')
                            ->get();
                
                        if ($packages->isNotEmpty()) {
                            return response()->json($packages, 200);
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'No packages were found.'
                            ], 404);
                        }
                
                    } catch (\Exception $e) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Something went wrong.',
                            'error' => $e->getMessage()
                        ], 500);
                    }
                }
                
            public function getSuccessStories()
            {
                try {
                    $stories = DB::table('tbl_success_stories')
                        ->select('id', 'name', 'imageUrl as photo', 'description')
                        ->get();
            
                    if ($stories->isNotEmpty()) {
                        return response()->json($stories, 200);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'No success stories were found.'
                        ], 404);
                    }
            
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Something went wrong.',
                        'error' => $e->getMessage()
                    ], 500);
                }
            }

        public function fetchReligion($religion_id = 0)
        {
            try {
                $records = DB::table('religions')
                    ->select('id', 'name')
                    ->get();
        
                $res = [];
        
                foreach ($records as $r) {
                    $res[] = [
                        'id' => (int) $r->id,
                        'name' => $r->name
                    ];
                }
        
                return response()->json($res, 200);
        
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong.',
                    'error' => $e->getMessage()
                ], 500);
            }
        }
        
        public function fetchCaste($religion_id = 0)
        {
            try {
                $records = DB::table('castes')
                    ->select('id', 'name')
                    ->where('religion_id',$religion_id)
                    ->get();
        
                $res = [];
        
                foreach ($records as $r) {
                    $res[] = [
                        'id' => (int) $r->id,
                        'name' => $r->name
                    ];
                }
        
                return response()->json($res, 200);
        
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong.',
                    'error' => $e->getMessage()
                ], 500);
            }
        }
        
        public function fetchGender()
        {
            try {
                $records = DB::table('tbl_gender')
                    ->select('id', 'name')
                    ->get();
        
                $res = [];
        
                foreach ($records as $r) {
                    $res[] = [
                        'id' => (int) $r->id,
                        'name' => $r->name
                    ];
                }
        
                return response()->json($res, 200);
        
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong.',
                    'error' => $e->getMessage()
                ], 500);
            }
        }
        
        public function fetchCreated_by()
        {
            try {
                $records = DB::table('tbl_created_by')
                    ->select('id', 'name')
                    ->get();
        
                $res = [];
        
                foreach ($records as $r) {
                    $res[] = [
                        'id' => (int) $r->id,
                        'name' => $r->name
                    ];
                }
        
                return response()->json($res, 200);
        
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong.',
                    'error' => $e->getMessage()
                ], 500);
            }
        }
        
        public function fetchOccupations()
            {
                try {
                    $records = DB::table('tbl_occupations_type')
                        ->select('id', 'name')
                        ->get();
            
                    $res = [];
            
                    foreach ($records as $r) {
                        $res[] = [
                            'id' => (int) $r->id,
                            'name' => $r->name
                        ];
                    }
            
                    return response()->json($res, 200);
            
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Something went wrong.',
                        'error' => $e->getMessage()
                    ], 500);
                }
            }
            
            public function fetchIncome()
            {
                try {
                    $records = DB::table('tbl_income')
                        ->select('id', 'name')
                        ->get();
            
                    $res = [];
            
                    foreach ($records as $r) {
                        $res[] = [
                            'id' => (int) $r->id,
                            'name' => $r->name
                        ];
                    }
            
                    return response()->json($res, 200);
            
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Something went wrong.',
                        'error' => $e->getMessage()
                    ], 500);
                }
            }
            
             public function fetchHeight()
                {
                    try {
                        $records = DB::table('tbl_height')
                            ->select('id', 'name')
                            ->get();
                
                        $res = [];
                
                        foreach ($records as $r) {
                            $res[] = [
                                'id' => (int) $r->id,
                                'name' => $r->name
                            ];
                        }
                
                        return response()->json($res, 200);
                
                    } catch (\Exception $e) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Something went wrong.',
                            'error' => $e->getMessage()
                        ], 500);
                    }
                }
                
            public function fetchMarital_status()
            {
                try {
                    $records = DB::table('tbl_marital_status')->select('id', 'name')->get();
            
                    $res = [];
                    foreach ($records as $r) {
                        $res[] = [
                            'id' => (int) $r->id,
                            'name' => $r->name
                        ];
                    }
            
                    return response()->json($res, 200);
                } catch (\Exception $e) {
                    return response()->json([
                        'error' => true,
                        'message' => 'Failed to fetch marital status.',
                        'details' => $e->getMessage()
                    ], 500);
                }
            }    
            
            public function getMembersShortFavourite($from_user_id, $flag)
            {
                try {
                    $users = DB::table('shortlists')
                        ->join('members', 'shortlists.to_user_id', '=', 'members.id')
                        ->where('shortlists.from_user_id', $from_user_id)
                        ->where('shortlists.flag', $flag)
                        ->where('members.status', 1)
                        ->select('members.*') // or specific fields if needed
                        ->get();
            
                    if ($users->isNotEmpty()) {
                        
                                if($flag==1)
                                {
                               
                                     $data = [
                                        'sender_id' => $request->input('my_id'),
                                        'receiver_id' => $request->input('to_id'),
                                        'chat_request_status' => 'Accept',
                                    ];
                                
                                    $insert = DB::table('chat_request')->insert($data);
                                }
                                
                                
                        return response()->json($users, 200);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'No users were found.'
                        ], 404);
                    }
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Something went wrong while fetching data.',
                        'error' => $e->getMessage()
                    ], 500);
                }
            }
            
            
            public function contact_us(Request $request)
                {
                    $request->validate([
                        'name' => 'required|string|max:255',
                        'email' => 'required|email|max:255',
                        'mobile' => 'required|string|max:20',
                        'description' => 'required|string',
                    ]);
                
                    try {
                        DB::table('contact_us')->insert([
                            'name' => $request->input('name'),
                            'email' => $request->input('email'),
                            'mobile' => $request->input('mobile'),
                            'description' => $request->input('description'),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                
                        return response()->json([
                            'status' => true,
                            'message' => 'Form submitted successfully.'
                        ], 200);
                    } catch (\Exception $e) {
                        // Log::error('Contact Us Submission Error: ' . $e->getMessage());
                
                        return response()->json([
                            'status' => false,
                            'message' => $e->getMessage()
                        ], 400);
                    }
                }
                
            public function user(Request $request)
                {
                    $validator = Validator::make($request->all(), [
                        'name' => 'required|string|max:255',
                        'mobile' => 'required|string|max:20|unique:members,mobile',
                        'email' => 'required|email|max:255',
                        'birthdate' => 'required|date',
                        'password' => 'required|string|min:6',
                        'mother_tongue' => 'nullable|string|max:255',
                       // 'weight' => 'required',
                        'height' => 'required',
                        'gender' => 'required',
                        'marital_status' => 'required|string|max:50',
                        'created_by' => 'required|integer',
                        // Related data
                        'religion_id' => 'required|integer',
                        'caste_id' => 'required|integer',
                        'education' => 'required|string|max:255',
                        'about' => 'nullable|string',
                        'occupation_type' => 'required',
                        'annual_income' => 'required|string|max:50',
                       // 'occupation' => 'required'
                    ]);
                
                    if ($validator->fails()) {
                        return response()->json([
                            'status' => false,
                            'message' => $validator->errors()->first()
                        ], 400);
                    }
                
                    try {
                        DB::beginTransaction();
                
                        $dob = $request->input('birthdate');
                        $age = date('Y') - date('Y', strtotime($dob));
                
                        $userData = [
                            'name' => $request->input('name'),
                            'mobile' => $request->input('mobile'),
                            'email' => $request->input('email'),
                            'birthdate' => $dob,
                            'password' => md5($request->input('password')), // You may consider Hash::make() if not tied to legacy system
                            'mother_tongue' => $request->input('mother_tongue'),
                            'weight' => 80,//$request->input('weight'),
                            'height' => $request->input('height'),
                            'gender' => $request->input('gender'),
                            'marital_status' => $request->input('marital_status'),
                            'created_by' => $request->input('created_by'),
                            'age' => $age,
                            'last_package_date'=>date('Y-m-d'),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                
                        $memberId = DB::table('members')->insertGetId($userData);
                
                        // Insert/Update related details
                        DB::table('religion_details')->updateOrInsert(
                            ['member_id' => $memberId],
                            ['religion_id' => $request->input('religion_id'), 'caste_id' => $request->input('caste_id'), 'manglik' => 'No', 'gothra' => 'Abcd', 'created_at' => now(),
                            'updated_at' => now()]
                        );
                
                        DB::table('educations')->updateOrInsert(
                            ['member_id' => $memberId],
                            ['degree' => $request->input('education'), 'created_at' => now(),
                            'updated_at' => now()]
                        );
                
                        DB::table('about_us')->updateOrInsert(
                            ['member_id' => $memberId],
                            ['about_us' => $request->input('about_us'),'hobby' => 'Chess','birthplace' =>'Khodashi','birthdate' =>'2024-10-15'
                            ,'birthtime' => '10:10:10', 'created_at' => now(),
                            'updated_at' => now()]
                        );
                
                        DB::table('occupations')->updateOrInsert(
                            ['member_id' => $memberId],
                            [
                                'occupation_type' => $request->input('occupation_type'),
                                'annual_income' => $request->input('annual_income'),
                                'about_occupations' =>'About Occupation',// $request->input('occupation'),
                                'created_at' => now(),
                                'updated_at' => now()
                            ]
                        );
                        
                          $directory = public_path('uploads/' . $memberId);
                            if (!File::exists($directory)) {
                                File::makeDirectory($directory, 0777, true);
                            }
                           if ($request->hasFile('upload_image')) {
           
                                    $file = $request->file('upload_image');
                                   $path = $file->store('uploads/'.$memberId, 'public');
                                    $relativePath ='storage/app/public/'. $path; 
                              
                    
                                DB::table('members')
                                    ->where('id', $memberId)
                                    ->update(['photo' => $relativePath]);
                            }
                        
                
                        DB::commit();
                
                        return response()->json([
                            'status' => true,
                            'message' => 'Your registration was successful. Your member ID is: ' . $memberId
                        ], 200);
                
                    } catch (\Exception $e) {
                        DB::rollBack();
                       // Log::error('User registration error: ' . $e->getMessage());
                
                        return response()->json([
                            'status' => false,
                            'message' => $e->getMessage()
                        ], 400);
                    }
                }
                
                public function chats_member($user_id = 0)
                    {
                        try {
                            $records = DB::table('members')
                                ->join('chat_request', function ($join) use ($user_id) {
                                    $join->on('chat_request.sender_id', '=', 'members.id')
                                        ->orOn('chat_request.receiver_id', '=', 'members.id');
                                })
                                ->where(function ($query) use ($user_id) {
                                    $query->where('chat_request.sender_id', $user_id)
                                          ->orWhere('chat_request.receiver_id', $user_id);
                                })
                                ->where('chat_request.chat_request_status', 'Accept')
                                ->where('members.id', '!=', $user_id)
                                //->groupBy('chat_request.receiver_id', 'chat_request.sender_id')
                                ->select('members.*', 'chat_request.*')
                                ->get();
                    
                            return response()->json($records);
                        } catch (\Exception $e) {
                            return response()->json([
                                'error' => true,
                                'message' => 'Failed to retrieve chat members.',
                                'details' => $e->getMessage()
                            ], 500);
                        }
                    }
                    
                    public function chats($sender_user_id = 0, $user_id = 0)
                        {
                            try {
                                // Set character set for utf8mb4 manually if needed (usually configured in database.php)
                                DB::statement("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
                        
                                $records = DB::table('chats')
                                    ->select([
                                        'id as id',
                                        'message',
                                        'attachment',
                                        'sender_user_id',
                                        'chat_thread_id'
                                    ])
                                    ->where(function ($query) use ($sender_user_id) {
                                        $query->where('sender_user_id', $sender_user_id)
                                              ->orWhere('chat_thread_id', $sender_user_id);
                                    })
                                    ->where(function ($query) use ($user_id) {
                                        $query->where('sender_user_id', $user_id)
                                              ->orWhere('chat_thread_id', $user_id);
                                    })
                                    ->orderBy('id', 'desc')
                                    ->get();
                        
                                return response()->json($records);
                            } catch (\Exception $e) {
                                return response()->json([
                                    'error' => true,
                                    'message' => 'Failed to retrieve chat records.',
                                    'details' => $e->getMessage()
                                ], 500);
                            }
                        }
                        
                public function chatsData(Request $request,$to_member_id = 0, $member_id = 0)
                    {
                        // Optional: Validate the request
                        $validator = Validator::make($request->all(), [
                            'message' => 'required|string'
                        ]);
                    
                        if ($validator->fails()) {
                            return response()->json([
                                'status' => false,
                                'message' => 'Validation failed.',
                                'errors' => $validator->errors()
                            ], 422);
                        }
                    
                        try {
                            $attachment = '';
                             $directory = public_path('uploads/' . $member_id.'/chat_images');
                                if (!File::exists($directory)) {
                                    File::makeDirectory($directory, 0777, true);
                                }
                                
                            if ($request->hasFile('attachement')) {
           
                                    $file = $request->file('attachement');
                                   $path = $file->store('uploads/'.$member_id.'/chat_images', 'public');
                                    $attachment ='storage/app/public/'. $path;
                            }
                            
                            
                            // Set character encoding (usually not needed if database config uses utf8mb4)
                            DB::statement("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
                    
                            // Prepare chat data
                            $chatData = [
                                'message' => $request->input('message'),
                                 'attachment' =>$attachment,
                                'sender_user_id' => $member_id,
                                'chat_thread_id' => $to_member_id,
                                'created_at' => now(), // optional if you have timestamps enabled
                                'updated_at' => now()
                            ];
                    
                            // Insert into the database
                            $inserted = DB::table('chats')->insert($chatData);
                    
                            if ($inserted) {
                                return response()->json([
                                    'status' => true,
                                    'message' => 'Chat submitted successfully.'
                                ], 200);
                            } else {
                                return response()->json([
                                    'status' => false,
                                    'message' => 'Failed to submit chat. Please try again.'
                                ], 400);
                            }
                    
                        } catch (\Exception $e) {
                            return response()->json([
                                'status' => false,
                                'message' => 'An error occurred.',
                                'details' => $e->getMessage()
                            ], 500);
                        }
                    }
                    
               public function profileRequest(Request $request)
                {
                    try {
                        $myId = $request->input('my_id');
                        $toId = $request->input('to_id');
                        $requestType = $request->input('request_type');
                        
                        $message= "Your request Proceesed successfully!!!";
                        // Check if the user is trying to interact with themselves
                        if ($myId == $toId) {
                            return response()->json([
                                'status' => 'warning',
                                'message' => 'You can\'t do this process'
                            ]);
                        }
                
                        $where = [
                            'from_user_id' => $myId,
                            'to_user_id' => $toId,
                            'flag' => $requestType
                        ];
                
                        $exists = DB::table('shortlists')->where($where)->exists();
                
                        if ($exists) {
                             return response()->json([
                                    'status' => false,
                                    'message' => 'Already done this process !!!.'
                                ], 400);
                        }
                
                        // Insert into shortlists table
                        DB::table('shortlists')->insert($where);
                
                        // $message = match ($requestType) {
                        //     1 => 'Chat request sent successfully!',
                        //     2 => 'Favourite Successfully!',
                        //     3 => 'Shortlisted Successfully !!!',
                        //     default => 'Request processed.',
                        // };
                
                        // If it's a chat request, also insert into chat_request table
                        if ($requestType == 1) {
                            DB::table('chat_request')->insert([
                                'sender_id' => $myId,
                                'receiver_id' => $toId,
                                'chat_request_status' => 'Accept'
                            ]);
                        }
                
                        return response()->json([
                            'status' => 'success',
                            'message' => $message
                        ]);
                
                    } catch (\Exception $e) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Something went wrong.',
                            'error' => $e->getMessage()
                        ], 500);
                    }
                }     
                   
            
              public function paymentUpdate(Request $request)
                {
                    
                     try {
                        $user_id = $request->input('user_id');
                        $package_id = $request->input('package_id');
                        $transaction_id = $request->input('transaction_id');
                        $payment_status = $request->input('payment_status');
                        $amount = $request->input('amount');
                        $message= "Your payment updated successfully!!!";
                      
                      
                                     $update = DB::table('members')
                                        ->where('id', $user_id)
                                        ->increment('view_member', 100);
                                        if($update > 0)
                                        {
                                                return response()->json([
                                                    'status' => 'success',
                                                    'message' => $message
                                                ]);    
                                        }
                                        else
                                        {
                                              return response()->json([
                                                    'status' => false,
                                                    'message' => 'Failed'
                                                ]); 
                                        }
                
                    } catch (\Exception $e) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Something went wrong.',
                            'error' => $e->getMessage()
                        ], 500);
                    }
                    
                }
            public function my_profile($id = 0)
                {
                    try {
                                 $where['members.id'] =$id;
                        		 $where['members.status'] =1;
                                 $user = $this->apiModel->getMemberById($id);
                    
                                if ($user) {
                                    return response()->json($user, 200);
                                } else {
                                    return response()->json([
                                        'status' => false,
                                        'message' => 'No user was found.'
                                    ], 404);
                                }
                
                    } catch (\Exception $e) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Something went wrong.',
                            'error' => $e->getMessage()
                        ], 500);
                    }
                }         
                
            public function user_update(Request $request)
                {
                    $validator = Validator::make($request->all(), [
                        'name' => 'required|string|max:255',
                        //'mobile' => 'required|string|max:20|unique:members,mobile',
                        'email' => 'required|email|max:255',
                        'birthdate' => 'required|date',
                       // 'password' => 'required|string|min:6',
                        'mother_tongue' => 'nullable|string|max:255',
                       // 'weight' => 'required',
                        'height' => 'required',
                        'gender' => 'required',
                        'marital_status' => 'required|string|max:50',
                        //'created_by' => 'required|integer',
                        // Related data
                        'religion_id' => 'required|integer',
                        'caste_id' => 'required|integer',
                        'education' => 'required|string|max:255',
                        'about' => 'nullable|string',
                        'occupation_type' => 'required',
                        'annual_income' => 'required|string|max:50',
                       // 'occupation' => 'required'
                    ]);
                
                    if ($validator->fails()) {
                        return response()->json([
                            'status' => false,
                            'message' => $validator->errors()->first()
                        ], 400);
                    }
                
                    try {
                        DB::beginTransaction();
                
                        $dob = $request->input('birthdate');
                        $age = date('Y') - date('Y', strtotime($dob));
                
                        $userData = [
                            'name' => $request->input('name'),
                           // 'mobile' => $request->input('mobile'),
                            'email' => $request->input('email'),
                            'birthdate' => $dob,
                            'password' => md5($request->input('password')), // You may consider Hash::make() if not tied to legacy system
                            'mother_tongue' => $request->input('mother_tongue'),
                            'weight' => 80,//$request->input('weight'),
                            'height' => $request->input('height'),
                            'gender' => $request->input('gender'),
                            'marital_status' => $request->input('marital_status'),
                            //'created_by' => $request->input('created_by'),
                            'age' => $age,
                            'last_package_date'=>date('Y-m-d'),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        $memberId = $request->input('memberID');
                        DB::table('members')->where('id',$memberId)->update($userData);
                
                        // Insert/Update related details
                        DB::table('religion_details')->updateOrInsert(
                            ['member_id' => $memberId],
                            ['religion_id' => $request->input('religion_id'), 'caste_id' => $request->input('caste_id'), 'manglik' => 'No', 'gothra' => 'Abcd', 'created_at' => now(),
                            'updated_at' => now()]
                        );
                
                        DB::table('educations')->updateOrInsert(
                            ['member_id' => $memberId],
                            ['degree' => $request->input('education'), 'created_at' => now(),
                            'updated_at' => now()]
                        );
                
                        DB::table('about_us')->updateOrInsert(
                            ['member_id' => $memberId],
                            ['about_us' => $request->input('about_us'),'hobby' => 'Chess','birthplace' =>'Khodashi','birthdate' =>'2024-10-15'
                            ,'birthtime' => '10:10:10', 'created_at' => now(),
                            'updated_at' => now()]
                        );
                
                        DB::table('occupations')->updateOrInsert(
                            ['member_id' => $memberId],
                            [
                                'occupation_type' => $request->input('occupation_type'),
                                'annual_income' => $request->input('annual_income'),
                                'about_occupations' =>'About Occupation',// $request->input('occupation'),
                                'created_at' => now(),
                                'updated_at' => now()
                            ]
                        );
                        
                     $directory = public_path('uploads/' . $memberId);
                    if (!File::exists($directory)) {
                        File::makeDirectory($directory, 0777, true);
                    }
                           if ($request->hasFile('upload_image')) {
           
                                    $file = $request->file('upload_image');
                                   $path = $file->store('uploads/'.$memberId, 'public');
                                    $relativePath ='backend/storage/app/public/'. $path; 
                              
                    
                                DB::table('members')
                                    ->where('id', $memberId)
                                    ->update(['photo' => $relativePath]);
                            }
                        
                
                        DB::commit();
                
                        return response()->json([
                            'status' => true,
                            'message' => 'Your updated successful. Your member ID is: ' . $memberId
                        ], 200);
                
                    } catch (\Exception $e) {
                        DB::rollBack();
                       // Log::error('User registration error: ' . $e->getMessage());
                
                        return response()->json([
                            'status' => false,
                            'message' => $e->getMessage()
                        ], 400);
                    }
                }    
                
                 public function settings($id = 0)
                {
                    try {
                        if ($id > 0) {
                            $page = DB::table('settings')->where('id', $id)->first();
                        } else {
                            $page = DB::table('settings')->get();
                        }
                
                        if ($page) {
                            return response()->json($page, 200);
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'No settings was found.'
                            ], 404);
                        }
                
                    } catch (\Exception $e) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Something went wrong.',
                            'error' => $e->getMessage()
                        ], 500);
                    }
                }  
                            
}
