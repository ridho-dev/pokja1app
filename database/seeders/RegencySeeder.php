<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Regency;

class RegencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regencies = [
            // Aceh (11)
            ['id' => 1100, 'province_id' => 11, 'name' => 'Provinsi Aceh'],
            ['id' => 1101, 'province_id' => 11, 'name' => 'Aceh Selatan'],
            ['id' => 1102, 'province_id' => 11, 'name' => 'Aceh Tenggara'],
            ['id' => 1103, 'province_id' => 11, 'name' => 'Aceh Timur'],
            ['id' => 1104, 'province_id' => 11, 'name' => 'Aceh Tengah'],
            ['id' => 1105, 'province_id' => 11, 'name' => 'Aceh Barat'],
            ['id' => 1106, 'province_id' => 11, 'name' => 'Aceh Besar'],
            ['id' => 1107, 'province_id' => 11, 'name' => 'Pidie'],
            ['id' => 1108, 'province_id' => 11, 'name' => 'Aceh Utara'],
            ['id' => 1109, 'province_id' => 11, 'name' => 'Simeulue'],
            ['id' => 1110, 'province_id' => 11, 'name' => 'Aceh Singkil'],
            ['id' => 1111, 'province_id' => 11, 'name' => 'Bireuen'],
            ['id' => 1112, 'province_id' => 11, 'name' => 'Aceh Barat Daya'],
            ['id' => 1113, 'province_id' => 11, 'name' => 'Gayo Lues'],
            ['id' => 1114, 'province_id' => 11, 'name' => 'Aceh Jaya'],
            ['id' => 1115, 'province_id' => 11, 'name' => 'Nagan Raya'],
            ['id' => 1116, 'province_id' => 11, 'name' => 'Aceh Tamiang'],
            ['id' => 1117, 'province_id' => 11, 'name' => 'Bener Meriah'],
            ['id' => 1118, 'province_id' => 11, 'name' => 'Pidie Jaya'],
            ['id' => 1119, 'province_id' => 11, 'name' => 'Kota Banda Aceh'],
            ['id' => 1120, 'province_id' => 11, 'name' => 'Kota Sabang'],
            ['id' => 1121, 'province_id' => 11, 'name' => 'Kota Lhokseumawe'],
            ['id' => 1122, 'province_id' => 11, 'name' => 'Kota Langsa'],
            ['id' => 1123, 'province_id' => 11, 'name' => 'Kota Subulussalam'],

            // Sumatera Utara (12)
            ['id' => 1200, 'province_id' => 12, 'name' => 'Provinsi Sumatera Utara'],
            ['id' => 1201, 'province_id' => 12, 'name' => 'Tapanuli Tengah'],
            ['id' => 1202, 'province_id' => 12, 'name' => 'Tapanuli Utara'],
            ['id' => 1203, 'province_id' => 12, 'name' => 'Tapanuli Selatan'],
            ['id' => 1204, 'province_id' => 12, 'name' => 'Nias'],
            ['id' => 1205, 'province_id' => 12, 'name' => 'Langkat'],
            ['id' => 1206, 'province_id' => 12, 'name' => 'Karo'],
            ['id' => 1207, 'province_id' => 12, 'name' => 'Deli Serdang'],
            ['id' => 1208, 'province_id' => 12, 'name' => 'Simalungun'],
            ['id' => 1209, 'province_id' => 12, 'name' => 'Asahan'],
            ['id' => 1210, 'province_id' => 12, 'name' => 'Labuhanbatu'],
            ['id' => 1211, 'province_id' => 12, 'name' => 'Dairi'],
            ['id' => 1212, 'province_id' => 12, 'name' => 'Toba Samosir'],
            ['id' => 1213, 'province_id' => 12, 'name' => 'Mandailing Natal'],
            ['id' => 1214, 'province_id' => 12, 'name' => 'Nias Selatan'],
            ['id' => 1215, 'province_id' => 12, 'name' => 'Pakpak Bharat'],
            ['id' => 1216, 'province_id' => 12, 'name' => 'Humbang Hasundutan'],
            ['id' => 1217, 'province_id' => 12, 'name' => 'Samosir'],
            ['id' => 1218, 'province_id' => 12, 'name' => 'Serdang Bedagai'],
            ['id' => 1219, 'province_id' => 12, 'name' => 'Batu Bara'],
            ['id' => 1220, 'province_id' => 12, 'name' => 'Padang Lawas Utara'],
            ['id' => 1221, 'province_id' => 12, 'name' => 'Padang Lawas'],
            ['id' => 1222, 'province_id' => 12, 'name' => 'Labuhanbatu Selatan'],
            ['id' => 1223, 'province_id' => 12, 'name' => 'Labuhanbatu Utara'],
            ['id' => 1224, 'province_id' => 12, 'name' => 'Nias Utara'],
            ['id' => 1225, 'province_id' => 12, 'name' => 'Nias Barat'],
            ['id' => 1271, 'province_id' => 12, 'name' => 'Kota Medan'],
            ['id' => 1272, 'province_id' => 12, 'name' => 'Kota Pematangsiantar'],
            ['id' => 1273, 'province_id' => 12, 'name' => 'Kota Sibolga'],
            ['id' => 1274, 'province_id' => 12, 'name' => 'Kota Tanjung Balai'],
            ['id' => 1275, 'province_id' => 12, 'name' => 'Kota Binjai'],
            ['id' => 1276, 'province_id' => 12, 'name' => 'Kota Tebing Tinggi'],
            ['id' => 1277, 'province_id' => 12, 'name' => 'Kota Padang Sidempuan'],
            ['id' => 1278, 'province_id' => 12, 'name' => 'Kota Gunungsitoli'],

            // Sumatera Barat (13)
            ['id' => 1300, 'province_id' => 13, 'name' => 'Sumatera Barat'],
            ['id' => 1301, 'province_id' => 13, 'name' => 'Pesisir Selatan'],
            ['id' => 1302, 'province_id' => 13, 'name' => 'Solok'],
            ['id' => 1303, 'province_id' => 13, 'name' => 'Sijunjung'],
            ['id' => 1304, 'province_id' => 13, 'name' => 'Tanah Datar'],
            ['id' => 1305, 'province_id' => 13, 'name' => 'Padang Pariaman'],
            ['id' => 1306, 'province_id' => 13, 'name' => 'Agam'],
            ['id' => 1307, 'province_id' => 13, 'name' => 'Lima Puluh Kota'],
            ['id' => 1308, 'province_id' => 13, 'name' => 'Pasaman'],
            ['id' => 1309, 'province_id' => 13, 'name' => 'Kepulauan Mentawai'],
            ['id' => 1310, 'province_id' => 13, 'name' => 'Dharmasraya'],
            ['id' => 1311, 'province_id' => 13, 'name' => 'Solok Selatan'],
            ['id' => 1312, 'province_id' => 13, 'name' => 'Pasaman Barat'],
            ['id' => 1371, 'province_id' => 13, 'name' => 'Kota Padang'],
            ['id' => 1372, 'province_id' => 13, 'name' => 'Kota Solok'],
            ['id' => 1373, 'province_id' => 13, 'name' => 'Kota Sawahlunto'],
            ['id' => 1374, 'province_id' => 13, 'name' => 'Kota Padang Panjang'],
            ['id' => 1375, 'province_id' => 13, 'name' => 'Kota Bukittinggi'],
            ['id' => 1376, 'province_id' => 13, 'name' => 'Kota Payakumbuh'],
            ['id' => 1377, 'province_id' => 13, 'name' => 'Kota Pariaman'],

            // Riau (14)
            ['id' => 1400, 'province_id' => 14, 'name' => 'Provinsi Riau'],
            ['id' => 1401, 'province_id' => 14, 'name' => 'Kampar'],
            ['id' => 1402, 'province_id' => 14, 'name' => 'Indragiri Hulu'],
            ['id' => 1403, 'province_id' => 14, 'name' => 'Bengkalis'],
            ['id' => 1404, 'province_id' => 14, 'name' => 'Indragiri Hilir'],
            ['id' => 1405, 'province_id' => 14, 'name' => 'Pelalawan'],
            ['id' => 1406, 'province_id' => 14, 'name' => 'Rokan Hulu'],
            ['id' => 1407, 'province_id' => 14, 'name' => 'Rokan Hilir'],
            ['id' => 1408, 'province_id' => 14, 'name' => 'Siak'],
            ['id' => 1409, 'province_id' => 14, 'name' => 'Kuantan Singingi'],
            ['id' => 1410, 'province_id' => 14, 'name' => 'Kepulauan Meranti'],
            ['id' => 1471, 'province_id' => 14, 'name' => 'Kota Pekanbaru'],
            ['id' => 1472, 'province_id' => 14, 'name' => 'Kota Dumai'],

            // Jambi (15)
            ['id' => 1500, 'province_id' => 15, 'name' => 'Provinsi Jambi'],
            ['id' => 1501, 'province_id' => 15, 'name' => 'Kerinci'],
            ['id' => 1502, 'province_id' => 15, 'name' => 'Merangin'],
            ['id' => 1503, 'province_id' => 15, 'name' => 'Sarolangun'],
            ['id' => 1504, 'province_id' => 15, 'name' => 'Batanghari'],
            ['id' => 1505, 'province_id' => 15, 'name' => 'Muaro Jambi'],
            ['id' => 1506, 'province_id' => 15, 'name' => 'Tanjung Jabung Barat'],
            ['id' => 1507, 'province_id' => 15, 'name' => 'Tanjung Jabung Timur'],
            ['id' => 1508, 'province_id' => 15, 'name' => 'Bungo'],
            ['id' => 1509, 'province_id' => 15, 'name' => 'Tebo'],
            ['id' => 1571, 'province_id' => 15, 'name' => 'Kota Jambi'],
            ['id' => 1572, 'province_id' => 15, 'name' => 'Kota Sungai Penuh'],

            // Sumatera Selatan (16)
            ['id' => 1600, 'province_id' => 16, 'name' => 'Provinsi Sumatera Selatan'],
            ['id' => 1601, 'province_id' => 16, 'name' => 'Ogan Komering Ulu'],
            ['id' => 1602, 'province_id' => 16, 'name' => 'Ogan Komering Ilir'],
            ['id' => 1603, 'province_id' => 16, 'name' => 'Muara Enim'],
            ['id' => 1604, 'province_id' => 16, 'name' => 'Lahat'],
            ['id' => 1605, 'province_id' => 16, 'name' => 'Musi Rawas'],
            ['id' => 1606, 'province_id' => 16, 'name' => 'Musi Banyuasin'],
            ['id' => 1607, 'province_id' => 16, 'name' => 'Banyuasin'],
            ['id' => 1608, 'province_id' => 16, 'name' => 'Ogan Komering Ulutimur'],
            ['id' => 1609, 'province_id' => 16, 'name' => 'Ogan Komering Uluselatan'],
            ['id' => 1610, 'province_id' => 16, 'name' => 'Ogan Ilir'],
            ['id' => 1611, 'province_id' => 16, 'name' => 'Empat Lawang'],
            ['id' => 1612, 'province_id' => 16, 'name' => 'Penukal Abab Lematangilir'],
            ['id' => 1613, 'province_id' => 16, 'name' => 'Musi Rawas Utara'],
            ['id' => 1671, 'province_id' => 16, 'name' => 'Kota Palembang'],
            ['id' => 1672, 'province_id' => 16, 'name' => 'Kota Pagar Alam'],
            ['id' => 1673, 'province_id' => 16, 'name' => 'Kota Lubuk Linggau'],
            ['id' => 1674, 'province_id' => 16, 'name' => 'Kota Prabumulih'],

            // Bengkulu (17)
            ['id' => 1700, 'province_id' => 17, 'name' => 'Provinsi Bengkulu'],
            ['id' => 1701, 'province_id' => 17, 'name' => 'Bengkulu Selatan'],
            ['id' => 1702, 'province_id' => 17, 'name' => 'Rejang Lebong'],
            ['id' => 1703, 'province_id' => 17, 'name' => 'Bengkulu Utara'],
            ['id' => 1704, 'province_id' => 17, 'name' => 'Kaur'],
            ['id' => 1705, 'province_id' => 17, 'name' => 'Seluma'],
            ['id' => 1706, 'province_id' => 17, 'name' => 'Muko Muko'],
            ['id' => 1707, 'province_id' => 17, 'name' => 'Lebong'],
            ['id' => 1708, 'province_id' => 17, 'name' => 'Kepahiang'],
            ['id' => 1709, 'province_id' => 17, 'name' => 'Bengkulu Tengah'],
            ['id' => 1771, 'province_id' => 17, 'name' => 'Kota Bengkulu'],

            // Lampung (18)
            ['id' => 1800, 'province_id' => 18, 'name' => 'Provinsi Lampung'],
            ['id' => 1801, 'province_id' => 18, 'name' => 'Lampung Selatan'],
            ['id' => 1802, 'province_id' => 18, 'name' => 'Lampung Tengah'],
            ['id' => 1803, 'province_id' => 18, 'name' => 'Lampung Utara'],
            ['id' => 1804, 'province_id' => 18, 'name' => 'Lampung Barat'],
            ['id' => 1805, 'province_id' => 18, 'name' => 'Tulang Bawang'],
            ['id' => 1806, 'province_id' => 18, 'name' => 'Tanggamus'],
            ['id' => 1807, 'province_id' => 18, 'name' => 'Lampung Timur'],
            ['id' => 1808, 'province_id' => 18, 'name' => 'Way Kanan'],
            ['id' => 1809, 'province_id' => 18, 'name' => 'Pesawaran'],
            ['id' => 1810, 'province_id' => 18, 'name' => 'Pringsewu'],
            ['id' => 1811, 'province_id' => 18, 'name' => 'Mesuji'],
            ['id' => 1812, 'province_id' => 18, 'name' => 'Tulang Bawang Barat'],
            ['id' => 1813, 'province_id' => 18, 'name' => 'Pesisir Barat'],
            ['id' => 1871, 'province_id' => 18, 'name' => 'Kota Bandar Lampung'],
            ['id' => 1872, 'province_id' => 18, 'name' => 'Kota Metro'],

            // Bangka Belitung (19)
            ['id' => 1900, 'province_id' => 19, 'name' => 'Provinsi Bangka Belitung'],
            ['id' => 1901, 'province_id' => 19, 'name' => 'Bangka'],
            ['id' => 1902, 'province_id' => 19, 'name' => 'Belitung'],
            ['id' => 1903, 'province_id' => 19, 'name' => 'Bangka Selatan'],
            ['id' => 1904, 'province_id' => 19, 'name' => 'Bangka Tengah'],
            ['id' => 1905, 'province_id' => 19, 'name' => 'Bangka Barat'],
            ['id' => 1906, 'province_id' => 19, 'name' => 'Belitung Timur'],
            ['id' => 1971, 'province_id' => 19, 'name' => 'Kota Pangkal Pinang'],

            // Kepulauan Riau (21)
            ['id' => 2100, 'province_id' => 21, 'name' => 'Provinsi Kepulauan Riau'],
            ['id' => 2101, 'province_id' => 21, 'name' => 'Bintan'],
            ['id' => 2102, 'province_id' => 21, 'name' => 'Karimun'],
            ['id' => 2103, 'province_id' => 21, 'name' => 'Natuna'],
            ['id' => 2104, 'province_id' => 21, 'name' => 'Lingga'],
            ['id' => 2105, 'province_id' => 21, 'name' => 'Kepulauan Anambas'],
            ['id' => 2171, 'province_id' => 21, 'name' => 'Kota Batam'],
            ['id' => 2172, 'province_id' => 21, 'name' => 'Kota Tanjung Pinang'],
        ];

        foreach ($regencies as $regency) {
            Regency::updateOrCreate(
                ['id' => $regency['id']], // Cari berdasarkan ID
                [
                    'province_id' => $regency['province_id'],
                    'name' => $regency['name']
                ]
            );
        }
    }
}
