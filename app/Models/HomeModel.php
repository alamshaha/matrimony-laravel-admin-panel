<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class HomeModel extends Model
{
    //
   public function fetchCaste($caste_id=0)
        {

            if($caste_id != 0)
            {
                return $records = DB::table('castes')
                ->join('religions', 'castes.religion_id', '=', 'religions.id')
                ->select('castes.*', 'religions.name as religion_name')
                ->where('castes.id',$caste_id)->get();
            }
             return $records = DB::table('castes')
                ->join('religions', 'castes.religion_id', '=', 'religions.id')
                ->select('castes.*', 'religions.name as religion_name')
                ->paginate(10); // 10 records per page
        }

        public function fetchMembers()
        {
                return DB::table('members')
                ->select([
                    'members.*', DB::raw('DATE_FORMAT(members.birthdate, "%d-%b-%Y") AS birthdate'), 'about_us.about_us',
                    'tbl_occupations_type.name as occu_type_name', 'occupations.about_occupations', 'countries.name as country_name',
                    'states.name as state_name', 'cities.name as city_name', 'religions.name as religion_name', 'castes.name as caste_name',
                    'sub_castes.name as subcaste_name', 'educations.degree', 'educations.university', 'tbl_gender.name as gender_name',
                    'tbl_height.name as height_name', 'tbl_marital_status.name as marital_status_name', 'tbl_created_by.name as created_name',
                    'tbl_income.name as income_name'
                ])
                ->leftJoin('countries', 'countries.id', '=', 'members.countries')
                ->leftJoin('states', 'states.id', '=', 'members.states')
                ->leftJoin('educations', 'educations.member_id', '=', 'members.id')
                ->leftJoin('about_us', 'about_us.member_id', '=', 'members.id')
                ->leftJoin('occupations', 'occupations.member_id', '=', 'members.id')
                ->leftJoin('tbl_occupations_type', 'tbl_occupations_type.id', '=', 'occupations.occupation_type')
                ->leftJoin('cities', 'cities.id', '=', 'members.cities')
                ->leftJoin('religion_details', 'members.id', '=', 'religion_details.member_id')
                ->leftJoin('religions', 'religions.id', '=', 'religion_details.religion_id')
                ->leftJoin('castes', 'castes.id', '=', 'religion_details.caste_id')
                ->leftJoin('sub_castes', 'sub_castes.id', '=', 'religion_details.subcaste_id')
                ->leftJoin('tbl_gender', 'members.gender', '=', 'tbl_gender.id')
                ->leftJoin('tbl_height', 'members.height', '=', 'tbl_height.id')
                ->leftJoin('tbl_marital_status', 'members.marital_status', '=', 'tbl_marital_status.id')
                ->leftJoin('tbl_income', 'occupations.annual_income', '=', 'tbl_income.id')
                ->leftJoin('tbl_created_by', 'members.created_by', '=', 'tbl_created_by.id')               
                 ->paginate(5); 
        }

        public function fetchCastewiseMembers($caste_id=0)
        {
                return DB::table('members')
                ->select([
                    'members.*', DB::raw('DATE_FORMAT(members.birthdate, "%d-%b-%Y") AS birthdate'), 'about_us.about_us',
                    'tbl_occupations_type.name as occu_type_name', 'occupations.about_occupations', 'countries.name as country_name',
                    'states.name as state_name', 'cities.name as city_name', 'religions.name as religion_name', 'castes.name as caste_name',
                    'sub_castes.name as subcaste_name', 'educations.degree', 'educations.university', 'tbl_gender.name as gender_name',
                    'tbl_height.name as height_name', 'tbl_marital_status.name as marital_status_name', 'tbl_created_by.name as created_name',
                    'tbl_income.name as income_name'
                ])
                ->leftJoin('countries', 'countries.id', '=', 'members.countries')
                ->leftJoin('states', 'states.id', '=', 'members.states')
                ->leftJoin('educations', 'educations.member_id', '=', 'members.id')
                ->leftJoin('about_us', 'about_us.member_id', '=', 'members.id')
                ->leftJoin('occupations', 'occupations.member_id', '=', 'members.id')
                ->leftJoin('tbl_occupations_type', 'tbl_occupations_type.id', '=', 'occupations.occupation_type')
                ->leftJoin('cities', 'cities.id', '=', 'members.cities')
                ->leftJoin('religion_details', 'members.id', '=', 'religion_details.member_id')
                ->leftJoin('religions', 'religions.id', '=', 'religion_details.religion_id')
                ->join('castes', 'castes.id', '=', 'religion_details.caste_id')
                ->leftJoin('sub_castes', 'sub_castes.id', '=', 'religion_details.subcaste_id')
                ->leftJoin('tbl_gender', 'members.gender', '=', 'tbl_gender.id')
                ->leftJoin('tbl_height', 'members.height', '=', 'tbl_height.id')
                ->leftJoin('tbl_marital_status', 'members.marital_status', '=', 'tbl_marital_status.id')
                ->leftJoin('tbl_income', 'occupations.annual_income', '=', 'tbl_income.id')
                ->leftJoin('tbl_created_by', 'members.created_by', '=', 'tbl_created_by.id')     
                ->where('castes.id',$caste_id)          
                 ->paginate(5); 
        }
        public function fetchGenderwiseMembers($gender_id=0)
        {
                return DB::table('members')
                ->select([
                    'members.*', DB::raw('DATE_FORMAT(members.birthdate, "%d-%b-%Y") AS birthdate'), 'about_us.about_us',
                    'tbl_occupations_type.name as occu_type_name', 'occupations.about_occupations', 'countries.name as country_name',
                    'states.name as state_name', 'cities.name as city_name', 'religions.name as religion_name', 'castes.name as caste_name',
                    'sub_castes.name as subcaste_name', 'educations.degree', 'educations.university', 'tbl_gender.name as gender_name',
                    'tbl_height.name as height_name', 'tbl_marital_status.name as marital_status_name', 'tbl_created_by.name as created_name',
                    'tbl_income.name as income_name'
                ])
                ->leftJoin('countries', 'countries.id', '=', 'members.countries')
                ->leftJoin('states', 'states.id', '=', 'members.states')
                ->leftJoin('educations', 'educations.member_id', '=', 'members.id')
                ->leftJoin('about_us', 'about_us.member_id', '=', 'members.id')
                ->leftJoin('occupations', 'occupations.member_id', '=', 'members.id')
                ->leftJoin('tbl_occupations_type', 'tbl_occupations_type.id', '=', 'occupations.occupation_type')
                ->leftJoin('cities', 'cities.id', '=', 'members.cities')
                ->leftJoin('religion_details', 'members.id', '=', 'religion_details.member_id')
                ->leftJoin('religions', 'religions.id', '=', 'religion_details.religion_id')
                ->leftJoin('castes', 'castes.id', '=', 'religion_details.caste_id')
                ->leftJoin('sub_castes', 'sub_castes.id', '=', 'religion_details.subcaste_id')
                ->leftJoin('tbl_gender', 'members.gender', '=', 'tbl_gender.id')
                ->leftJoin('tbl_height', 'members.height', '=', 'tbl_height.id')
                ->leftJoin('tbl_marital_status', 'members.marital_status', '=', 'tbl_marital_status.id')
                ->leftJoin('tbl_income', 'occupations.annual_income', '=', 'tbl_income.id')
                ->leftJoin('tbl_created_by', 'members.created_by', '=', 'tbl_created_by.id')     
                ->where('members.gender',$gender_id)          
                 ->paginate(5); 
        }

}