<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        City::truncate();

        $cities = array (
  0 => 
  array (
    'name' => 'Kota Luwuk',
    'slug' => 'kota-luwuk',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  1 => 
  array (
    'name' => 'Kota Medan',
    'slug' => 'kota-medan',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  2 => 
  array (
    'name' => 'Kota Pekanbaru',
    'slug' => 'kota-pekanbaru',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  3 => 
  array (
    'name' => 'Kota Padang',
    'slug' => 'kota-padang',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  4 => 
  array (
    'name' => 'Kota Batam',
    'slug' => 'kota-batam',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  5 => 
  array (
    'name' => 'Jambi',
    'slug' => 'jambi',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  6 => 
  array (
    'name' => 'Kota Palembang',
    'slug' => 'kota-palembang',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  7 => 
  array (
    'name' => 'Bandar Lampung',
    'slug' => 'bandar-lampung',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  8 => 
  array (
    'name' => 'Kota Cilegon',
    'slug' => 'kota-cilegon',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  9 => 
  array (
    'name' => 'Kota Serang',
    'slug' => 'kota-serang',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  10 => 
  array (
    'name' => 'Tangerang',
    'slug' => 'tangerang',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  11 => 
  array (
    'name' => 'Jakarta',
    'slug' => 'jakarta',
    'island' => 'Jawa',
    'is_hub' => true,
  ),
  12 => 
  array (
    'name' => 'Bekasi',
    'slug' => 'bekasi',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  13 => 
  array (
    'name' => 'Bogor',
    'slug' => 'bogor',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  14 => 
  array (
    'name' => 'Cikarang',
    'slug' => 'cikarang',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  15 => 
  array (
    'name' => 'Karawang',
    'slug' => 'karawang',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  16 => 
  array (
    'name' => 'Bandung',
    'slug' => 'bandung',
    'island' => 'Jawa',
    'is_hub' => true,
  ),
  17 => 
  array (
    'name' => 'Semarang',
    'slug' => 'semarang',
    'island' => 'Jawa',
    'is_hub' => true,
  ),
  18 => 
  array (
    'name' => 'Yogyakarta',
    'slug' => 'yogyakarta',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  19 => 
  array (
    'name' => 'Surabaya',
    'slug' => 'surabaya',
    'island' => 'Jawa',
    'is_hub' => true,
  ),
  20 => 
  array (
    'name' => 'Pasuruan',
    'slug' => 'pasuruan',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  21 => 
  array (
    'name' => 'Bali',
    'slug' => 'bali',
    'island' => 'Bali & Nusa Tenggara',
    'is_hub' => false,
  ),
  22 => 
  array (
    'name' => 'Sumbawa',
    'slug' => 'sumbawa',
    'island' => 'Bali & Nusa Tenggara',
    'is_hub' => false,
  ),
  23 => 
  array (
    'name' => 'Lombok',
    'slug' => 'lombok',
    'island' => 'Bali & Nusa Tenggara',
    'is_hub' => false,
  ),
  24 => 
  array (
    'name' => 'Balikpapan',
    'slug' => 'balikpapan',
    'island' => 'Kalimantan',
    'is_hub' => true,
  ),
  25 => 
  array (
    'name' => 'Samarinda',
    'slug' => 'samarinda',
    'island' => 'Kalimantan',
    'is_hub' => true,
  ),
  26 => 
  array (
    'name' => 'Kutai Kartanegara',
    'slug' => 'kutai-kartanegara',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  27 => 
  array (
    'name' => 'Banjarmasin',
    'slug' => 'banjarmasin',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  28 => 
  array (
    'name' => 'Pontianak',
    'slug' => 'pontianak',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  29 => 
  array (
    'name' => 'Makassar',
    'slug' => 'makassar',
    'island' => 'Sulawesi',
    'is_hub' => true,
  ),
  30 => 
  array (
    'name' => 'Morowali',
    'slug' => 'morowali',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  31 => 
  array (
    'name' => 'Gorontalo',
    'slug' => 'gorontalo',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  32 => 
  array (
    'name' => 'Manado',
    'slug' => 'manado',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  33 => 
  array (
    'name' => 'Ternate',
    'slug' => 'ternate',
    'island' => 'Maluku & Papua',
    'is_hub' => false,
  ),
  34 => 
  array (
    'name' => 'Bontang',
    'slug' => 'bontang',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  35 => 
  array (
    'name' => 'Mamuju',
    'slug' => 'mamuju',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  36 => 
  array (
    'name' => 'Dumai',
    'slug' => 'dumai',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  37 => 
  array (
    'name' => 'Batulicin',
    'slug' => 'batulicin',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  38 => 
  array (
    'name' => 'Gresik',
    'slug' => 'gresik',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  39 => 
  array (
    'name' => 'Cepu',
    'slug' => 'cepu',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  40 => 
  array (
    'name' => 'Prabumulih',
    'slug' => 'prabumulih',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  41 => 
  array (
    'name' => 'Muara Enim',
    'slug' => 'muara-enim',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  42 => 
  array (
    'name' => 'Subang',
    'slug' => 'subang',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  43 => 
  array (
    'name' => 'Sukabumi',
    'slug' => 'sukabumi',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  44 => 
  array (
    'name' => 'Purwakarta',
    'slug' => 'purwakarta',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  45 => 
  array (
    'name' => 'Cirebon',
    'slug' => 'cirebon',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  46 => 
  array (
    'name' => 'Cilacap',
    'slug' => 'cilacap',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  47 => 
  array (
    'name' => 'Batang',
    'slug' => 'batang',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  48 => 
  array (
    'name' => 'Kota Solo',
    'slug' => 'kota-solo',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  49 => 
  array (
    'name' => 'Mojokerto',
    'slug' => 'mojokerto',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  50 => 
  array (
    'name' => 'Malang',
    'slug' => 'malang',
    'island' => 'Jawa',
    'is_hub' => true,
  ),
  51 => 
  array (
    'name' => 'Sidoarjo',
    'slug' => 'sidoarjo',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  52 => 
  array (
    'name' => 'Banyuwangi',
    'slug' => 'banyuwangi',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  53 => 
  array (
    'name' => 'Kediri',
    'slug' => 'kediri',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  54 => 
  array (
    'name' => 'Lamongan',
    'slug' => 'lamongan',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  55 => 
  array (
    'name' => 'Tuban',
    'slug' => 'tuban',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  56 => 
  array (
    'name' => 'Bengkulu',
    'slug' => 'bengkulu',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  57 => 
  array (
    'name' => 'Bangka Belitung',
    'slug' => 'bangka-belitung',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  58 => 
  array (
    'name' => 'Denpasar',
    'slug' => 'denpasar',
    'island' => 'Bali & Nusa Tenggara',
    'is_hub' => false,
  ),
  59 => 
  array (
    'name' => 'Kolaka',
    'slug' => 'kolaka',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  60 => 
  array (
    'name' => 'Konawe',
    'slug' => 'konawe',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  61 => 
  array (
    'name' => 'Palu',
    'slug' => 'palu',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  62 => 
  array (
    'name' => 'Banggai',
    'slug' => 'banggai',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  63 => 
  array (
    'name' => 'Tenggarong',
    'slug' => 'tenggarong',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  64 => 
  array (
    'name' => 'Sangatta',
    'slug' => 'sangatta',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  65 => 
  array (
    'name' => 'Berau',
    'slug' => 'berau',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  66 => 
  array (
    'name' => 'Tarakan',
    'slug' => 'tarakan',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  67 => 
  array (
    'name' => 'Bintan',
    'slug' => 'bintan',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  68 => 
  array (
    'name' => 'Jakarta Barat',
    'slug' => 'jakarta-barat',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  69 => 
  array (
    'name' => 'Majalengka',
    'slug' => 'majalengka',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  70 => 
  array (
    'name' => 'Demak',
    'slug' => 'demak',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  71 => 
  array (
    'name' => 'Kendal',
    'slug' => 'kendal',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  72 => 
  array (
    'name' => 'Bontang',
    'slug' => 'bontang-2',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  73 => 
  array (
    'name' => 'Halmahera',
    'slug' => 'halmahera',
    'island' => 'Maluku & Papua',
    'is_hub' => false,
  ),
  74 => 
  array (
    'name' => 'Kotabaru',
    'slug' => 'kotabaru',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  75 => 
  array (
    'name' => 'Barito',
    'slug' => 'barito',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  76 => 
  array (
    'name' => 'Kotawaringin',
    'slug' => 'kotawaringin',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  77 => 
  array (
    'name' => 'Kapuas',
    'slug' => 'kapuas',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  78 => 
  array (
    'name' => 'Malinau',
    'slug' => 'malinau',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  79 => 
  array (
    'name' => 'Bintuni',
    'slug' => 'bintuni',
    'island' => 'Maluku & Papua',
    'is_hub' => false,
  ),
  80 => 
  array (
    'name' => 'Lhokseumawe',
    'slug' => 'lhokseumawe',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  81 => 
  array (
    'name' => 'Langsa',
    'slug' => 'langsa',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  82 => 
  array (
    'name' => 'Langkat',
    'slug' => 'langkat',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  83 => 
  array (
    'name' => 'Binjai ',
    'slug' => 'binjai',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  84 => 
  array (
    'name' => 'Deli Serdang',
    'slug' => 'deli-serdang',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  85 => 
  array (
    'name' => 'Asahan',
    'slug' => 'asahan',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  86 => 
  array (
    'name' => 'Kisaran',
    'slug' => 'kisaran',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  87 => 
  array (
    'name' => 'Batubara',
    'slug' => 'batubara',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  88 => 
  array (
    'name' => 'Sungai Liat',
    'slug' => 'sungai-liat',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  89 => 
  array (
    'name' => 'Kendari',
    'slug' => 'kendari',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  90 => 
  array (
    'name' => 'Aceh Singkil',
    'slug' => 'aceh-singkil',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  91 => 
  array (
    'name' => 'Aceh Barat',
    'slug' => 'aceh-barat',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  92 => 
  array (
    'name' => 'Nagan Raya',
    'slug' => 'nagan-raya',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  93 => 
  array (
    'name' => 'Melawi',
    'slug' => 'melawi',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  94 => 
  array (
    'name' => 'Sambas',
    'slug' => 'sambas',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  95 => 
  array (
    'name' => 'Sanggau',
    'slug' => 'sanggau',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  96 => 
  array (
    'name' => 'Sintang',
    'slug' => 'sintang',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  97 => 
  array (
    'name' => 'Kapuas Hulu',
    'slug' => 'kapuas-hulu',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  98 => 
  array (
    'name' => 'Kayong Utara',
    'slug' => 'kayong-utara',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  99 => 
  array (
    'name' => 'Bengkayang',
    'slug' => 'bengkayang',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  100 => 
  array (
    'name' => 'Mempawah',
    'slug' => 'mempawah',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  101 => 
  array (
    'name' => 'Landak',
    'slug' => 'landak',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  102 => 
  array (
    'name' => 'Ngabang',
    'slug' => 'ngabang',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  103 => 
  array (
    'name' => 'Sukamara',
    'slug' => 'sukamara',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  104 => 
  array (
    'name' => 'Gunung Mas',
    'slug' => 'gunung-mas',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  105 => 
  array (
    'name' => 'Lamandau',
    'slug' => 'lamandau',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  106 => 
  array (
    'name' => 'Katingan',
    'slug' => 'katingan',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  107 => 
  array (
    'name' => 'Murung Raya',
    'slug' => 'murung-raya',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  108 => 
  array (
    'name' => 'Seruyan',
    'slug' => 'seruyan',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  109 => 
  array (
    'name' => 'Tana Tidung',
    'slug' => 'tana-tidung',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  110 => 
  array (
    'name' => 'Nunukan',
    'slug' => 'nunukan',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  111 => 
  array (
    'name' => 'Bulungan',
    'slug' => 'bulungan',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  112 => 
  array (
    'name' => 'Kutai Timur',
    'slug' => 'kutai-timur',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  113 => 
  array (
    'name' => 'Kutai Barat',
    'slug' => 'kutai-barat',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  114 => 
  array (
    'name' => 'Paser',
    'slug' => 'paser',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  115 => 
  array (
    'name' => 'Mahakam Ulu',
    'slug' => 'mahakam-ulu',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  116 => 
  array (
    'name' => 'Pulau Laut',
    'slug' => 'pulau-laut',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  117 => 
  array (
    'name' => 'Banjarbaru',
    'slug' => 'banjarbaru',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  118 => 
  array (
    'name' => 'Hulu Sungai Selatan',
    'slug' => 'hulu-sungai-selatan',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  119 => 
  array (
    'name' => 'Hulu Sungai Tengah',
    'slug' => 'hulu-sungai-tengah',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  120 => 
  array (
    'name' => 'Banjar',
    'slug' => 'banjar',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  121 => 
  array (
    'name' => 'Balangan',
    'slug' => 'balangan',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  122 => 
  array (
    'name' => 'Tapin',
    'slug' => 'tapin',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  123 => 
  array (
    'name' => 'Pandeglang',
    'slug' => 'pandeglang',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  124 => 
  array (
    'name' => 'Lebak',
    'slug' => 'lebak',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  125 => 
  array (
    'name' => 'Garut',
    'slug' => 'garut',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  126 => 
  array (
    'name' => 'Cianjur',
    'slug' => 'cianjur',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  127 => 
  array (
    'name' => 'Wonogiri',
    'slug' => 'wonogiri',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  128 => 
  array (
    'name' => 'Kebumen',
    'slug' => 'kebumen',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  129 => 
  array (
    'name' => 'Banjarnegara',
    'slug' => 'banjarnegara',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  130 => 
  array (
    'name' => 'Lumajang',
    'slug' => 'lumajang',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  131 => 
  array (
    'name' => 'Jember',
    'slug' => 'jember',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  132 => 
  array (
    'name' => 'Pacitan',
    'slug' => 'pacitan',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  133 => 
  array (
    'name' => 'Dompu',
    'slug' => 'dompu',
    'island' => 'Bali & Nusa Tenggara',
    'is_hub' => false,
  ),
  134 => 
  array (
    'name' => 'Bima',
    'slug' => 'bima',
    'island' => 'Bali & Nusa Tenggara',
    'is_hub' => false,
  ),
  135 => 
  array (
    'name' => 'Kupang',
    'slug' => 'kupang',
    'island' => 'Bali & Nusa Tenggara',
    'is_hub' => false,
  ),
  136 => 
  array (
    'name' => 'Ende',
    'slug' => 'ende',
    'island' => 'Bali & Nusa Tenggara',
    'is_hub' => false,
  ),
  137 => 
  array (
    'name' => 'Mimika',
    'slug' => 'mimika',
    'island' => 'Maluku & Papua',
    'is_hub' => false,
  ),
  138 => 
  array (
    'name' => 'Merauke',
    'slug' => 'merauke',
    'island' => 'Maluku & Papua',
    'is_hub' => false,
  ),
  139 => 
  array (
    'name' => 'Jayapura',
    'slug' => 'jayapura',
    'island' => 'Maluku & Papua',
    'is_hub' => false,
  ),
  140 => 
  array (
    'name' => 'Sawalunto',
    'slug' => 'sawalunto',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  141 => 
  array (
    'name' => 'Jakarta Selatan',
    'slug' => 'jakarta-selatan',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  142 => 
  array (
    'name' => 'Jakarta Pusat',
    'slug' => 'jakarta-pusat',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  143 => 
  array (
    'name' => 'Jakarta Timur',
    'slug' => 'jakarta-timur',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  144 => 
  array (
    'name' => 'Jakarta Utara',
    'slug' => 'jakarta-utara',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  145 => 
  array (
    'name' => 'Sorong',
    'slug' => 'sorong',
    'island' => 'Maluku & Papua',
    'is_hub' => false,
  ),
  146 => 
  array (
    'name' => 'Tangerang Selatan',
    'slug' => 'tangerang-selatan',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  147 => 
  array (
    'name' => 'Magelang',
    'slug' => 'magelang',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  148 => 
  array (
    'name' => 'Tegal',
    'slug' => 'tegal',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  149 => 
  array (
    'name' => 'Blitar',
    'slug' => 'blitar',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  150 => 
  array (
    'name' => 'Madiun',
    'slug' => 'madiun',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  151 => 
  array (
    'name' => 'Probolinggo',
    'slug' => 'probolinggo',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  152 => 
  array (
    'name' => 'Singkawang',
    'slug' => 'singkawang',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  153 => 
  array (
    'name' => 'Palopo',
    'slug' => 'palopo',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  154 => 
  array (
    'name' => 'Parepare',
    'slug' => 'parepare',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  155 => 
  array (
    'name' => 'Baubau',
    'slug' => 'baubau',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  156 => 
  array (
    'name' => 'Bitung',
    'slug' => 'bitung',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  157 => 
  array (
    'name' => 'Tomohon',
    'slug' => 'tomohon',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  158 => 
  array (
    'name' => 'Tapanuli',
    'slug' => 'tapanuli',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  159 => 
  array (
    'name' => 'Lubuk Linggau',
    'slug' => 'lubuk-linggau',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  160 => 
  array (
    'name' => 'Musi Banyuasin',
    'slug' => 'musi-banyuasin',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  161 => 
  array (
    'name' => 'Sekayu',
    'slug' => 'sekayu',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  162 => 
  array (
    'name' => 'Binjai',
    'slug' => 'binjai-2',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  163 => 
  array (
    'name' => 'Dairi',
    'slug' => 'dairi',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  164 => 
  array (
    'name' => 'Karo',
    'slug' => 'karo',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  165 => 
  array (
    'name' => 'Tebing Tinggi',
    'slug' => 'tebing-tinggi',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  166 => 
  array (
    'name' => 'Ambon',
    'slug' => 'ambon',
    'island' => 'Maluku & Papua',
    'is_hub' => false,
  ),
  167 => 
  array (
    'name' => 'Pulau Sebuku',
    'slug' => 'pulau-sebuku',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  168 => 
  array (
    'name' => 'Palangkaraya',
    'slug' => 'palangkaraya',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  169 => 
  array (
    'name' => 'Pulau Madura',
    'slug' => 'pulau-madura',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  170 => 
  array (
    'name' => 'Tanjung Jabung',
    'slug' => 'tanjung-jabung',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  171 => 
  array (
    'name' => 'Sei Semangkei',
    'slug' => 'sei-semangkei',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  172 => 
  array (
    'name' => 'Tanjungbalai',
    'slug' => 'tanjungbalai',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  173 => 
  array (
    'name' => 'Dharmasraya',
    'slug' => 'dharmasraya',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  174 => 
  array (
    'name' => 'Bukittinggi',
    'slug' => 'bukittinggi',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  175 => 
  array (
    'name' => 'Payakumbuh',
    'slug' => 'payakumbuh',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  176 => 
  array (
    'name' => 'Lahat',
    'slug' => 'lahat',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  177 => 
  array (
    'name' => 'Bengkalis',
    'slug' => 'bengkalis',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  178 => 
  array (
    'name' => 'Indragiri Hulu & Hilir',
    'slug' => 'indragiri-hulu-hilir',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  179 => 
  array (
    'name' => 'Kampar',
    'slug' => 'kampar',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  180 => 
  array (
    'name' => 'Pelalawan',
    'slug' => 'pelalawan',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  181 => 
  array (
    'name' => 'Rokan Hulu & Hilir',
    'slug' => 'rokan-hulu-hilir',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  182 => 
  array (
    'name' => 'Kota Siak',
    'slug' => 'kota-siak',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  183 => 
  array (
    'name' => 'Karimun',
    'slug' => 'karimun',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  184 => 
  array (
    'name' => 'Pulau Matak',
    'slug' => 'pulau-matak',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  185 => 
  array (
    'name' => 'Kota Tanjung Pinang',
    'slug' => 'kota-tanjung-pinang',
    'island' => 'Sumatera',
    'is_hub' => false,
  ),
  186 => 
  array (
    'name' => 'Batanghari',
    'slug' => 'batanghari',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  187 => 
  array (
    'name' => 'Pangkal Pinang',
    'slug' => 'pangkal-pinang',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  188 => 
  array (
    'name' => 'Tasikmalaya',
    'slug' => 'tasikmalaya',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  189 => 
  array (
    'name' => 'Jombang',
    'slug' => 'jombang',
    'island' => 'Jawa',
    'is_hub' => false,
  ),
  190 => 
  array (
    'name' => 'Kota Mataram',
    'slug' => 'kota-mataram',
    'island' => 'Bali & Nusa Tenggara',
    'is_hub' => false,
  ),
  191 => 
  array (
    'name' => 'Kubu raya',
    'slug' => 'kubu-raya',
    'island' => 'Indonesia',
    'is_hub' => false,
  ),
  192 => 
  array (
    'name' => 'Sekadau',
    'slug' => 'sekadau',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  193 => 
  array (
    'name' => 'Tabalong',
    'slug' => 'tabalong',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  194 => 
  array (
    'name' => 'Tanah Bumbu',
    'slug' => 'tanah-bumbu',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  195 => 
  array (
    'name' => 'Penajam Paser Utara',
    'slug' => 'penajam-paser-utara',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  196 => 
  array (
    'name' => 'Buton',
    'slug' => 'buton',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  197 => 
  array (
    'name' => 'Buol',
    'slug' => 'buol',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  198 => 
  array (
    'name' => 'Donggala',
    'slug' => 'donggala',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  199 => 
  array (
    'name' => 'Parigi Moutong',
    'slug' => 'parigi-moutong',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  200 => 
  array (
    'name' => 'Melak',
    'slug' => 'melak',
    'island' => 'Kalimantan',
    'is_hub' => false,
  ),
  201 => 
  array (
    'name' => 'Bolaang Mongondow',
    'slug' => 'bolaang-mongondow',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  202 => 
  array (
    'name' => 'Kotamobagu',
    'slug' => 'kotamobagu',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  203 => 
  array (
    'name' => 'Majene',
    'slug' => 'majene',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  204 => 
  array (
    'name' => 'Mamasa',
    'slug' => 'mamasa',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  205 => 
  array (
    'name' => 'Polewali Mandar',
    'slug' => 'polewali-mandar',
    'island' => 'Sulawesi',
    'is_hub' => false,
  ),
  206 => 
  array (
    'name' => 'Kabupaten Seram',
    'slug' => 'kabupaten-seram',
    'island' => 'Maluku & Papua',
    'is_hub' => false,
  ),
  207 => 
  array (
    'name' => 'Kabupaten Halmahera Barat',
    'slug' => 'kabupaten-halmahera-barat',
    'island' => 'Maluku & Papua',
    'is_hub' => false,
  ),
  208 => 
  array (
    'name' => 'Kabupaten Halmahera Tengah',
    'slug' => 'kabupaten-halmahera-tengah',
    'island' => 'Maluku & Papua',
    'is_hub' => false,
  ),
  209 => 
  array (
    'name' => 'Kabupaten Halmahera Utara',
    'slug' => 'kabupaten-halmahera-utara',
    'island' => 'Maluku & Papua',
    'is_hub' => false,
  ),
  210 => 
  array (
    'name' => 'Halmahera Selatan',
    'slug' => 'halmahera-selatan',
    'island' => 'Maluku & Papua',
    'is_hub' => false,
  ),
  211 => 
  array (
    'name' => 'Weda',
    'slug' => 'weda',
    'island' => 'Maluku & Papua',
    'is_hub' => false,
  ),
);

        foreach (array_chunk($cities, 50) as $chunk) {
            City::insert($chunk);
        }
    }
}
