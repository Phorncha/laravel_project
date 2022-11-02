<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           <h1>หมวดบริการ</h1>   

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
                                <div class="card-header">ตารางบริการ</div>
                             
                                    <table class="table table-bordered border-primary">
                                    <thead>
                                        <tr>
                                        <th scope="col">ลำดับ</th>
                                        <th scope="col">ภาพ</th>
                                        <th scope="col">ชื่อบริการ</th>
                                        <th scope="col">Created_At</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($service as $row)
                                        <tr>
                                            <th>{{$service->firstitem()+$loop->index}}</th> <!--เรียงหมายเลขหน้า-->
                                            <td>
                                                <img src="{{asset($row->service_image)}}"alt="" width="100px" height="100px">

                                            </td>
                                            <td>{{$row->service_name}}</td>
                                            <td>
                                                @if($row->created_at == NULL)
                                                ไม่ถูกนิยาม
                                                @else
                                                {{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
                                                @endif
                                            </td>
                                            <!--แก้ไขข้อมูล-->
                                            <td>
                                            <a href="{{url('/service/edit/'.$row->id)}}"class="btn btn-primary">แก้ไข</a>
                                            </td>
                                            <!--ลบข้อมูลเข้าถังขยะ แบบsoftdelete-->
                                            <td>
                                            <a href="{{url('/service/delete/'.$row->id)}}" class="btn btn-danger"
                                            onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่ ?')"
                                            >ลบข้อมูล</a>
                                            </td>
                                        </tr>
                                     @endforeach
                                    </tbody>
                                </table>
                                {{$service->links()}}
                            </div>

                   </div>             
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">แบบฟอร์มบริการ</div>
                                <div class="card-body">
                                    <form action="{{route('addService')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div for="from-group">
                                            <label for="service_name">ชื่อบริการ</label>
                                            <input type="text" class="form-control"name="service_name">
                                        </div>
                                        <!--แจ้งเตือน error-->
                                        @error('service_name')
                                            <div class="my-2">
                                            <span class="text-danger my-2">{{$message}}</span>
                                            </div>
                                        @enderror
                                        <div class="form-group">
                                            <label for="service_image">ภาพประกอบ</label>
                                            <input type="file" class="form-control"name="service_image">
                                        </div>
                                        <!--แจ้งเตือน error-->
                                        @error('service_image')
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
