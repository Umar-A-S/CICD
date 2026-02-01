const input = document.getElementById('fileUpload');
        const preview = document.getElementById('filePreview');

        let filesArr = [];

        input.addEventListener('change', function () {
            [...this.files].forEach(file => {
                filesArr.push(file);
            });
            renderFiles();
            this.value = '';
        });

        function renderFiles() {
            preview.innerHTML = '';

            filesArr.forEach((file, index) => {
                const url = URL.createObjectURL(file);

                preview.innerHTML += `
                    <div class="flex items-center justify-between bg-slate-100 px-4 py-3 rounded-lg">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-file-pdf text-red-500 text-xl"></i>
                            <span class="text-sm font-semibold">${file.name}</span>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="button"
                                onclick="openPdf('${url}')"
                                class="text-sky-600 hover:text-sky-800">
                                <i class="fa-solid fa-eye"></i>
                            </button>

                            <button type="button"
                                onclick="removeFile(${index})"
                                class="text-red-500 hover:text-red-700">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
            });

            syncFileInput();
        }

        function removeFile(index) {
            filesArr.splice(index, 1);
            renderFiles();
        }

        function syncFileInput() {
            const dataTransfer = new DataTransfer();
            filesArr.forEach(file => dataTransfer.items.add(file));
            input.files = dataTransfer.files;
        }

        function openPdf(url) {
            document.getElementById('pdfFrame').src = url;
            document.getElementById('pdfModal').classList.remove('hidden');
            document.getElementById('pdfModal').classList.add('flex');
        }

        function closePdf() {
            document.getElementById('pdfFrame').src = '';
            document.getElementById('pdfModal').classList.add('hidden');
            document.getElementById('pdfModal').classList.remove('flex');
        }