@extends('layouts.app', ['judul' => 'Ubah Produk'])

@section('content')
    <main>
        <section class="section">
            <div class="container" style="max-width: 720px;">
                <div class="form-card">
                    <h2>Ubah Produk</h2>
                    <p>Mengubah listing "{{ $product->judul }}". Penjual mengikuti akunmu dan tidak bisa diubah dari sini.</p>
                    <form method="POST" action="{{ route('products.update', $product->id) }}">
                        @csrf
                        @method('PUT')
                        @include('products._form', ['product' => $product, 'submitLabel' => 'Simpan Perubahan'])
                    </form>
                    <p style="margin-top: 1rem;"><a class="btn btn-secondary btn-sm" href="{{ route('products.show', $product->id) }}">Batalkan</a></p>
                </div>
            </div>
        </section>
    </main>
@endsection
