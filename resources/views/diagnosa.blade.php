@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-card p-8 rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-6 text-center text-primary">
        <i class="fa-solid fa-cat"></i>
        Diagnosa Penyakit Kulit Kucing
    </h2>

    <form method="POST" action="/diagnosa/proses">
        @csrf

        <div class="space-y-2">
            @foreach ($gejala as $kode => $nama)
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="gejala[]" value="{{ $kode }}">
                    <span>{{ $nama }}</span>
                </label>
            @endforeach
        </div>

        <button class="mt-6 w-full bg-primary hover:bg-hover bg-primary hover:bg-hover text-white py-2 font-semibold rounded">
            Proses Diagnosa
        </button>
    </form>
</div>
@endsection
