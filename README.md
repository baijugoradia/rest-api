# REST API for Employee


# Getting started

## Installation

Clone the repository

    git clone git@github.com:baijugoradia/rest-api.git

Switch to the repo folder

    cd rest-api

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve


## Create a new Department

### Request

    POST /api/department

### Request Body (Content Type application/json)

```
{
    "name":"Dept newsasa"
}
```


### Response


```
[
    {
        "departments_id": 1,
        "name": "Dept newsasa"
    }
]
```

## Get all Department

### Request

    GET /api/department


### Response


```
[
    {
        "departments_id": 1,
        "name": "Dept newsasa"
    },
    {
        "departments_id": 2,
        "name": "IT"
    }
]
```


## Update a new Department

### Request

    PUT /api/department/{:departments_id}

### Request Body (Content Type application/json)

```
{
    "name":"New Name"
}
```


### Response


```
[
    {
        "departments_id": 1,
        "name": "New Name"
    }
]
```


## Update a new Department

### Request

    DELETE /api/department/{:departments_id}


### Response


```
[
    {
        "departments_id": 1,
        "name": "New Name"
    }
]
```


### Failure Response
If department is linked to any employee then that department ca not be deleted.

```
{
    "message": "this department is linked to employee"
}
```



## Create a new Employee

### Request

    POST /api/employee

### Request Body

```
{
    "firstname"     :   "John",
    "lastname"      :   "Doe",
    "dateofjoining" :   "11-May-2022",
    "department_id" :   1,
    "email"         :   "bassaiju@gmddsda.adssoss",
    "gender"        :   "m",
    "contact": [
        {
            "country_code"  :   92,
            "phone"         :   123434244
        }
    ],
    "address":[
        {
            "address"   :   "addres line 1",
            "address2"  :   "address line 2",
            "district"  :   "district name",
            "city"      :   "city name",
            "pincode"   :   34564546576 
        }
    ]
}
```


### Response


```
[
    {
        "employee_id"   :   1,
        "firstname"     :   "John",
        "lastname"      :   "Doe",
        "dateofjoining" :   "11-May-2022",
        "department_id" :   1,
        "email"         :   "bassaiju@gmddsda.adssoss",
        "gender"        :   "m",
        "contact": [
            {
                "contacts_id"   :   21,
                "employee_id"   :   11,
                "country_code"  :   92,
                "phone"         :   123434244
            }
        ],
        "address":[
            {
                "addresses_id"  :   21,
                "employee_id"   :   11,
                "address"       :   "addres line 1",
                "address2"      :   "address line 2",
                "district"      :   "district name",
                "city"          :   "city name",
                "pincode"       :   34564546576 
            }
        ]
    }
]
```


## Update an Employee

### Request

    PUT /api/employee/{:employee_id}

### Request Body

```
{
    "firstname"     :   "John",
    "lastname"      :   "Doe",
    "dateofjoining" :   "11-May-2022",
    "department_id" :   1,
    "gender"        :   "m",
    "contact": [
        {
            "contacts_id"   :   21,
            "country_code"  :   92,
            "phone"         :   123434244
        }
    ],
    "address":[
        {
            "addresses_id"  :   21,
            "address"       :   "addres line 1",
            "address2"      :   "address line 2",
            "district"      :   "district name",
            "city"          :   "city name",
            "pincode"       :   34564546576 
        }
    ]
}
```


### Response


```

[
    {
        "employee_id"   :   1,
        "firstname"     :   "John",
        "lastname"      :   "Doe",
        "dateofjoining" :   "11-May-2022",
        "department_id" :   1,
        "email"         :   "bassaiju@gmddsda.adssoss",
        "gender"        :   "m",
        "contact": [
            {
                "contacts_id"   :   21,
                "employee_id"   :   11,
                "country_code"  :   92,
                "phone"         :   123434244
            }
        ],
        "address":[
            {
                "addresses_id"  :   21,
                "employee_id"   :   11,
                "address"       :   "addres line 1",
                "address2"      :   "address line 2",
                "district"      :   "district name",
                "city"          :   "city name",
                "pincode"       :   34564546576 
            }
        ]
    }
]
```


## Delete an Employee

### Request

    DELETE /api/employee/{:employee_id}



### Response


```
{
    "deleted": true
}
```






## Create a new Contact

### Request

    POST /api/contact

### Request Body

```
{
    "employee_id": "12",
    "country_code":"91",
    "phone":"9032901"
}
```


### Response


```
[
    {
        "contacts_id": 25,
        "country_code": "91",
        "phone": "9032901",
        "employee_id": 12
    }
]
```


## Update an Contact

### Request

    PUT /api/contact/{:contacts_id}

### Request Body

```
{
    "employee_id": "12",
    "country_code":"91",
    "phone":"9032901"
}
```


### Response


```
[
    {
        "contacts_id": 25,
        "country_code": "91",
        "phone": "9032901",
        "employee_id": 12
    }
]
```


## Delete an Contact

### Request

    DELETE /api/contact/{:contacts_id}



### Response


```
{
    "deleted": true
}
```




## Create a new Address

### Request

    POST /api/address

### Request Body

```
{
    "employee_id":12,
    "address": "test",
    "address2": "test",
    "district": "test",
    "city": "test",
    "pincode": "3242432"

}
```


### Response


```
[
    {
        "addresses_id": 13,
        "address": "test",
        "address2": "test",
        "district": "test",
        "city": "test",
        "pincode": "3242432"
    }
]
```


## Update an Address

### Request

    PUT /api/address/{:addresses_id}

### Request Body

```
{
        "addresses_id": 13,
        "address": "test",
        "address2": "test",
        "district": "test",
        "city": "test",
        "pincode": "3242432"
    }
```


### Response


```
[
    {
        "addresses_id": 13,
        "address": "test",
        "address2": "test",
        "district": "test",
        "city": "test",
        "pincode": "3242432"
    }
]
```


## Delete an Address

### Request

    DELETE /api/address/{:addresses_id}



### Response


```
{
    "deleted": true
}
```
