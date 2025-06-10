<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApiModel extends Model
{
    // Define the table name (optional if not following Laravel's conventions)
    protected $table = 'members';

    // Get rows from a specific table with an optional condition
    public function getRows($column_name = '*', $table_name, $where = [], $limit = 0)
    {
        $query = DB::table($table_name)->select($column_name);

        // Apply where conditions if provided
        if (!empty($where)) {
            $query->where($where);
        }

        // Apply limit if provided
        if ($limit > 0) {
            $query->limit($limit);
        }

        return $query->get()->toArray(); // Return results as an array
    }

    // Insert data into a table and return the last inserted ID
    public function insertData($table_name, $data = [])
    {
        $inserted = DB::table($table_name)->insertGetId($data);

        return $inserted ? $inserted : false;
    }

    // Update data in a table based on a condition
    public function updateData($table_name, $data, $where)
    {
        $updated = DB::table($table_name)->where($where)->update($data);
        
        return $updated > 0;
    }

    // Delete data from a table based on a condition
    public function deleteData($table_name, $where)
    {
        $deleted = DB::table($table_name)->where($where)->delete();
        
        return $deleted > 0;
    }

    // Get a member by their ID with detailed joined data
    public function getMemberById($id)
    {
        return DB::table('members')
            ->select([
                 'members.*','religion_details.*', 'about_us.*', 'educations.*', 'occupations.*', 'lifestyles.*', 'family_details.*', 
                'countries.name as country_name', 'states.name as state_name', 'cities.name as city_name',
                'religions.name as religion_name', 'castes.name as caste_name', 'sub_castes.name as subcaste_name',
                'members.id as member_final_id','tbl_height.name as height_name'
            ])
            ->leftJoin('countries', 'countries.id', '=', 'members.countries')
            ->leftJoin('states', 'states.id', '=', 'members.states')
            ->leftJoin('cities', 'cities.id', '=', 'members.cities')
            ->leftJoin('religion_details', 'members.id', '=', 'religion_details.member_id')
            ->leftJoin('religions', 'religions.id', '=', 'religion_details.religion_id')
            ->leftJoin('castes', 'castes.id', '=', 'religion_details.caste_id')
            ->leftJoin('sub_castes', 'sub_castes.id', '=', 'religion_details.subcaste_id')
            ->leftJoin('about_us', 'members.id', '=', 'about_us.member_id')
            ->leftJoin('educations', 'members.id', '=', 'educations.member_id')
            ->leftJoin('occupations', 'members.id', '=', 'occupations.member_id')
            ->leftJoin('lifestyles', 'members.id', '=', 'lifestyles.member_id')
            ->leftJoin('family_details', 'members.id', '=', 'family_details.member_id')
            ->leftJoin('tbl_height', 'members.height', '=', 'tbl_height.id')
            ->where('members.id', $id)
            ->get()
            ->toArray(); // Return results as an array
    }

    // Get multiple members with an optional where condition
    public function getMembers($where = [])
    {
        return DB::table('members')
            ->select([
                'members.*', 'countries.name as country_name', 'states.name as state_name', 'cities.name as city_name',
                'religions.name as religion_name', 'castes.name as caste_name', 'sub_castes.name as subcaste_name',
                'tbl_height.name as height_name'
            ])
            ->leftJoin('countries', 'countries.id', '=', 'members.countries')
            ->leftJoin('states', 'states.id', '=', 'members.states')
            ->leftJoin('cities', 'cities.id', '=', 'members.cities')
            ->leftJoin('religion_details', 'members.id', '=', 'religion_details.member_id')
            ->leftJoin('religions', 'religions.id', '=', 'religion_details.religion_id')
            ->leftJoin('castes', 'castes.id', '=', 'religion_details.caste_id')
            ->leftJoin('sub_castes', 'sub_castes.id', '=', 'religion_details.subcaste_id')
            ->leftJoin('tbl_height', 'members.height', '=', 'tbl_height.id')
            ->where('photo', '!=', '')
            ->where($where)
            ->limit(100)
            ->get()
            ->toArray(); // Return results as an array
    }

    // Get multiple members with an optional where condition and shortlisted data
    public function getMembersShortFavourite($where = [])
    {
        return DB::table('members')
            ->select([
                'members.*', 'countries.name as country_name', 'states.name as state_name', 'cities.name as city_name',
                'religions.name as religion_name', 'castes.name as caste_name', 'sub_castes.name as subcaste_name',
                'tbl_height.name as height_name'
            ])
            ->leftJoin('countries', 'countries.id', '=', 'members.countries')
            ->leftJoin('states', 'states.id', '=', 'members.states')
            ->leftJoin('cities', 'cities.id', '=', 'members.cities')
            ->leftJoin('religion_details', 'members.id', '=', 'religion_details.member_id')
            ->leftJoin('religions', 'religions.id', '=', 'religion_details.religion_id')
            ->leftJoin('castes', 'castes.id', '=', 'religion_details.caste_id')
            ->leftJoin('sub_castes', 'sub_castes.id', '=', 'religion_details.subcaste_id')
            ->leftJoin('tbl_height', 'members.height', '=', 'tbl_height.id')
            ->leftJoin('shortlists', 'shortlists.user_id', '=', 'members.id')
            ->where($where)
            ->limit(100)
            ->get()
            ->toArray(); // Return results as an array
    }

    // Get single user details with related data
    public function getSingleUser($where = [])
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
            ->where($where)
            ->where('photo', '!=', '')
            ->limit(1)
            ->get()
            ->toArray(); // Return results as an array
    }

    // Custom query
    public function queryData($query)
    {
        return DB::select(DB::raw($query));
    }
}
