<h3 class="text-center mb-5">Konfirmasi Toko</h3>
<div class="form-group mb-3">
    <label>Nama Toko</label>
    <input type="text" name="nama_toko" class="form-control"
        value="{{ old('nama_toko', session('toko_step1.nama_toko')) }}" required>
</div>

<div class="form-group mb-3">
    <label>No HP</label>
    <input type="text" name="no_hp_toko" class="form-control" maxlength="13"
        value="{{ old('no_hp_toko', session('toko_step1.no_hp_toko')) }}" required>
</div>

<div class="form-group mb-3">
    <label>Kategori Toko</label>
    <select name="kategori_toko_id" class="form-control" required>
        <option value="">-- Pilih Kategori --</option>
        @foreach ($kategori_tokos as $kategori)
            <option value="{{ $kategori->id }}"
                {{ old('kategori_toko_id', session('toko_step1.kategori_toko_id')) == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group mb-3">
    <label>Alamat</label>
    <textarea name="alamat_toko" class="form-control" required>{{ old('alamat_toko', session('toko_step1.alamat_toko')) }}</textarea>
</div>

<div class="form-group mb-3">
    <label>Logo Toko</label>
    <input type="file" name="logo_toko" class="form-control" accept="image/*">
</div>

<div class="form-group mb-3">
    <label>Deskripsi</label>
    <textarea name="deskripsi_toko" class="form-control">{{ old('deskripsi_toko', session('toko_step1.deskripsi_toko')) }}</textarea>
</div>
