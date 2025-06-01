from flask import Flask, render_template, request, jsonify
import pymysql.cursors
import json # Import modul json

app = Flask(__name__)

# --- Konfigurasi Database ---
DB_CONFIG = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'lowong', # Pastikan nama database sudah benar
    'cursorclass': pymysql.cursors.DictCursor
}

def get_db_connection():
    return pymysql.connect(**DB_CONFIG)

# Fungsi untuk memuat PROFIL_IDEAL dan BOBOT_KRITERIA berdasarkan bidang_id
def load_profil_dan_bobot_by_bidang(bidang_id):
    conn = None
    profil_ideal = {}
    bobot_kriteria = {}
    try:
        conn = get_db_connection()
        with conn.cursor() as cursor:
            # Load Profil Ideal
            cursor.execute("SELECT kriteria, nilai FROM profil_ideal WHERE bidang_id = %s", (bidang_id,))
            profil_ideal = {row['kriteria']: int(row['nilai']) for row in cursor.fetchall()}

            # Load Bobot Kriteria
            cursor.execute("SELECT kriteria, bobot FROM bobot_kriteria WHERE bidang_id = %s", (bidang_id,))
            bobot_kriteria = {row['kriteria']: float(row['bobot']) for row in cursor.fetchall()}

        print(f"Data Profil Ideal dan Bobot Kriteria untuk Bidang ID {bidang_id} berhasil dimuat.")
        # print("Profil Ideal:", profil_ideal) # Komentari atau hapus untuk output lebih bersih
        # print("Bobot Kriteria:", bobot_kriteria) # Komentari atau hapus untuk output lebih bersih
        return profil_ideal, bobot_kriteria

    except Exception as e:
        print(f"Error saat memuat profil dan bobot untuk bidang ID {bidang_id}: {e}")
        # Jika ada error, gunakan data default (penting agar aplikasi tidak crash)
        return {
            'pendidikan': 4,
            'pengalaman_kerja': 4,
            'keterampilan_komunikasi': 4,
            'problem_solving': 4
        }, {
            'pendidikan': 0.25,
            'pengalaman_kerja': 0.25,
            'keterampilan_komunikasi': 0.25,
            'problem_solving': 0.25
        }
    finally:
        if conn:
            conn.close()

# Fungsi konversi GAP ke skor (tetap sama)
def konversi_gap_ke_skor(gap):
    gap = abs(gap)
    if gap == 0:
        return 5.0
    elif gap == 1:
        return 4.0
    elif gap == 2:
        return 3.0
    elif gap == 3:
        return 2.0
    elif gap == 4:
        return 1.0
    else:
        return 1.0

# Fungsi untuk menghitung skor kecocokan satu kandidat
def calculate_single_candidate_score(candidate_data, profil_ideal, bobot_kriteria):
    skor_total = 0
    penjelasan_skor = []

    for kriteria in profil_ideal.keys():
        if kriteria in candidate_data and kriteria in bobot_kriteria:
            ideal_value = profil_ideal[kriteria]
            kandidat_value = candidate_data[kriteria]
            
            gap = kandidat_value - ideal_value
            skor_gap = konversi_gap_ke_skor(gap)
            
            skor_normalisasi = (skor_gap / 5.0) * bobot_kriteria[kriteria]
            skor_total += skor_normalisasi

            penjelasan_skor.append(f"{kriteria.replace('_', ' ').title()}: Kandidat {kandidat_value}, Ideal {ideal_value}, GAP {gap}, Skor Konversi {skor_gap:.2f}, Bobot {bobot_kriteria[kriteria]}, Skor x Bobot {skor_normalisasi:.2f}")
    
    return round(skor_total * 100, 2), penjelasan_skor

# --- Rute Utama (index) ---
@app.route('/')
def index():
    return render_template('index.php', profil_ideal={}, bobot_kriteria={})

# --- Rute: Mendapatkan Daftar Bidang ---
@app.route('/get_bidang', methods=['GET'])
def get_bidang():
    conn = None
    try:
        conn = get_db_connection()
        with conn.cursor() as cursor:
            cursor.execute("SELECT id, nama_bidang FROM bidang ORDER BY nama_bidang")
            bidang_list = cursor.fetchall()
        return jsonify(bidang_list)
    except Exception as e:
        print(f"Error fetching bidang: {e}")
        return jsonify({"error": "Gagal mengambil daftar bidang."}), 500
    finally:
        if conn:
            conn.close()

# --- Rute: Mendapatkan Profil Ideal dan Bobot Berdasarkan Bidang ID ---
@app.route('/get_profil_bobot_by_bidang/<int:bidang_id>', methods=['GET'])
def get_profil_bobot_by_bidang_route(bidang_id):
    profil_ideal, bobot_kriteria = load_profil_dan_bobot_by_bidang(bidang_id)
    if not profil_ideal or not bobot_kriteria:
        return jsonify({"error": "Data profil ideal atau bobot tidak ditemukan untuk bidang ini."}), 404
    return jsonify({
        'profil_ideal': profil_ideal,
        'bobot_kriteria': bobot_kriteria
    })

# --- Rute: Mendapatkan Tahun Pendaftaran Unik ---
@app.route('/get_unique_years', methods=['GET'])
def get_unique_years():
    conn = None
    try:
        conn = get_db_connection()
        with conn.cursor() as cursor:
            cursor.execute("SELECT DISTINCT tahun_daftar FROM calon_karyawan ORDER BY tahun_daftar DESC")
            years = [row['tahun_daftar'] for row in cursor.fetchall()]
        return jsonify(years)
    except Exception as e:
        print(f"Error fetching unique years: {e}")
        return jsonify({"error": "Gagal mengambil daftar tahun pendaftaran."}), 500
    finally:
        if conn:
            conn.close()

# --- Rute UNTUK MENDAPATKAN CALON KARYAWAN (difilter berdasarkan BIDANG dan TAHUN) ---
@app.route('/get_candidates', methods=['GET'])
def get_candidates():
    tahun = request.args.get('tahun')
    bidang_id = request.args.get('bidang_id')

    conn = None
    try:
        conn = get_db_connection()
        with conn.cursor() as cursor:
            query = """
                SELECT
                    ck.id,
                    ck.nama,
                    ck.tahun_daftar,
                    ck.pendidikan,
                    ck.pengalaman_kerja,
                    ck.keterampilan_komunikasi,
                    ck.problem_solving
                FROM calon_karyawan ck
            """
            params = []
            where_clauses = []

            if bidang_id and bidang_id.isdigit():
                query += """
                    JOIN kandidat_bidang kb ON ck.id = kb.calon_karyawan_id
                    WHERE kb.bidang_id = %s
                """
                params.append(int(bidang_id))
                
                if tahun and tahun.isdigit():
                    where_clauses.append("ck.tahun_daftar = %s")
                    params.append(int(tahun))
            elif tahun and tahun.isdigit():
                where_clauses.append("ck.tahun_daftar = %s")
                params.append(int(tahun))
                query += " WHERE " + " AND ".join(where_clauses)
            
            if where_clauses and (bidang_id and bidang_id.isdigit()):
                query += " AND " + " AND ".join(where_clauses)

            cursor.execute(query, tuple(params))
            candidates = cursor.fetchall()
        return jsonify(candidates)
    except Exception as e:
        print(f"Error fetching candidates: {e}")
        return jsonify({"error": "Gagal mengambil data calon karyawan."}), 500
    finally:
        if conn:
            conn.close()

# --- Rute untuk Menghitung Kecocokan Kandidat yang Dipilih ---
@app.route('/match_selected_candidates', methods=['POST'])
def match_selected_candidates():
    data = request.json
    selected_ids = data.get('candidate_ids', [])
    bidang_id = data.get('bidang_id')

    if not bidang_id:
        return jsonify({"error": "Bidang belum dipilih. Silakan pilih bidang terlebih dahulu."}), 400

    profil_ideal_aktif, bobot_kriteria_aktif = load_profil_dan_bobot_by_bidang(bidang_id)

    if not profil_ideal_aktif or not bobot_kriteria_aktif:
        return jsonify({"error": "Profil ideal atau bobot kriteria tidak ditemukan untuk bidang yang dipilih."}), 404

    if not selected_ids:
        return jsonify({"message": "Tidak ada kandidat yang dipilih untuk pencocokan."}), 200

    selected_ids = [int(id) for id in selected_ids]

    conn = None
    try:
        conn = get_db_connection()
        with conn.cursor() as cursor:
            placeholders = ', '.join(['%s'] * len(selected_ids))
            sql_query = f"""
                SELECT
                    id,
                    nama,
                    tahun_daftar,
                    pendidikan,
                    pengalaman_kerja,
                    keterampilan_komunikasi,
                    problem_solving
                FROM calon_karyawan
                WHERE id IN ({placeholders})
            """
            cursor.execute(sql_query, selected_ids)
            candidates_data = cursor.fetchall()

        results = []
        for candidate in candidates_data:
            candidate_criteria = {
                'pendidikan': candidate['pendidikan'],
                'pengalaman_kerja': candidate['pengalaman_kerja'],
                'keterampilan_komunikasi': candidate['keterampilan_komunikasi'],
                'problem_solving': candidate['problem_solving']
            }
            
            skor_kecocokan, penjelasan = calculate_single_candidate_score(
                candidate_criteria, profil_ideal_aktif, bobot_kriteria_aktif
            )
            
            # Tambahkan bidang_id ke setiap hasil, ini penting untuk penyimpanan
            results.append({
                'id': candidate['id'],
                'nama': candidate['nama'],
                'skor_kecocokan': skor_kecocokan,
                'detail_kandidat': candidate,
                'penjelasan_skor': penjelasan,
                'bidang_id': int(bidang_id) # Pastikan bidang_id masuk ke hasil
            })
        
        results.sort(key=lambda x: x['skor_kecocokan'], reverse=True)

        return jsonify(results)

    except Exception as e:
        print(f"Error saat menghitung kecocokan kandidat terpilih: {e}")
        return jsonify({"error": f"Gagal menghitung kecocokan kandidat: {e}"}), 500
    finally:
        if conn:
            conn.close()

# --- Rute Baru: Menyimpan Hasil Pencocokan ke Database ---
@app.route('/save_matching_results', methods=['POST'])
def save_matching_results():
    data = request.json # Data ini adalah list of candidate results

    if not data:
        return jsonify({"error": "Tidak ada data yang disediakan untuk disimpan."}), 400

    conn = None
    try:
        conn = get_db_connection()
        with conn.cursor() as cursor:
            for result in data:
                calon_karyawan_id = result.get('id')
                bidang_id = result.get('bidang_id')
                skor_kecocokan = result.get('skor_kecocokan')
                
                # Convert list penjelasan_skor to JSON string for storage
                penjelasan_skor_json = json.dumps(result.get('penjelasan_skor', []))

                # Pastikan semua data penting ada
                if not all([calon_karyawan_id, bidang_id, skor_kecocokan is not None]):
                    print(f"Peringatan: Melewatkan data tidak lengkap: {result}")
                    continue # Lewati jika ada data yang kurang

                cursor.execute(
                    """
                    INSERT INTO hasil_pencocokan
                    (calon_karyawan_id, bidang_id, skor_kecocokan, detail_penjelasan_skor)
                    VALUES (%s, %s, %s, %s)
                    """,
                    (calon_karyawan_id, bidang_id, skor_kecocokan, penjelasan_skor_json)
                )
            conn.commit() # Commit transaksi setelah semua insert berhasil
        return jsonify({"message": "Hasil pencocokan berhasil disimpan ke database!"}), 200
    except Exception as e:
        print(f"Error saat menyimpan hasil pencocokan: {e}")
        conn.rollback() # Rollback jika ada kesalahan
        return jsonify({"error": f"Gagal menyimpan hasil pencocokan: {e}"}), 500
    finally:
        if conn:
            conn.close()

if __name__ == '__main__':
    app.run(debug=True)