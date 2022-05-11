<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Address;
use App\Models\Employee;
use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\returnArgument;


class EmployeeController extends Controller
{
    private $searchContactsCols = ['country_code', 'phone'];
    private $searchAddressCols = ['country_code', 'phone'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = Employee::with('contact');
        if ($request->has('firstname')) {
            $employees->orWhere("firstname", "like", "%" . $request->get('firstname') . "%");
        }
        if ($request->has('lastname')) {
            $employees->orWhere("lastname", "like", "%{$request->get('lastname')}");
        }

        if ($request->has('country_code') || $request->has('phone')) {
            $employees->whereHas('contact', function (Builder $query) use ($request) {
                if ($request->has('country_code')) {
                    $query->where('country_code', '=', $request->get('country_code'), 'and');
                }
                if ($request->has('phone')) {
                    $query->where('phone', '=', $request->get('phone'));
                }
            });
        }

//        echo $employees->toSql();
//        exit;

        if ($request->has('limit')) {
            $employees->simplePaginate($request->get('limit'));
        }

        $data = $employees->get();

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->json()->all();

        $valid = Validator::make($data, array(
            'firstname' => ['string', 'required'],
            'lastname' => ['string', 'required'],
            'email' => ['unique:Employee', 'email', 'required'],
            'gender' => ['in:m,f,o'],
            'dateofjoining' => ['date', 'required'],
            "department_id" => ['required', 'integer', Rule::exists('departments', 'departments_id')],
            "contact.*.country_code" => ['nullable', 'integer'],
            "contact.*.phone" => ['numeric', 'nullable'],
            "address.*.address" => ['string', 'nullable'],
            "address.*.address2" => ['string', 'nullable'],
            "address.*.district" => ['string', 'nullable'],
            "address.*.city" => ['string', 'nullable'],
            "address.*.pincode" => ['integer', 'nullable'],
        ));

        if ($valid->errors()->isNotEmpty()) {
            return response()->json($valid->errors());
        }

        $employee = new Employee();
        $employee->firstname = $data['firstname'];
        $employee->lastname = $data['lastname'];
        $employee->gender = $data['gender'];
        $employee->email = $data['email'];
        $employee->doj = date('Y-m-d', strtotime($data['dateofjoining']));
        $employee->departments_id = $data['department_id'];

        if ($employee->save()) {
            if (isset($data['contact'])) {
                foreach ($data['contact'] as $key => $value) {
                    $contact = new Contact();
                    $contact->country_code = $value['country_code'] ?? 91;
                    $contact->phone = $value['phone'];
                    $contact->employee_id = $employee->employee_id;
                    $contact->save();
                }
            }

            if (isset($data['address'])) {
                foreach ($data['address'] as $key => $value) {
                    $address = new Address();
                    $address->address = $value['address'] ?? null;
                    $address->address2 = $value['address2'] ?? null;
                    $address->district = $value['district'] ?? null;
                    $address->city = $value['city'] ?? null;
                    $address->pincode = $value['pincode'] ?? null;
                    $address->employee_id = $employee->employee_id;
                    $address->save();
                }
            }

            return response()->json(
                Employee::with('contact')->with('address')->where('employee_id', $employee->employee_id)->get()
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return response()->json(Employee::with('contact')->with('address')->where('employee_id', $id)->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->json()->all();

        $valid = Validator::make($data, array(
            'firstname' => ['string'],
            'lastname' => ['string'],
//            'email' => ['unique:Employee', 'email'],
            'gender' => ['in:m,f,o'],
            'dateofjoining' => ['date'],
            "department_id" => ['integer', Rule::exists('departments', 'departments_id')],
            "contact.*.contacts_id" => ['required_with:contact.*.phone,contact.*.country_code,', 'integer'],
            "contact.*.country_code" => ['nullable', 'integer'],
            "contact.*.phone" => ['numeric', 'nullable'],
            "address.*.addresses_id" => [
                'required_with:address.*.address,address.*.address2,address.*.district,address.*.city,address.*.pincode',
                'integer'
            ],
            "address.*.address" => ['string', 'nullable'],
            "address.*.address2" => ['string', 'nullable'],
            "address.*.district" => ['string', 'nullable'],
            "address.*.city" => ['string', 'nullable'],
            "address.*.pincode" => ['integer', 'nullable'],
        ));

        if ($valid->errors()->isNotEmpty()) {
            return response()->json($valid->errors());
        }

        $employee = Employee::where('employee_id', $id)->first();
        if (count($employee->get()) > 0) {
            if (isset($data['firstname'])) {
                $employee->firstname = $data['firstname'];
            }
            if (isset($data['lastname'])) {
                $employee->lastname = $data['lastname'];
            }
            if (isset($data['gender'])) {
                $employee->gender = $data['gender'];
            }
//            if (isset($data['email'])) {
//                $employee->email = $data['email'];
//            }
            if (isset($data['dateofjoining'])) {
                $employee->doj = date('Y-m-d', strtotime($data['dateofjoining']));
            }
            if (isset($data['department_id'])) {
                $employee->departments_id = $data['department_id'];
            }
            $employee->save();

            if (isset($data['contact'])) {
                foreach ($data['contact'] as $key => $value) {
                    $contact = Contact::where('contacts_id', $value['contacts_id'])->where('employee_id', $id)->first();
                    if (isset($value['country_code'])) {
                        $contact->country_code = $value['country_code'] ?? 91;
                    }
                    if (isset($value['phone'])) {
                        $contact->phone = $value['phone'];
                    }
                    $contact->save();
                }
            }

            if (isset($data['address'])) {
                foreach ($data['address'] as $key => $value) {
                    $address = Address::where('addresses_id', $value['addresses_id'])->where('employee_id', $id)->first(
                    );
                    if (isset($value['address'])) {
                        $address->address = $value['address'];
                    }
                    if (isset($value['address2'])) {
                        $address->address2 = $value['address2'];
                    }
                    if (isset($value['district'])) {
                        $address->district = $value['district'];
                    }
                    if (isset($value['city'])) {
                        $address->city = $value['city'];
                    }
                    if (isset($value['pincode'])) {
                        $address->pincode = $value['pincode'];
                    }

                    $address->save();
                }
            }
            return response()->json(
                Employee::with('contact')->with('address')->where('employee_id', $employee->employee_id)->get()
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(
        $id
    ) {
        $employee = Employee::where('employee_id', $id);
        if (count($employee->get()) > 0) {
            //Employee
            $employee->delete();
            return response()->json(["deleted" => true]);
        } else {
            return response()->json(["message" => 'no such employee'], 404);
        }
    }
}
