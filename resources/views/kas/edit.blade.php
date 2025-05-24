@extends('layout.main')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Form Update Kas Keuangan</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('kas.update', $kas->id_kas) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Update Kas</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-5">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="datetime-local" value="{{ $kas->tanggal }}" class="form-control" name="tanggal" />
                                        </div>
                                        <div class="form-group">
                                            <label>Jenis</label>
                                            <select class="form-select" id="jenis-select" name="jenis">
                                                <option value="{{ $kas->jenis }}" selected>{{ $kas->jenis }}</option>
                                                @if($kas->jenis != 'Pemasukan')
                                                    <option value="Pemasukan">Pemasukan</option>
                                                @endif
                                                @if($kas->jenis != 'Pengeluaran')
                                                    <option value="Pengeluaran">Pengeluaran</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Jumlah</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" value="{{ $kas->nominal }}" name="nominal" class="form-control" />
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-5">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Keterangan</label>
                                            <textarea class="form-control" rows="5" name="keterangan">{{ $kas->keterangan }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Kategori</label>
                                            <select class="form-select" id="kategori-select" name="kategori_id">
                                                <option value="{{ $kas->kategori_id }}" selected>{{ optional($kas->Kategori)->nama_kategori }}</option>
                                                @foreach ($kategori->where('jenis', $kas->jenis) as $item)
                                                    @if($item->id_kategori != $kas->kategori_id)
                                                        <option value="{{ $item->id_kategori }}" data-jenis="{{ $item->jenis }}">
                                                            {{ $item->nama_kategori }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-action text-end">
                                    <a href="{{ route('kas.index') }}" class="btn btn-danger">Cancel</a>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisSelect = document.getElementById('jenis-select');
            const kategoriSelect = document.getElementById('kategori-select');

            // Store all kategori options for filtering
            const allKategoriOptions = @json($kategori->map(function($item) {
                return [
                    'id' => $item->id_kategori,
                    'nama' => $item->nama_kategori,
                    'jenis' => $item->jenis
                ];
            }));

            jenisSelect.addEventListener('change', function() {
                const selectedJenis = this.value;

                // Clear the kategori select
                kategoriSelect.innerHTML = '<option value="">-- Pilih Kategori --</option>';

                // Filter and show kategori options based on selected jenis
                const filteredOptions = allKategoriOptions.filter(opt => opt.jenis === selectedJenis);

                filteredOptions.forEach(opt => {
                    const option = document.createElement('option');
                    option.value = opt.id;
                    option.textContent = opt.nama;
                    option.dataset.jenis = opt.jenis;
                    kategoriSelect.appendChild(option);
                });
            });
        });
    </script>
    @endpush
@endsection
