@extends('layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-dark mb-2">Edit Tujuan Tabungan</h2>
                <p class="text-muted">Perbarui informasi tujuan tabungan Anda</p>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('goals.update', $goal->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="text-center mb-4">
                            <img src="{{ asset($goal->gambar) }}" alt="{{ $goal->nama_barang }}" 
                                 class="img-fluid rounded-lg mb-3" style="max-height: 200px;">
                            <p class="text-muted small">Gambar saat ini</p>
                        </div>

                        <div class="mb-4">
                            <label for="gambar" class="form-label fw-semibold text-dark">
                                Ganti Gambar (Opsional)
                            </label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                            <div class="form-text text-muted small">Kosongkan jika tidak ingin mengganti gambar</div>
                        </div>

                        <div class="mb-4">
                            <label for="nama_barang" class="form-label fw-semibold text-dark">
                                Nama Barang / Tujuan
                            </label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" 
                                   value="{{ old('nama_barang', $goal->nama_barang) }}" required 
                                   placeholder="Masukkan nama tujuan tabungan">
                        </div>

                        <div class="mb-4">
                            <label for="harga_barang" class="form-label fw-semibold text-dark">
                                Target Nominal
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">Rp</span>
                                <input type="number" class="form-control" id="harga_barang" name="harga_barang" 
                                       value="{{ old('harga_barang', $goal->harga_barang) }}" required 
                                       placeholder="Masukkan target nominal">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="target_tanggal" class="form-label fw-semibold text-dark">
                                Target Tanggal Tercapai
                            </label>
                            <input type="date" class="form-control" id="target_tanggal" name="target_tanggal" 
                                   value="{{ old('target_tanggal', $goal->target_tanggal) }}" required>
                        </div>

                        <div class="d-flex justify-content-between pt-3">
                            <a href="{{ route('goals.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 12px;
        border: none;
    }
    
    .form-control {
        border-radius: 8px;
        border: 2px solid #e2e8f0;
        padding: 10px 14px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .input-group-text {
        border-radius: 8px 0 0 8px;
        background-color: #f8fafc;
        border: 2px solid #e2e8f0;
        border-right: none;
    }
    
    .input-group .form-control {
        border-left: none;
        border-radius: 0 8px 8px 0;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        font-weight: 600;
        padding: 10px 24px;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    .btn-outline-secondary {
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 500;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .btn-outline-secondary:hover {
        border-color: #cbd5e0;
        background-color: #f8fafc;
    }
    
    .form-text {
        color: #6b7280;
        font-size: 0.875rem;
        margin-top: 6px;
    }
    
    .rounded-lg {
        border-radius: 12px;
    }
</style>
@endsection