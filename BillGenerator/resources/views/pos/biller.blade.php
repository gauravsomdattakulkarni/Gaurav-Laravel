@extends('pos.layouts.app')

@section('title', 'POS Biller')

@section('page_title', 'POS Biller System')

@push('styles')
<style>
    .pairing-code { font-size: 32px; font-weight: 800; letter-spacing: 4px; color: var(--primary-blue); }
    .cart-table th { background: var(--light-blue); color: var(--primary-blue); border-bottom: none; }
    .cart-table td { vertical-align: middle; }
    .total-box { background: var(--light-blue); border: 1px solid var(--border-blue); border-radius: 10px; padding: 20px; }
    .total-text { font-size: 24px; font-weight: 700; color: var(--text-dark); }
</style>
@endpush

@section('content')

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center p-4">
                <h5 class="fw-bold mb-3">Scanner Connection</h5>
                <a href="{{ url('/pos_scanner') }}" target="_blank" class="btn btn-sm btn-outline-primary mb-3">Open Mobile Scanner Page</a>
                
                <div id="pcCodeBlock" class="mb-3">
                    <p class="text-muted mb-1">Enter Code on Mobile</p>
                    <div class="pairing-code" id="pcIdDisplay">------</div>
                </div>

                <div class="alert alert-warning fw-bold mb-0" id="pcStatus">Connecting...</div>
                
                <div id="pcScanControls" class="d-none mt-3">
                    <button class="btn btn-primary btn-lg w-100 fw-bold shadow" id="btnTriggerScan">
                        <i class="bi bi-upc-scan"></i> Trigger Scanner
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Current Bill</h5>
                    <button class="btn btn-danger btn-sm" id="btnClearCart">Clear All</button>
                </div>
                
                <div class="table-responsive" style="min-height: 250px;">
                    <table class="table table-hover cart-table">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Code</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Final Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="cartBody">
                        </tbody>
                    </table>
                </div>

                <div class="total-box mt-3 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-0">Total Items: <span id="lblTotalItems" class="fw-bold text-dark">0</span></p>
                    </div>
                    <div class="text-end">
                        <p class="text-muted mb-0">Total Amount</p>
                        <div class="total-text">₹<span id="lblTotalAmount">0.00</span></div>
                    </div>
                    <div>
                        <button class="btn btn-success btn-lg fw-bold" id="btnCheckout" disabled>
                            Generate Bill <i class="bi bi-check-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/peerjs@1.5.2/dist/peerjs.min.js"></script>
<script>
    let peer = null;
    let conn = null;
    let cart = [];
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const pcIdDisplay = document.getElementById('pcIdDisplay');
    const pcStatus = document.getElementById('pcStatus');
    const pcCodeBlock = document.getElementById('pcCodeBlock');
    const pcScanControls = document.getElementById('pcScanControls');
    const btnTriggerScan = document.getElementById('btnTriggerScan');
    
    const cartBody = document.getElementById('cartBody');
    const lblTotalItems = document.getElementById('lblTotalItems');
    const lblTotalAmount = document.getElementById('lblTotalAmount');
    const btnClearCart = document.getElementById('btnClearCart');
    const btnCheckout = document.getElementById('btnCheckout');

    function generateId() {
        return Math.random().toString(36).substring(2, 8).toUpperCase();
    }

    function initPeer() {
        const pcId = generateId();
        peer = new Peer(pcId);

        peer.on('open', (id) => {
            pcIdDisplay.textContent = id;
            pcStatus.className = 'alert alert-warning fw-bold mb-0';
            pcStatus.textContent = 'Waiting for mobile...';
        });

        peer.on('connection', (connection) => {
            conn = connection;
            pcCodeBlock.classList.add('d-none');
            pcScanControls.classList.remove('d-none');
            pcStatus.className = 'alert alert-success fw-bold mb-0';
            pcStatus.textContent = 'Scanner Connected!';

            conn.on('data', (data) => {
                try {
                    const msg = JSON.parse(data);
                    if (msg.type === 'barcode' && msg.data) {
                        pcStatus.className = 'alert alert-success fw-bold mb-0';
                        pcStatus.textContent = 'Code Scanned: ' + msg.data;
                        
                        btnTriggerScan.disabled = false;
                        btnTriggerScan.innerHTML = '<i class="bi bi-upc-scan"></i> Trigger Scanner';
                        
                        fetchProduct(msg.data);
                    }
                } catch (e) {}
            });

            conn.on('close', () => { location.reload(); });
        });
    }

    btnTriggerScan.addEventListener('click', () => {
        if (conn && conn.open) {
            conn.send(JSON.stringify({ type: 'command', action: 'start_scan' }));
            btnTriggerScan.disabled = true;
            btnTriggerScan.innerHTML = 'Scanning on Mobile...';
            pcStatus.className = 'alert alert-warning fw-bold mb-0';
            pcStatus.textContent = 'Camera open on mobile...';
        }
    });

    async function fetchProduct(barcode) {
        try {
            const response = await fetch('{{ url("/pos_get_product") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ barcode: barcode })
            });
            const result = await response.json();
            
            if (result.status === 'success') {
                addToCart(result.product);
            } else {
                alert('Product code ' + barcode + ' not found in database.');
            }
        } catch (error) {
            alert('Error fetching product details.');
        }
    }

    function addToCart(product) {
        cart.push(product);
        renderCart();
    }

    function removeCartItem(index) {
        cart.splice(index, 1);
        renderCart();
    }

    function renderCart() {
        cartBody.innerHTML = '';
        let total = 0;
        
        cart.forEach((item, index) => {
            total += parseFloat(item.product_price_after_discount);
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="fw-bold">${item.product_name}</td>
                <td>${item.product_code}</td>
                <td>₹${item.product_price}</td>
                <td class="text-danger">-₹${item.product_discount_amount}</td>
                <td class="fw-bold text-success">₹${item.product_price_after_discount}</td>
                <td><button class="btn btn-sm btn-outline-danger" onclick="removeCartItem(${index})"><i class="bi bi-trash"></i></button></td>
            `;
            cartBody.appendChild(tr);
        });

        lblTotalItems.textContent = cart.length;
        lblTotalAmount.textContent = total.toFixed(2);
        
        btnCheckout.disabled = cart.length === 0;
    }

    btnClearCart.addEventListener('click', () => {
        cart = [];
        renderCart();
    });

    btnCheckout.addEventListener('click', async () => {
        if (cart.length === 0) return;

        btnCheckout.disabled = true;
        btnCheckout.textContent = 'Processing...';

        const totalAmt = cart.reduce((sum, item) => sum + parseFloat(item.product_price_after_discount), 0);

        try {
            const response = await fetch('{{ url("/pos_checkout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    total_amount: totalAmt,
                    total_items: cart.length,
                    items: cart
                })
            });
            const result = await response.json();
            
            if (result.status === 'success') {
                cart = [];
                renderCart();
                
                window.open('{{ url("/pos_print_bill") }}/' + result.bill_id, '_blank');
            }
        } catch (error) {
            alert('Error generating bill.');
        }
        
        btnCheckout.innerHTML = 'Generate Bill <i class="bi bi-check-circle"></i>';
        btnCheckout.disabled = cart.length === 0;
    });

    initPeer();
</script>
@endpush