<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           <h1 ><b>แผนกงาน</b></h1>   
        
           <h3 class="float-end">สวัสดี <span>{{Auth::user()->name}}</span></></h3>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
           
                   <div class="col-md-8">
                            <div class="card">
                                @if(session("success"))
                                <div class="alert alert-success">{{session('success')}}</div>
                                @endif
                                <div class="card-header">ตารางข้อมูลแผนก</div>
                             
                                    <table class="table">
                                    <thead>
                                        <tr>
                                        <th scope="col">ลำดับ</th>
                                        <th scope="col">ชื่อแผนก</th>
                                        <th scope="col">ชื่อพนักงาน</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($department as $row)
                                        <tr>
                                            <th>{{$department->firstitem()+$loop->index}}</th> <!--เรียงหมายเลขหน้า-->
                                            <td>{{$row->department_name}}</td>
                                            <td>{{$row->user->name}}</td>
                                            <!--แก้ไขข้อมูล-->
                                            <td>
                                            <a href="{{url('/department/edit/'.$row->id)}}" class="btn btn-primary">แก้ไข</a>
                                            </td>
                                            <!--ลบข้อมูลเข้าถังขยะ แบบsoftdelete-->
                                            <td>
                                            <a href="{{url('/department/softdelete/'.$row->id)}}" class="btn btn-danger">ลบข้อมูล</a>
                                            </td>
                                        </tr>
                                     @endforeach
                                    </tbody>
                                </table>
                                {{$department->links()}}
                            </div>
                            @if(count($trashDepartment)>0)
                            <div class="card my-2">
                            <div class="card-header">ถังขยะ</div>
                             
                             <table class="table">
                             <thead>
                                 <tr>
                                 <th scope="col">ลำดับ</th>
                                 <th scope="col">ชื่อแผนก</th>
                                 <th scope="col">ชื่อพนักงาน</th>
                                 <th scope="col">กู้คืนข้อมูล</th>
                                 <th scope="col">ลบข้อมูลถาวร</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($trashDepartment as $row)
                                 <tr>
                                     <th>{{$trashDepartment->firstitem()+$loop->index}}</th> <!--เรียงหมายเลขหน้า-->
                                     <td>{{$row->department_name}}</td>
                                     <td>{{$row->user->name}}</td>
                                     <!--แก้ไขข้อมูล-->
                                     <td>
                                     <a href="{{url('/department/restore/'.$row->id)}}" class="btn btn-primary">กู้คืนข้อมูล</a>
                                     </td>
                                     <!--ลบข้อมูลเข้าถังขยะ แบบsoftdelete-->
                                     <td>
                                     <a href="{{url('/department/delete/'.$row->id)}}" class="btn btn-danger"
                                     onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่ ?')"
                                     >ลบข้อมูลถาวร</a>
                                     </td>
                                 </tr> 
                              @endforeach
                             </tbody>
                         </table>
                            {{$trashDepartment->links()}}
                        </div>
                        @endif 
                   </div>             
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">แบบฟอร์ม</div>
                                <div class="card-body">
                                    <form action="{{route('addDepartment')}}" method="post">
                                        @csrf
                                        <div for="from-group">
                                            <label for="department_name">ชื่อแผนกงาน</label>
                                            <input type="text" class="form-control"name="department_name">
                                        </div>
                                        <!--แจ้งเตือน error-->
                                        @error('department_name')
                                            <div class="my-2">
                                            <span class="text-danger my-2">{{$message}}</span>
                                            </div>
                                        @enderror
                                        <br>
                                        <input type="submit" value="บันทึก" class="btn btn-primary">
                                    </form>
                                </div>
                            </div>
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>
