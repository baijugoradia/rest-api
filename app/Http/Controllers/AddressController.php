<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    //
    public function create(Request $request)
    {
        $data = $request->json()->all();
        $validator = Validator($data, [
            "address" => ['string', 'required'],
            "address2" => ['string', 'required'],
            "district" => ['string', 'required'],
            "city" => ['string', 'required'],
            "pincode" => ['integer', 'required'],
            "employee_id" => ['integer', 'required', Rule::exists('employee', 'employee_id')],
        ]);
        if ($validator->errors()->isNotEmpty()) {
            return response()->json($validator->errors()->all());
        }
        $address = new Address();
        if (isset($data['address'])) {
            $address->address = $data['address'];
        }
        if (isset($data['address2'])) {
            $address->address2 = $data['address2'];
        }
        if ($data['district']) {
            $address->district = $data['district'];
        }
        if ($data['city']) {
            $address->city = $data['city'];
        }
        if (isset($data['pincode'])) {
            $address->pincode = $data['pincode'];
        }

        if (isset($data['employee_id'])) {
            $address->employee_id = $data['employee_id'];
        }


        if ($address->save()) {
            return response()->json(Address::where('addresses_id', $address->addresses_id)->get());
        }
    }

    public function update($id, Request $request)
    {
        $data = $request->json()->all();
        $validator = Validator($data, [
            "addresses_id" => [
                'required_with:address.*.address,address.*.address2,address.*.district,address.*.city,address.*.pincode',
                'integer'
            ],
            "address" => ['string', 'nullable'],
            "address2" => ['string', 'nullable'],
            "district" => ['string', 'nullable'],
            "city" => ['string', 'nullable'],
            "pincode" => ['integer', 'nullable'],
        ]);
        if ($validator->errors()->isNotEmpty()) {
            return response()->json($validator->errors()->all());
        }

        $address = Address::where('addresses_id', $id)->first();

        if (isset($data['address'])) {
            $address->address = $data['address'];
        }
        if (isset($data['address2'])) {
            $address->address2 = $data['address2'];
        }
        if ($data['district']) {
            $address->district = $data['district'];
        }
        if ($data['city']) {
            $address->city = $data['city'];
        }
        if (isset($data['pincode'])) {
            $address->pincode = $data['pincode'];
        }


        if ($address->save()) {
            return response()->json(Address::where('addresses_id', $address->addresses_id)->get());
        }
    }

    public function delete($id)
    {
        $address = Address::where('addresses_id', $id);
        if (count($address->get())) {
            $address->delete();
            return response()->json(["deleted" => true]);
        } else {
            return response()->json(["message" => 'no such contact'], 404);
        }
    }
}
