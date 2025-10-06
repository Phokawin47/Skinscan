@extends('layouts.app')
@section('title','Admin • Users')

@push('styles')
  {{-- Bootstrap + Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <style>
    /* ========== Minimal Light look (เฉพาะหน้านี้) ========== */
    .admin-users-page {
      --bg: #f7f8fc; --surface:#fff; --border:#e5e7eb; --text:#111827;
    }
    .admin-users-page { background:var(--bg); color:var(--text); }

    /* ป้าย Role มองชัด (ดำ/ขาว) */
    .role-pill{
      display:inline-flex; align-items:center; gap:.35rem;
      padding:.32rem .66rem; border-radius:999px;
      font-weight:700; font-size:.85rem; line-height:1;
      border:1px solid #111;
    }
    .role-pill.is-filled{ background:#111; color:#fff; }
    .role-pill.is-empty{ background:#fff; color:#111; }
    /* ให้ตารางอ่านง่าย */
    .table > :not(caption) > * > * { padding:1rem 1rem; }
    thead th{ font-weight:800; letter-spacing:.02em; }
  </style>
@endpush

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@section('content')
<div class="admin-users-page">
  <div class="container py-4" style="max-width:1200px;">

    <div class="d-flex align-items-center justify-content-between mb-3">
      <h1 class="h4 mb-0">Users</h1>
    </div>

    @if(session('ok'))
      <div class="alert alert-success">{{ session('ok') }}</div>
    @endif

    {{-- Search & Filter --}}
    <form method="get" class="row gy-2 gx-2 mb-3">
      <div class="col-lg-6">
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
          <input name="q" value="{{ $q }}" class="form-control" placeholder="ค้นหา: username / email / first/last name">
        </div>
      </div>
      <div class="col-lg-3">
        <select name="role_id" class="form-select">
          <option value="">-- ทุกบทบาท --</option>
          @foreach($roles as $r)
            <option value="{{ $r->role_id }}" @selected($role==$r->role_id)>{{ $r->role_name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-lg-3 d-flex gap-2">
        <button class="btn btn-primary">ค้นหา</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">ล้าง</a>
      </div>
    </form>

    <div class="table-responsive rounded-3 border border-1">
      <table class="table table-hover align-middle mb-0 bg-white">
        <thead class="table-light position-sticky top-0" style="z-index:1;">
          <tr>
            <th style="width:72px" class="text-end">ID</th>
            <th>Username / Email</th>
            <th>ชื่อ - สกุล</th>
            <th style="width:160px">Role</th>
            <th style="width:190px">Created</th>
            <th style="width:110px"></th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $u)
            @php $roleName = optional($u->role)->role_name; @endphp
            <tr>
              <td class="text-end">{{ $u->id }}</td>
              <td>
                <div class="fw-semibold">{{ $u->username }}</div>
                <div class="text-muted small">{{ $u->email }}</div>
              </td>
              <td>{{ $u->first_name }} {{ $u->last_name }}</td>
              <td>
                <span class="role-pill {{ $roleName ? 'is-filled' : 'is-empty' }}">
                  {{ $roleName ?? '—' }}
                </span>
              </td>
              <td class="text-muted small">{{ $u->created_at }}</td>
              <td class="text-end">
                <a href="{{ route('admin.users.edit',$u) }}" class="btn btn-sm btn-outline-secondary rounded-pill">แก้ไข</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">ไม่พบข้อมูลผู้ใช้</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $users->links() }}
    </div>
  </div>
</div>
@endsection
