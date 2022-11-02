<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index(){
        $department=Department::paginate(3); //แบ่งหน้า
        $trashDepartment = Department::onlyTrashed()->paginate(3);
        return view('admin.department.index',compact('department','trashDepartment'));
    } 

    public function store(Request $request){

       //การตรวจสอบข้อมูล และแสดงข้อความกรณีที่ error ไม่ใส่ข้อความ
       $request->validate(      //คำสั่ง Validate ป้องกันการพิมพ์ซ้ำ
        [
            'department_name'=>'required|unique:departments|max:255'
        ],
        [
        'department_name.required'=>"กรุณาป้อนชื่อแผนก",
        'department_name.max'=> "ป้อนข้อความได้ไม่เกิน 255 ตัวอักษร",
        'department_name.unique'=>"มีข้อมุลในแผนกแล้ว"

        ]
        );

        //บันทึกข้อมูล
        $department = new Department;
        $department->department_name = $request->department_name;
        $department->user_id = Auth::user()->id;
        $department->save();

        return redirect()->back()->with('success',"บันทึกเสร็จสิ้น");

    }

    public function edit($id){
        $department = Department::find($id);
        return view('admin.department.edit',compact('department'));
    }

    public function update(Request $request , $id){
           //การตรวจสอบข้อมูล และแสดงข้อความกรณีที่ error ไม่ใส่ข้อความ
            $request->validate(
                [
                    'department_name'=>'required|unique:departments|max:255'
                ],
                [
                    'department_name.required'=>"กรุณาป้อนชื่อแผนก",
                    'department_name.max'=> "ป้อนข้อความได้ไม่เกิน 255 ตัวอักษร",
                    'department_name.unique'=>"มีข้อมุลในแผนกแล้ว"

                ]
            );
            $update = Department::find($id)->update([
            'department_name'=>$request->department_name,
            'user_id'=>Auth::user()->id
        ]);
        return redirect()->route('department')->with('success',"บันทึกเสร็จสิ้น");

    }

    public function softdelete($id){
        $delete = Department::find($id)->delete();
        return redirect()->back()->with('success',"ลบข้อมูลเรียบร้อย");
    }

    public function restore($id){
       $restore = Department::withTrashed()->find($id)->restore();
       return redirect()->back()->with('success',"กู้คืนข้อมูลเรียบร้อย");
    }

    public function delete($id){
       $delete = Department::onlyTrashed()->find($id)->forceDelete();
       return redirect()->back()->with('success',"ลบข้อมูลเรียบร้อย");
    }
}
