{{-- ============================================================ --}}
{{-- POS LEFT PANEL — Product Browser                            --}}
{{-- Category → Brand → Product navigation                       --}}
{{-- ============================================================ --}}
<div id="pos-left">

    {{-- ── Top Bar: Back + Breadcrumb + Search ────────────────── --}}
    <div style="background:#fff;border-bottom:1px solid #e2e8f0;
                padding:10px 16px;display:flex;align-items:center;
                gap:10px;flex-shrink:0;"
         class="dark:bg-gray-900 dark:border-gray-800">

        {{-- Back Button --}}
        <button id="btnBack"
                onclick="POS.goBack()"
                style="display:none;width:32px;height:32px;border-radius:8px;
                       background:#f1f5f9;border:none;cursor:pointer;
                       align-items:center;justify-content:center;flex-shrink:0;
                       transition:all 0.15s;"
                class="dark:bg-gray-800">
            <svg width="16" height="16" fill="none" stroke="#475569"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2.5" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        {{-- Breadcrumb --}}
        <div id="breadcrumb"
             style="flex:1;display:flex;align-items:center;gap:6px;
                    font-size:0.8rem;overflow:hidden;min-width:0;">
            <span style="color:#6366f1;font-weight:700;cursor:pointer;"
                  onclick="POS.goHome()">
                All
            </span>
        </div>

        {{-- Search Input --}}
        <div style="position:relative;flex-shrink:0;">
            <svg style="position:absolute;left:9px;top:50%;
                        transform:translateY(-50%);pointer-events:none;"
                 width="14" height="14" fill="none" stroke="#94a3b8"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
            </svg>
            <input type="text"
                   id="searchProduct"
                   placeholder="Search products..."
                   oninput="POS.handleSearch(this.value)"
                   style="width:200px;padding:8px 32px 8px 30px;
                          border:1.5px solid #e2e8f0;border-radius:10px;
                          font-size:0.8rem;outline:none;background:#f8fafc;
                          color:#1e293b;transition:border 0.15s;"
                   class="dark:bg-gray-800 dark:border-gray-700
                          dark:text-gray-200 dark:placeholder-gray-500">
            <button id="clearSearchBtn"
                    onclick="POS.clearSearch()"
                    style="display:none;position:absolute;right:8px;top:50%;
                           transform:translateY(-50%);background:none;
                           border:none;cursor:pointer;color:#94a3b8;
                           padding:0;line-height:1;transition:color 0.15s;"
                    onmouseover="this.style.color='#ef4444'"
                    onmouseout="this.style.color='#94a3b8'">
                <svg width="14" height="14" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

    </div>

    {{-- ── Product / Category / Brand Grid ─────────────────────── --}}
    <div style="flex:1;overflow-y:auto;padding:12px;
                scrollbar-width:thin;scrollbar-color:#e2e8f0 transparent;">

        {{-- Loading Skeleton --}}
        <div id="gridLoading" style="display:none;">
            <div style="display:grid;
                        grid-template-columns:repeat(auto-fill,minmax(100px,1fr));
                        gap:8px;">
                @for($i = 0; $i < 12; $i++)
                <div style="aspect-ratio:1;background:#fff;border-radius:14px;
                            border:1.5px solid #e2e8f0;
                            animation:pulse 1.5s ease-in-out infinite;"
                     class="dark:bg-gray-800 dark:border-gray-700">
                </div>
                @endfor
            </div>
        </div>

        {{-- Empty State --}}
        <div id="gridEmpty"
             style="display:none;flex-direction:column;align-items:center;
                    justify-content:center;height:200px;color:#94a3b8;">
            <svg width="48" height="48" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24"
                 style="opacity:0.4;margin-bottom:10px;">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="1.5"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4
                         7m8 4v10M4 7v10l8 4"/>
            </svg>
            <p style="font-size:0.85rem;font-weight:600;margin:0;">
                Nothing found
            </p>
            <p style="font-size:0.75rem;margin:4px 0 0;color:#cbd5e1;">
                Try a different search or filter
            </p>
        </div>

        {{-- Main Grid --}}
        <div id="mainGrid"
             style="display:grid;
                    grid-template-columns:repeat(auto-fill,minmax(100px,1fr));
                    gap:8px;">
        </div>

    </div>
</div>