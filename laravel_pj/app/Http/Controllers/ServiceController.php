<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Carbon\Carbon;


class ServiceController extends Controller
{
    public function index(){
        $service =Service::paginate(3); //แบ่งหน้า
        return view('admin.service.index',compact('service'));
    } 
        
    public function edit($id){
        $service =Service::find($id);
        return view('admin.service.edit',compact('service'));
    }

    public function update(Request $request , $id){
        //การตรวจสอบข้อมูล และแสดงข้อความกรณีที่ error ไม่ใส่ข้อความ
        $request->validate(      //คำสั่ง Validate ป้องกันการพิมพ์ซ้ำ
            [
               'service_name'=>'required|max:255',
              
            ],
            [
                'service_name.required'=>"กรุณาป้อนชื่อบริการ",
                'service_name.max'=> "ป้อนข้อความได้ไม่เกิน 255 ตัวอักษร",
            ]
        );
            $service_image = $request->file('service_image');

                //อัพเดตภาพและชื่อ
                if($service_image){
                    // /generate ชื่อภาพ
                    $name_gen=hexdec(uniqid());
                    //ดึงนามสกุลๆฟล์ภาพ
                    $img_ext = strtolower($service_image->getclientoriginalExtension());
                    $img_name = $name_gen.'.'.$img_ext;
 
                    //อัพโหลดและอัพเดตข้อมูล
                    $upload_location = 'image/services/';
                    $full_path = $upload_location.$img_name;

                   
                     //อัพเดตข้อมูล
                     Service::find($id)->update([
                        'service_name'=>$request->service_name,
                        'service_image'=>$full_path,
                        
                    ]);

                     // ลบภาพเก่าและอัพภาพใหม่แทนที่
                     $old_image = $request->old_image;
                    unlink($old_image);
                    $service_image->move($upload_location,$img_name);
                    return redirect()->route('service')->with('success',"อัพเดตภาพเสร็จสิ้น");
                }else{
                    //อัพเดตภาพและชื่อ
                    Service::find($id)->update([
                        'service_name'=>$request->service_name,
                    ]);
                    return redirect()->route('service')->with('success',"อัพเดตชื่อบริการเสร็จสิ้น");
                }
    }

    public function store(Request $request){

        //การตรวจสอบข้อมูล และแสดงข้อความกรณีที่ error ไม่ใส่ข้อความ
        $request->validate(      //คำสั่ง Validate ป้องกันการพิมพ์ซ้ำ
         [
            'service_name'=>'required|unique:services|max:255',
            'service_image'=>'required|mimes:jpe,jpeg,png'
         ],
         [
         'service_name.required'=>"กรุณาป้อนชื่อบริการ",
         'service_name.max'=> "ป้อนข้อความได้ไม่เกิน 255 ตัวอักษร",
         'service_name.unique'=>"มีข้อมูลในฐานบริการแล้ว",
         'service_image.required'=>"กรุณาใส่ภาพประกอบการบริการ"
         ]
         );
         //เข้ารหัสภาพ
         $service_image = $request->file('service_image');

         // /generate ชื่อภาพ
         $name_gen=hexdec(uniqid());
        //ดึงนามสกุลๆฟล์ภาพ
        $img_ext = strtolower($service_image->getclientoriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;

        //อัพโหลดและบันทึก
        $upload_location = 'image/services/';
        $full_path = $upload_location.$img_name;
        
       Service::insert([
            'service_name'=>$request->service_name,
            'service_image'=>$full_path,
            'created_at'=>Carbon::now()
        ]);
        $service_image->move($upload_location,$img_name);
        return redirect()->back()->with('success',"บันทึกเสร็จสิ้น");   
    }
        public function delete($id){
            //ลบภาพ
            $img = Service::find($id)->service_image;
            unlink($img);
            //ลบข้อมูลจากฐานข้อมูล
            $delete = Service::find($id)->Delete();
            return redirect()->back()->with('success',"ลบข้อมูลเรียบร้อย");
        } 
        
     
}
