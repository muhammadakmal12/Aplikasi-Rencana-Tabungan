@extends('layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 text-gray-800 fw-bold">Semua Tabungan</h1>
                    <p class="text-muted">Kelola dan pantau progress tabungan Anda</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body py-3">
                    <form method="GET" action="{{ route('home') }}" class="row g-3 align-items-center">
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="tercapai" {{ request('status') == 'tercapai' ? 'selected' : '' }}>Tercapai</option>
                                <option value="belum tercapai" {{ request('status') == 'belum tercapai' ? 'selected' : '' }}>Belum Tercapai</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama tabungan..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary w-100">
                                <i class="bi bi-funnel me-2"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($goals->count() > 0)
        <div class="row g-4">
            @foreach($goals as $goal)
            @php
                $total_saving = $goal->savings->sum('jumlah_setor');
                $progress = $goal->harga_barang > 0 ? min(100, ($total_saving / $goal->harga_barang) * 100) : 0;
                $isCompleted = $total_saving >= $goal->harga_barang;
                $daysLeft = \Carbon\Carbon::parse($goal->target_tanggal)->diffInDays(now(), false) * -1;
            @endphp
            
            <div class="col-xl-4 col-md-6">
                <div class="card savings-card shadow-sm h-100 border-0">
                    <div class="card-header position-relative p-0 border-0">
                        <img src="{{ $goal->gambar }}" class="card-img-top" alt="{{ $goal->nama_barang }}" 
                             style="height: 200px; object-fit: cover;">
                        
                        <span class="position-absolute top-0 start-0 m-3 badge {{ $isCompleted ? 'bg-success' : 'bg-warning' }}">
                            {{ $isCompleted ? 'Tercapai' : 'Progress' }}
                        </span>
                        
                        <div class="progress position-absolute bottom-0 start-0 w-100 rounded-0" style="height: 6px;">
                            <div class="progress-bar {{ $isCompleted ? 'bg-success' : 'bg-primary' }}" 
                                 style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-dark mb-2">{{ $goal->nama_barang }}</h5>
                        <p class="card-text text-muted small mb-3">{{ $goal->deskripsi ?? 'Tabungan untuk ' . $goal->nama_barang }}</p>
                        
                        <div class="savings-info mb-3 p-3 rounded">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small">Target:</span>
                                <span class="fw-bold text-dark">Rp {{ number_format($goal->harga_barang, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small">Terkumpul:</span>
                                <span class="fw-bold {{ $isCompleted ? 'text-success' : 'text-primary' }}">
                                    Rp {{ number_format($total_saving, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">Target Date:</span>
                                <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($goal->target_tanggal)->format('d M Y') }}</span>
                            </div>
                        </div>

                        @if($isCompleted)
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="text-center">
                                    <div class="text-success mb-1">
                                        <i class="bi bi-check-circle-fill fs-4"></i>
                                    </div>
                                    <small class="text-success fw-bold">Selesai</small>
                                </div>
                                @if($daysLeft > 0)
                                <div class="text-center">
                                    <div class="text-primary mb-1">
                                        <i class="bi bi-calendar-check fs-4"></i>
                                    </div>
                                    <small class="text-muted">{{ $daysLeft }} Hari Lebih Awal</small>
                                </div>
                                @endif
                                <div class="text-center">
                                    <div class="text-warning mb-1">
                                        <i class="bi bi-trophy fs-4"></i>
                                    </div>
                                    <small class="text-muted">Target Terpenuhi</small>
                                </div>
                            </div>
                        @else
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar {{ $isCompleted ? 'bg-success' : 'bg-primary' }}" 
                                     style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="text-center mb-3">
                                <small class="{{ $daysLeft < 0 ? 'text-danger' : 'text-muted' }}">
                                    {{ number_format($progress, 1) }}% Tercapai - 
                                    Rp {{ number_format($goal->harga_barang - $total_saving, 0, ',', '.') }} lagi
                                </small>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-center">
                                    <div class="{{ $progress > 50 ? 'text-success' : 'text-primary' }} mb-1">
                                        <i class="bi bi-{{ $progress > 50 ? 'lightning' : 'clock' }} fs-4"></i>
                                    </div>
                                    <small class="{{ $progress > 50 ? 'text-success' : 'text-muted' }}">
                                        {{ $progress > 50 ? 'On Track' : 'Dalam Progress' }}
                                    </small>
                                </div>
                                
                                <div class="text-center">
                                    <div class="text-primary mb-1">
                                        <i class="bi bi-calendar fs-4"></i>
                                    </div>
                                    <small class="text-muted">
                                        @if($daysLeft > 0)
                                            {{ $daysLeft }} Hari Tersisa
                                        @else
                                            {{ abs($daysLeft) }} Hari Terlambat
                                        @endif
                                    </small>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <div class="d-grid gap-2">
                            @if($isCompleted)
                                <a href="{{ route('savings.create', $goal->id) }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-cart-check me-2"></i>Beli Sekarang
                                </a>
                            @else
                                <a href="{{ route('savings.create', $goal->id) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-wallet2 me-2"></i>Tambah Tabungan
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    @else
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-5">
                        <div class="empty-state-icon mb-4">
                            <i class="bi bi-piggy-bank fs-1 text-muted opacity-50"></i>
                        </div>
                        <h4 class="text-muted mb-3">Belum ada rencana tabungan</h4>
                        <p class="text-muted mb-4">Mulai buat rencana tabungan pertama Anda</p>
                        <a href="{{ route('goals.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Tabungan Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    .savings-card {
        border-radius: 16px;
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
    }
    
    .savings-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.15) !important;
    }
    
    .card-header {
        border-radius: 16px 16px 0 0 !important;
        overflow: hidden;
    }
    
    .savings-info {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-left: 4px solid #667eea;
    }
    
    .progress {
        border-radius: 10px;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-weight: 600;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }
    
    .btn-success {
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-success:hover {
        transform: translateY(-1px);
    }
    
    .empty-state-icon {
        opacity: 0.5;
    }
    
    .text-primary { color: #667eea !important; }
    .text-success { color: #10b981 !important; }
    .text-warning { color: #f59e0b !important; }
    .text-danger { color: #ef4444 !important; }
    
    .bg-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; }
    .bg-success { background-color: #10b981 !important; }
    .bg-warning { background-color: #f59e0b !important; }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    @media (max-width: 768px) {
        .card-body.py-3 {
            padding: 1rem !important;
        }
        
        .row.g-3.align-items-center {
            gap: 1rem !important;
        }
        
        .col-md-3,
        .col-md-6 {
            width: 100%;
        }
    }
</style>
@endsection 