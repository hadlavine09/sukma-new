@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-ui-checks"></i> Edit Hak Akses</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item active"><a href="#">Edit Hak Akses</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <!-- Menampilkan pesan error jika ada -->
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('hakakses.update', $hakakses->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- This ensures that the form sends a PUT request -->

                        <div class="row mb-3">
                            <!-- Hak Akses -->
                            <div class="col-md-6">
                                <label class="form-label">Hak Akses</label>
                                <select class="form-control" name="hakakses" required>
                                    <option disabled selected hidden>Select Hakakses</option>
                                    <option value="Create"
                                        {{ $hakakses->hakakses == 'Create' ? 'selected' : '' }}
                                        {{ $hakakses_selected->contains('hakakses', 'Create') && $hakakses->hakakses != 'Create' ? 'disabled' : '' }}>Create</option>
                                    <option value="Read"
                                        {{ $hakakses->hakakses == 'Read' ? 'selected' : '' }}
                                        {{ $hakakses_selected->contains('hakakses', 'Read') && $hakakses->hakakses != 'Read' ? 'disabled' : '' }}>Read</option>
                                    <option value="Update"
                                        {{ $hakakses->hakakses == 'Update' ? 'selected' : '' }}
                                        {{ $hakakses_selected->contains('hakakses', 'Update') && $hakakses->hakakses != 'Update' ? 'disabled' : '' }}>Update</option>
                                    <option value="Delete"
                                        {{ $hakakses->hakakses == 'Delete' ? 'selected' : '' }}
                                        {{ $hakakses_selected->contains('hakakses', 'Delete') && $hakakses->hakakses != 'Delete' ? 'disabled' : '' }}>Delete</option>
                                </select>
                            </div>

                            <!-- Deskripsi -->
                            <div class="col-md-6">
                                <label class="form-label" for="description">Deskripsi</label>
                                <textarea class="form-control" name="description" rows="2" placeholder="Masukkan deskripsi hak akses">{{ old('description', $hakakses->description) }}</textarea>
                            </div>
                        </div>

                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle"></i> Simpan</button>
                            <a href="{{ route('hakakses.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@section('js_content')
<script>
    // Script untuk menghilangkan alert setelah 3 detik
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);  // 3 detik
</script>
@endsection
