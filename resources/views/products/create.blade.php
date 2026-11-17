@extends('layouts.app', ['judul' => 'Tambah Produk'])

@section('content')
    <main>
        <section class="section">
            <div class="container" style="max-width: 720px;">
                <div class="form-card">
                    <h2>Tambah Produk Baru</h2>
                    <p>Isi detail akun game yang akan dijual. Data tersimpan ke database dan langsung tampil di katalog.</p>
                    <form method="POST" action="{{ route('products.store') }}">
                        @csrf
                        @include('products._form', ['product' => null, 'submitLabel' => 'Simpan Produk'])
                    </form>
                    <p style="margin-top: 1rem;"><a class="btn btn-secondary btn-sm" href="{{ route('products.index') }}">Batalkan</a></p>
                </div>
            </div>
        </section>
    </main>
@endsection
