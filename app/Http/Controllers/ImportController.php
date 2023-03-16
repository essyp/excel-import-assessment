<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Imports\DataImport;
use App\Imports\EditImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ImportController extends Controller
{
    public function fetchData()
    {
        $data = User::latest()->get();
        return view('welcome', compact('data'));
    }

    public function editData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'import_file' => 'required|file|mimes:xls,xlsx,csv,txt',
        ]);
    
        if ($validator->fails()) {
            $response = array(
                "status" => "failed",
                "message" => $validator->messages()->first(),
            );
            return Response::json($response);
        }

        try {
            $path = $request->file('import_file');
            $data = Excel::toArray(new DataImport(), $path);

            $data = json_decode(json_encode($data));

            return view('edit-import', compact('data'));
            
        } catch (\Exception $e) {
            $response = array(
                "status" => "failed",
                "message" => "operation failed! - ".$e->getMessage(),
            );
            return Response::json($response);
        }       
        
    }

    public function downloadTemplate()
    {        
        $filepath = public_path('template/data-template.xlsx');
        return Response::download($filepath);
    }

    public function importData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'import_file' => 'required|file|mimes:xls,xlsx,csv,txt',
        ]);
    
        if ($validator->fails()) {
            $response = array(
                "status" => "failed",
                "message" => $validator->messages()->first(),
            );
            return Response::json($response);
        }

        try {
            $path = $request->file('import_file');
            Excel::import(new DataImport, $path);
            
           
            $response = array(
                "status" => "success",
                "message" => "operation successful!",
            );
            return Response::json($response);
        } catch (\Exception $e) {
            $response = array(
                "status" => "failed",
                "message" => "operation failed! - ".$e->getMessage(),
            );
            return Response::json($response);
        }
    }

    public function bulkAction(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|array',
            'id.*' => 'required',
        ]);
        if ($validator->fails()){
            $response = array(
                "status" => "unsuccessful",
                "message" => $validator->messages()->first(),
                );
                return Response::json($response);
        }
        $id = $request->id;
       
		if($request->submit == "delete"){
            foreach ($id as $idd) {
                User::where('id',$idd)->delete();
                $response = array(
                    "status" => "success",
                    "message" => "Operation Successful",
                );
                
            }
        }
		return Response::json($response);
    }

    public function importEditedData(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|array',
                'email.*' => 'required|unique:users,email',
                'phone_number' => 'required|array',
                'phone_number.*' => 'required|unique:users,phone_number',
                'first_name' => 'required|array',
                'first_name.*' => 'required|string',
                'last_name' => 'required|array',
                'last_name.*' => 'required|string',
            ]);
            if ($validator->fails()){
                $response = array(
                    "status" => "unsuccessful",
                    "message" => $validator->messages()->first(),
                );
                return Response::json($response);
            }  

            $batch_id = $this->unique_code(10);
            
            for($i=0; $i < count($request->first_name); $i++){
                $data = new User();
                $data->ref_id = 'RF-'.$this->unique_code(6);
                $data->batch_id = $batch_id;
                $data->first_name = $request->first_name[$i];
                $data->last_name = $request->last_name[$i];
                $data->email = $request->email[$i];
                $data->phone_number = $request->phone_number[$i];
                $data->country = $request->country[$i];
                $data->state = $request->state[$i];
                $data->city = $request->city[$i];
                $data->address = $request->address[$i];
                $data->gender = $request->gender[$i];
                $data->marital_status = $request->marital_status[$i];
                $data->save();
            }

            $response = array(
                "status" => "success",
                "message" => "operation successful!",
            );
            return Response::json($response);
        } catch (\Exception $e) {
            $response = array(
                "status" => "failed",
                "message" => "operation failed! - ".$e->getMessage(),
            );
            return Response::json($response);
        }
    }

    public function updateData(Request $request){
        try {
            $data = User::where('id', $request->id)->first();
            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->email = $request->email;
            $data->phone_number = $request->phone_number;
            $data->country = $request->country;
            $data->state = $request->state;
            $data->city = $request->city;
            $data->address = $request->address;
            $data->gender = $request->gender;
            $data->marital_status = $request->marital_status;
            $data->save();

            $response = array(
                "status" => "success",
                "message" => "operation successful!",
            );
            return Response::json($response);
        } catch (\Exception $e) {
            $response = array(
                "status" => "failed",
                "message" => "operation failed! - ".$e->getMessage(),
            );
            return Response::json($response);
        }
    }

    public function unique_code($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }
}