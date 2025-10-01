<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Member;
use App\Models\SalaryComponent;
use App\Models\Payroll;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Pastikan tabel dikosongkan sebelum seeding
        DB::table('payrolls')->truncate();
        DB::table('salary_components')->truncate();
        DB::table('members')->truncate();
        DB::table('users')->truncate();

        // 1. DATA PENGGUNA (ROLE)
        // ----------------------------------------------------
        User::create([
            'name' => 'Admin DPR',
            'email' => 'admin@dpr.com',
            'password' => Hash::make('password'), 
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Public User',
            'email' => 'public@dpr.com',
            'password' => Hash::make('password'), 
            'role' => 'public',
        ]);

        // 2. DATA KOMPONEN GAJI
        // Menggunakan id_komponen_gaji (component_id) sebagai primary key
        // Note: 'Tunjangan Melekat' dan 'Tunjangan Lain' disederhanakan menjadi 'Tunjangan' di Laravel
        // Tipe ENUM dari SQL: ('Gaji Pokok', 'Tunjangan Melekat', 'Tunjangan Lain')
        // Tipe ENUM di Migrasi: ('Gaji Pokok', 'Tunjangan', 'Fasilitas')
        // Jabatan ENUM: ('Ketua', 'Wakil Ketua', 'Anggota', 'Semua')
        // Satuan ENUM: ('Bulan', 'Hari', 'Periode')

        $components = [
            ['component_id' => 1001, 'component_name' => 'Gaji Pokok', 'category' => 'Gaji Pokok', 'position_eligibility' => 'Semua', 'nominal' => 4200000.00, 'unit' => 'Bulan'],
            ['component_id' => 1002, 'component_name' => 'Tunjangan Jabatan Ketua', 'category' => 'Tunjangan', 'position_eligibility' => 'Ketua', 'nominal' => 5000000.00, 'unit' => 'Bulan'],
            ['component_id' => 1003, 'component_name' => 'Tunjangan Jabatan Wakil', 'category' => 'Tunjangan', 'position_eligibility' => 'Wakil Ketua', 'nominal' => 4500000.00, 'unit' => 'Bulan'],
            ['component_id' => 1004, 'component_name' => 'Tunjangan Kehormatan', 'category' => 'Tunjangan', 'position_eligibility' => 'Semua', 'nominal' => 5700000.00, 'unit' => 'Bulan'],
            ['component_id' => 1005, 'component_name' => 'Fasilitas Rumah Dinas', 'category' => 'Fasilitas', 'position_eligibility' => 'Semua', 'nominal' => 10000000.00, 'unit' => 'Periode'],
            ['component_id' => 1006, 'component_name' => 'Biaya Komunikasi', 'category' => 'Tunjangan', 'position_eligibility' => 'Semua', 'nominal' => 4000000.00, 'unit' => 'Bulan'],
        ];
        SalaryComponent::insert($components);
        
        // 3. DATA ANGGOTA DPR
        // Tipe ENUM dari SQL: ('Kawin', 'Belum Kawin', 'Cerai Hidup', 'Cerai Mati')
        // Tipe ENUM di Migrasi: ('Lajang', 'Kawin', 'Cerai') - disederhanakan
        
        $members = [
            ['member_id' => 2001, 'title_prefix' => 'Dr.', 'first_name' => 'Samudra', 'last_name' => 'Gunawan', 'title_suffix' => 'M.Si.', 'position' => 'Ketua', 'marital_status' => 'Kawin', 'number_of_children' => 3],
            ['member_id' => 2002, 'title_prefix' => '', 'first_name' => 'Puti', 'last_name' => 'Syarif', 'title_suffix' => 'S.H.', 'position' => 'Wakil Ketua', 'marital_status' => 'Kawin', 'number_of_children' => 1],
            ['member_id' => 2003, 'title_prefix' => 'Hj.', 'first_name' => 'Rina', 'last_name' => 'Wijaya', 'title_suffix' => '', 'position' => 'Anggota', 'marital_status' => 'Lajang', 'number_of_children' => 0],
            ['member_id' => 2004, 'title_prefix' => '', 'first_name' => 'Joko', 'last_name' => 'Santoso', 'title_suffix' => 'SE', 'position' => 'Anggota', 'marital_status' => 'Cerai', 'number_of_children' => 2],
        ];
        Member::insert($members);

        // 4. DATA PENGGAJIAN (untuk bulan ini)
        // Note: Komponen Gaji dihitung per bulan, PayrollService akan menambah Tunjangan Istri/Anak.
        $pay_date = Carbon::now()->startOfMonth();

        // Samudra Gunawan (Ketua, Kawin, 3 Anak)
        Payroll::create(['member_id' => 2001, 'component_id' => 1001, 'pay_date' => $pay_date, 'calculated_nominal' => 4200000.00]); // Gaji Pokok
        Payroll::create(['member_id' => 2001, 'component_id' => 1002, 'pay_date' => $pay_date, 'calculated_nominal' => 5000000.00]); // Tunjangan Jabatan Ketua
        Payroll::create(['member_id' => 2001, 'component_id' => 1004, 'pay_date' => $pay_date, 'calculated_nominal' => 5700000.00]); // Tunjangan Kehormatan
        Payroll::create(['member_id' => 2001, 'component_id' => 1006, 'pay_date' => $pay_date, 'calculated_nominal' => 4000000.00]); // Biaya Komunikasi

        // Puti Syarif (Wakil Ketua, Kawin, 1 Anak)
        Payroll::create(['member_id' => 2002, 'component_id' => 1001, 'pay_date' => $pay_date, 'calculated_nominal' => 4200000.00]); // Gaji Pokok
        Payroll::create(['member_id' => 2002, 'component_id' => 1003, 'pay_date' => $pay_date, 'calculated_nominal' => 4500000.00]); // Tunjangan Jabatan Wakil
        Payroll::create(['member_id' => 2002, 'component_id' => 1004, 'pay_date' => $pay_date, 'calculated_nominal' => 5700000.00]); // Tunjangan Kehormatan

        // Rina Wijaya (Anggota, Lajang, 0 Anak)
        Payroll::create(['member_id' => 2003, 'component_id' => 1001, 'pay_date' => $pay_date, 'calculated_nominal' => 4200000.00]); // Gaji Pokok
        Payroll::create(['member_id' => 2003, 'component_id' => 1004, 'pay_date' => $pay_date, 'calculated_nominal' => 5700000.00]); // Tunjangan Kehormatan
    }
}
