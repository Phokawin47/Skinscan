@extends('layouts.app')
@section('title','Edit User')

@push('styles')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush
@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@section('content')
<div class="container py-4" style="max-width:760px;">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h5 mb-0">แก้ไขผู้ใช้ #{{ $user->id }}</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">ย้อนกลับ</a>
  </div>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif

  <form method="post" action="{{ route('admin.users.update',$user) }}" class="needs-validation" novalidate>
    @csrf
    @method('PUT')

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Username <span class="text-danger">*</span></label>
        <input name="username" class="form-control" value="{{ old('username',$user->username) }}" required>
        <div class="invalid-feedback">กรอก Username</div>
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Email <span class="text-danger">*</span></label>
        <input name="email" type="email" class="form-control" value="{{ old('email',$user->email) }}" required>
        <div class="invalid-feedback">กรอก Email ให้ถูกต้อง</div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">First name</label>
        <input name="first_name" class="form-control" value="{{ old('first_name',$user->first_name) }}">
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Last name</label>
        <input name="last_name" class="form-control" value="{{ old('last_name',$user->last_name) }}">
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Role <span class="text-danger">*</span></label>
      <select name="role_id" class="form-select" required>
        @foreach($roles as $r)
          <option value="{{ $r->role_id }}" @selected(old('role_id',$user->role_id)==$r->role_id)>
            {{ $r->role_name }}
          </option>
        @endforeach
      </select>
      <div class="form-text">บทบาท: general / product_manager / admin</div>
      <div class="invalid-feedback">เลือก Role</div>
    </div>

    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-primary">บันทึก</button>
      <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">ยกเลิก</a>
    </div>
  </form>
</div>

{{-- Bootstrap client-side validation helper --}}
<script>
(() => {
  'use strict';
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', e => {
      if (!form.checkValidity()) {
        e.preventDefault(); e.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>
@endsection
