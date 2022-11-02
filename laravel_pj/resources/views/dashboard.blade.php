<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           
            <h1>ผู้ใช้งานระบบ</h1>
        สวัสดี , {{Auth::user()->name}}
           
            <b class="float-end">จำนวนผู้ใช้ <span>{{count($user)}}</span>คน</b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                        <th scope="col">ลำดับ</th>
                        <th scope="col">ชื่อ</th>
                        <th scope="col">อีเมล</th>
                        <th scope="col">วันเข้าใช้ระบบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i=1)
                        @foreach($user as $row)
                        <tr>
                            <th >{{$i++}}</th>
                            <td>{{$row->name}}</td>
                            <td>{{$row->email}}</td>
                            <td>{{$row->created_at->diffForHumans()}}</td>
                        </tr>
                       @endforeach
                    </tbody>
                    </table>
            </div>
        </div>
    </div>
</x-app-layout>
