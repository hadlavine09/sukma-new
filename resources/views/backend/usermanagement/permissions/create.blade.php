@extends('backend.component.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-ui-checks"></i> Tambah Permission</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item active"><a href="#">Tambah Permission</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <form id="permissionForm" action="{{ route('permission.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3" id="permissionFields">
                            <div class="col-md-6">
                                <label class="form-label">Tipe Permission</label>
                                <select class="form-control" name="permission_type" id="permissionType">
                                    <option value="permission">Permission</option>
                                    <option value="sub_permission">Sub Permission</option>
                                </select>
                            </div>

                            <!-- Permission Number Input -->
                            <div id="permission_pilih" class="col-md-6">
                                <label class="form-label">Nomor Permission</label>
                                <input type="number" class="form-control" name="permission_number" placeholder="Masukkan nomor permission" required>
                            </div>

                            <!-- Sub Permission Fields -->
                            <div id="sub_permission_pilih" class="col-md-6" style="display: none;">
                                <label class="form-label">Nomor Sub Permission</label>
                                <input type="number" class="form-control" name="sub_permission_number" placeholder="Masukkan nomor permission" required>
                            </div>

                            <div id="sub_permission_select" class="col-md-6" style="display: none;">
                                <label class="form-label">Permission</label>
                                <select class="form-control" name="parent_permission_id" id="permissionSelect">
                                    <option value="">Pilih Permission</option>
                                    <!-- Populate this with existing permissions if needed -->
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6" id="permission_input">
                                <label class="form-label">Input Permission</label>
                                <input type="text" class="form-control" name="permission_input" placeholder="Masukkan permission">
                            </div>
                            <div class="col-md-6" id="sub_permission_input" style="display: none;">
                                <label class="form-label">Input Sub Permission</label>
                                <input type="text" class="form-control" name="sub_permission_input" placeholder="Masukkan permission" >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="2" placeholder="Masukkan deskripsi hak akses"></textarea>
                            </div>
                        </div>

                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle"></i> Simpan</button>
                            <a href="{{ route('permission.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
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
   document.addEventListener("DOMContentLoaded", function () {
    const permissionType = document.getElementById('permissionType');
    const permissionFields = document.getElementById('permission_pilih');
    const subPermissionFields = document.getElementById('sub_permission_pilih');
    const subPermissionSelect = document.getElementById('sub_permission_select');
    const permissionInput = document.getElementById('permission_input');
    const subPermissionInput = document.getElementById('sub_permission_input');
    const form = document.getElementById('permissionForm');
    const permissionNumberField = form.querySelector('[name="permission_number"]');
    const subPermissionNumberField = form.querySelector('[name="sub_permission_number"]');
    const parentPermissionField = form.querySelector('[name="parent_permission_id"]');

    function updateColumnSize(isSubPermission) {
        // Make sure the closest .col-md-6 exists before accessing its classList
        const permissionTypeContainer = permissionType.closest('.col-md-6');
        if (permissionTypeContainer) {
            if (isSubPermission) {
                permissionTypeContainer.classList.replace('col-md-6', 'col-md-3');
                subPermissionFields.classList.replace('col-md-6', 'col-md-3');
            } else {
                permissionTypeContainer.classList.replace('col-md-3', 'col-md-6');
                subPermissionFields.classList.replace('col-md-3', 'col-md-6');
            }
        }
    }

    function toggleRequiredFields() {
        if (permissionType.value === 'permission') {
            permissionFields.style.display = 'block';
            subPermissionFields.style.display = 'none';
            subPermissionSelect.style.display = 'none';
            permissionInput.style.display = 'block';
            subPermissionInput.style.display = 'none';

            // Set 'required' only for the visible fields
            permissionNumberField.setAttribute('required', 'required');
            subPermissionNumberField.removeAttribute('required');
            parentPermissionField.removeAttribute('required');
            subPermissionInput.removeAttribute('required');
            updateColumnSize(false);
        } else if (permissionType.value === 'sub_permission') {
            permissionFields.style.display = 'none';
            subPermissionFields.style.display = 'block';
            subPermissionSelect.style.display = 'block';
            permissionInput.style.display = 'none';
            subPermissionInput.style.display = 'block';

            // Set 'required' only for the visible fields
            permissionNumberField.removeAttribute('required');
            subPermissionNumberField.setAttribute('required', 'required');
            parentPermissionField.setAttribute('required', 'required');
            subPermissionInput.setAttribute('required', 'required');
            updateColumnSize(true);
        }
    }

    permissionType.addEventListener('change', function() {
        toggleRequiredFields();
    });

    // Initialize based on the default value of the permission type
    toggleRequiredFields();

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        let formData = new FormData(form);
        formData.append('_token', document.querySelector('input[name="_token"]').value);

        // Check if required fields are visible and have values
        if (permissionType.value === 'permission' && !formData.get('permission_number')) {
            alert('Nomor Permission harus diisi.');
            return;
        }

        if (permissionType.value === 'sub_permission') {
            if (!formData.get('sub_permission_number')) {
                alert('Nomor Sub Permission harus diisi.');
                return;
            }
            if (!formData.get('parent_permission_id')) {
                alert('Permission induk harus dipilih.');
                return;
            }
        }

        fetch(form.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Permission berhasil ditambahkan!');
                window.location.href = data.redirect;
            } else {
                alert('Terjadi kesalahan, silakan coba lagi.');
            }
        })
        .catch(error => console.error('Error:', error));
    });

    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(alert => alert.style.display = 'none');
    }, 3000);
});

</script>
@endsection

