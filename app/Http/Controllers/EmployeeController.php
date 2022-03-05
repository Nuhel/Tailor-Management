<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\BasicPersonRequest;
use App\DataTables\EmployeeDataTable;
use App\Http\Traits\BasicPersonTrait;

class EmployeeController extends Controller
{
    use BasicPersonTrait;
    public function index(EmployeeDataTable $employeeDataTable){
        return $employeeDataTable->render('components.datatable.index',['heading'=>'Employees']);
    }


    public function create()
    {
        return view('basic_person.create')->with([
            'route' => route('employees.store'),
            'personRole' => "Employee"
        ]);
    }


    public function store(BasicPersonRequest $request)
    {
        $employee = new Employee();
        return $this->redirectWithAlert($this->storePerson($request,$employee));
    }


    public function show(Employee $employee)
    {
        return view('employee.show')->with('employee',$employee);
    }


    public function edit(Employee $employee)
    {
        return view('basic_person.edit')->with([
            'route' => route('employees.update',  ['employee'=> $employee]),
            'personRole' => "Employee"
        ])->with('person',$employee);
    }


    public function update(BasicPersonRequest $request, Employee $employee)
    {
        return $this->redirectWithAlert($this->updatePerson($request,$employee));
    }

    public function destroy(Employee $employee)
    {
        return $this->redirectWithAlert($employee->delete());
    }
}
