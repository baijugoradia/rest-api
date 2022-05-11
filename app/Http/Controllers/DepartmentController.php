<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    //
    public function create(Request $request)
    {
        $data = $request->json()->all();
        $validator = Validator($data, [
            "name" => ['string', 'required']
        ]);
        if ($validator->errors()->isNotEmpty()) {
            return response()->json($validator->errors()->all());
        }
        $department = new Department();
        $department->name = $data['name'];
        if ($department->save()) {
            return response()->json(Department::where('departments_id', $department->departments_id)->get());
        }
    }

    public function list()
    {
        return response()->json(Department::all());
    }

    public function update($id, Request $request)
    {
        $data = $request->json()->all();
        $validator = Validator($data, [
            "name" => ['string', 'required']
        ]);
        if ($validator->errors()->isNotEmpty()) {
            return response()->json($validator->errors()->all());
        }

        $department = Department::where('departments_id', $id)->first();

        $department->name = $data['name'];
        if ($department->save()) {
            return response()->json(Department::where('departments_id', $department->departments_id)->get());
        }
    }

    public function delete($id)
    {
        $department = Department::where('departments_id', $id);
        $employees = Employee::where("departments_id", $id);
        if (count($employees->get())) {
            return response()->json(["message" => "this department is linked to employee"], 401);
        }
        if (count($department->get())) {
            $department->delete();
            return response()->json(["deleted" => true]);
        } else {
            return response()->json(["message" => 'no such department'], 404);
        }
    }
}
