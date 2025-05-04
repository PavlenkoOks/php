<div class="d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <span class="me-2">Show</span>
        <select class="form-select form-select-sm" onchange="window.location.href = this.value">
            <option value="{{ request()->fullUrlWithQuery(['per_page' => 10]) }}" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
            <option value="{{ request()->fullUrlWithQuery(['per_page' => 25]) }}" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
            <option value="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
            <option value="{{ request()->fullUrlWithQuery(['per_page' => 100]) }}" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
        </select>
        <span class="ms-2">entries</span>
    </div>
    <div>
        {{ $items->links() }}
    </div>
</div> 