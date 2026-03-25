<div class="modal-overlay" id="globalConfirmModal" style="position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity 0.25s;">
    <div style="background:#fff;border-radius:20px;padding:32px;width:400px;max-width:92vw;position:relative;box-shadow:0 25px 60px rgba(0,0,0,0.25);transform:scale(0.95);transition:transform 0.25s;" id="globalConfirmBox">
        <div style="width:60px;height:60px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;" id="globalConfirmIconBox">
            <svg id="globalConfirmIcon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="#dc2626" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
        </div>
        <p style="font-size:1.25rem;font-weight:800;color:#1e293b;margin-bottom:6px;text-align:center;" id="globalConfirmTitle">Konfirmasi</p>
        <p style="font-size:0.9rem;color:#64748b;margin-bottom:20px;text-align:center;" id="globalConfirmMessage">Anda yakin ingin melanjutkan aksi ini?</p>
        <div style="display:flex;gap:12px;">
            <button type="button" onclick="closeGlobalConfirmModal()" style="flex:1;background:#f1f5f9;color:#475569;border:none;border-radius:10px;padding:12px;font-size:0.88rem;font-weight:700;cursor:pointer;transition:background 0.2s;">Batal</button>
            <button type="button" id="globalConfirmBtnProceed" onclick="globalConfirmProceed()" style="flex:1;background:#ef4444;color:#fff;border:none;border-radius:10px;padding:12px;font-size:0.88rem;font-weight:700;cursor:pointer;transition:background 0.2s;">Ya, Lanjutkan</button>
        </div>
    </div>
</div>

<script>
    let confirmTargetForm = null;
    let confirmTargetUrl = null;

    function confirmAction(event, message, actionText = 'Ya, Lanjutkan', title = 'Konfirmasi', isDanger = true) {
        event.preventDefault();
        
        const el = event.currentTarget || event.target;
        
        document.getElementById('globalConfirmMessage').textContent = message;
        document.getElementById('globalConfirmTitle').textContent = title;
        
        const btnProceed = document.getElementById('globalConfirmBtnProceed');
        btnProceed.textContent = actionText;
        
        const iconBox = document.getElementById('globalConfirmIconBox');
        const icon = document.getElementById('globalConfirmIcon');
        
        if (isDanger) {
            btnProceed.style.background = '#ef4444';
            iconBox.style.background = '#fee2e2';
            icon.setAttribute('stroke', '#dc2626');
            icon.innerHTML = '<path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>';
        } else {
            btnProceed.style.background = '#4361ee';
            iconBox.style.background = '#e0e7ff';
            icon.setAttribute('stroke', '#4361ee');
            icon.innerHTML = '<circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>';
        }

        if (el.tagName === 'FORM') {
            confirmTargetForm = el;
            confirmTargetUrl = null;
        } else if (el.tagName === 'A' || el.hasAttribute('href')) {
            confirmTargetUrl = el.href || el.getAttribute('href');
            confirmTargetForm = null;
        } else {
            confirmTargetForm = el.closest('form');
            confirmTargetUrl = null;
            if (!confirmTargetForm && el.tagName === 'BUTTON') {
                // If it's a button not in a form but has an onclick, this might be trickier.
                // Assuming most are either in a form or are links.
            }
        }
        
        const modal = document.getElementById('globalConfirmModal');
        const box = document.getElementById('globalConfirmBox');
        modal.style.opacity = '1';
        modal.style.pointerEvents = 'all';
        box.style.transform = 'scale(1)';
    }

    function closeGlobalConfirmModal() {
        const modal = document.getElementById('globalConfirmModal');
        const box = document.getElementById('globalConfirmBox');
        modal.style.opacity = '0';
        modal.style.pointerEvents = 'none';
        box.style.transform = 'scale(0.95)';
        confirmTargetForm = null;
        confirmTargetUrl = null;
    }

    function globalConfirmProceed() {
        if (confirmTargetForm) {
            confirmTargetForm.submit();
        } else if (confirmTargetUrl) {
            window.location.href = confirmTargetUrl;
        }
        closeGlobalConfirmModal();
    }
</script>
