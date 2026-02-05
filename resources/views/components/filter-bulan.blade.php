<div class="flex gap-3 items-center">
    <label for="{{ $id }}" class="text-sm font-semibold text-gray-700">Filter:</label>
    <select id="{{ $id }}" 
        class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white">
        <option value="">-- Semua Bulan --</option>
        <option value="01">Januari</option>
        <option value="02">Februari</option>
        <option value="03">Maret</option>
        <option value="04">April</option>
        <option value="05">Mei</option>
        <option value="06">Juni</option>
        <option value="07">Juli</option>
        <option value="08">Agustus</option>
        <option value="09">September</option>
        <option value="10">Oktober</option>
        <option value="11">November</option>
        <option value="12">Desember</option>
    </select>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterSelect = document.getElementById('{{ $id }}');
        const targetTable = document.getElementById('{{ $targetTable }}');
        
        if (filterSelect && targetTable) {
            filterSelect.addEventListener('change', () => {
                const selectedMonth = filterSelect.value;
                const rows = targetTable.querySelectorAll('tbody tr');
                
                // Regex pattern untuk mendeteksi format tanggal dd/mm/yyyy atau dd/m/yyyy
                const datePattern = /^\d{1,2}\/\d{1,2}\/\d{4}$/;
                
                rows.forEach(row => {
                    // Skip empty state row
                    if (row.querySelector('td[colspan]')) {
                        return;
                    }
                    
                    // Cari kolom yang berisi tanggal (loop semua td)
                    const cells = row.querySelectorAll('td');
                    let dateCell = null;
                    
                    for (let cell of cells) {
                        const cellText = cell.textContent.trim();
                        if (datePattern.test(cellText)) {
                            dateCell = cell;
                            break;
                        }
                    }
                    
                    if (!dateCell) return;
                    
                    if (selectedMonth === '') {
                        // Tampilkan semua
                        row.style.display = '';
                    } else {
                        // Parse tanggal dari format 'dd/m/Y'
                        const dateText = dateCell.textContent.trim();
                        const [day, month, year] = dateText.split('/');
                        
                        // Format bulan ke 2 digit
                        const monthFormatted = String(parseInt(month)).padStart(2, '0');
                        
                        if (monthFormatted === selectedMonth) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
                
                // Cek apakah semua row hidden, jika ya tampilkan pesan
                const visibleRows = Array.from(rows).filter(row => 
                    row.style.display !== 'none' && !row.querySelector('td[colspan]')
                );
                
                let emptyRow = targetTable.querySelector('tbody tr td[colspan]')?.parentElement;
                if (visibleRows.length === 0) {
                    if (!emptyRow) {
                        emptyRow = document.createElement('tr');
                        const td = document.createElement('td');
                        td.setAttribute('colspan', '6');
                        td.className = 'p-10 text-center text-gray-400 italic';
                        td.textContent = 'Tidak ada data untuk bulan yang dipilih.';
                        emptyRow.appendChild(td);
                        targetTable.querySelector('tbody').appendChild(emptyRow);
                    }
                    emptyRow.style.display = '';
                } else {
                    if (emptyRow) {
                        emptyRow.style.display = 'none';
                    }
                }
            });
        }
    });
</script>