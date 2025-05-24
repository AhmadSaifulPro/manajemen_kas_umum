<div wire:poll.60s>
    <div class="row">
        {{-- Keseluruhan --}}
        <div class="col-md-4 mb-3">
            <x-card title="Sisa Saldo Keseluruhan" value="{{ $sisaKeseluruhan }}" />
        </div>
        <div class="col-md-4 mb-3">
            <x-card title="Pengeluaran Keseluruhan" value="{{ $pengeluaranKeseluruhan }}" color="red" />
        </div>
        <div class="col-md-4 mb-3">
            <x-card title="Pemasukan Keseluruhan" value="{{ $pemasukanKeseluruhan }}" color="green" />
        </div>

        {{-- Bulan ini --}}
        <div class="col-md-4 mb-3">
            <x-card title="Sisa Saldo Bulan ini" value="{{ $sisaBulan }}" />
        </div>
        <div class="col-md-4 mb-3">
            <x-card title="Pengeluaran Bulan ini" value="{{ $pengeluaranBulan }}" color="red" />
        </div>
        <div class="col-md-4 mb-3">
            <x-card title="Pemasukan Bulan ini" value="{{ $pemasukanBulan }}" color="green" />
        </div>

        {{-- Hari ini --}}
        <div class="col-md-4 mb-3">
            <x-card title="Sisa Saldo Hari ini" value="{{ $sisaHari }}" />
        </div>
        <div class="col-md-4 mb-3">
            <x-card title="Pengeluaran Hari ini" value="{{ $pengeluaranHari }}" color="red" />
        </div>
        <div class="col-md-4 mb-3">
            <x-card title="Pemasukan Hari ini" value="{{ $pemasukanHari }}" color="green" />
        </div>
    </div>
</div>
