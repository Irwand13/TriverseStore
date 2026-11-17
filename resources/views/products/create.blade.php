@extends('layouts.app', ['judul' => 'Tambah Produk'])

@section('content')
    <section class="section">
        <div class="container narrow">
            <div class="form-card">
                <p class="form-step">Langkah 1 dari 1 — Isi detail akun</p>
                <h2>Tambah Produk Baru</h2>
                <p>Isi detail akun game yang akan dijual. Data tersimpan ke database dan langsung tampil di katalog.</p>
                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    @csrf
                    @include('products._form', ['product' => null, 'submitLabel' => 'Simpan Produk'])
                </form>
            </div>
        </div>
    </section>
@endsection
