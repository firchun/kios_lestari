<div class="btn-group">
    @if ($pesanan->diantar == 1)
        <button class="btn btn-sm btn-primary" onclick="updatePengantaran({{ $pesanan->id }})">Pengantaran</button>
    @else
        <button class="btn btn-sm btn-success" onclick="updatePesanan({{ $pesanan->id }})">Update</button>
    @endif
    <button class="btn btn-sm btn-warning" onclick="detailPesanan({{ $pesanan->id }})">Detail</button>
</div>
