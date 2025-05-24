@extends('layout.main')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Form Tambah Catatan Kas Keuangan</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('kas.store') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Tambah Catatan Kas</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-5">
                                        <div class="form-group">
                                            <label>Jenis</label>
                                            <select class="form-select" id="jenis-select" name="jenis">
                                                <option value="">-- Pilih Jenis --</option>
                                                <option value="Pemasukan">Pemasukan</option>
                                                <option value="Pengeluaran">Pengeluaran</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nominal</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" name="nominal" class="form-control"" />
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-5">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Keterangan</label>
                                            <textarea class="form-control" rows="5" name="keterangan"></textarea>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label>Nama Kategori</label>
                                            <select class="form-select" id="exampleFormControlSelect1" name="kategori_id">
                                                <option>-- --</option>
                                                @foreach ($kategori as $item)
                                                    <option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                                                @endforeach
                                            </select>
                                        </div> --}}
                                        <div class="form-group">
                                            <label>Nama Kategori</label>
                                            <select class="form-select" id="kategori-select" name="kategori_id" disabled>
                                                <option value="">-- Pilih Jenis terlebih dahulu --</option>
                                                @foreach ($kategori as $item)
                                                    <option value="{{ $item->id_kategori }}"
                                                        data-jenis="{{ $item->jenis }}">
                                                        {{ $item->nama_kategori }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            {{-- <div class="form-group">
                                                <label>ID Admin</label>
                                                <input type="text" class="form-control" placeholder="Enter ID_user"
                                                    name="user_id" value="1" readonly />
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-action text-end">
                                    <a href="{{ route('kas.index') }}" class="btn btn-danger">Cancel</a>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    {{-- <button class="btn btn-danger">Cancel</button> --}}
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisSelect = document.getElementById('jenis-select');
            const kategoriSelect = document.getElementById('kategori-select');
            const allOptions = Array.from(kategoriSelect.querySelectorAll('option[data-jenis]'));

            jenisSelect.addEventListener('change', function() {
                const selectedJenis = this.value;

                // Kosongkan dulu select
                kategoriSelect.innerHTML = '';

                if (!selectedJenis) {
                    kategoriSelect.disabled = true;
                    kategoriSelect.innerHTML =
                    '<option value="">-- Pilih Jenis terlebih dahulu --</option>';
                    return;
                }

                // Filter dan tampilkan opsi kategori sesuai jenis
                kategoriSelect.disabled = false;
                const filteredOptions = allOptions.filter(opt => opt.dataset.jenis === selectedJenis);

                kategoriSelect.innerHTML = '<option value="">-- Pilih Kategori --</option>';
                filteredOptions.forEach(opt => {
                    kategoriSelect.appendChild(opt.cloneNode(true));
                });
            });
        });
    </script>
@endsection
