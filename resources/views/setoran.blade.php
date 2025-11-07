@extends('layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-dark mb-2">Setor Tabungan</h2>
                <p class="text-muted">Untuk: <span class="fw-semibold text-primary">{{ $goal->nama_barang }}</span></p>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="text-primary">
                                <i class="bi bi-bullseye fs-2"></i>
                            </div>
                            <h6 class="fw-bold text-dark mt-2">Target</h6>
                            <p class="mb-0 fw-semibold">Rp {{ number_format($goal->harga_barang, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-6">
                            <div class="text-success">
                                <i class="bi bi-cash-coin fs-2"></i>
                            </div>
                            <h6 class="fw-bold text-dark mt-2">Terkumpul</h6>
                            <p class="mb-0 fw-semibold">Rp {{ number_format($goal->savings->sum('jumlah_setor'), 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('savings.store', $goal->id) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="jumlah_setor" class="form-label fw-semibold text-dark">
                                Nominal Setoran
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">Rp</span>
                                <input type="number" class="form-control" id="jumlah_setor" 
                                       name="jumlah_setor" required min="1" 
                                       placeholder="Masukkan jumlah setoran">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="tanggal_setor" class="form-label fw-semibold text-dark">
                                Tanggal Setor
                            </label>
                            <input type="date" class="form-control" id="tanggal_setor" 
                                   name="tanggal_setor" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="d-flex justify-content-between pt-3">
                            <a href="{{ route('goals.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-wallet2 me-2"></i>Simpan Setoran
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
    
    .text-primary { color: #667eea !important; }
    .text-success { color: #10b981 !important; }
</style>
@endsection