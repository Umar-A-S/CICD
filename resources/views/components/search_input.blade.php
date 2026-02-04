@props(['id', 'placeholder' => 'Cari data...', 'targetTable'])

<div class="relative mb-4">
    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
    </div>
    
    <input 
        type="text" 
        id="{{ $id }}" 
        data-target="{{ $targetTable }}"
        class="table-search block w-full p-2.5 pl-10 text-sm text-black border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-lime-400 shadow-sm transition" 
        placeholder="{{ $placeholder }}"
    >
</div>

@once
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.body.addEventListener('keyup', function(e) {
            // Cek apakah yang diketik adalah element dengan class 'table-search'
            if (e.target && e.target.classList.contains('table-search')) {
                
                const input = e.target;
                const term = input.value.toLowerCase();
                const targetId = input.getAttribute('data-target');
                const tableBody = document.querySelector(`#${targetId} tbody`);
                
                if (!tableBody) return;

                const rows = tableBody.getElementsByTagName('tr');

                Array.from(rows).forEach(row => {
                    // Jangan filter baris "Tidak ada data" / colspan
                    if (row.querySelector('td[colspan]')) return;

                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(term) ? '' : 'none';
                });
            }
        });
    });
</script>
@endonce