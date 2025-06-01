<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Profil Matching Karyawan</title>
    <link rel="stylesheet" href="{{ url_for('static', filename='css/style.css') }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            text-align: center;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 2em;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        button:hover {
            background-color: #0056b3;
        }
        
        #filterSection {
            text-align: left;
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fcfcfc;
        }
        #filterSection label {
            font-weight: bold;
            margin-right: 10px;
            color: #34495e;
            display: inline-block;
            margin-bottom: 5px;
        }
        #filterSection select {
            padding: 8px 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1em;
            width: auto;
            margin-right: 15px;
        }
        .filter-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .filter-group:last-child {
            margin-bottom: 0;
        }

        #candidatesSelection {
            text-align: left;
            margin-bottom: 20px;
            max-height: 350px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background-color: #fcfcfc;
        }
        #candidatesSelection h2 {
            margin-top: 0;
            color: #34495e;
            margin-bottom: 15px;
        }
        .candidate-item {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            border-bottom: 1px dashed #eee;
            padding-bottom: 8px;
        }
        .candidate-item:last-child {
            border-bottom: none;
        }
        .candidate-item input[type="checkbox"] {
            margin-right: 10px;
            transform: scale(1.2);
            cursor: pointer;
        }
        .candidate-item label {
            font-size: 1.1em;
            color: #2c3e50;
            font-weight: normal;
            cursor: pointer;
            flex-grow: 1;
        }
        .candidate-item span.tahun {
            font-size: 0.9em;
            color: #777;
            margin-left: auto;
            padding-left: 10px;
        }
        .select-all-container {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
            display: flex;
            align-items: center;
        }
        .select-all-container input[type="checkbox"] {
            margin-right: 10px;
            transform: scale(1.3);
            cursor: pointer;
        }
        .select-all-container label {
            font-weight: bold;
            font-size: 1.1em;
            cursor: pointer;
        }


        /* Gaya untuk hasil pencocokan */
        #matchingResults {
            margin-top: 30px;
            text-align: left;
        }
        #matchingResults h2 {
            color: #2c3e50;
            margin-bottom: 15px;
        }
        .candidate-card {
            background-color: #e6f7ff;
            border: 1px solid #91d5ff;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: transform 0.2s ease-in-out;
        }
        .candidate-card:hover {
            transform: translateY(-3px);
        }
        .candidate-card h3 {
            color: #0056b3;
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.3em;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .candidate-card .score {
            font-size: 1.5em;
            font-weight: bold;
            color: #28a745;
        }
        .candidate-card p {
            margin: 5px 0;
            color: #333;
        }
        .candidate-card ul {
            list-style: disc;
            margin-left: 20px;
            color: #555;
            font-size: 0.9em;
            margin-top: 10px;
        }
        .loading-spinner {
            display: none;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Gaya untuk informasi profil ideal/bobot */
        .info-box {
            margin-top: 30px;
            padding: 20px;
            background-color: #e9ecef;
            border-radius: 8px;
            text-align: left;
            font-size: 0.9em;
            color: #495057;
        }
        .info-box h3 {
            margin-top: 0;
            color: #007bff;
        }
        .info-box ul {
            list-style-type: disc;
            margin-left: 20px;
        }
        /* Style for Save Results Button */
        #saveResultsButton {
            background-color: #28a745; /* Green color */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            margin-top: 15px;
            margin-bottom: 10px;
            display: none; /* Hidden by default */
        }
        #saveResultsButton:hover {
            background-color: #218838;
        }
        #saveMessage {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sistem Profil Matching Karyawan</h1>
        <p>Pilih bidang dan periode tahun, lalu pilih karyawan yang ingin dicocokkan.</p>

        <div id="filterSection">
            <div class="filter-group">
                <label for="bidangFilter">Pilih Bidang:</label>
                <select id="bidangFilter">
                    <option value="">-- Pilih Bidang --</option>
                    </select>
            </div>
            <div class="filter-group">
                <label for="yearFilter">Pilih Periode Tahun:</label>
                <select id="yearFilter" disabled>
                    <option value="">Semua Tahun</option>
                    </select>
            </div>
        </div>

        <div id="candidatesSelection">
            <h2>Daftar Calon Karyawan</h2>
            <div class="select-all-container">
                <input type="checkbox" id="selectAllCandidates" disabled>
                <label for="selectAllCandidates">Pilih Semua</label>
            </div>
            <div id="candidatesCheckboxes">
                <p id="selectBidangMessage" style="color:#888;">Silakan pilih bidang terlebih dahulu.</p>
                </div>
            <p id="noCandidatesMessage" style="display:none; color: #888;">Tidak ada calon karyawan yang ditemukan untuk periode ini.</p>
        </div>

        <button id="matchSelectedButton" disabled>Cocokkan yang Dipilih</button>
        <a href="http://localhost/lowongan/admin/index.php?page=home">
            <button style="background-color: #007bff;" >Kembali</button>
        </a>
        <div class="loading-spinner" id="loadingSpinner"></div>

        <div id="matchingResults" style="display:none;">
            <h2>Hasil Kecocokan Calon Karyawan (Terurut dari Terbaik):</h2>
            <div id="candidatesList">
                </div>
            <button id="saveResultsButton" style="display:none;">Simpan Hasil ke Database</button>
            <p id="saveMessage"></p>
        </div>

        {# Bagian untuk menampilkan Profil Ideal dan Bobot yang digunakan #}
        <div class="info-box" id="infoBox">
            <h3>Profil Ideal yang Digunakan (<span id="activeBidangName">Belum Dipilih</span>):</h3>
            <ul id="profilIdealList">
                <li>Silakan pilih bidang untuk melihat profil ideal.</li>
            </ul>
            <h3>Bobot Kriteria yang Digunakan (<span id="activeBidangNameBobot">Belum Dipilih</span>):</h3>
            <ul id="bobotKriteriaList">
                <li>Silakan pilih bidang untuk melihat bobot kriteria.</li>
            </ul>
        </div>
    </div>

    <script>
        // Helper function untuk mengubah string menjadi Title Case
        function toTitleCase(str) {
            if (typeof str !== 'string') return str;
            return str.replace(/_/g, ' ').split(' ').map(word => {
                if (word.length === 0) return '';
                return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
            }).join(' ');
        }

        // --- DOM Elements ---
        const bidangFilter = document.getElementById('bidangFilter');
        const yearFilter = document.getElementById('yearFilter');
        const selectAllCheckbox = document.getElementById('selectAllCandidates');
        const candidatesCheckboxesDiv = document.getElementById('candidatesCheckboxes');
        const noCandidatesMessage = document.getElementById('noCandidatesMessage');
        const selectBidangMessage = document.getElementById('selectBidangMessage');
        const matchSelectedButton = document.getElementById('matchSelectedButton');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const resultsDiv = document.getElementById('matchingResults');
        const candidatesListDiv = document.getElementById('candidatesList');
        const profilIdealList = document.getElementById('profilIdealList');
        const bobotKriteriaList = document.getElementById('bobotKriteriaList');
        const activeBidangNameSpan = document.getElementById('activeBidangName');
        const activeBidangNameBobotSpan = document.getElementById('activeBidangNameBobot');
        const saveResultsButton = document.getElementById('saveResultsButton'); // New element
        const saveMessage = document.getElementById('saveMessage'); // New element

        let currentActiveBidangId = null;
        let currentActiveBidangName = "";
        let lastMatchingResults = []; // New global variable to store results

        // --- Fungsi Pemuatan Data ---

        async function loadBidang() {
            try {
                const response = await fetch('/get_bidang');
                const bidangList = await response.json();

                if (response.ok) {
                    bidangList.forEach(bidang => {
                        const option = document.createElement('option');
                        option.value = bidang.id;
                        option.textContent = bidang.nama_bidang;
                        bidangFilter.appendChild(option);
                    });
                } else {
                    console.error('Error loading bidang:', bidangList.error || 'Unknown error');
                }
            } catch (error) {
                console.error('Network error loading bidang:', error);
            }
        }

        async function loadYears() {
            yearFilter.innerHTML = '<option value="">Semua Tahun</option>';
            try {
                const response = await fetch('/get_unique_years');
                const years = await response.json();

                if (response.ok) {
                    years.forEach(year => {
                        const option = document.createElement('option');
                        option.value = year;
                        option.textContent = year;
                        yearFilter.appendChild(option);
                    });
                } else {
                    console.error('Error loading years:', years.error || 'Unknown error');
                }
            } catch (error) {
                console.error('Network error loading years:', error);
            }
        }

        async function loadProfilAndBobot(bidangId) {
            profilIdealList.innerHTML = '<li style="color:#888;">Memuat...</li>';
            bobotKriteriaList.innerHTML = '<li style="color:#888;">Memuat...</li>';
            activeBidangNameSpan.textContent = 'Memuat...';
            activeBidangNameBobotSpan.textContent = 'Memuat...';

            try {
                const response = await fetch(`/get_profil_bobot_by_bidang/${bidangId}`);
                const data = await response.json();

                if (response.ok) {
                    profilIdealList.innerHTML = '';
                    bobotKriteriaList.innerHTML = '';

                    for (const kriteria in data.profil_ideal) {
                        const li = document.createElement('li');
                        li.textContent = `${toTitleCase(kriteria)}: ${data.profil_ideal[kriteria]}`;
                        profilIdealList.appendChild(li);
                    }
                    for (const kriteria in data.bobot_kriteria) {
                        const li = document.createElement('li');
                        li.textContent = `${toTitleCase(kriteria)}: ${data.bobot_kriteria[kriteria]}`;
                        bobotKriteriaList.appendChild(li);
                    }
                    currentActiveBidangName = bidangFilter.options[bidangFilter.selectedIndex].textContent;
                    activeBidangNameSpan.textContent = currentActiveBidangName;
                    activeBidangNameBobotSpan.textContent = currentActiveBidangName;

                } else {
                    profilIdealList.innerHTML = `<li style="color:red;">Error: ${data.error || 'Gagal memuat profil.'}</li>`;
                    bobotKriteriaList.innerHTML = `<li style="color:red;">Error: ${data.error || 'Gagal memuat bobot.'}</li>`;
                    activeBidangNameSpan.textContent = 'Error';
                    activeBidangNameBobotSpan.textContent = 'Error';
                    console.error('Error loading profil/bobot:', data.error);
                }
            } catch (error) {
                profilIdealList.innerHTML = `<li style="color:red;">Network Error: ${error.message}</li>`;
                bobotKriteriaList.innerHTML = `<li style="color:red;">Network Error: ${error.message}</li>`;
                activeBidangNameSpan.textContent = 'Error Koneksi';
                activeBidangNameBobotSpan.textContent = 'Error Koneksi';
                console.error('Network error loading profil/bobot:', error);
            }
        }

        async function loadCandidates(bidangId = '', year = '') {
            candidatesCheckboxesDiv.innerHTML = '';
            noCandidatesMessage.style.display = 'none';
            selectBidangMessage.style.display = 'none';
            selectAllCheckbox.checked = false;
            selectAllCheckbox.disabled = true;
            saveResultsButton.style.display = 'none'; // Sembunyikan tombol simpan
            saveMessage.textContent = ''; // Bersihkan pesan simpan

            if (!bidangId) {
                selectBidangMessage.style.display = 'block';
                return;
            }

            candidatesCheckboxesDiv.innerHTML = '<p style="text-align:center; color:#888;">Memuat kandidat...</p>';

            let url = '/get_candidates?';
            const params = [];
            if (bidangId) {
                params.push(`bidang_id=${bidangId}`);
            }
            if (year) {
                params.push(`tahun=${year}`);
            }
            url += params.join('&');

            try {
                const response = await fetch(url);
                const candidates = await response.json();

                candidatesCheckboxesDiv.innerHTML = '';

                if (response.ok) {
                    if (candidates.length === 0) {
                        noCandidatesMessage.style.display = 'block';
                        selectAllCheckbox.disabled = true;
                    } else {
                        selectAllCheckbox.disabled = false;
                        candidates.forEach(candidate => {
                            const itemDiv = document.createElement('div');
                            itemDiv.classList.add('candidate-item');

                            const checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.id = `candidate-${candidate.id}`;
                            checkbox.value = candidate.id;
                            checkbox.name = 'selected_candidate'; 

                            const label = document.createElement('label');
                            label.htmlFor = `candidate-${candidate.id}`;
                            label.textContent = candidate.nama;

                            const tahunSpan = document.createElement('span');
                            tahunSpan.classList.add('tahun');
                            if (candidate.tahun_daftar) {
                                tahunSpan.textContent = `(${candidate.tahun_daftar})`;
                            }

                            itemDiv.appendChild(checkbox);
                            itemDiv.appendChild(label);
                            itemDiv.appendChild(tahunSpan);
                            candidatesCheckboxesDiv.appendChild(itemDiv);
                        });
                    }
                } else {
                    candidatesCheckboxesDiv.innerHTML = `<p style="color: red;">Error memuat daftar karyawan: ${candidates.error || 'Terjadi kesalahan.'}</p>`;
                    selectAllCheckbox.disabled = true;
                }
            } catch (error) {
                console.error('Network error fetching candidates:', error);
                candidatesCheckboxesDiv.innerHTML = `<p style="color: red;">Gagal terhubung ke server untuk memuat daftar karyawan.</p>`;
                selectAllCheckbox.disabled = true;
            }
        }


        // --- Event Listeners ---

        document.addEventListener('DOMContentLoaded', async function() {
            await loadBidang();
            await loadYears();
            selectBidangMessage.style.display = 'block';
        });

        bidangFilter.addEventListener('change', async function() {
            const selectedBidangId = this.value;
            const selectedYear = yearFilter.value;

            matchSelectedButton.disabled = true;
            yearFilter.disabled = true;
            selectAllCheckbox.disabled = true;
            selectAllCheckbox.checked = false;
            saveResultsButton.style.display = 'none'; // Sembunyikan tombol simpan
            saveMessage.textContent = ''; // Bersihkan pesan simpan
            resultsDiv.style.display = 'none'; // Sembunyikan hasil lama

            if (selectedBidangId) {
                currentActiveBidangId = selectedBidangId;
                
                yearFilter.disabled = false;
                matchSelectedButton.disabled = false; 

                await loadProfilAndBobot(selectedBidangId);
                await loadCandidates(selectedBidangId, selectedYear);
                selectBidangMessage.style.display = 'none';

            } else {
                currentActiveBidangId = null;
                profilIdealList.innerHTML = '<li>Silakan pilih bidang untuk melihat profil ideal.</li>';
                bobotKriteriaList.innerHTML = '<li>Silakan pilih bidang untuk melihat bobot kriteria.</li>';
                activeBidangNameSpan.textContent = 'Belum Dipilih';
                activeBidangNameBobotSpan.textContent = 'Belum Dipilih';

                candidatesCheckboxesDiv.innerHTML = '';
                selectBidangMessage.style.display = 'block';
                noCandidatesMessage.style.display = 'none';

                yearFilter.disabled = true;
            }
        });

        yearFilter.addEventListener('change', function() {
            const selectedYear = this.value;
            loadCandidates(currentActiveBidangId, selectedYear);
            saveResultsButton.style.display = 'none'; // Sembunyikan tombol simpan
            saveMessage.textContent = ''; // Bersihkan pesan simpan
            resultsDiv.style.display = 'none'; // Sembunyikan hasil lama
        });

        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            const checkboxes = document.querySelectorAll('#candidatesCheckboxes input[type="checkbox"][name="selected_candidate"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
        });

        // Event listener untuk tombol pencocokan
        matchSelectedButton.addEventListener('click', async function() {
            if (!currentActiveBidangId) {
                alert("Mohon pilih bidang terlebih dahulu!");
                return;
            }

            resultsDiv.style.display = 'none';
            candidatesListDiv.innerHTML = '';
            loadingSpinner.style.display = 'block';
            saveResultsButton.style.display = 'none'; // Sembunyikan tombol simpan saat proses perhitungan
            saveMessage.textContent = ''; // Bersihkan pesan simpan

            const selectedCheckboxes = document.querySelectorAll('#candidatesCheckboxes input[type="checkbox"][name="selected_candidate"]:checked');
            const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);

            if (selectedIds.length === 0) {
                candidatesListDiv.innerHTML = '<p style="color: orange;">Tidak ada kandidat yang dipilih untuk pencocokan.</p>';
                resultsDiv.style.display = 'block';
                loadingSpinner.style.display = 'none';
                return;
            }

            try {
                const response = await fetch('/match_selected_candidates', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ 
                        candidate_ids: selectedIds,
                        bidang_id: currentActiveBidangId
                    })
                });

                const results = await response.json();

                if (response.ok) {
                    if (results.length === 0) {
                        candidatesListDiv.innerHTML = '<p>Tidak ada hasil pencocokan (mungkin ID tidak ditemukan atau terjadi kesalahan server).</p>';
                    } else if (results.message) {
                        candidatesListDiv.innerHTML = `<p style="color: orange;">${results.message}</p>`;
                    }
                    else {
                        lastMatchingResults = results; // Simpan hasil ke variabel global
                        
                        results.forEach(candidate => {
                            const card = document.createElement('div');
                            card.classList.add('candidate-card');
                            
                            const header = document.createElement('h3');
                            header.innerHTML = `${candidate.nama} <span class="score">${candidate.skor_kecocokan}%</span>`;
                            card.appendChild(header);

                            const detailKandidatDiv = document.createElement('div');
                            detailKandidatDiv.innerHTML = '<p><strong>Data Kriteria Kandidat:</strong></p>';
                            const ulDetail = document.createElement('ul');
                            for (const key in candidate.detail_kandidat) {
                                if (typeof key === 'string' && key !== 'id' && key !== 'nama' && key !== 'tahun_daftar') { 
                                    const li = document.createElement('li');
                                    li.textContent = `${toTitleCase(key)}: ${candidate.detail_kandidat[key]}`;
                                    ulDetail.appendChild(li);
                                } else if (key === 'tahun_daftar' && candidate.detail_kandidat[key]) {
                                     const li = document.createElement('li');
                                     li.textContent = `Tahun Daftar: ${candidate.detail_kandidat[key]}`;
                                     ulDetail.appendChild(li);
                                }
                            }
                            detailKandidatDiv.appendChild(ulDetail);
                            card.appendChild(detailKandidatDiv);

                            const penjelasanDiv = document.createElement('div');
                            penjelasanDiv.innerHTML = '<p><strong>Detail Perhitungan Skor:</strong></p>';
                            const ulPenjelasan = document.createElement('ul');
                            candidate.penjelasan_skor.forEach(item => {
                                const li = document.createElement('li');
                                li.textContent = item;
                                ulPenjelasan.appendChild(li);
                            });
                            penjelasanDiv.appendChild(ulPenjelasan);
                            card.appendChild(penjelasanDiv);

                            candidatesListDiv.appendChild(card);
                        });
                        saveResultsButton.style.display = 'block'; // Tampilkan tombol simpan
                    }
                    resultsDiv.style.display = 'block';
                } else {
                    candidatesListDiv.innerHTML = `<p style="color: red;">Error: ${results.error || 'Terjadi kesalahan.'}</p>`;
                    resultsDiv.style.display = 'block';
                }
            } catch (error) {
                console.error('Error:', error);
                candidatesListDiv.innerHTML = `<p style="color: red;">Terjadi kesalahan pada koneksi atau server: ${error.message}</p>`;
                resultsDiv.style.display = 'block';
            } finally {
                loadingSpinner.style.display = 'none';
            }
        });

        // Event listener untuk tombol "Simpan Hasil ke Database"
        saveResultsButton.addEventListener('click', async function() {
            if (lastMatchingResults.length === 0) {
                saveMessage.style.color = 'orange';
                saveMessage.textContent = 'Tidak ada hasil untuk disimpan.';
                return;
            }

            saveResultsButton.disabled = true; // Nonaktifkan tombol saat menyimpan
            saveMessage.textContent = 'Sedang menyimpan...';
            saveMessage.style.color = '#007bff';

            try {
                const response = await fetch('/save_matching_results', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(lastMatchingResults) // Kirim semua hasil yang disimpan
                });

                const data = await response.json();

                if (response.ok) {
                    saveMessage.style.color = 'green';
                    saveMessage.textContent = data.message;
                    // Optional: Reset lastMatchingResults = [] if you want to prevent double saving
                    // lastMatchingResults = []; 
                } else {
                    saveMessage.style.color = 'red';
                    saveMessage.textContent = `Gagal menyimpan: ${data.error || 'Terjadi kesalahan.'}`;
                }
            } catch (error) {
                console.error('Error saving results:', error);
                saveMessage.style.color = 'red';
                saveMessage.textContent = `Gagal menyimpan: Kesalahan koneksi (${error.message})`;
            } finally {
                saveResultsButton.disabled = false; // Aktifkan kembali tombol
            }
        });

    </script>
</body>
</html>