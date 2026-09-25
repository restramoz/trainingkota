============================================================
TRAININGKOTA — MASTER UI/UX AUDIT & REPAIR INSTRUCTION
============================================================

PROJECT:
TrainingKota

PURPOSE:
Melakukan perbaikan UI/UX berdasarkan hasil audit terbaru tanpa
merusak architecture, database relationship, routing, business
logic, fitur yang sudah berjalan, maupun desain yang sudah benar.

============================================================
⚠️ ABSOLUTE LOCK — WAJIB DIPATUHI AGENT
============================================================

RULE 01 — JANGAN REBUILD PROJECT
Jangan melakukan rewrite, rebuild, refactor besar, atau membuat
ulang architecture hanya karena menemukan masalah UI/UX.

Perbaiki bagian yang memang bermasalah saja.

------------------------------------------------------------

RULE 02 — JANGAN MENGUBAH DATABASE STRUCTURE SEMBARANGAN
Jangan membuat migration, menghapus column, mengganti relationship,
menghapus model, atau mengubah struktur database hanya untuk
menyelesaikan masalah UI.

Jika memang ditemukan bahwa database relationship tidak cukup untuk
memenuhi requirement, STOP dan laporkan terlebih dahulu.

Jangan mengambil keputusan database sendiri.

------------------------------------------------------------

RULE 03 — JANGAN MENGUBAH BUSINESS LOGIC YANG SUDAH BERJALAN
Fitur yang sudah berjalan harus tetap berjalan.

Jangan mengganti:
- routing
- controller architecture
- model relationship
- slug structure
- BPS relationship
- city/kabupaten distinction
- kecamatan relationship
- service/category relationship
- existing API/data import logic

kecuali memang diperlukan dan sudah diverifikasi.

------------------------------------------------------------

RULE 04 — KOTA DAN KABUPATEN HARUS TETAP DIBEDAKAN
TrainingKota menggunakan data wilayah berdasarkan BPS.

Jangan menggabungkan:
- Kota
- Kabupaten

hanya karena namanya mirip.

BPS CODE adalah sumber identitas wilayah.

Jangan menggunakan nama wilayah sebagai pengganti BPS code
untuk menentukan identity/relationship jika BPS code tersedia.

------------------------------------------------------------

RULE 05 — JANGAN MENGHAPUS FITUR YANG SUDAH ADA
Jika sebuah fitur sudah ada dan bekerja:

KEEP IT.

Jangan mengganti implementasinya hanya karena agent memiliki
preferensi implementation yang berbeda.

------------------------------------------------------------

RULE 06 — JANGAN MENGUBAH DESIGN SYSTEM SEMBARANGAN
Sebelum membuat komponen baru, cari dan gunakan komponen/design
pattern yang sudah ada.

Jangan membuat:
- button style baru tanpa alasan
- card style baru tanpa alasan
- spacing system baru
- typography system baru
- warna baru
- layout system baru

jika sudah tersedia di project.

============================================================
🔒 GLOBAL UI/UX RULES
============================================================

RULE A — CARD LIMIT

Untuk semua listing program/layanan:

DEFAULT:
Tampilkan hanya 4 atau 6 card.

Setelah itu tampilkan:

[ Show All ]

Klik Show All:
→ tampilkan seluruh item.

Jangan menampilkan puluhan/ratusan card sekaligus pada initial
page load jika requirement halaman tersebut menggunakan Show All.

Gunakan jumlah yang konsisten dengan layout halaman.

------------------------------------------------------------

RULE B — RESPONSIVE

Semua halaman wajib responsive:

Desktop
Tablet
Mobile

Minimal test:
- desktop
- tablet
- mobile width

Jangan hanya memperbaiki desktop.

Pastikan:
- tidak horizontal overflow
- card tidak keluar container
- text tidak bertabrakan
- button tidak keluar layar
- navigation tetap usable
- sidebar tetap usable
- article layout responsive

------------------------------------------------------------

RULE C — BPS REGION HIERARCHY

Untuk seluruh UI wilayah gunakan struktur:

PULAU / WILAYAH
    ↓
KOTA / KABUPATEN
    ↓
KECAMATAN

Grouping harus mengikuti data BPS.

Jangan membuat grouping wilayah berdasarkan asumsi agent.

------------------------------------------------------------

RULE D — COLLAPSE / EXPAND

Jika listing terlalu panjang, gunakan:

Collapsed by default
→ user dapat membuka wilayah/program dengan collapse/expand.

Jangan memenuhi halaman dengan seluruh data sekaligus.

------------------------------------------------------------

RULE E — EXISTING DATA FIRST

Jangan membuat dummy data jika data sebenarnya sudah tersedia
di database.

Jika data belum tersedia:
STOP dan laporkan.

Jangan mengisi database dengan data palsu hanya agar UI terlihat
selesai.

============================================================
1. HOME PAGE
============================================================

TASK 1 — WIDGET 514 KOTA/KABUPATEN

Saat ini widget 514 Kota/Kabupaten belum memiliki pemisah wilayah.

UBAH MENJADI:

PULAU / WILAYAH
    ↓
    Kota/Kabupaten
    Kota/Kabupaten
    Kota/Kabupaten

Setiap wilayah harus memiliki:

[ Collapse / Expand ]

DEFAULT:
Wilayah dapat dalam kondisi collapsed.

Saat user membuka wilayah:
→ daftar Kota/Kabupaten muncul.

------------------------------------------------------------

TASK 2 — HAPUS "JADWAL AKTIF"

Hapus tampilan:

[Jadwal Aktif]

dari widget Kota/Kabupaten.

Jangan mengganti dengan label lain yang tidak diminta.

------------------------------------------------------------

TASK 3 — ARTIKEL DI HOME

Tambahkan section:

ARTIKEL

Tampilkan artikel keseluruhan/relevan sesuai data artikel yang
sudah tersedia.

Jangan membuat artikel dummy.

Gunakan existing article system.

Jika jumlah artikel banyak:
gunakan pola listing/card yang tidak membuat Home terlalu panjang.

------------------------------------------------------------

TASK 4 — ADVANTAGE

Tambahkan section:

KEUNGGULAN / ADVANTAGE

Tujuannya menjelaskan keunggulan TrainingKota kepada user.

Gunakan design system existing.

Jangan membuat layout yang berlebihan.

------------------------------------------------------------

TASK 5 — ABOUT

Tambahkan:

ABOUT TRAININGKOTA

Section harus menjelaskan secara ringkas tentang TrainingKota.

Gunakan content/data yang sudah tersedia.

Jika content belum tersedia:
jangan mengarang informasi bisnis.

Gunakan placeholder yang jelas atau laporkan kebutuhan content.

============================================================
2. KATALOG PELATIHAN
============================================================

RULE:

Default hanya tampil 4 atau 6 card.

Tambahkan:

[ Show All Pelatihan ]

Klik:
→ seluruh layanan Pelatihan ditampilkan.

Jangan menghapus layanan lainnya.

------------------------------------------------------------

DETAIL PELATIHAN

Yang SUDAH ADA dan WAJIB DIPERTAHANKAN:

1. Skema Teknis
2. Silabus
3. Sasaran Peserta
4. CTA Form
5. Program Terkait

JANGAN merusak atau menghapus bagian tersebut.

Tambahkan:

6. FAQ
7. Q&A

FAQ dan Q&A harus menggunakan data/structure yang sesuai dengan
existing content system.

Jangan membuat data palsu.

============================================================
3. KATALOG JASA
============================================================

RULE:

Default hanya tampil 4 atau 6 card.

Tambahkan:

[ Show All Jasa ]

Klik:
→ seluruh layanan Jasa ditampilkan.

------------------------------------------------------------

DETAIL JASA

Yang SUDAH ADA dan WAJIB DIPERTAHANKAN:

1. Skema Teknis
2. Alur Proses
3. Cakupan Pemeriksaan
4. CTA Form
5. Program Terkait

Tambahkan:

6. FAQ
7. Q&A

Jangan menghapus section existing.

============================================================
4. KATALOG KAJIAN
============================================================

Gunakan pattern yang sama.

DEFAULT:
4 atau 6 card.

BUTTON:

[ Show All Kajian ]

Klik:
→ seluruh layanan Kajian ditampilkan.

Detail layanan Kajian harus mengikuti pola detail layanan existing.

Tambahkan:

FAQ
Q&A

Jangan menghapus existing information.

============================================================
5. PAGE KOTA
============================================================

Yang SUDAH BENAR:

✓ Seluruh Kota/Kabupaten sudah ditampilkan.

Jangan merusaknya.

------------------------------------------------------------

Tambahkan grouping berdasarkan data BPS:

PULAU / WILAYAH
    ↓
    KOTA / KABUPATEN
        ↓
        KOTA
        KABUPATEN

Contoh struktur UI:

[ Pulau / Wilayah ]

    [ Kota/Kabupaten ]

        Kota A
        Kota B
        Kabupaten C

Setiap wilayah harus dapat collapse/expand jika diperlukan.

Jangan menggabungkan Kota dan Kabupaten hanya karena nama sama.

============================================================
6. CITY LANDING PAGE
============================================================

CITY LANDING PAGE HARUS FOKUS PADA PROGRAM DAN WILAYAH.

------------------------------------------------------------

TASK 1 — PROGRAM CATALOG

Default:

4 atau 6 program card.

Tambahkan:

[ Show All Programs ]

Klik:
→ seluruh program untuk city tersebut ditampilkan.

Program harus tetap menggunakan relationship yang sudah ada.

Jangan mengambil seluruh program global jika relationship city sudah
tersedia.

------------------------------------------------------------

TASK 2 — ARTIKEL

JANGAN tampilkan artikel umum di City Landing Page.

City Landing Page:
NO GENERAL ARTICLE SECTION.

------------------------------------------------------------

TASK 3 — FAQ + Q&A

City Landing Page cukup menampilkan:

FAQ
Q&A

Tidak perlu section artikel umum.

------------------------------------------------------------

TASK 4 — DETAIL PROGRAM

Program yang muncul di City Landing harus memiliki akses terhadap:

- Detail layanan
- FAQ
- Q&A
- Artikel pendukung

Artikel pendukung berbeda dengan artikel umum City Landing.

Jika relationship artikel pendukung belum tersedia:
jangan membuat relationship baru tanpa audit terlebih dahulu.

------------------------------------------------------------

TASK 5 — KECAMATAN

Wilayah Kecamatan harus ditampilkan dalam layout yang rapi.

Gunakan:

GRID / LIST

Contoh:

[ Kecamatan A ] [ Kecamatan B ]
[ Kecamatan C ] [ Kecamatan D ]
[ Kecamatan E ] [ Kecamatan F ]

Jangan membuat daftar panjang yang tidak terstruktur.

Gunakan data Kecamatan yang memang terikat dengan City tersebut.

============================================================
7. KECAMATAN LANDING PAGE
============================================================

Kecamatan Landing Page harus memberikan informasi yang berguna
tanpa memaksa user berpindah halaman hanya untuk melihat detail.

------------------------------------------------------------

TASK 1 — DETAIL INFORMATION

Card layanan:

[ Nama Layanan ]
Deskripsi singkat

[ Show Detail ]

Saat klik:

→ tampilkan kotak/detail information di bawah card atau area
yang sudah ditentukan oleh design.

Detail tidak boleh membutuhkan navigasi ke halaman lain hanya
untuk melihat informasi dasar.

------------------------------------------------------------

TASK 2 — CARD LIMIT

Default:

4 atau 6 layanan.

Kemudian:

[ Show All Layanan ]

Klik:
→ seluruh layanan Kecamatan ditampilkan.

------------------------------------------------------------

TASK 3 — ARTICLE RESPONSIVE

Artikel pada Kecamatan Landing Page saat ini belum responsive.

Perbaiki:

- mobile
- tablet
- desktop

Pastikan:
- image tidak overflow
- text tidak overflow
- card tidak rusak
- spacing tetap baik
- button tetap usable

============================================================
8. ADMIN DASHBOARD
============================================================

ADMIN DASHBOARD TIDAK BOLEH MENGUBAH PUBLIC BUSINESS LOGIC.

------------------------------------------------------------

TASK 1 — SIDEBAR ACTIVE STATE

Saat user memilih menu:

Contoh:

Overview
Katalog Layanan
Artikel
Kota
Kecamatan
dll.

Sidebar harus menunjukkan menu yang sedang aktif.

Jangan membuat sidebar selalu terlihat seperti:

Portal CMS keseluruhan
Overview
Katalog Layanan
...

tanpa active state yang jelas.

WAJIB ADA:

- active menu
- visual distinction
- correct current route state
- responsive state

------------------------------------------------------------

TASK 2 — SIDEBAR RESPONSIVE

Sidebar harus responsive.

Desktop:
→ normal sidebar.

Tablet:
→ compact/sidebar behavior sesuai existing design.

Mobile:
→ usable navigation, tidak menutup content secara permanen.

Jangan merusak desktop layout saat memperbaiki mobile.

------------------------------------------------------------

TASK 3 — PAGINATION

Pagination saat ini desainnya mati.

Perbaiki visual dan interaction state:

- Previous
- Next
- Current Page
- Disabled State
- Hover/Focus State
- Mobile responsive

Jangan mengubah pagination logic/database query jika sebenarnya
sudah bekerja.

Fokus perbaikan pada UI terlebih dahulu.

------------------------------------------------------------

TASK 4 — ARTICLE ADMIN PAGE

Article admin page harus responsive.

Periksa:

- table/list
- card
- form
- filter
- pagination
- button
- modal/drawer jika ada

Pastikan tidak terjadi horizontal overflow pada mobile.

============================================================
9. GENERATE ARTICLE
============================================================

INI ADALAH REQUIREMENT LOGIC + UX.

Form:

CATEGORY
    ↓
LAYANAN
    ↓
KOTA
    ↓
KECAMATAN
    ↓
TOPIC / KEYWORD

Relationship harus mengikuti pilihan sebelumnya.

------------------------------------------------------------

REQUIREMENT

Saat user memilih:

Kategori
↓
Layanan

maka data Kota yang tersedia harus otomatis mengikuti relationship
Layanan tersebut.

Kemudian setelah Kota dipilih:

Kecamatan harus otomatis mengikuti Kota tersebut.

Contoh:

Kategori:
Pelatihan

Layanan:
Pelatihan X

Kota:
→ hanya Kota yang relevan dengan layanan X

Kecamatan:
→ hanya Kecamatan yang berada dalam Kota yang dipilih.

------------------------------------------------------------

JANGAN:

Menampilkan semua Kota secara global jika relationship sudah
tersedia.

Menampilkan semua Kecamatan secara global.

Meminta user memilih data yang sebenarnya dapat ditentukan dari
relationship database.

------------------------------------------------------------

IMPORTANT:

Jangan mengubah database structure hanya untuk membuat dependent
dropdown.

Audit terlebih dahulu model + relationship + existing data.

Jika relationship sudah tersedia:
gunakan relationship existing.

Jika relationship tidak tersedia:
STOP dan laporkan.

============================================================
10. DESIGN & COMPONENT CONSISTENCY
============================================================

Sebelum membuat UI baru:

1. Cari component existing.
2. Cari style existing.
3. Cari button existing.
4. Cari card existing.
5. Cari typography existing.
6. Cari spacing existing.
7. Cari responsive breakpoint existing.

Gunakan kembali component tersebut.

Jangan membuat duplicate component tanpa alasan.

============================================================
11. CODE SAFETY
============================================================

SEBELUM EDIT:

Agent WAJIB membaca implementation existing.

Jangan langsung overwrite file.

Jika sebuah file digunakan oleh banyak halaman:
audit dependency terlebih dahulu.

------------------------------------------------------------

SETELAH EDIT:

WAJIB melakukan:

1. Syntax check
2. Route check jika route terkait
3. Build frontend jika frontend berubah
4. Clear/cache check jika diperlukan
5. Test halaman terkait
6. Responsive check

------------------------------------------------------------

JANGAN:

- menghapus file tanpa alasan
- mengganti architecture
- menghapus migration
- menghapus model
- mengganti route global
- mengganti database schema
- menghapus existing content
- mengganti BPS code
- membuat dummy data
- membuat fake relationship
- melakukan broad refactor

============================================================
12. CHANGE MANAGEMENT RULE
============================================================

SETIAP PERUBAHAN HARUS TERBATAS PADA REQUIREMENT.

Jika menemukan masalah lain yang tidak masuk audit:

JANGAN langsung diperbaiki.

Catat sebagai:

OUT OF SCOPE

dan laporkan.

Contoh:

OUT OF SCOPE:
- masalah SEO
- masalah database lain
- masalah authentication
- refactor controller
- redesign global
- migration cleanup

Kecuali masalah tersebut secara langsung menyebabkan requirement
yang sedang dikerjakan tidak dapat berjalan.

============================================================
13. DEFINITION OF DONE
============================================================

TASK dianggap SELESAI hanya jika:

✓ Requirement sudah implemented
✓ Existing feature tetap berjalan
✓ Existing relationship tetap berjalan
✓ Tidak ada dummy data
✓ Tidak ada broken route
✓ Tidak ada broken link
✓ Tidak ada horizontal overflow
✓ Desktop responsive
✓ Tablet responsive
✓ Mobile responsive
✓ Card limit 4/6 bekerja
✓ Show All bekerja
✓ Collapse/Expand bekerja
✓ Active sidebar bekerja
✓ Pagination UI bekerja
✓ Generate Article dependent selection bekerja
✓ Tidak ada console error yang disebabkan perubahan
✓ Frontend build berhasil jika diperlukan

============================================================
14. FINAL AGENT REPORT
============================================================

Setelah selesai, JANGAN hanya mengatakan:

"Done."

Agent wajib memberikan report:

FILES CHANGED:
- file 1
- file 2
- file 3

FEATURES CHANGED:
- Home
- Pelatihan
- Jasa
- Kajian
- Kota
- City Landing
- Kecamatan Landing
- Admin
- Generate Artikel

TESTED:
- route
- responsive
- build
- interaction

NOT CHANGED:
Tuliskan bagian penting yang sengaja tidak disentuh untuk menjaga
stability.

ISSUES FOUND:
Tuliskan masalah yang ditemukan tetapi tidak dikerjakan karena
OUT OF SCOPE.

============================================================
FINAL COMMAND TO AGENT
============================================================

KERJAKAN AUDIT INI SECARA BERTAHAP.

JANGAN mencoba menyelesaikan semuanya dengan satu refactor besar.

Prioritas:

PHASE 1
Home Page

PHASE 2
Pelatihan / Jasa / Kajian

PHASE 3
Page Kota

PHASE 4
City Landing Page

PHASE 5
Kecamatan Landing Page

PHASE 6
Admin Dashboard

PHASE 7
Generate Artikel

PHASE 8
Global Responsive QA

PHASE 9
Final Regression Test

SETIAP PHASE:
- inspect existing implementation
- make minimal changes
- test
- verify existing functionality
- report result

JIKA MENEMUKAN KONFLIK ANTARA REQUIREMENT INI DENGAN
IMPLEMENTATION EXISTING:

JANGAN MENEBak.

JANGAN MEMAKSA.

JANGAN MENGUBAH DATABASE / ARCHITECTURE.

STOP PADA BAGIAN TERSEBUT DAN LAPORKAN:
1. Apa konfliknya
2. File yang terlibat
3. Existing behavior
4. Requirement yang bentrok
5. Solusi yang agent rekomendasikan

MENUNGGU KEPUTUSAN SEBELUM MELAKUKAN PERUBAHAN BERISIKO.

============================================================
END OF MASTER UI/UX AUDIT & REPAIR INSTRUCTION
============================================================