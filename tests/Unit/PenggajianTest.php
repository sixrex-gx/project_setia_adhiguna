<?php

namespace Tests\Unit;

use App\Models\Penggajian;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PenggajianTest extends TestCase
{
    #[Test]
    public function it_calculates_net_salary_without_overtime(): void
    {
        $gajiBersih = Penggajian::hitungGajiBersih(
            gajiPokok: 2500000,
            tunjangan: 500000,
            lemburJam: 0,
            lemburRate: 0,
            potongan: 100000,
        );

        $this->assertEquals(2900000, $gajiBersih);
    }

    #[Test]
    public function it_calculates_net_salary_with_overtime(): void
    {
        $gajiBersih = Penggajian::hitungGajiBersih(
            gajiPokok: 2500000,
            tunjangan: 500000,
            lemburJam: 10,
            lemburRate: 25000,
            potongan: 100000,
        );

        $expected = 2500000 + 500000 + (10 * 25000) - 100000;
        $this->assertEquals($expected, $gajiBersih);
    }
}
