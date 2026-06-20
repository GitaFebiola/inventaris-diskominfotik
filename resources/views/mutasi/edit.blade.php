@extends('layouts.admin')

@section('title', 'Edit Mutasi Barang')

@section('content')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between">
        <h5>Edit Mutasi Barang</h5>
        <a href="{{ route('mutasi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <tbody>
                            <tr>
                                <th width="200">No. Register</th>
                                <td>{{ $mutasi->barang->nomor_register }}</td>
                            </tr>
                            <tr>
                                <th>Nama Barang</th>
                                <td>{{ $mutasi->barang->nama_barang }}</td>
                            </tr>
                            <tr>
                                <th>Ruangan Asal</th>
                                <td>{{ $mutasi->ruanganAsal->nama_ruangan }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <form action="{{ route('mutasi.update', $mutasi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="ruangan_tujuan_id" class="form-label">
                        Ruangan Tujuan <span class="text-danger">*</span>
                    </label>
                    <select name="ruangan_tujuan_id" id="ruangan_tujuan_id" 
                            class="form-select @error('ruangan_tujuan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Ruangan Tujuan --</option>
                        @foreach($ruangan as $r)
                            <option value="{{ $r->id }}" 
                                    {{ old('ruangan_tujuan_id', $mutasi->ruangan_tujuan_id) == $r->id ? 'selected' : '' }}>
                                {{ $r->nama_ruangan }}
                            </option>
                        @endforeach
                    </select>
                    @error('ruangan_tujuan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tanggal_mutasi" class="form-label">
                        Tanggal Mutasi <span class="text-danger">*</span>
                    </label>
                    <input type="date" name="tanggal_mutasi" id="tanggal_mutasi" 
                           class="form-control @error('tanggal_mutasi') is-invalid @enderror" 
                           value="{{ old('tanggal_mutasi', $mutasi->tanggal_mutasi) }}" required>
                    @error('tanggal_mutasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" 
                              class="form-control @error('keterangan') is-invalid @enderror" 
                              rows="3" placeholder="Masukkan keterangan mutasi...">{{ old('keterangan', $mutasi->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                      Simpan Perubahan
                    </button>
                    <a href="{{ route('mutasi.index') }}" class="btn btn-danger">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection