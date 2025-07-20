# 📘 Blueprint Sistem Tracking Proyek Kontraktor - Tracky TKJ (Versi Disempurnakan)

Blueprint ini mendeskripsikan struktur database untuk aplikasi pelacakan proyek perusahaan kontraktor, siap dikonversi ke dalam migration Laravel. Setiap entitas disusun agar merepresentasikan alur kerja proyek dari awal hingga serah terima.

---

## 🏗 Projects
**Deskripsi:** Menyimpan informasi utama dari proyek.

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| project_code | string | Kode unik proyek |
| project_name | string | Nama proyek |
| client_name | string | Nama klien atau instansi |
| location | string | Lokasi proyek |
| start_date | date | Tanggal mulai |
| end_date | date | Tanggal selesai |
| status | enum | `Planning`, `On Progress`, `Completed`, `Cancelled` |
| notes | text | Catatan tambahan |
| created_at, updated_at | timestamps | Timestamp bawaan Laravel |

---

## 📄 SHPT (Surat Hasil Permintaan Teknis)
**Deskripsi:** Dokumen awal permintaan teknis dari klien.

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| shpt_number | string | Nomor dokumen SHPT |
| project_id | FK → Projects | Relasi ke proyek |
| created_date | date | Tanggal dibuat |
| submitted_date | date | Tanggal disubmit |
| status | enum | `Draft`, `Submitted`, `Approved`, `Rejected` |
| note | text | Catatan |
| created_at, updated_at | timestamps | - |

---

## 🧾 PO (Purchase Order)
**Deskripsi:** Dokumen pemesanan terhadap vendor atau internal.

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| po_number | string | Nomor PO |
| project_id | FK → Projects | Relasi ke proyek |
| created_date | date | Tanggal pembuatan PO |
| total_value | double | Nilai total PO |
| status | enum | `Draft`, `Approved`, `In Progress`, `Completed` |
| note | text | Catatan |
| created_at, updated_at | timestamps | - |

### 📦 PO_Items
**Deskripsi:** Item-item pada PO.

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| po_id | FK → PO | Relasi ke PO |
| description | string | Deskripsi barang/jasa |
| quantity | integer | Jumlah |
| unit | string | pcs, meter, kg, dll |
| unit_price | double | Harga satuan |
| subtotal | double | Total per item |
| created_at, updated_at | timestamps | - |

---

## 📊 Progress Tracking
**Deskripsi:** Melacak status pengerjaan proyek berdasarkan PO.

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| po_id | FK → PO | Relasi ke PO |
| progress_percentage | integer | 0–100 persen |
| overall_status | enum | `Not Started`, `On Progress`, `Delayed`, `Completed` |
| created_at, updated_at | timestamps | - |

### Sub Progress (Per Divisi)
Tabel-tabel berikut merepresentasikan progres di tiap divisi. Semua relasi ke `progress_tracking_id`.

#### 🛒 Purchasing / 🏭 Production / 🔧 Installation / 🎨 Finishing
| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| progress_tracking_id | FK | Relasi ke tracking induk |
| status | enum | Status per divisi |
| note | text | Catatan kendala/progres |
| pic_user_id | FK → Users | PIC pada tahap ini |
| deadline_date | date | Deadline tahap ini |
| updated_at | timestamp | - |

---

## 🧪 ATP (Acceptance Test Procedure)
**Deskripsi:** Serah terima hasil proyek untuk pengujian.

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| atp_number | string | Nomor dokumen |
| project_id | FK → Projects | - |
| created_date | date | Tanggal dibuat |
| accepted_date | date | Tanggal diterima |
| status | enum | `Waiting`, `Accepted`, `Rejected` |
| note | text | Catatan |
| created_at, updated_at | timestamps | - |

---

## 📜 BAST (Berita Acara Serah Terima)
**Deskripsi:** Dokumen final serah terima proyek.

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| bast_number | string | Nomor dokumen |
| project_id | FK → Projects | - |
| created_date | date | Tanggal dibuat |
| status | enum | `Pending`, `Submitted`, `Signed` |
| note | text | Catatan |
| created_at, updated_at | timestamps | - |

---

## 👤 Users
**Deskripsi:** Akun pengguna sistem (Admin, PIC, dll).

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| name | string | Nama lengkap |
| email | string | Email login |
| role | enum | `Admin`, `Manager`, `PIC` |
| created_at, updated_at | timestamps | - |

---

## 📚 Activity Logs
**Deskripsi:** Melacak aktivitas perubahan data oleh user.

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| reference_table | string | Nama tabel |
| reference_id | bigint | ID baris terkait |
| user_id | FK → Users | Pelaku aksi |
| action | enum | `create`, `update`, `delete` |
| description | text | Rincian aksi |
| created_at | timestamp | - |

---

## 📎 Files (Opsional)
**Deskripsi:** Menyimpan path file dokumen (jika ada upload).

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| project_id | FK → Projects | - |
| file_type | enum | `SHPT`, `PO`, `ATP`, `BAST`, dll |
| file_path | string | Path penyimpanan file |
| uploaded_by | FK → Users | User pengunggah |
| created_at | timestamp | - |

---

## 🔄 Relasi Penting
- `Projects` ↔ `SHPT`, `PO`, `ATP`, `BAST`, `Files`
- `PO` ↔ `PO_Items`, `Progress_Tracking`
- `Progress_Tracking` ↔ Divisi: Purchasing, Production, Installation, Finishing
- `Progress_Tracking` ↔ `Users` (sebagai PIC)
- `Activity_Logs` ↔ Semua entitas dengan tracking