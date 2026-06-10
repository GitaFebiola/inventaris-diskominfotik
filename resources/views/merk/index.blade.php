@extends('layouts.admin')

@section('title','Merk')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between">

        <h5>Data Merk</h5>

        <a href="{{ route('merk.create') }}"
           class="btn btn-primary">

            Tambah Merk

        </a>

    </div>

    <div class="card-body">

        <x-datatable>

        <table class="table table-bordered table-striped align-middle datatable">

            <thead>

                <tr>
                    <th width="80">No</th>
                    <th>Kategori</th>
                    <th>Nama Merk</th>
                    <th width="200">Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($merk as $item)

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $item->kategori->nama_kategori }}
                    </td>

                    <td>
                        {{ $item->nama_merk }}
                    </td>

                    <td>

                        <a href="{{ route('merk.edit',$item->id) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form
                            action="{{ route('merk.destroy',$item->id) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus merk?')">

                                Hapus

                            </button>

                        </form>

                    </td>

                </tr>

                @empty
                @endforelse

            </tbody>

        </table>

        </x-datatable>

    </div>

</div>

@endsection