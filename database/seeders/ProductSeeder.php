<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name'=>'Pulpen Pilot G2',      'emoji'=>'🖊',  'category'=>'ATK Tulis',    'unit'=>'pcs',    'price'=>8500,   'cost'=>5000,   'stock'=>120],
            ['name'=>'Spidol Whiteboard',     'emoji'=>'✏️',  'category'=>'ATK Tulis',    'unit'=>'pcs',    'price'=>15000,  'cost'=>9000,   'stock'=>85],
            ['name'=>'Stabilo Highlighter',   'emoji'=>'🖍',  'category'=>'ATK Tulis',    'unit'=>'pcs',    'price'=>12000,  'cost'=>7000,   'stock'=>3],
            ['name'=>'Kertas HVS A4',         'emoji'=>'📄',  'category'=>'Kertas',       'unit'=>'rim',    'price'=>65000,  'cost'=>42000,  'stock'=>45],
            ['name'=>'Kertas Foto Glossy',    'emoji'=>'🖼',  'category'=>'Kertas',       'unit'=>'pack',   'price'=>95000,  'cost'=>60000,  'stock'=>8],
            ['name'=>'Amplop Coklat',         'emoji'=>'✉️',  'category'=>'Kertas',       'unit'=>'pack',   'price'=>25000,  'cost'=>15000,  'stock'=>50],
            ['name'=>'Binder A4',             'emoji'=>'📁',  'category'=>'Perlengkapan', 'unit'=>'pcs',    'price'=>35000,  'cost'=>22000,  'stock'=>30],
            ['name'=>'Gunting Kenko',         'emoji'=>'✂️',  'category'=>'Perlengkapan', 'unit'=>'pcs',    'price'=>18000,  'cost'=>11000,  'stock'=>25],
            ['name'=>'Selotip Besar',         'emoji'=>'🎀',  'category'=>'Perlengkapan', 'unit'=>'roll',   'price'=>9500,   'cost'=>5500,   'stock'=>60],
            ['name'=>'Tinta Printer Hitam',   'emoji'=>'🖨',  'category'=>'Perlengkapan', 'unit'=>'botol',  'price'=>55000,  'cost'=>35000,  'stock'=>18],
            ['name'=>'Banner Print A1',       'emoji'=>'🖼',  'category'=>'Advertising',  'unit'=>'lbr',    'price'=>125000, 'cost'=>75000,  'stock'=>2],
            ['name'=>'Stiker Label Vinyl',    'emoji'=>'🏷',  'category'=>'Advertising',  'unit'=>'lbr',    'price'=>45000,  'cost'=>28000,  'stock'=>15],
            ['name'=>'Brosur A5 Full Color',  'emoji'=>'📰',  'category'=>'Advertising',  'unit'=>'500lbr', 'price'=>350000, 'cost'=>220000, 'stock'=>5],
            ['name'=>'Kartu Nama Premium',    'emoji'=>'💳',  'category'=>'Advertising',  'unit'=>'100pcs', 'price'=>200000, 'cost'=>120000, 'stock'=>7],
            ['name'=>'Spanduk 3x1 meter',     'emoji'=>'🎌',  'category'=>'Advertising',  'unit'=>'pcs',    'price'=>180000, 'cost'=>110000, 'stock'=>4],
            ['name'=>'Penggaris 30cm',        'emoji'=>'📏',  'category'=>'ATK Tulis',    'unit'=>'pcs',    'price'=>8000,   'cost'=>4500,   'stock'=>40],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}