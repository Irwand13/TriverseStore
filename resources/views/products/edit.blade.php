@extends('layouts.app', ['judul' => 'Ubah Produk'])

@section('content')
    <section class="section">
        <div class="container narrow">
            <div class="form-card">
                <p class="form-step">Mengubah listing</p>
                <h2>Ubah Produk</h2>
                <p>Mengubah listing "{{ $product->judul }}". Penjual mengikuti akunmu dan tidak bisa diubah dari sini.</p>
                <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('products._form', ['product' => $product, 'submitLabel' => 'Simpan Perubahan'])
                </form>
            </div>
        </div>
    </section>
@endsection
