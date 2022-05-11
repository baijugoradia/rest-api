<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class ContactController extends Controller
{
    //
    public function create(Request $request)
    {
        $data = $request->json()->all();
        $validator = Validator($data, [
            "country_code" => ['string', 'required'],
            "phone" => ['string', 'required'],
            "employee_id" => ['integer', 'required', Rule::exists('employee', 'employee_id')],
        ]);
        if ($validator->errors()->isNotEmpty()) {
            return response()->json($validator->errors()->all());
        }
        $contact = new Contact();
        $contact->country_code = $data['country_code'];
        $contact->phone = $data['phone'];
        $contact->employee_id = $data['employee_id'];
        if ($contact->save()) {
            return response()->json(Contact::where('contacts_id', $contact->contacts_id)->get());
        }
    }

    public function update($id, Request $request)
    {
        $data = $request->json()->all();
        $validator = Validator($data, [
            "country_code" => ['string', 'required'],
            "phone" => ['string', 'required'],
        ]);
        if ($validator->errors()->isNotEmpty()) {
            return response()->json($validator->errors()->all());
        }

        $contact = Contact::where('contacts_id', $id)->first();
        if (isset($data['country_code'])) {
            $contact->country_code = $data['country_code'];
        }
        if (isset($data['phone'])) {
            $contact->phone = $data['phone'];
        }

        if ($contact->save()) {
            return response()->json(Contact::where('contacts_id', $contact->contacts_id)->get());
        }
    }

    public function delete($id)
    {
        $contact = Contact::where('contacts_id', $id);
        if (count($contact->get())) {
            $contact->delete();
            return response()->json(["deleted" => true]);
        } else {
            return response()->json(["message" => 'no such contact'], 404);
        }
    }
}
