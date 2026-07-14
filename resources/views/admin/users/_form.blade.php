@php
    /** @var \App\Models\User|null $user */
    $user = $user ?? null;

    $val = function(string $key, $default = '') use ($user) {
        return old($key, $user?->{$key} ?? $default);
    };
@endphp

<div class="row g-4">

    {{-- LEFT FORM --}}
    <div class="col-lg-8">

        {{-- NAME --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">
                Nama <span class="text-danger">*</span>
            </label>

            <input
                type="text"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ $val('name') }}"
                placeholder="Masukkan nama user"
                required
            >

            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>


        {{-- EMAIL --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">
                Email <span class="text-danger">*</span>
            </label>

            <input
                type="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ $val('email') }}"
                placeholder="Masukkan email"
                required
            >

            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>


        {{-- PASSWORD --}}
        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    Password {{ $user ? '' : '*' }}
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="{{ $user ? 'Biarkan kosong jika tidak diganti' : 'Masukkan password' }}"
                    {{ $user ? '' : 'required' }}
                >

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                @if($user)
                    <div class="text-muted small mt-1">
                        Kosongkan jika tidak ingin mengganti password.
                    </div>
                @endif
            </div>


            {{-- PASSWORD CONFIRM --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    Konfirmasi Password {{ $user ? '' : '*' }}
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Ulangi password"
                    {{ $user ? '' : 'required' }}
                >
            </div>

        </div>


        {{-- ROLE --}}
        <div class="mt-3">

            <label class="form-label fw-semibold">
                Role <span class="text-danger">*</span>
            </label>

            <select
                name="role_id"
                class="form-select @error('role_id') is-invalid @enderror"
                required
            >
                <option value="">-- Pilih Role --</option>

                @foreach($roles as $role)
                    <option
                        value="{{ $role->id }}"
                        @selected((string) old('role_id', $user?->role_id) === (string) $role->id)
                    >
                        {{ $role->name }} ({{ $role->slug }})
                    </option>
                @endforeach

            </select>

            @error('role_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>

    </div>



    {{-- RIGHT INFO PANEL --}}
    <div class="col-lg-4">

        <div class="border rounded-4 p-3">

            <div class="fw-bold mb-2">
                Informasi
            </div>

            <div class="text-muted small">

                • Hanya **superadmin** yang bisa membuat dan mengubah user.  
                • Role menentukan akses menu admin.  
                • Admin tidak bisa mengubah role superadmin.

            </div>

        </div>

    </div>

</div>