// document.addEventListener('DOMContentLoaded', () => {
//     // ================= DAERAH TUJUAN (PROVINSI -> KAB/KOTA) =================
//     fetch('/data/kota_kabupaten.json')
//         .then(res => res.json())
//         .then(data => {
//             const provSelect = document.getElementById('provinsi');
//             const kabSelect  = document.getElementById('kabkota');

//             if(provSelect && kabSelect) {
//                 Object.keys(data).sort().forEach(prov => {
//                     const opt = document.createElement('option');
//                     opt.value = prov;
//                     opt.textContent = prov;
//                     provSelect.appendChild(opt);
//                 });

//                 provSelect.addEventListener('change', () => {
//                     const provinsiDipilih = provSelect.value;
//                     kabSelect.innerHTML = '';
//                     kabSelect.disabled = false;
                    
//                     const placeholder = document.createElement('option');
//                     placeholder.text = 'Pilih Kab/Kota';
//                     placeholder.disabled = true; 
//                     placeholder.selected = true;
//                     kabSelect.appendChild(placeholder);

//                     data[provinsiDipilih].sort().forEach(kab => {
//                         const opt = document.createElement('option');
//                         opt.value = kab;
//                         opt.textContent = kab;
//                         kabSelect.appendChild(opt);
//                     });
//                 });
//             }
//         });
// });

// ================= NAVIGATION =================
function goBack() {
    window.history.back();
}

// // ================= FILE PREVIEW =================
// const fileInput = document.getElementById('fileUpload');
// const filePreview = document.getElementById('filePreview');

// if (fileInput && filePreview) {
//     fileInput.addEventListener('change', () => {
//         filePreview.innerHTML = ''; // Clear previous preview
//         const files = Array.from(fileInput.files);

//         files.forEach(file => {
//             const wrapper = document.createElement('div');
//             wrapper.className = 'flex items-center justify-between bg-gray-100 rounded-lg p-3 border mt-2';
//             wrapper.innerHTML = `
//                 <div>
//                     <p class="text-sm font-semibold">${file.name}</p>
//                     <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(1)} KB</p>
//                 </div>
//             `;
//             filePreview.appendChild(wrapper);
//         });
//     });
// }