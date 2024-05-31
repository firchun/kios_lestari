<div class="col-sm-6 col-lg-3 mb-4">
    <div class="widget widget-card-four">
        <div class="widget-content">
            <div class="w-content">
                <div class="w-{{ $color ?? 'primary' }}">
                    <h4 class="value">{{ number_format($count ?? 0) }}</h4>
                    <h6 class="text-{{ $color ?? 'primary' }}">{{ $title ?? 'Title' }}</h6>
                    <p class="text-muted">{{ $subtitle ?? 'Subtitle' }}</p>
                </div>
                <div class="">
                    <div class="w-icon">
                        <i class="bx bx-home bx-sm"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
