@extends('layouts.app')

@section('title', 'جدول الأعضاء')

@section('content')

<div class="card">
    
    <div class="card-header d-flex justify-content-between align-items-center">

        <h6 class="mb-0">جدول الاعضاء</h6>

        <button 
            class="btn btn-sm btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#addUserModal">

            + إضافة عضو

        </button>

    </div>

    <div class="table-responsive">
        
        <table class="table align-items-center mb-0">

            <thead>
                <tr>
                    <th>الرقم</th>
                    <th>العضو</th>
                    <th>الوظيفة</th>
                    <th>الحالة</th>
                    <th>تاريخ التوظيف</th>
                    <th>الاجراءت</th>
                </tr>
            </thead>

            <tbody>

                @foreach($users as $user)

                <tr>
                     <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>

                    <td>عضو</td>

                    <td>
                        @if($user->status == 'active')
                            <span class="text-success">نشط</span>
                        @else
                            <span class="text-danger">غير نشط</span>
                        @endif
                    </td>

                    <td>{{ $user->created_at->format('Y-m-d') }}</td>

                    <td>

                        <button 
                            class="btn btn-sm btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#editUserModal{{ $user->id }}">

                            تعديل الحالة

                        </button>
                        <a 
                            href="{{ route('users.statement', $user->id) }}"
                            target="_blank"
                            class="btn btn-sm btn-dark">

                            طباعة الكشف

                        </a>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

{{-- Modals --}}
@foreach($users as $user)

<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">

            {{-- Header --}}
            <div class="modal-header bg-dark text-white" style="border-radius: 15px 15px 0 0;">

                <h6 class="mb-0 text-white">تعديل حالة العضو</h6>

            </div>

            {{-- Body --}}
            <form method="POST" action="{{ url('/users/'.$user->id) }}">

                @csrf
                @method('PUT')

                <div class="modal-body p-4">

                    {{-- اسم العضو --}}
                    <div class="card card-plain mb-3">

                        <div class="card-body p-2">

                            <label class="form-label text-xs">اسم العضو</label>

                            <input 
                                type="text"
                                class="form-control"
                                value="{{ $user->name }}"
                                disabled>

                        </div>

                    </div>

                    {{-- الحالة --}}
                    <div class="card card-plain">

                        <div class="card-body p-2">

                            <label class="form-label text-xs">
                                حالة الاشتراك
                            </label>

                            <select name="status" class="form-control">

                                <option 
                                    value="active"
                                    {{ $user->status == 'active' ? 'selected' : '' }}>

                                    🟢 نشط

                                </option>

                                <option 
                                    value="inactive"
                                    {{ $user->status == 'inactive' ? 'selected' : '' }}>

                                    🔴 متوقف

                                </option>

                            </select>

                        </div>

                    </div>

                </div>

                {{-- Footer --}}
                <div class="modal-footer border-0 px-4 pb-4">

                    <button 
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">

                        إلغاء

                    </button>

                    <button 
                        type="submit"
                        class="btn btn-success shadow-sm">

                        حفظ التعديل

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endforeach
{{-- Add User Modal --}}
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">

            <div class="modal-header bg-primary text-white" style="border-radius: 15px 15px 0 0;">

                <h6 class="mb-0 text-white">إضافة عضو جديد</h6>

            </div>

            <form method="POST" action="{{ route('users.store') }}">

                @csrf

                <div class="modal-body p-4">

                    {{-- اسم العضو --}}
                    <div class="mb-3">

                        <label class="form-label">اسم العضو</label>

                        <input 
                            type="text"
                            name="name"
                            class="form-control"
                            required>

                    </div>

                    {{-- كلمة المرور --}}
                    <div class="mb-3">

                        <label class="form-label">رقم الهاتف</label>

                        <input 
                            type="phone"
                            name="phone"
                            class="form-control"
                            required>

                    </div>

                    {{-- الحالة --}}
                    <div>

                        <label class="form-label">الحالة</label>

                        <select name="status" class="form-control">

                            <option value="active">🟢 نشط</option>

                            <option value="inactive">🔴 متوقف</option>

                        </select>

                    </div>

                </div>

                <div class="modal-footer border-0 px-4 pb-4">

                    <button 
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">

                        إلغاء

                    </button>

                    <button 
                        type="submit"
                        class="btn btn-success">

                        حفظ العضو

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
@endsection