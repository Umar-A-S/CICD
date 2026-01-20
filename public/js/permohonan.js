// Graceful guards for DOM elements (page may not include permohonan)
const uploadArea = document.getElementById('uploadArea');
const fileInput = document.getElementById('fileInput');
const fileName = document.getElementById('fileName');
const form = document.getElementById('permohonanForm');
const filePreview = document.getElementById('filePreview');
const previewName = document.getElementById('previewName');
const previewInfo = document.getElementById('previewInfo');
const fileIcon = document.getElementById('fileIcon');
const removeFileBtn = document.getElementById('removeFile');

let uploadedFile = null;

if (uploadArea && fileInput) {
    // Click to open file picker
    uploadArea.addEventListener('click', () => fileInput.click());

    // Drag & Drop
    ['dragenter', 'dragover'].forEach(evt => uploadArea.addEventListener(evt, (e) => {
        e.preventDefault(); e.stopPropagation();
        uploadArea.classList.add('bg-lime-50');
    }));
    ['dragleave', 'drop'].forEach(evt => uploadArea.addEventListener(evt, (e) => {
        e.preventDefault(); e.stopPropagation();
        uploadArea.classList.remove('bg-lime-50');
    }));
    uploadArea.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        if (dt && dt.files && dt.files.length) {
            handleFile(dt.files[0]);
        }
    });
}

if (fileInput) {
    fileInput.addEventListener('change', () => {
        if (fileInput.files && fileInput.files.length) handleFile(fileInput.files[0]);
    });
}

function handleFile(file) {
    if (!file) return;

    // Validate type
    const allowed = ['application/pdf','image/jpeg','image/png'];
    if (!allowed.includes(file.type)) {
        alert('Tipe file tidak diizinkan. Gunakan PDF/JPG/PNG.');
        fileInput.value = '';
        return;
    }

    // Validate size (2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file maksimal 2MB');
        fileInput.value = '';
        return;
    }

    uploadedFile = file;
    fileName.textContent = file.name;

    // show preview block
    if (filePreview && previewName && previewInfo) {
        previewName.textContent = file.name;
        previewInfo.textContent = `${(file.size/1024).toFixed(0)} KB • ${file.type}`;
        filePreview.classList.remove('hidden');
        // set icon for pdf or image
        if (file.type === 'application/pdf') {
            fileIcon.className = 'fa-solid fa-file-pdf text-2xl text-red-500';
        } else {
            fileIcon.className = 'fa-solid fa-image text-2xl text-sky-500';
        }
    }

    // enable submit button if present
    const submitBtn = form ? form.querySelector('button[type="submit"]') : null;
    if (submitBtn) submitBtn.disabled = false;
}

if (removeFileBtn) {
    removeFileBtn.addEventListener('click', () => {
        uploadedFile = null;
        fileInput.value = '';
        fileName.textContent = '';
        if (filePreview) filePreview.classList.add('hidden');
        const submitBtn = form ? form.querySelector('button[type="submit"]') : null;
        if (submitBtn) submitBtn.disabled = true;
    });
}

if (form) {
    // disable submit initially
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) submitBtn.disabled = true;

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        // basic validation
        const required = ['jenis','nama','nik','tanggal','nomor','wilayahTujuan','wilayah','daerahTujuan','daerahAsal'];
        for (const id of required) {
            const el = document.getElementById(id);
            if (!el || !el.value) {
                alert('Lengkapi semua kolom yang diperlukan.');
                return;
            }
        }

        if (!uploadedFile) {
            alert('Silakan upload berkas terlebih dahulu');
            return;
        }

        // Build FormData for future real submission
        const fd = new FormData();
        required.forEach(id => fd.append(id, document.getElementById(id).value));
        fd.append('file', uploadedFile);

        // send to backend
        fetch('/permohonan/store', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: fd
        })
        .then(r => r.json())
        .then(res => {
            if (res && res.success) {
                alert('Permohonan berhasil dikirim. ID: ' + res.id);
                window.location.href = '/status-permohonan';
            } else {
                alert('Gagal mengirim permohonan.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat mengirim. Cek console.');
        });
    });
}

// load list of kota/kabupaten and populate selects
document.addEventListener('DOMContentLoaded', () => {
    const daerahAsal = document.getElementById('daerahAsal');
    const daerahTujuan = document.getElementById('daerahTujuan');
    const wilayah = document.getElementById('wilayah');
    if (!daerahAsal || !daerahTujuan) return;

    fetch('/data/kota_kabupaten.json')
        .then(r => r.json())
        .then(data => {
            // support both formats: array (flat) or object {prov: [list]}
            window.__kotaData = data; // store globally for later filtering
            if (Array.isArray(data)) {
                data.forEach(name => {
                    const o1 = document.createElement('option');
                    o1.value = name; o1.textContent = name;
                    daerahAsal.appendChild(o1);

                    const o2 = document.createElement('option');
                    o2.value = name; o2.textContent = name;
                    daerahTujuan.appendChild(o2);

                    if (wilayah) {
                        const o3 = document.createElement('option');
                        o3.value = name; o3.textContent = name;
                        wilayah.appendChild(o3);
                    }
                });
                return;
            }

            // object: create optgroup per province
            const provinces = Object.keys(data).sort();

            // Populate `daerahAsal` ONLY with cities/kabupaten from Jawa Tengah
            if (data['Jawa Tengah'] && Array.isArray(data['Jawa Tengah'])) {
                const jtOg = document.createElement('optgroup');
                jtOg.label = 'Jawa Tengah';
                data['Jawa Tengah'].sort().forEach(name => {
                    const o = document.createElement('option');
                    o.value = name; o.textContent = name;
                    jtOg.appendChild(o);
                });
                daerahAsal.appendChild(jtOg);
            }

            // Populate daerahTujuan (optgroups per province) and `wilayah` (list of provinces)
            provinces.forEach(prov => {
                const list = data[prov];
                const og2 = document.createElement('optgroup');
                og2.label = prov;

                if (Array.isArray(list)) {
                    list.sort().forEach(name => {
                        const o2 = document.createElement('option');
                        o2.value = name; o2.textContent = name;
                        og2.appendChild(o2);
                    });
                }

                daerahTujuan.appendChild(og2);

                if (wilayah) {
                    const opt = document.createElement('option');
                    opt.value = prov; opt.textContent = prov;
                    wilayah.appendChild(opt);
                }
            });
            
            // when user selects a province in `wilayah`, populate daerahTujuan with its cities
            const wilayahEl = document.getElementById('wilayah');
            if (wilayahEl) {
                function populateDaerahByProvince(provName) {
                    daerahTujuan.innerHTML = '<option value="">-- Pilih Daerah Tujuan --</option>';
                    if (!provName || !data[provName]) return;
                    const og = document.createElement('optgroup');
                    og.label = provName;
                    data[provName].sort().forEach(name => {
                        const o = document.createElement('option');
                        o.value = name; o.textContent = name;
                        og.appendChild(o);
                    });
                    daerahTujuan.appendChild(og);
                }

                wilayahEl.addEventListener('change', () => {
                    populateDaerahByProvince(wilayahEl.value);
                });
            }
            // after initial population, filter daerahTujuan according to current wilayahTujuan
            const wt = document.getElementById('wilayahTujuan');
            if (wt) {
                function populateDaerahTujuanByScope(scope) {
                    // clear existing
                    daerahTujuan.innerHTML = '<option value="">-- Pilih Daerah Tujuan --</option>';
                    if (!data || typeof data !== 'object') return;

                    if (scope === 'Dalam Jateng') {
                        const list = data['Jawa Tengah'] || [];
                        const og = document.createElement('optgroup');
                        og.label = 'Jawa Tengah';
                        list.sort().forEach(name => {
                            const o = document.createElement('option');
                            o.value = name; o.textContent = name;
                            og.appendChild(o);
                        });
                        daerahTujuan.appendChild(og);
                        return;
                    }

                    // Luar Jateng -> all provinces except Jawa Tengah
                    const provincesOut = Object.keys(data).filter(p => p !== 'Jawa Tengah').sort();
                    provincesOut.forEach(provName => {
                        const listProv = data[provName];
                        if (!listProv || !listProv.length) return;
                        const ogProv = document.createElement('optgroup');
                        ogProv.label = provName;
                        listProv.sort().forEach(name => {
                            const o = document.createElement('option');
                            o.value = name; o.textContent = name;
                            ogProv.appendChild(o);
                        });
                        daerahTujuan.appendChild(ogProv);
                    });
                }

                // initial populate
                populateDaerahTujuanByScope(wt.value || wt.options[0].text);

                wt.addEventListener('change', () => {
                    populateDaerahTujuanByScope(wt.value);
                });
            }
        })
        .catch(err => console.error('Gagal load kota_kabupaten.json', err));
});