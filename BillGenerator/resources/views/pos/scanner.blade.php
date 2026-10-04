@extends('pos.layouts.app')

@section('title', 'POS Mobile Scanner')

@section('page_title', 'Mobile Scanner')

@push('styles')
<style>
    .pairing-code {
        font-size: 40px;
        font-weight: 800;
        letter-spacing: 5px;
    }
    .scanner-wrapper {
        position: relative;
        width: 100%;
        height: 350px;
        background-color: #111;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    #video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
    }
    .target-box {
        position: absolute;
        width: 80%;
        height: 150px;
        border: 3px solid #32cd32;
        border-radius: 10px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.7);
        z-index: 5;
        display: none;
    }
    .laser {
        position: absolute;
        width: 70%;
        height: 2px;
        background-color: #32cd32;
        left: 15%;
        box-shadow: 0 0 10px 3px #32cd32;
        animation: scan 1s infinite alternate ease-in-out;
        z-index: 10;
        display: none;
    }
    @keyframes scan {
        0% { top: 30%; }
        100% { top: 70%; }
    }
    .standby-text {
        color: #fff;
        font-weight: bold;
        font-size: 1.2rem;
        z-index: 1;
        text-align: center;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card shadow border-0">
            <div class="card-body p-4">
                
                <div id="mobileSetup">
                    <label class="form-label fw-bold text-muted mb-2">PC Pairing Code</label>
                    <input type="text" class="form-control form-control-lg text-center mb-3 text-uppercase pairing-code" id="targetPcId" maxlength="6">
                    
                    <div id="validationError" class="text-danger fw-bold mb-3 d-none text-center">
                        Enter a valid 6-character code.
                    </div>
                    
                    <button class="btn btn-primary btn-lg w-100 fw-bold" id="btnConnectPc">
                        Connect to Biller
                    </button>
                </div>
                
                <div id="mobileScannerArea" class="d-none">
                    <div class="alert alert-success fw-bold text-center mb-3" id="mobileStatus">
                        Waiting for PC trigger...
                    </div>
                    
                    <div class="scanner-wrapper mb-3 shadow-sm">
                        <div class="standby-text" id="standbyText">
                            Camera OFF<br><br><small class="text-muted">Trigger from PC</small>
                        </div>
                        
                        <video id="video" muted playsinline></video>
                        <div class="target-box" id="targetBox"></div>
                        <div class="laser" id="laserLine"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/peerjs@1.5.2/dist/peerjs.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/@zxing/library@latest"></script>

<script>
    const targetPcId = document.getElementById('targetPcId');
    const btnConnectPc = document.getElementById('btnConnectPc');
    const validationError = document.getElementById('validationError');
    const mobileSetup = document.getElementById('mobileSetup');
    const mobileScannerArea = document.getElementById('mobileScannerArea');
    const mobileStatus = document.getElementById('mobileStatus');
    const video = document.getElementById('video');
    const targetBox = document.getElementById('targetBox');
    const laserLine = document.getElementById('laserLine');
    const standbyText = document.getElementById('standbyText');

    let peer = null;
    let conn = null;
    let codeReader = null;
    let isScanning = false;

    btnConnectPc.addEventListener('click', () => {
        const targetId = targetPcId.value.trim().toUpperCase();
        
        if (targetId.length !== 6) {
            validationError.classList.remove('d-none');
            return;
        }
        
        validationError.classList.add('d-none');
        btnConnectPc.textContent = 'Connecting...';
        btnConnectPc.disabled = true;

        peer = new Peer();
        
        peer.on('open', () => {
            conn = peer.connect(targetId, { reliable: true });
            
            conn.on('open', () => {
                mobileSetup.classList.add('d-none');
                mobileScannerArea.classList.remove('d-none');
            });

            conn.on('data', (data) => {
                try {
                    const msg = JSON.parse(data);
                    if (msg.type === 'command' && msg.action === 'start_scan') {
                        startCamera();
                    }
                } catch(e) {}
            });

            conn.on('close', () => { 
                location.reload(); 
            });
        });

        peer.on('error', () => {
            btnConnectPc.textContent = 'Connect to Biller';
            btnConnectPc.disabled = false;
            validationError.textContent = "Connection failed.";
            validationError.classList.remove('d-none');
        });
    });

    async function startCamera() {
        if (isScanning) {
            return;
        }
        
        codeReader = new ZXing.BrowserMultiFormatReader();
        
        standbyText.style.display = 'none';
        video.style.display = 'block';
        targetBox.style.display = 'block';
        laserLine.style.display = 'block';
        
        mobileStatus.className = 'alert alert-warning fw-bold text-center mb-3';
        mobileStatus.textContent = 'Point camera at barcode...';
        
        isScanning = true;

        try {
            codeReader.decodeFromVideoDevice(null, 'video', (result, err) => {
                if (result && result.text && isScanning) {
                    if (conn && conn.open) {
                        conn.send(JSON.stringify({ type: 'barcode', data: result.text }));
                    }
                    stopCamera('Scanned! Sent to PC.');
                }
            });
        } catch (error) {
            mobileStatus.className = 'alert alert-danger fw-bold text-center mb-3';
            mobileStatus.textContent = 'Camera blocked. Use HTTPS link.';
            stopCamera('Camera error.');
        }
    }

    function stopCamera(statusMessage) {
        if (codeReader) {
            codeReader.reset();
        }
        
        isScanning = false;
        
        video.style.display = 'none';
        targetBox.style.display = 'none';
        laserLine.style.display = 'none';
        standbyText.style.display = 'block';
        
        if (!mobileStatus.classList.contains('alert-danger')) {
            mobileStatus.className = 'alert alert-success fw-bold text-center mb-3';
            mobileStatus.textContent = statusMessage;
        }
    }
</script>
@endpush