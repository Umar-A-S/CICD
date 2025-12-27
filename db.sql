CREATE DATABASE perpustakaan;

USE perpustakaan;

CREATE TABLE rak(
  kode VARCHAR(10) PRIMARY KEY,
  kategori VARCHAR(20) NOT NULL,
  baris VARCHAR(20) NOT NULL
);

CREATE TABLE pegawai(
  nip VARCHAR(20) PRIMARY KEY,
  alamat VARCHAR(50) NOT NULL,
  nama VARCHAR(30) NOT NULL
);

CREATE TABLE buku (
  id_buku VARCHAR(10) PRIMARY KEY,
  judul VARCHAR(30) NOT NULL,
  stok INT,  -- Ubah dari VARCHAR(50) ke INT
  kode VARCHAR(10) NOT NULL,
  FOREIGN KEY (kode) REFERENCES rak(kode)
);

CREATE TABLE anggota(
  id_anggota VARCHAR(255) PRIMARY KEY,
  nama VARCHAR(40) NOT NULL
);

CREATE TABLE pengembalian(
  tgl_kembali TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  denda INT,
  id_buku VARCHAR(10) NOT NULL,
  id_anggota VARCHAR(255) NOT NULL,
  FOREIGN KEY (id_buku) REFERENCES buku(id_buku),
  FOREIGN KEY (id_anggota) REFERENCES anggota(id_anggota)  
);

CREATE TABLE peminjaman(
  kode_transaksi VARCHAR(255) PRIMARY KEY,
  tgl_kembali TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  tgl_pinjam TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  id_buku VARCHAR(10) NOT NULL,
  id_anggota VARCHAR(255) NOT NULL,
  FOREIGN KEY (id_buku) REFERENCES buku(id_buku),
  FOREIGN KEY (id_anggota) REFERENCES anggota(id_anggota)  
);

-- Mengisi Tabel rak
INSERT INTO rak (kode, kategori, baris) VALUES
('R001', 'Fiksi', 'Baris 1'),
('R002', 'Non-Fiksi', 'Baris 2'),
('R003', 'Sains', 'Baris 3'),
('R004', 'Sejarah', 'Baris 4');

-- Mengisi Tabel pegawai
INSERT INTO pegawai (nip, alamat, nama) VALUES
('P001', 'Jalan Merdeka No. 10', 'Ahmad Fauzi'),
('P002', 'Jalan Sudirman No. 12', 'Budi Santoso'),
('P003', 'Jalan Kartini No. 5', 'Citra Dewi'),
('P004', 'Jalan Diponegoro No. 3', 'Dewi Rahma');

-- Mengisi Tabel buku
INSERT INTO buku (id_buku, judul, stok, kode) VALUES
('B001', 'Laskar Pelangi', 15, 'R001'),
('B002', 'Biografi Albert Einstein', 10, 'R003'),
('B003', 'Sejarah Indonesia', 20, 'R004'),
('B004', 'Filosofi Teras', 12, 'R002'),
('B005', 'Hukum Newton', 8, 'R003');

-- Mengisi Tabel anggota
INSERT INTO anggota (id_anggota, nama) VALUES
('A001', 'Siti Aisyah'),
('A002', 'Rahmat Hidayat'),
('A003', 'Indra Lesmana'),
('A004', 'Diana Putri');

-- Mengisi Tabel pengembalian
INSERT INTO pengembalian (denda, id_buku, id_anggota) VALUES
(5000, 'B001', 'A001'),
(10000, 'B003', 'A002'),
(0, 'B002', 'A003'),
(15000, 'B004', 'A004');

-- Mengisi Tabel peminjaman
INSERT INTO peminjaman (kode_transaksi, id_buku, id_anggota) VALUES
('T001', 'B001', 'A001'),
('T002', 'B003', 'A002'),
('T003', 'B002', 'A003'),
('T004', 'B004', 'A004');
