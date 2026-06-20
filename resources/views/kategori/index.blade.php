@extends('layouts.admin')

@section('title','Kategori')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between">

        <h5>Data Kategori</h5>

        <a href="{{ route('kategori.create') }}"
           class="btn btn-primary">

            Tambah Kategori

        </a>

    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
       
<x-datatable>

<table class="table table-bordered table-striped align-middle datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode BMD</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse($kategori as $item)

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $item->kode_bmd }}
                    </td>

                    <td>
                        {{ $item->nama_kategori }}
                    </td>

                    <td>

                        <a href="{{ route('kategori.edit',$item->id) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form
                            action="{{ route('kategori.destroy',$item->id) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            <!-- @method('DELETE')

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus kategori?')">

                                Hapus

                            </button> -->

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="4"
                        class="text-center">

                        Data kosong

                    </td>
                </tr>

            @endforelse

            </tbody>

</x-datatable>

    </div>

</div>


@endsection