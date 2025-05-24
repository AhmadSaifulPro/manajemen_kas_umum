@extends('layout.main')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Form Edit Kategori</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Edit Kategori</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-5">
                                        <div class="form-group">
                                            <label>Nama Kategori</label>
                                            <input type="text" value="{{ @$kategori->nama_kategori }}" class="form-control" placeholder="Enter Nama kategori" name="nama_kategori" />
                                        </div>
                                        <div class="form-group">
                                            <label>Jenis</label>
                                            <select class="form-select" id="exampleFormControlSelect1" name="jenis">
                                                <option value="Pemasukan">Pemasukan</option>
                                                <option value="Pengeluaran">Pengeluaran</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-5">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Deskripsi</label>
                                            <textarea class="form-control" rows="5" name="deskripsi">{{ @$kategori->deskripsi }}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action text-end">
                                <a href="{{ route('kategori.index') }}" class="btn btn-danger">Cancel</a>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
@endif
@endsection
