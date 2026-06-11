@extends('layouts.admin')

@section('title', 'Edit Barang')

@section('content')

<div class="card shadow-sm">

<div class="card-header">
    <h5 class="mb-0">Edit Barang</h5>
</div>

<div class="card-body">

    @php
        // Ambil data master untuk dropdown agar tidak perlu ubah Controller
        if (!isset($kategori)) $kategori = \App\Models\Kategori::orderBy('nama_kategori')->get();
        if (!isset($ruangan)) $ruangan = \App\Models\Ruangan::orderBy('nama_ruangan')->get();
        if (!isset($merk)) $merk = \App\Models\Merk::all();
    @endphp

    <form action="{{ route('barang.update', $barang->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="row">

            <!-- Info Statis -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Nomor Register</label>
                <input type="text"
                       class="form-control bg-light"
                       value="{{ $barang->nomor_register }}"
                       readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <input type="text"
                       class="form-control bg-light"
                       value="{{ $barang->status }}"
                       readonly>
            </div>

            <!-- 1. Ruangan -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Ruangan</label>
                <select name="ruangan_id"
                        id="ruangan_id"
                        class="form-select"
                        required>
                    <option value="">-- Pilih Ruangan --</option>
                    @foreach($ruangan as $item)
                        <option value="{{ $item->id }}"
                            {{ old('ruangan_id', $barang->ruangan_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_ruangan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- 2. Kategori -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Kategori</label>
                <select name="kategori_id"
                        id="kategori_id"
                        class="form-select"
                        required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori as $item)
                        <option value="{{ $item->id }}"
                            {{ old('kategori_id', $barang->kategori_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kategori }} ({{ $item->kode_bmd }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- 3. Merk -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Merk</label>
                <select name="merk"
                        id="merk"
                        class="form-select">
                    <option value="">-- Pilih Merk --</option>
                </select>
                <input type="hidden" id="data_merk" value='{{ json_encode($merk) }}'>
                <input type="hidden" id="old_merk" value="{{ old('merk', $barang->merk) }}">
            </div>

            <!-- 4. Sumber Anggaran -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Sumber Anggaran</label>
                <input type="text"
                       name="Sumber"
                       class="form-control"
                       value="{{ old('Sumber', $barang->Sumber) }}"
                       placeholder="Contoh: APBD, APBN, Mandiri...">
            </div>

            <!-- 5. Nama Barang -->
            <div class="col-md-12 mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text"
                       name="nama_barang"
                       class="form-control"
                       value="{{ old('nama_barang', $barang->nama_barang) }}"
                       required>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Spesifikasi</label>
                <textarea name="spesifikasi"
                          rows="4"
                          class="form-control">{{ old('spesifikasi', $barang->spesifikasi) }}</textarea>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Tahun Perolehan</label>
                <input type="number"
                       name="tahun_perolehan"
                       class="form-control"
                       value="{{ $barang->tahun_perolehan }}"
                       required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Harga Perolehan</label>
                <input type="number"
                       name="harga_perolehan"
                       class="form-control"
                       value="{{ $barang->harga_perolehan }}"
                       required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Kondisi</label>
                <select name="kondisi"
                        class="form-select">
                    <option value="Baik" {{ $barang->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ $barang->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Rusak Berat" {{ $barang->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Ganti Foto</label>
                <input type="file"
                       name="foto"
                       class="form-control"
                       accept=".jpg,.jpeg,.png">
                @if($barang->foto)
                    <small class="text-muted d-block mt-1">
                        Foto saat ini: <img src="{{ asset('storage/' . $barang->foto) }}" height="40" alt="Foto">
                    </small>
                @endif
            </div>

        </div>

        <a href="{{ route('barang.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>

        <button type="submit"
                class="btn btn-warning">
            Update
        </button>

    </form>

</div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kategoriSelect = document.getElementById('kategori_id');
        const merkSelect = document.getElementById('merk');
        const dataMerkInput = document.getElementById('data_merk');
        const oldMerkInput = document.getElementById('old_merk');

        let allMerks = [];
        if (dataMerkInput.value) {
            try {
                allMerks = JSON.parse(dataMerkInput.value);
            } catch (e) {
                console.error('Gagal parsing data merk');
            }
        }
        
        const originalMerk = oldMerkInput.value;

        function updateMerkOptions() {
            const selectedKategoriId = kategoriSelect.value;
            merkSelect.innerHTML = '<option value="">-- Pilih Merk --</option>';

            if (selectedKategoriId) {
                const filteredMerks = allMerks.filter(function(item) {
                    return item.kategori_id == selectedKategoriId;
                });

                filteredMerks.forEach(function(merk) {
                    const option = document.createElement('option');
                    option.value = merk.nama_merk;
                    option.textContent = merk.nama_merk;
                    
                    if (merk.nama_merk === originalMerk) {
                        option.selected = true;
                    }
                    
                    merkSelect.appendChild(option);
                });
            }
        }

        updateMerkOptions();
        kategoriSelect.addEventListener('change', updateMerkOptions);
    });
</script>
@endpush

@endsection