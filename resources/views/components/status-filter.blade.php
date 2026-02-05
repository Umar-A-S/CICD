@props(['statuses', 'targetTable', 'activeColor' => 'bg-lime-400 text-white'])

<div class="flex flex-wrap gap-2 mb-4">
    @foreach($statuses as $value => $label)
        <button 
            class="status-filter-btn px-4 py-2 rounded-lg {{ $loop->first ? 'active ' . $activeColor : 'bg-gray-200' }}" 
            data-status="{{ $value }}"
            data-target="{{ $targetTable }}"
            data-active-color="{{ $activeColor }}">
            {{ $label }}
        </button>
    @endforeach
</div>

@once
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.status-filter-btn');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetTable = this.getAttribute('data-target');
                const activeColorClasses = this.getAttribute('data-active-color').split(' ');
                const selectedStatus = this.getAttribute('data-status');

                // Get all buttons for this specific filter group
                const groupButtons = document.querySelectorAll(`.status-filter-btn[data-target="${targetTable}"]`);
                
                // Remove active state from all buttons in this group
                groupButtons.forEach(btn => {
                    btn.classList.remove('active', ...activeColorClasses);
                    btn.classList.add('bg-gray-200');
                });

                // Add active state to clicked button
                this.classList.add('active', ...activeColorClasses);
                this.classList.remove('bg-gray-200');

                // Filter table rows
                const tableRows = document.querySelectorAll(`#${targetTable} tbody tr[data-status]`);
                
                tableRows.forEach(row => {
                    const rowStatus = row.getAttribute('data-status');
                    
                    if (selectedStatus === 'all' || rowStatus === selectedStatus) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endonce
