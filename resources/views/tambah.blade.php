@extends('layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="brand-icon me-3">
                            <i class="bi bi-bullseye fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">Tambah Tujuan Tabungan Baru</h4>
                            <p class="mb-0 opacity-90">Buat rencana tabungan untuk tujuan impian Anda</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-lg mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                            <h6 class="mb-0 fw-bold">Terjadi Kesalahan</h6>
                        </div>
                        <ul class="mb-0 mt-2 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('goals.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="nama_barang" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-tag me-2 text-primary"></i>Nama Tabungan
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="nama_barang" 
                                           name="nama_barang" value="{{ old('nama_barang') }}" 
                                           placeholder="Contoh: Liburan ke Bali, Laptop Baru, dll." required>
                                    <div class="form-text">Berikan nama yang mudah diingat untuk tujuan tabungan Anda</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="harga_barang" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-currency-dollar me-2 text-primary"></i>Target Nominal
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-end-0">Rp</span>
                                        <input type="number" class="form-control border-start-0" id="harga_barang" 
                                               name="harga_barang" value="{{ old('harga_barang') }}" 
                                               placeholder="0" min="0" required>
                                    </div>
                                    <div class="form-text">Masukkan jumlah total yang ingin Anda kumpulkan</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="target_tanggal" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-calendar-event me-2 text-primary"></i>Tanggal Target Tercapai
                                    </label>
                                    <input type="date" class="form-control form-control-lg" id="target_tanggal" 
                                           name="target_tanggal" value="{{ old('target_tanggal') }}" required>
                                    <div class="form-text">Pilih tanggal ketika Anda ingin mencapai target ini</div>
                                </div>
                            </div>

                        <div class="mb-4">
                            <label for="gambar" class="form-label fw-semibold text-dark">
                                <i class="bi bi-image me-2 text-primary"></i>Upload Gambar
                            </label>
                            <input type="file" class="form-control form-control-lg" id="gambar" name="gambar" 
                                   accept="image/*" required onchange="previewImage(this)">
                            <div class="form-text">Pilih gambar yang mewakili tujuan tabungan Anda (max 2MB)</div>
                            
                            <div class="mt-3 text-center" id="imagePreview" style="display: none;">
                                <img id="preview" class="img-thumbnail rounded-lg" style="max-height: 200px;">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="removeImage()">
                                    <i class="bi bi-trash me-1"></i>Hapus Gambar
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="{{ route('goals.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Tujuan Tabungan
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
        border-radius: 16px;
        border: none;
    }
    
    .card-header {
        border-radius: 16px 16px 0 0 !important;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
    
    .brand-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .form-control, .form-select {
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        padding: 12px 16px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control-lg, .form-select-lg {
        padding: 14px 18px;
        font-size: 1.05rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .input-group-text {
        border-radius: 12px 0 0 12px;
        background-color: #f8fafc;
        border: 2px solid #e2e8f0;
        border-right: none;
    }
    
    .input-group .form-control {
        border-left: none;
        border-radius: 0 12px 12px 0;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        font-weight: 600;
        padding: 12px 30px;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }
    
    .btn-outline-secondary {
        border-radius: 12px;
        padding: 12px 30px;
        font-weight: 500;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .btn-outline-secondary:hover {
        border-color: #cbd5e0;
        background-color: #f8fafc;
    }
    
    .alert {
        border-radius: 12px;
        border: none;
    }
    
    .form-label {
        color: #374151;
        margin-bottom: 8px;
    }
    
    .form-text {
        color: #6b7280;
        font-size: 0.875rem;
        margin-top: 6px;
    }
    
    .img-thumbnail {
        border-radius: 12px;
        border: 2px dashed #e2e8f0;
        padding: 8px;
    }
</style>

<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const imagePreview = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function removeImage() {
        const input = document.getElementById('gambar');
        const preview = document.getElementById('preview');
        const imagePreview = document.getElementById('imagePreview');
        
        input.value = '';
        preview.src = '';
        imagePreview.style.display = 'none';
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.needs-validation');
        
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    });
</script>
@endsection